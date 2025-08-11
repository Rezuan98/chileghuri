@extends('frontend.master.master')


<!-- In your product_details.blade.php file -->
@push('metascinan')
@php
    // Calculate final price for meta tags
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
    
    // Create description with price
    $description = strip_tags(Str::limit($product->description ?? '', 100));
    $priceText = $discount_amount > 0 && $final_price < $sale_price 
        ? "Price: ৳" . number_format($final_price, 2) . " (was ৳" . number_format($sale_price, 2) . ")"
        : "Price: ৳" . number_format($sale_price, 2);
    
    $fullDescription = $description . " | " . $priceText;
@endphp

<!-- Basic Open Graph Tags -->
<meta property="og:title" content="{{ $product->product_name }} - ৳{{ number_format($final_price, 2) }}">
<meta property="og:description" content="{{ $fullDescription }}">
<meta property="og:image" content="{{ asset('uploads/products/' . $product->product_image) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="product">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="en_US">

<!-- Product Specific Open Graph Tags -->
<meta property="product:price:amount" content="{{ $final_price }}">
<meta property="product:price:currency" content="BDT">
@if($discount_amount > 0 && $final_price < $sale_price)
<meta property="product:original_price:amount" content="{{ $sale_price }}">
<meta property="product:original_price:currency" content="BDT">
@endif
<meta property="product:availability" content="in stock">
<meta property="product:condition" content="new">
<meta property="product:brand" content="{{ $product->brand->name ?? 'Unknown' }}">
<meta property="product:category" content="{{ $product->category->name ?? 'Uncategorized' }}">

<!-- Additional Images for Gallery -->
@foreach($product->galleryImages->take(3) as $image)
<meta property="og:image" content="{{ asset('uploads/gallery/' . $image->image) }}">
@endforeach

<!-- Twitter Card Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $product->product_name }} - ৳{{ number_format($final_price, 2) }}">
<meta name="twitter:description" content="{{ $fullDescription }}">
<meta name="twitter:image" content="{{ asset('uploads/products/' . $product->product_image) }}">
<meta name="twitter:site" content="@{{ config('app.name') }}">

<!-- WhatsApp and Telegram specific -->
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $product->product_name }} - ৳{{ number_format($final_price, 2) }}">

<!-- Additional Meta for Better SEO -->
<meta name="description" content="{{ $fullDescription }}">
<meta name="keywords" content="{{ $product->product_name }}, {{ $product->category->name ?? '' }}, {{ $product->brand->name ?? '' }}, online shopping, ৳{{ number_format($final_price, 2) }}">
@endpush

@section('keyTitle', 'Product Details')
@push('ecomcss')
    <style>
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        .toast-notification.success {
            border-left: 4px solid #28a745;
        }

        .toast-notification.error {
            border-left: 4px solid #dc3545;
        }

        .toast-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toast-content i {
            font-size: 1.25rem;
        }

        .toast-content i.fa-check-circle {
            color: #28a745;
        }

        .toast-content i.fa-exclamation-circle {
            color: #dc3545;
        }

        /* Loading State */
        .btn .spinner-border {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        /* end of toaster */
        /* Additional Information Tab Styles */
        .additional-info .table {
            margin-bottom: 0;
        }

        .additional-info th {
            background-color: #f8f9fa;
            font-weight: 500;
            border-bottom-width: 1px;
        }

        .additional-info td {
            color: #666;
        }

        .additional-info tr:last-child th,
        .additional-info tr:last-child td {
            border-bottom: none;
        }
.tab-content #description {
    text-align: center;
}

.tab-content #description p {
    text-align: center;
    /* max-width: 800px; */
    margin: 0 auto;
    
}

        @media (max-width: 576px) {

            .additional-info th,
            .additional-info td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }


       /* Social Share Styles */
.social-share {
    margin: 20px 0;
}

.social-share-title {
    font-weight: 500;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.social-share-title i {
    margin-right: 5px;
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-share-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white!important;
    transition: transform 0.3s ease;
    text-decoration: none;
}
.social-share-btn i {
    color: white;
}

.social-share-btn:hover {
    transform: translateY(-3px);
}

.facebook {
    background-color: #3b5998;
}

.instagram {
    background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
}

.twitter {
    background-color: #000000;
}

.whatsapp {
    background-color: #25D366;
}

.email {
    background-color: #6c757d;
}

/* Recommended Products Styles - Same as Featured Products */
.recommended-products {
    background: #fff;
    border-top: 1px solid #eee;
    padding-top: 2rem;
}

.recommended-box {
    position: relative;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
    width: 100%;
}

.recommended-box:hover {
    transform: translateY(-5px);
}

.rp-product-info {
    padding: 10px;
}

.rp-product-info .rp-product-title {
    font-size: 14px;
    margin: 0 0 5px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    line-height: 1.5;
    height: 3em;
    color: #333;
    font-family:"Jost", sans-serif;
}

.rp-price-row {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-family: "Jost", sans-serif;
    white-space: nowrap;
}

.rp-current-price {
    font-weight: 500;
    font-family: "Jost", sans-serif;
    color: #000;
}

/* Image Styles */
.recommended-image {
    position: relative;
    margin-bottom: 10px;
    height: 0;
    padding-bottom: 100%;
    overflow: hidden;
}

.recommended-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .7s ease;
}

.recommended-image:hover img {
    transform: scale(1.1);
}

/* Plus Button */
.recommended-box .plus-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background-color: #f5f5f5;
    color: #000;
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease, background-color 0.3s ease;
    z-index: 2;
}

.recommended-box:hover .plus-btn {
    opacity: 1;
}

.recommended-box .plus-btn:hover {
    background-color: #333;
    color: white;
}

/* Desktop Layout */
@media (min-width: 767px) {
    .recommended-products .col-md-2-4 {
        flex: 0 0 20%;
        max-width: 20%;
    }
}

/* Mobile Layout */
@media (min-width: 320px) and (max-width: 766px) {
    .recommended-box {
        margin: 0 !important;
    }
    
    .recommended-products .col-lg-2-4,
    .recommended-products .col-md-2-4 {
        flex: 0 0 50% !important;
        max-width: 50% !important;
        width: 50% !important;
        padding: 8px !important;
        box-sizing: border-box;
    }

    .recommended-box .rp-product-title {
        font-size: 12px;
        line-height: 18px;
    }

    .recommended-box .plus-btn {
        opacity: 1;
        width: 25px;
        height: 25px;
        bottom: 5px;
        right: 5px;
    }

    .recommended-box .original-product-price {
        font-size: 10px;
        margin-left: 2px;
    }

    .rp-product-info .rp-product-title {
        font-size: 12px;
        line-height: 1.4;
        height: 2.8em;
    }
}
.breadcrumb {
    background-color: #f8f9fa;
    font-size: 14px;
}

.breadcrumb a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb a:hover {
    color: #dc3545;
    text-decoration: underline;
}






.section-header {
  display: flex;
  align-items: center;
  text-align: center;
  margin: 50px 0;
}

.section-header::before,
.section-header::after {
  content: "";
  flex: 1;
  border-bottom: 1px solid #8c7d7d;
}

.section-title {
  font-family: "Playfair Display", serif;
  font-size: 1.2rem;
  font-weight: 700;
  padding: 0 20px;
  color: #000; /* Or use var(--primary-color) */
  letter-spacing: 1px;
  white-space: nowrap;
  border: 1px solid #987777;
  padding: 6px 20px;
  background-color: #978787c2;
}
.product-brand {
    font-size: 14px;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.product-brand .fw-semibold {
    color: #333;
    font-weight: 600;
}

    </style>
@endpush








@section('contents')
    

    <nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb bg-white p-2 rounded">
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    @if($product->category)
    <li class="breadcrumb-item">
      <a href="{{ route('category.products', $product->category->id) }}">{{ $product->category->name }}</a>
    </li>
    @endif
    @if($product->subcategory)
    <li class="breadcrumb-item">
      <a href="{{ route('subcategory.products', $product->subcategory->id) }}">{{ $product->subcategory->name }}</a>
    </li>
    @endif
    
  </ol>
</nav>

        <div class="row">
            <div class="col-lg-6 col-md-7 col-sm-12 p-0 m-0">
                <div class="product-gallery-container">
                    <!-- Thumbnails Gallery (Left side on desktop) -->
                    <div class="thumbnails-container">
                        <!-- Main product image thumbnail -->
                        <div class="thumbnail-item active" data-bs-target="#productCarousel" data-bs-slide-to="0">
                            <img src="{{ asset('/uploads/products/' . $product->product_image) }}" alt="Main">
                        </div>

                        <!-- Gallery images thumbnails -->
                        @foreach ($product->galleryImages as $key => $image)
                            <div class="thumbnail-item" data-bs-target="#productCarousel"
                                data-bs-slide-to="{{ $key + 1 }}">
                                <img src="{{ asset('/uploads/gallery/' . $image->image) }}" alt="Gallery">
                            </div>
                        @endforeach
                    </div>

                    <!-- Main Carousel Container -->
                    <div class="main-image-container">
                        <div id="productCarousel" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner">
                                <!-- Main product image -->
                                <div class="carousel-item active">
                                    <img id="zoom_image" src="{{ asset('uploads/products/' . $product->product_image) }}"
                                        data-zoom-image="{{ asset('uploads/products/' . $product->product_image) }}"
                                        class="d-block" alt="{{ $product->name }}">
                                </div>

                                <!-- Gallery images -->
                                @foreach ($product->galleryImages as $key => $image)
                                    <div class="carousel-item">
                                        <img class="zoom_image_gallery"
                                            src="{{ asset('uploads/gallery/' . $image->image) }}"
                                            data-zoom-image="{{ asset('/uploads/gallery/' . $image->image) }}"
                                            class="d-block w-100" alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            </div>

                            <!-- Carousel Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Product Info -->
            <div class="col-lg-6 col-md-5 col-sm-6">
               <div class="product-info">
    <h1 class="product-details-title mb-3">{{ $product->product_name ?? 'NO Name' }}</h1>

    <?php
        $discount_type = $product->discount_type;
        $discount_amount = $product->discount_amount ?? 0;
        $sale_price = $product->sale_price;
        $final_price = $sale_price; // Default to sale price
        
        if ($discount_amount > 0) {
            if ($discount_type == 'fixed') {
                $final_price = $sale_price - $discount_amount;
            } elseif ($discount_type == 'percentage') {
                $discount_value = ($sale_price * $discount_amount) / 100;
                $final_price = $sale_price - $discount_value;
            }
        }
    ?>

    <input type="hidden" value="{{ $product->id }}" id="productID">

    <div class="product-brand mb-3">
        <span class="text-muted">Brand: </span>
        <span class="fw-semibold">{{ $product->brand->name ?? 'No Brand' }}</span>
    </div>

    <div class="product-price mb-4">
        {{-- Only show discount pricing if there's actually a discount --}}
        @if($discount_amount > 0 && $final_price < $sale_price)
            <span class="current-price h3">৳{{ number_format($final_price, 2) }}</span>
            <span class="original-price text-muted text-decoration-line-through ms-2">৳{{ number_format($sale_price, 2) }}</span>
            <span class="text-danger ms-2">
                @if($discount_type == 'percentage')
                    ({{ $discount_amount }}% Off)
                @else
                    (৳{{ $discount_amount }} Off)
                @endif
            </span>
        @else
            <span class="current-price h3">৳{{ number_format($sale_price, 2) }}</span>
        @endif
    </div>

    <!-- Product Description -->

    @if($product->variants)
        <!-- Color Selection -->
        <div class="variant-box d-flex mx-10 ">
<div class="color-selection mb-4  " style="">
            <h6 class="mb-2" style="font-family: 'Jost', sans-serif;">COLOR</h6>
            <div class="color-options d-flex gap-2">
                @foreach($product->variants->unique('color_id') as $variant)
                    <div class="color-option {{ $loop->first ? 'active' : '' }}" 
                         data-color="{{ $variant->color_id }}" 
                         style="background-color: {{ $variant->color->code }}">
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Size Selection -->
        <div class="size-selection mb-4 mx-5">
            <h6 class="mb-2" style="font-family: 'Jost', sans-serif;">SIZE</h6>
            <div class="size-options d-flex gap-2 flex-wrap">
                @foreach($product->variants->unique('size_id') as $variant)
                    <div class="size-option {{ $loop->first ? 'active' : '' }}" 
                         data-size="{{ $variant->size_id }}">
                        {{ $variant->size->name }}
                    </div>
                @endforeach
            </div>
        </div>

        </div>
        
    @endif

    <!-- Quantity -->
    <div class="addtocartbox d-flex">

<div class="quantity-section mb-4">
        <h6 class="mb-2">QUANTITY</h6>
        <div class="quantity-selector d-flex align-items-center gap-3">
            <button class="qty-btn" onclick="decrementQty()">-</button>
            <input type="number" id="quantity" value="1" min="1" 
                   class="form-control text-center" style="width: 60px;">
            <button class="qty-btn" onclick="incrementQty()">+</button>
        </div>
        @if($product->variants->sum('stock_quantity') < 10)
            <small class="text-danger">Only {{ $product->variants->sum('stock_quantity') }} left in stock!</small>
        @endif
    </div>

    <!-- Add to Cart Button -->
    <button id="addToCart" class="">
        ADD TO CART
    </button>
    </div>
    

  

      @php
    // Calculate final price for sharing
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
    
    // Create share text with price
    $shareTitle = $product->product_name . " - ৳" . number_format($final_price, 2);
    $shareText = $discount_amount > 0 && $final_price < $sale_price 
        ? $product->product_name . " now only ৳" . number_format($final_price, 2) . " (was ৳" . number_format($sale_price, 2) . ") 💸"
        : $product->product_name . " - ৳" . number_format($final_price, 2);
    
    $fullShareText = $shareText . " | Shop now: " . url()->current();
@endphp
<!-- Social Share Section -->
<div class="social-share">
    <div class="social-share-title">
        <i class="fas fa-share-alt"></i>
        <span>Share this product:</span>
    </div>

    <div class="social-links">
        <!-- Facebook with price -->
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&quote={{ urlencode($shareTitle . ' | ' . strip_tags(Str::limit($product->description ?? '', 100))) }}" 
           target="_blank" class="social-share-btn facebook"
           onclick="window.open(this.href, 'facebook-share','width=580,height=296'); return false;">
            <i class="fab fa-facebook-f"></i>
        </a>

        <!-- Instagram -->
        <a href="https://www.instagram.com/" 
           target="_blank" class="social-share-btn instagram"
           title="Share on Instagram (copy: {{ $shareText }})">
            <i class="fab fa-instagram"></i>
        </a>

        <!-- WhatsApp with price and emojis -->
        <a href="https://api.whatsapp.com/send?text={{ urlencode('🛍️ Check out this amazing product! ' . $fullShareText . ' 🔥') }}" 
           target="_blank" class="social-share-btn whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>

        <!-- Twitter with price and hashtags -->
        <a href="https://twitter.com/intent/tweet?text={{ urlencode($shareText . ' #Shopping #Deals') }}&url={{ urlencode(url()->current()) }}" 
           target="_blank" class="social-share-btn twitter"
           onclick="window.open(this.href, 'twitter-share', 'width=580,height=296'); return false;">
            <i class="fab fa-twitter"></i>
        </a>

        <!-- Email with detailed price info -->
        <a href="mailto:?subject={{ urlencode($shareTitle) }}&body={{ urlencode('I found this great product: ' . $fullShareText . "\n\nProduct Details:\n" . strip_tags($product->description ?? '')) }}" 
           class="social-share-btn email">
            <i class="fas fa-envelope"></i>
        </a>

        <!-- Copy Link Button with Price -->
        <button class="social-share-btn" style="background-color: #6c757d; border: none;" 
                onclick="copyProductLink()" title="Copy link with price">
            <i class="fas fa-link"></i>
        </button>
    </div>
</div>
    </div>
</div>
            </div>
        </div>
        <!-- Product Tabs -->
        <div class="product-tabs mt-2 mb-4">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-danger active" id="description-tab" data-bs-toggle="tab"
                        data-bs-target="#description" type="button" role="tab" aria-controls="description"
                        aria-selected="true">
                        Details
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link text-danger" id="additional-tab" data-bs-toggle="tab"
                        data-bs-target="#additional" type="button" role="tab" aria-controls="additional"
                        aria-selected="false">
                        ADDITIONAL
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="productTabContent">
                <!-- Description Tab -->
                <!-- Description Tab -->
<div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
    <div class="d-flex justify-content-center">
        <div class="text-center" style="1000px; margin-left:30px; margin-right:30px;">
            <p>{!! $product->description !!}</p>
        </div>
    </div>
</div>



                <!-- Additional Information Tab -->
                <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                    <div class="additional-info">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%;">Brand</th>
                                    <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Category</th>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Subcategory Name:</th>
                                    <td>{{ $product->subcategory->name ?? 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">Product Code</th>
                                    <td>{{ $product->product_code }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




      {{-- Recommended Products Section --}}
@if(isset($recommendedProducts) && $recommendedProducts->count() > 0)
<section id="recommended-products-section" class="recommended-products">
    <div class="container mt-5">
        <div class="section-header">
<h2 class="section-title" style="text-align: center;">You May Also Like</h2>

        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach($recommendedProducts as $product)
                    <?php
                        $discount_type = $product->discount_type;
                        $discount_amount = $product->discount_amount ?? 0;
                        $sale_price = $product->sale_price;
                        $final_price = $sale_price;

                        // Skip discount calculation if discount_type is null or discount amount is 0
                        if ($discount_amount > 0) {
                            if ($discount_type === 'fixed') {
                                $final_price = $sale_price - $discount_amount;
                            } elseif ($discount_type === 'percentage') {
                                $final_price = $sale_price - ($sale_price / 100) * $discount_amount;
                            }
                        }
                    ?>
                    <div class="col-md-2-4 col-lg-2-4">
                        <div class="recommended-box">
                            <div class="recommended-image">
                                <a href="{{ route('product.details', $product->id) }}">
                                    <img class="primary-image" src="{{ asset('uploads/products/' . $product->product_image) }}" alt="{{ $product->product_name }}">
                                </a>
                                <button onclick="addToCartFromRecommended(
                                    event,
                                    {{ $product->id }},
                                    {{ $product->variants->first()->id ?? 0 }},
                                    {{ $final_price }},
                                    '{{ addslashes($product->product_name) }}',
                                    '{{ addslashes($product->brand->name ?? 'No Brand') }}',
                                    '{{ addslashes($product->category->name ?? 'Uncategorized') }}',
                                    '{{ addslashes($product->product_code) }}'
                                )" class="plus-btn" title="Add to Cart">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                            <div class="rp-product-info">
                                <div class="rp-product-price">
                                    <p class="rp-product-title">
                                        <a href="{{ route('product.details', $product->id) }}" style="color: inherit; text-decoration: none;">
                                            {{ $product->product_name }}
                                        </a>
                                    </p>

                                    {{-- Only show discount pricing if there's actually a discount --}}
                                    @if($discount_amount > 0 && $final_price < $sale_price)
                                    <div class="rp-price-row d-flex">
                                        <span class="rp-current-price">৳{{ $final_price }}</span>
                                        <span class="original-product-price">৳{{ $sale_price }}</span>
                                    </div>
                                    @else
                                    <span class="rp-current-price">৳{{ $sale_price }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
    </div>


    @php
        $productJson = [
            'event' => 'view_item',
            'ecommerce' => [
                'currency' => 'BDT',
                'value' => $final_price,
                'items' => [
                    [
                        'item_id' => $product->id,
                        'item_name' => $product->product_name,
                        'price' => $final_price,
                        'item_category' => $product->category->name ?? 'Uncategorized',
                        'item_brand' => $product->brand->name ?? 'No Brand',
                        'item_variant' => $product->product_code,
                    ],
                ],
            ],
        ];
    @endphp

    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(@json($productJson));
    </script>


@endsection
@push('ecomjs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle thumbnail clicks
            const thumbnails = document.querySelectorAll('.thumbnail-item');

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    // Remove active class from all thumbnails
                    thumbnails.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked thumbnail
                    this.classList.add('active');
                });
            });

            // Update thumbnail active state when carousel slides
            const carousel = document.getElementById('productCarousel');
            carousel.addEventListener('slide.bs.carousel', function(e) {
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                thumbnails[e.to].classList.add('active');
            });
        });










        // Quantity Controls
        function incrementQty() {
            const input = document.getElementById('quantity');
            input.value = parseInt(input.value) + 1;
        }

        function decrementQty() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }




        document.addEventListener('DOMContentLoaded', function() {
            // Size Selection
            const sizeBtns = document.querySelectorAll('.size-option');
            sizeBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    sizeBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Color Selection 
            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    colorOptions.forEach(o => o.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            document.getElementById('addToCart').addEventListener('click', async function() {
                const productId = document.getElementById('productID').value;
                const quantity = document.getElementById('quantity').value;
                const selectedColor = document.querySelector('.color-option.active');
                const selectedSize = document.querySelector('.size-option.active');

                // Extract the selected color and size IDs
                const selectedColorId = selectedColor ? selectedColor.getAttribute('data-color') : null;
                const selectedSizeId = selectedSize ? selectedSize.getAttribute('data-size') : null;

                // Debugging: Check selected values
                console.log('Selected Color ID:', selectedColorId);
                console.log('Selected Size ID:', selectedSizeId);

                // Validation
                if (!selectedColorId || !selectedSizeId) {
                    showToast('Please select both color and size', 'error');
                    return;
                }

                // Get product variants data from Blade
                const allvariants = JSON.parse('{!! addslashes(json_encode($allvariants)) !!}');

                console.log('Variants:', allvariants); // Debugging: Check the available variants

                // Find the correct variant based on selected color and size
                const variant = allvariants.find(v =>
                    v.color_id.toString() === selectedColorId &&
                    v.size_id.toString() === selectedSizeId
                );

                console.log('Matched Variant:', variant); // Debugging: Check if a variant was found

                if (!variant) {
                    showToast('Selected combination is not available', 'error');
                    return;
                }

                // Show loading state
                const addToCartBtn = this;
                const originalText = addToCartBtn.innerHTML;
                addToCartBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                addToCartBtn.disabled = true;

                try {
                    const response = await fetch('/add-to-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            varient_id: variant.id, // Corrected key name
                            quantity: quantity,
                            price: parseFloat('{{ $final_price }}')
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        updateCartCounts(data.cartCount);



                        window.dataLayer = window.dataLayer || [];
                        window.dataLayer.push({
                            event: 'add_to_cart',
                            ecommerce: {
                                currency: 'BDT',
                                value: parseFloat('{{ $final_price }}') * quantity,
                                items: [{
                                    item_id: '{{ $product->id }}',
                                    item_name: '{{ $product->product_name }}',
                                    price: parseFloat('{{ $final_price }}'),
                                    quantity: parseInt(quantity),
                                    item_category: '{{ $product->category->name ?? 'Uncategorized' }}',
                                    item_brand: '{{ $product->brand->name ?? 'No Brand' }}',
                                    item_variant: '{{ $product->product_code }}'
                                }]
                            }
                        });







                        showToast('Product added to cart successfully', 'success');
                    } else {
                        showToast(data.message || 'Failed to add product to cart', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Failed to add product to cart', 'error');
                } finally {
                    // Restore button state
                    addToCartBtn.innerHTML = originalText;
                    addToCartBtn.disabled = false;
                }
            });

            // Helper function for showing toast notifications
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `toast-notification ${type}`;
                toast.innerHTML = `
        <div class="toast-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
                document.body.appendChild(toast);

                // Force a reflow
                toast.offsetHeight;

                // Show toast
                toast.classList.add('show');

                // Remove after 3 seconds
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        });



        function updateCartCounts(count) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = count;
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            toast.innerHTML = `
        <div class="toast-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
            document.body.appendChild(toast);

            // Force a reflow
            toast.offsetHeight;

            // Show toast
            toast.classList.add('show');

            // Remove after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

async function addToCartFromRecommended(event, productId, variantId, price, productName, brandName, categoryName, productCode) {
    try {
        const clickedButton = event.currentTarget;
        clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        clickedButton.disabled = true;

        setTimeout(() => {
            clickedButton.innerHTML = '<i class="fas fa-plus"></i>';
            clickedButton.disabled = false;
        }, 3000);

        const response = await fetch('/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                varient_id: variantId,
                quantity: 1,
                price: price
            })
        });

        const data = await response.json();

        if (data.success) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = data.cartCount;
            });

            // Toggle cart sidebar
            toggleCart();

            // GTM tracking
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: 'add_to_cart',
                ecommerce: {
                    currency: 'BDT',
                    value: price,
                    items: [{
                        item_id: productId,
                        item_name: productName,
                        price: price,
                        quantity: 1,
                        item_category: categoryName,
                        item_brand: brandName,
                        item_variant: productCode
                    }]
                }
            });

            // Show success message (optional)
            showToast('Product added to cart!', 'success');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Failed to add product to cart', 'error');
    }
}








function copyProductLink() {
    const shareText = `{{ $shareText }}\n{{ url()->current() }}`;
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(shareText).then(() => {
            // Create a temporary notification
            const notification = document.createElement('div');
            notification.textContent = 'Product link with price copied!';
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; z-index: 1000;
                background: #28a745; color: white; padding: 10px 20px;
                border-radius: 4px; font-size: 14px;
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 3000);
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = shareText;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Product link with price copied!');
    }
}
    </script>
@endpush
