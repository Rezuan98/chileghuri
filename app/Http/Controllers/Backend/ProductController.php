<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;


use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Color;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Unit;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;

use App\Models\ProductVarient;
use App\Models\GalleryImage;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;
use DB;

class ProductController extends Controller
{
    public function index()
{
    $lists = Product::with(['category', 'subcategory', 'brand', 'unit'])
                    ->latest()
                    ->get();
    
    return view('back-end.product.index', compact('lists'));
}

public function ViewDetails($id){
    $variants = ProductVarient::where('product_id',$id)->with(['product', 'color', 'size'])
                            ->latest()
                            ->get();
    
    // return view('back-end');

    return view('back-end.product.product-details',compact('variants'));
}

    public function create(){

    $allcategories = Category::all();
    $subcategory = Subcategory::all();
    $color = Color::all();
    $size = Size::all();
    $brand = Brand::all();
    $unit = Unit::all();

    	return view('back-end.product.create',compact('allcategories','subcategory','color','size','brand','unit'));
    }

    public function bulkCreate(){

        return view('back-end.product.bulk_create');
    }

    

    public function bulkStore(Request $request)
{
}



















public function store(Request $request)
{
    $request->validate([
        'product_name' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'product_image' => 'required|image',
        'colors.*' => 'required|exists:colors,id',
        'sizes.*' => 'required|exists:sizes,id',
        'stock_quantity.*' => 'required|numeric|min:0',
        
    ]);

    $productImage = null; // Initialize the variable
    
    if ($request->hasFile('product_image')) {
        $file = $request->file('product_image');
        $productImage = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/products'), $productImage);
    }

    // Check if image was uploaded
    if (!$productImage) {
        return redirect()->back()->with('error', 'Product image is required');
    }

    // Check if variants exist
    if (empty($request->colors) || empty($request->sizes)) {
        return redirect()->back()->with('error', 'At least one variant is required');
    }

    // Create Product Object
    $product = new Product();
    $product->product_name = $request->product_name;
    $product->slug = Str::slug($request->product_name);
    $product->product_image = $productImage;
    $product->product_code = 'P' . time() . rand(10000, 99999);
    $product->category_id = $request->category_id;
    $product->subcategory_id = $request->subcategory_id;
    $product->brand_id = $request->brand_id;
    $product->unit_id = $request->unit_id;
    $product->description = $request->description;
    $product->discount_type = $request->discount_type;
    $product->discount_amount = $request->discount;
    $product->sale_price = $request->price;
    $product->status = true;
    $product->save();

    // for product variant
    $colors = $request->colors;
    $sizes = $request->sizes;
    $stocks = $request->stock_quantity;
    $prices = $request->variant_price;

    foreach ($colors as $key => $colorId) {
        $variant = new ProductVarient();
        $variant->product_id = $product->id;
        $variant->color_id = $colorId;
        $variant->size_id = $sizes[$key];
        $variant->stock_quantity = $stocks[$key];
       
        $variant->sku = $product->product_code . '-' . $colorId . '-' . $sizes[$key];
        $variant->status = true;
        $variant->save();
    }

    // Handle Gallery Images
    if ($request->hasFile('gallery')) {
        foreach ($request->file('gallery') as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/gallery'), $imageName);

            $galleryImage = new GalleryImage();
            $galleryImage->product_id = $product->id;
            $galleryImage->image = $imageName;
            $galleryImage->save();
        }
    }

    Toastr::success('Data Added Successfully', 'Success', ["positionClass" => "toast-top-right"]);
    return redirect()->route('product.index');
}




     public function edit($id){
        $product = Product::with(['variants', 'galleryImages'])->findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $brands = Brand::all();
        $units = Unit::all();
        $colors = Color::all();
        $sizes = Size::all();
    
        return view('back-end.product.edit', compact(
            'product',
            'categories',
            'subcategories',
            'brands',
            'units',
            'colors',
            'sizes'
        ));
    }
    
public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'product_name' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'product_image' => 'nullable|image', // Changed from 'required' to 'nullable'
        'colors.*' => 'required|exists:colors,id',
        'sizes.*' => 'required|exists:sizes,id',
        'stock_quantity.*' => 'required|numeric|min:0',
        'variant_price.*' => 'required|numeric|min:0',
    ]);

    $product = Product::findOrFail($id);

    // Update basic product information
    $product->product_name = $request->product_name;
    $product->category_id = $request->category_id;
    $product->subcategory_id = $request->subcategory_id;
    $product->brand_id = $request->brand_id;
    $product->unit_id = $request->unit_id;
    $product->description = $request->description;
    $product->sale_price = $request->price;
    $product->discount_type = $request->discount_type;
    $product->discount_amount = $request->discount;
    $product->tags = $request->tags;

    // Handle product image update
    if ($request->hasFile('product_image')) {
        // Delete old image
        if ($product->product_image && file_exists(public_path('uploads/products/' . $product->product_image))) {
            unlink(public_path('uploads/products/' . $product->product_image));
        }
        
        $image = $request->file('product_image');
        $imageName = 'product_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/products'), $imageName);
        $product->product_image = $imageName;
    }

    $product->save();

    // Handle variants
    if ($request->has('variant_ids')) {
        foreach ($request->variant_ids as $key => $variantId) {
            $colorId = $request->colors[$key] ?? null;
            $sizeId = $request->sizes[$key] ?? null;
            
            $variantData = [
                'product_id' => $product->id,
                'color_id' => $colorId,
                'size_id' => $sizeId,
                'stock_quantity' => $request->stock_quantity[$key] ?? 0,
                'variant_price' => $request->variant_price[$key] ?? 0,
                'sku' => $product->product_code . '-' . $colorId . '-' . $sizeId, // Added SKU generation
            ];
         
            if ($variantId) {
                // Update existing variant
                ProductVarient::where('id', $variantId)->update($variantData);
            } else {
                // Create new variant
                ProductVarient::create($variantData);
            }
        }
    }

    // Handle gallery images
    if ($request->hasFile('gallery')) {
        foreach ($request->file('gallery') as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/gallery'), $imageName);

            $galleryImage = new GalleryImage();
            $galleryImage->product_id = $product->id;
            $galleryImage->image = $imageName;
            $galleryImage->save();
        }
    }

    Toastr::success('Product Updated Successfully', 'Success', ["positionClass" => "toast-top-right"]);
    return redirect()->route('product.index');
}


    public function delete($id){
     	$info = Product::findOrFail($id);
     	
     	$info->delete();
    	return redirect()->route('product.index');
    }





    public function getSubcategories($categoryId)
{

 
    $subcategories = Subcategory::where('category_id', $categoryId)->get();
    return response()->json($subcategories);
}
public function updateStatus(Request $request)
{
    try {
        $product = Product::findOrFail($request->id);
        $product->status = $request->status;
        $product->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update status!'
        ]);
    }
}


public function updateFeatured(Request $request)
{
    try {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->featured;
        $product->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Featured updated successfully!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update status!'
        ]);
    }
}
public function updateVarientStatus(Request $request)
{
    try {
        $varient = ProductVarient::findOrFail($request->id);
        $varient->featured = $request->featured;
        $varient->save();
        
        return response()->json([
            'success' => true,
            'message' => 'featured updated successfully!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update featured!'
        ]);
    }
}

public function deleteGalleryImage($id){

    GalleryImage::where('id',$id)->delete();

    return response()->json([
        'success' => true,
        'message' => 'Image Deleted successfully!'
    ]);



}


public function duplicateProduct($id)
{
    try {
        // Find original product
        $originalProduct = Product::with(['variants', 'galleryImages'])->findOrFail($id);

        // Replicate the product
        $newProduct = $originalProduct->replicate();
        $newProduct->product_name = $originalProduct->product_name . ' (Copy)';
        $newProduct->slug = Str::slug($newProduct->product_name);
        $newProduct->product_code = 'P' . time() . rand(10000, 99999);
        
        // Copy product image
        if ($originalProduct->product_image) {
            $originalPath = public_path('uploads/products/') . $originalProduct->product_image;
            $newImageName = time() . '_' . uniqid() . '.' . pathinfo($originalProduct->product_image, PATHINFO_EXTENSION);
            $newPath = public_path('uploads/products/') . $newImageName;
            
            if (file_exists($originalPath)) {
                copy($originalPath, $newPath);
                $newProduct->product_image = $newImageName;
            }
        }

        $newProduct->save();

        // Replicate variants
        foreach ($originalProduct->variants as $variant) {
            $newVariant = $variant->replicate();
            $newVariant->product_id = $newProduct->id;
            $newVariant->sku = $newProduct->product_code . '-' . $variant->color_id . '-' . $variant->size_id;
            $newVariant->save();
        }

        // Replicate gallery images
        foreach ($originalProduct->galleryImages as $gallery) {
            $originalPath = public_path('uploads/gallery/') . $gallery->image;
            $newImageName = time() . '_' . uniqid() . '.' . pathinfo($gallery->image, PATHINFO_EXTENSION);
            $newPath = public_path('uploads/gallery/') . $newImageName;
            
            if (file_exists($originalPath)) {
                copy($originalPath, $newPath);
                
                $newGallery = new GalleryImage();
                $newGallery->product_id = $newProduct->id;
                $newGallery->image = $newImageName;
                $newGallery->save();
            }
        }

        Toastr::success('Product duplicated successfully', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('product.index');

    } catch (\Exception $e) {
        Toastr::error('Failed to duplicate product', 'Error', ["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }
}

public function deleteVariant($id)
{
    try {
        $variant = ProductVarient::findOrFail($id);
        
        // Add logging to debug
        \Log::info('Found variant:', ['id' => $id, 'variant' => $variant]);
        
        $deleted = $variant->delete();
        
        // Check if deletion was successful
        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Variant deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to delete variant'], 500);
        }
        
    } catch (\Exception $e) {
        \Log::error('Error deleting variant: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}
