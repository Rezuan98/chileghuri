<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\GalleryImage;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;

class ProductViewController extends Controller
{
    public function productDetails($id)
    {
      $product = Product::with(['category', 'galleryImages', 'variants.size', 'variants.color'])->findOrFail($id);
    
        // If needed, you can also include variants like this:
        $variants = ProductVarient::where('product_id', $product->id)->get();

        $allvariants = $product->variants;

        // Get recommended products
        $recommendedProducts = $this->getRecommendedProducts($product);

        return view('frontend.pages.product_details', [
            'product' => $product,
            'variants' => $variants,
            'allvariants' => $allvariants,
            'recommendedProducts' => $recommendedProducts,
            'pageType' => 'product_detail'
        ]);
        
    }
 private function getRecommendedProducts($currentProduct, $limit = 8)
    {
        // Strategy 1: Same category products (excluding current product)
        $sameCategory = Product::where('category_id', $currentProduct->category_id)
            ->where('id', '!=', $currentProduct->id)
            ->where('status', 1)
            ->with(['category', 'galleryImages', 'variants.size', 'variants.color'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Strategy 2: Same subcategory products (if available)
        $sameSubcategory = collect();
        if ($currentProduct->subcategory_id) {
            $sameSubcategory = Product::where('subcategory_id', $currentProduct->subcategory_id)
                ->where('id', '!=', $currentProduct->id)
                ->where('status', 1)
                ->with(['category', 'galleryImages', 'variants.size', 'variants.color'])
                ->inRandomOrder()
                ->take(2)
                ->get();
        }

        // Strategy 3: Featured products (if we still need more)
        $featured = Product::where('featured', 1)
            ->where('id', '!=', $currentProduct->id)
            ->where('status', 1)
            ->with(['category', 'galleryImages', 'variants.size', 'variants.color'])
            ->inRandomOrder()
            ->take(2)
            ->get();

        // Merge all recommendations and remove duplicates
        $recommended = $sameCategory
            ->merge($sameSubcategory)
            ->merge($featured)
            ->unique('id')
            ->take($limit);

        return $recommended;
    }
    

     public function categoryProducts(Request $request, $id)
    {
        // Get category information
        $category = Category::findOrFail($id);
        
        // Start with base query
        $query = Product::with(['category', 'galleryImages', 'variants.size', 'variants.color', 'brand'])
                       ->where('category_id', $id)
                       ->where('status', 1) // Only active products
                       ->distinct();

        // Apply price filter if provided
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = $request->get('min_price', 0);
            $maxPrice = $request->get('max_price', 999999);
            
            // Calculate final price including discounts
            $query->where(function($q) use ($minPrice, $maxPrice) {
                $q->whereRaw("
                    CASE 
                        WHEN discount_amount > 0 AND discount_type = 'fixed' THEN 
                            (sale_price - discount_amount) BETWEEN ? AND ?
                        WHEN discount_amount > 0 AND discount_type = 'percentage' THEN 
                            (sale_price - (sale_price * discount_amount / 100)) BETWEEN ? AND ?
                        ELSE 
                            sale_price BETWEEN ? AND ?
                    END
                ", [$minPrice, $maxPrice, $minPrice, $maxPrice, $minPrice, $maxPrice]);
            });
        }

        // Apply availability filter
        if ($request->filled('in_stock') && $request->filled('out_of_stock')) {
            // Both selected - show all products
        } elseif ($request->filled('in_stock')) {
            // Only in stock
            $query->whereHas('variants', function($q) {
                $q->where('stock_quantity', '>', 0);
            });
        } elseif ($request->filled('out_of_stock')) {
            // Only out of stock
            $query->whereDoesntHave('variants', function($q) {
                $q->where('stock_quantity', '>', 0);
            });
        }

        // Apply sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw("
                    CASE 
                        WHEN discount_amount > 0 AND discount_type = 'fixed' THEN 
                            (sale_price - discount_amount)
                        WHEN discount_amount > 0 AND discount_type = 'percentage' THEN 
                            (sale_price - (sale_price * discount_amount / 100))
                        ELSE 
                            sale_price
                    END ASC
                ");
                break;
            case 'price_high':
                $query->orderByRaw("
                    CASE 
                        WHEN discount_amount > 0 AND discount_type = 'fixed' THEN 
                            (sale_price - discount_amount)
                        WHEN discount_amount > 0 AND discount_type = 'percentage' THEN 
                            (sale_price - (sale_price * discount_amount / 100))
                        ELSE 
                            sale_price
                    END DESC
                ");
                break;
            case 'popular':
                // You can implement this based on sales count, views, etc.
                $query->withCount('orderItems')->orderBy('order_items_count', 'desc');
                break;
            case 'newest':
            default:
                $query->latest('created_at');
                break;
        }

        // Get total count before pagination for results info
        $totalProducts = $query->count();

        // Paginate results
        $product = $query->paginate(12)->withQueryString();

        // If this is an AJAX request, return only the partial view
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('frontend.pages.category_product_page', [
                'product' => $product,
                'id' => $id,
                'category' => $category,
                'categoryName' => $category->name,
                'totalProducts' => $totalProducts
            ]);
        }

        return view('frontend.pages.category_product_page', [
            'product' => $product,
            'id' => $id,
            'category' => $category,
            'categoryName' => $category->name,
            'totalProducts' => $totalProducts
        ]);
    }


 public function subCategoryProducts(Request $request, $id)
    {
        $subcategory = Subcategory::findOrFail($id);
        
        // Start building the query with eager loading
        $query = Product::with(['category', 'subcategory', 'brand', 'variants.size', 'variants.color', 'galleryImages'])
            ->where('subcategory_id', $id)
            ->where('status', 1);

        // Apply price filter
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = (float) $request->input('min_price', 0);
            $maxPrice = (float) $request->input('max_price', 50000);
            
            $query->whereBetween('sale_price', [$minPrice, $maxPrice]);
        }

        // Apply availability filter
        if ($request->has('in_stock') && !$request->has('out_of_stock')) {
            $query->whereHas('variants', function($q) {
                $q->where('stock_quantity', '>', 0);
            });
        } elseif ($request->has('out_of_stock') && !$request->has('in_stock')) {
            $query->whereDoesntHave('variants', function($q) {
                $q->where('stock_quantity', '>', 0);
            });
        }

        // Apply sorting
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('sale_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('sale_price', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_sold', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Paginate results
        $products = $query->paginate(12)->appends($request->query());

        // Handle AJAX requests
        if ($request->ajax()) {
            $html = view('frontend.pages.category_product_partial', [
                'product' => $products
            ])->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'total' => $products->total(),
                'count' => $products->count()
            ]);
        }

        return view('frontend.pages.category_product_page', [
            'product' => $products,
            'id' => $id,
            'categoryName' => $subcategory->name
        ]);
    }



public function brandProducts(Request $request, $id)
{
    // Get brand information
    $brand = Brand::findOrFail($id);
    
    // Start with base query
    $query = Product::with(['category', 'galleryImages', 'variants.size', 'variants.color', 'brand'])
                   ->where('brand_id', $id)
                   ->where('status', 1) // Only active products
                   ->distinct();

    // Apply price filter if provided
    if ($request->filled('min_price') || $request->filled('max_price')) {
        $minPrice = $request->get('min_price', 0);
        $maxPrice = $request->get('max_price', 999999);
        
        $query->where(function($q) use ($minPrice, $maxPrice) {
            $q->where(function($subQ) use ($minPrice, $maxPrice) {
                // For fixed discount
                $subQ->where('discount_type', 'fixed')
                     ->where('discount_amount', '>', 0)
                     ->whereRaw('(sale_price - discount_amount) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            })
            ->orWhere(function($subQ) use ($minPrice, $maxPrice) {
                // For percentage discount
                $subQ->where('discount_type', 'percentage')
                     ->where('discount_amount', '>', 0)
                     ->whereRaw('(sale_price - (sale_price * discount_amount / 100)) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            })
            ->orWhere(function($subQ) use ($minPrice, $maxPrice) {
                // For no discount or zero discount
                $subQ->where(function($innerQ) {
                    $innerQ->whereNull('discount_amount')
                           ->orWhere('discount_amount', 0);
                })
                ->whereBetween('sale_price', [$minPrice, $maxPrice]);
            });
        });
    }

    // Apply availability filter
    if ($request->filled('in_stock') && $request->filled('out_of_stock')) {
        // Both selected - show all products
    } elseif ($request->filled('in_stock')) {
        // Only in stock
        $query->whereHas('variants', function($q) {
            $q->where('stock_quantity', '>', 0);
        });
    } elseif ($request->filled('out_of_stock')) {
        // Only out of stock
        $query->whereDoesntHave('variants', function($q) {
            $q->where('stock_quantity', '>', 0);
        });
    }

    // Apply sorting - Fixed version
    $sort = $request->get('sort', 'newest');
    switch ($sort) {
        case 'price_low':
            // Get all products first, then sort by calculated final price
            $products = $query->get()->map(function($product) {
                $finalPrice = $product->sale_price;
                
                if ($product->discount_amount > 0) {
                    if ($product->discount_type === 'fixed') {
                        $finalPrice = $product->sale_price - $product->discount_amount;
                    } elseif ($product->discount_type === 'percentage') {
                        $finalPrice = $product->sale_price - ($product->sale_price * $product->discount_amount / 100);
                    }
                }
                
                $product->final_price = max(0, $finalPrice);
                return $product;
            })->sortBy('final_price');
            
            // Convert back to paginated collection
            $currentPage = $request->get('page', 1);
            $perPage = 12;
            $total = $products->count();
            
            $paginatedProducts = $products->forPage($currentPage, $perPage);
            
            $product = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedProducts->values(),
                $total,
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'pageName' => 'page',
                ]
            );
            $product->withQueryString();
            break;
            
        case 'price_high':
            // Get all products first, then sort by calculated final price (descending)
            $products = $query->get()->map(function($product) {
                $finalPrice = $product->sale_price;
                
                if ($product->discount_amount > 0) {
                    if ($product->discount_type === 'fixed') {
                        $finalPrice = $product->sale_price - $product->discount_amount;
                    } elseif ($product->discount_type === 'percentage') {
                        $finalPrice = $product->sale_price - ($product->sale_price * $product->discount_amount / 100);
                    }
                }
                
                $product->final_price = max(0, $finalPrice);
                return $product;
            })->sortByDesc('final_price');
            
            // Convert back to paginated collection
            $currentPage = $request->get('page', 1);
            $perPage = 12;
            $total = $products->count();
            
            $paginatedProducts = $products->forPage($currentPage, $perPage);
            
            $product = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedProducts->values(),
                $total,
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'pageName' => 'page',
                ]
            );
            $product->withQueryString();
            break;
            
        case 'popular':
            // You can implement this based on sales count, views, etc.
            $product = $query->withCount('orderItems')->orderBy('order_items_count', 'desc')->paginate(12)->withQueryString();
            break;
            
        case 'newest':
        default:
            $product = $query->latest('created_at')->paginate(12)->withQueryString();
            break;
    }

    // Get total count for results info
    $totalProducts = $query->count();

    // If this is an AJAX request, return JSON response with HTML
    if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
        $html = view('frontend.pages.brand_product_partial', [
            'product' => $product
        ])->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'total' => $product->total(),
            'count' => $product->count()
        ]);
    }

    return view('frontend.pages.brand_product_page', [
        'product' => $product,
        'id' => $id,
        'brand' => $brand,
        'brandName' => $brand->name,
        'totalProducts' => $totalProducts
    ]);
}






    // Add this method to your ProductViewController.php

public function generateOGImage($id)
{
    $product = Product::with(['category', 'brand'])->find($id);
    
    if (!$product) {
        abort(404);
    }
    
    // Calculate final price
    $discount_type = $product->discount_type;
    $discount_amount = $product->discount_amount ?? 0;
    $sale_price = $product->sale_price;
    $final_price = $sale_price;
    
    if ($discount_amount > 0) {
        if ($discount_type == 'fixed') {
            $final_price = $sale_price - $discount_amount;
        } elseif ($discount_type == 'percentage') {
            $discount_value = ($sale_price * $discount_amount) / 100;
            $final_price = $sale_price - $discount_value;
        }
    }
    
    // Create image with GD
    $width = 1200;
    $height = 630;
    
    // Create base image
    $image = imagecreatetruecolor($width, $height);
    
    // Colors
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $red = imagecolorallocate($image, 220, 53, 69);
    $green = imagecolorallocate($image, 40, 167, 69);
    
    // Fill background
    imagefill($image, 0, 0, $white);
    
    // Load product image if exists
    $productImagePath = public_path('uploads/products/' . $product->product_image);
    if (file_exists($productImagePath)) {
        $productImg = imagecreatefromstring(file_get_contents($productImagePath));
        if ($productImg) {
            // Resize and place product image
            $resized = imagescale($productImg, 400, 400);
            imagecopy($image, $resized, 50, 115, 0, 0, 400, 400);
            imagedestroy($resized);
            imagedestroy($productImg);
        }
    }
    
    // Add text
    $fontPath = public_path('fonts/arial.ttf'); // You need to add a font file
    
    // Product name
    $productName = wordwrap($product->product_name, 40);
    imagettftext($image, 24, 0, 500, 150, $black, $fontPath, $productName);
    
    // Price
    $priceText = '৳' . number_format($final_price, 2);
    if ($discount_amount > 0 && $final_price < $sale_price) {
        imagettftext($image, 32, 0, 500, 250, $green, $fontPath, $priceText);
        $oldPriceText = '৳' . number_format($sale_price, 2);
        imagettftext($image, 20, 0, 500, 290, $red, $fontPath, 'Was: ' . $oldPriceText);
    } else {
        imagettftext($image, 32, 0, 500, 250, $black, $fontPath, $priceText);
    }
    
    // Brand
    if ($product->brand) {
        imagettftext($image, 16, 0, 500, 350, $black, $fontPath, 'Brand: ' . $product->brand->name);
    }
    
    // Category
    if ($product->category) {
        imagettftext($image, 16, 0, 500, 380, $black, $fontPath, 'Category: ' . $product->category->name);
    }
    
    // Website name
    imagettftext($image, 18, 0, 500, 550, $black, $fontPath, config('app.name'));
    
    // Output
    header('Content-Type: image/png');
    header('Cache-Control: public, max-age=86400'); // Cache for 24 hours
    imagepng($image);
    imagedestroy($image);
}
}
