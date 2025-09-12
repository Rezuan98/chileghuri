<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\GalleryImage;
use App\Models\Slider;
use App\Models\Video;
use App\Models\Review;

class IndexController extends Controller
{
    public function index(){

        $new_arrival = Product::where('status', 1)->where('featured', 0)
        ->withSum('variants', 'stock_quantity')
        ->with('variants', 'galleryImages')
        ->latest()  // Orders by created_at DESC
        ->take(20)
        ->get();

       

    // Get best selling products based on order items count
    $best_selling = Product::where('status', 1)
    ->withCount('orderItems')  // Changed from 'Items' to 'orderItems'
    ->with(['variants', 'galleryImages'])
    ->orderBy('order_items_count', 'desc')
    ->take(10)
    ->get();

    $featured = Product::where('status', 1)
    ->where('featured', 1)
    ->withSum('variants', 'stock_quantity')
    ->with(['variants', 'galleryImages'])
    ->take(30)
    ->get();

// Access with: 

    

    
        $categoryNames = Category::all()->reverse();
        $sliderCategory = Category::where('status', 0)
    ->withCount([
        'products as products_count' => function ($q) {
            $q->whereHas('variants');    // product must have ≥1 variant
        },
    ])
    ->get();

      
        // $categoryNames = Category::where('status', 1)->limit(10)->get();
        $sliders = Slider::where('status', true)
        ->orderBy('order')
        ->get();


        $videos = Video::where('status', true)->first();


        $reviews = Review::where('status', 1)->orderBy('order', 'asc')->take(6)->get();
       
        
        return view('frontend.master.index', compact('new_arrival', 'best_selling','sliders','categoryNames','videos','featured','sliderCategory', 'reviews'));

    }
}
