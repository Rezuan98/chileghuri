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

        $description = strip_tags(Str::limit($product->description ?? '', 100));
        $priceText = $discount_amount > 0 && $final_price < $sale_price
            ? 'Price: ৳' . number_format($final_price, 0) . ' (was ৳' . number_format($sale_price, 0) . ')'
            : 'Price: ৳' . number_format($final_price, 0);
        $fullDescription = $description . ' | ' . $priceText;
    @endphp

    <!-- Basic Open Graph Tags -->
    <meta property="og:title" content="{{ $product->product_name }} - ৳{{ number_format($final_price, 0) }}">
    <meta property="og:description" content="{{ $fullDescription }}">
    <meta property="og:image" content="{{ url('uploads/products/' . $product->product_image) }}">
    <meta property="og:image:secure_url" content="{{ secure_url('uploads/products/' . $product->product_image) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $product->product_name }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="product">
    <meta property="og:site_name" content="{{ config('app.name') }}">

    <!-- Product Specific Tags -->
    <meta property="product:price:amount" content="{{ $final_price }}">
    <meta property="product:price:currency" content="BDT">
    @if ($discount_amount > 0 && $final_price < $sale_price)
        <meta property="product:original_price:amount" content="{{ $sale_price }}">
    @endif
    <meta property="product:availability" content="in stock">
    <meta property="product:brand" content="{{ $product->brand->name ?? 'Unknown' }}">

    <!-- Additional Images -->
    @foreach ($product->galleryImages->take(2) as $image)
        <meta property="og:image" content="{{ url('uploads/gallery/' . $image->image) }}">
    @endforeach

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->product_name }} - ৳{{ number_format($final_price, 0) }}">
    <meta name="twitter:description" content="{{ $fullDescription }}">
    <meta name="twitter:image" content="{{ url('uploads/products/' . $product->product_image) }}">
@endpush

@section('keyTitle', 'Product Details')
@push('ecomcss')
    <style>

    </style>
@endpush








@section('contents')


    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-white p-2 rounded">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            @if ($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('category.products', $product->category->id) }}">{{ $product->category->name }}</a>
                </li>
            @endif
            @if ($product->subcategory)
                <li class="breadcrumb-item">
                    <a
                        href="{{ route('subcategory.products', $product->subcategory->id) }}">{{ $product->subcategory->name }}</a>
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
                                    <img class="zoom_image_gallery" src="{{ asset('uploads/gallery/' . $image->image) }}"
                                        data-zoom-image="{{ asset('/uploads/gallery/' . $image->image) }}"
                                        class="d-block w-100" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="prev">
                            <i class="fas fa-chevron-left fa-2x text-dark"></i>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="next">
                            <i class="fas fa-chevron-right fa-2x text-dark"></i>
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
                    @if ($discount_amount > 0 && $final_price < $sale_price)
                        <span class="current-price h3">TK{{ number_format($final_price, 2) }}</span>
                        <span
                            class="original-price text-muted text-decoration-line-through ms-2">৳{{ number_format($sale_price, 2) }}</span>
                        <span class="text-danger ms-2">
                            @if ($discount_type == 'percentage')
                                ({{ $discount_amount }}% Off)
                            @else
                                (৳{{ $discount_amount }} Off)
                            @endif
                        </span>
                    @else
                        <span class="current-price h3">TK{{ number_format($sale_price, 2) }}</span>
                    @endif
                </div>

                <!-- Product Description -->

                @if ($product->variants)
                    <!-- Color Selection -->
                    <div class="variant-box d-flex mx-1 ">
                        <div class="color-selection mb-4  " style="">
                            <h6 class="mb-2" style="font-family: 'AloveraDisplay',sans-serif;">COLOR</h6>
                            <div class="color-options d-flex gap-2">
                                @foreach ($product->variants->unique('color_id') as $variant)
                                    <div class="color-option {{ $loop->first ? 'active' : '' }}"
                                        data-color="{{ $variant->color_id }}"
                                        style="background-color: {{ $variant->color->code }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Size Selection -->
                        <div class="size-selection mb-2">
                            <h6 class="mb-2" style="font-family: 'AloveraDisplay',sans-serif;">SIZE</h6>
                            <div class="size-options d-flex gap-2 flex-wrap">
                                @foreach ($product->variants->unique('size_id') as $variant)
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

                    <div class="purchase-row m-1">
        <div class="quantity-selector" role="group" aria-label="Quantity selector">
            <button type="button" class="qty-btn" onclick="decrementQty()" aria-label="Decrease">−</button>
            <input type="number" id="quantity" value="1" min="1" class="qty-input" inputmode="numeric">
            <button type="button" class="qty-btn" onclick="incrementQty()" aria-label="Increase">+</button>
        </div>

        @if($product->variants->sum('stock_quantity') > 0)
            <button id="addToCart" class="btn-cart">ADD TO CART</button>
        @else
            <button class="btn-cart btn-disabled" disabled>OUT OF STOCK</button>
        @endif

        @if($product->variants->sum('stock_quantity') > 0)
            <button id="buyNow" class="btn-buy">BUY NOW</button>
        @else
            <button class="btn-buy btn-disabled" disabled>OUT OF STOCK</button>
        @endif
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
                        $shareTitle = $product->product_name . ' - ৳' . number_format($final_price, 2);
                        $shareText =
                            $discount_amount > 0 && $final_price < $sale_price
                                ? $product->product_name .
                                    ' now only ৳' .
                                    number_format($final_price, 2) .
                                    ' (was ৳' .
                                    number_format($sale_price, 2) .
                                    ') '
                                : $product->product_name . ' - ৳' . number_format($final_price, 2);

                        $fullShareText = $shareText . ' | Shop now: ' . url()->current();
                    @endphp


                </div>
                @if ($product->variants->sum('stock_quantity') < 10)
                    <small class="text-danger d-block mt-1">
                        Only {{ $product->variants->sum('stock_quantity') }} left in stock!
                    </small>
                @endif
                <!-- Social Share Section -->
                <div class="social-share">


                    <div class="social-links">
                        <!-- Facebook with price -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&quote={{ urlencode($shareTitle . ' | ' . strip_tags(Str::limit($product->description ?? '', 100))) }}"
                            target="_blank" class="social-share-btn facebook"
                            onclick="window.open(this.href, 'facebook-share','width=580,height=296'); return false;">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <!-- Instagram -->
                        <a href="https://www.instagram.com/" target="_blank" class="social-share-btn instagram"
                            title="Share on Instagram (copy: {{ $shareText }})">
                            <i class="fa-brands fa-square-instagram"></i>
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
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                        <!-- Email with detailed price info -->

                    </div>
                </div>
                {{-- Product Description --}}
                <section class="product-desc mt-3">
                    <h6 class="desc-title">Product Description</h6>

                    <div id="descBody" class="desc-body collapsed">
                        {{-- If description contains HTML from your admin, keep {!! !!}. 
         If user-generated, switch to {{ }} to avoid XSS. --}}
                        {!! $product->description !!}
                    </div>

                    <button type="button" id="descToggle" class="desc-toggle">Read more</button>
                </section>

            </div>
        </div>
    </div>
    <!-- Product Tabs -->
    {{-- <div class="product-tabs mt-2 mb-4">
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
    </div> --}}




    {{-- Recommended Products Section --}}
    @if (isset($recommendedProducts) && $recommendedProducts->count() > 0)
        <section id="recommended-products-section" class="recommended-products">
            <div class="container mt-5">
                <div class="recommended-section-header">
                    <h2 class="recommended-section-title" >You May Also Like</h2>

                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            @foreach ($recommendedProducts as $product)
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
                                                <img class="primary-image"
                                                    src="{{ asset('uploads/products/' . $product->product_image) }}"
                                                    alt="{{ $product->product_name }}">
                                            </a>
                                            <button
                                                onclick="addToCartFromRecommended(
                                    event,
                                    {{ $product->id }},
                                    {{ $product->variants->first()->id ?? 0 }},
                                    {{ $final_price }},
                                    '{{ addslashes($product->product_name) }}',
                                    '{{ addslashes($product->brand->name ?? 'No Brand') }}',
                                    '{{ addslashes($product->category->name ?? 'Uncategorized') }}',
                                    '{{ addslashes($product->product_code) }}'
                                )"
                                                class="plus-btn" title="Add to Cart">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                        <div class="rp-product-info">
                                            <div class="rp-product-price">
                                                <p class="rp-product-title">
                                                    <a href="{{ route('product.details', $product->id) }}"
                                                        style="color: inherit; text-decoration: none;">
                                                        {{ $product->product_name }}
                                                    </a>
                                                </p>

                                                {{-- Only show discount pricing if there's actually a discount --}}
                                                @if ($discount_amount > 0 && $final_price < $sale_price)
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
        // window.dataLayer = window.dataLayer || [];
        // window.dataLayer.push(@json($productJson));
    </script>


@endsection
@push('ecomjs')
    <script>
       // Replace your existing Buy Now JavaScript with this
document.addEventListener('DOMContentLoaded', function() {
    // Buy Now button event listener
    const buyNowBtn = document.getElementById('buyNow');
    if (buyNowBtn && !buyNowBtn.disabled) {
        buyNowBtn.addEventListener('click', async function() {
            const productId = document.getElementById('productID').value;
            const quantity = document.getElementById('quantity').value;
            const selectedColor = document.querySelector('.color-option.active');
            const selectedSize = document.querySelector('.size-option.active');

            const selectedColorId = selectedColor ? selectedColor.getAttribute('data-color') : null;
            const selectedSizeId = selectedSize ? selectedSize.getAttribute('data-size') : null;

            if (!selectedColorId || !selectedSizeId) {
                showToast('Please select both color and size', 'error');
                return;
            }

            const allvariants = JSON.parse('{!! addslashes(json_encode($allvariants)) !!}');
            const variant = allvariants.find(v =>
                v.color_id.toString() === selectedColorId &&
                v.size_id.toString() === selectedSizeId
            );

            if (!variant) {
                showToast('Selected combination is not available', 'error');
                return;
            }

            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            this.disabled = true;

            try {
                const response = await fetch('/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        varient_id: variant.id,
                        quantity: quantity,
                        price: parseFloat('{{ $final_price }}')
                    })
                });

                const data = await response.json();

                if (data.success) {
                    updateCartCounts(data.cartCount);
                    window.location.href = '/cart/index';
                } else {
                    showToast(data.message || 'Failed to process order', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to process order', 'error');
            } finally {
                this.innerHTML = originalText;
                this.disabled = false;
            }
        });
    }

    // Add to Cart button event listener
    const addToCartBtn = document.getElementById('addToCart');
    if (addToCartBtn && !addToCartBtn.disabled) {
        addToCartBtn.addEventListener('click', async function() {
            // Your existing add to cart code here
            const productId = document.getElementById('productID').value;
            const quantity = document.getElementById('quantity').value;
            const selectedColor = document.querySelector('.color-option.active');
            const selectedSize = document.querySelector('.size-option.active');

            const selectedColorId = selectedColor ? selectedColor.getAttribute('data-color') : null;
            const selectedSizeId = selectedSize ? selectedSize.getAttribute('data-size') : null;

            if (!selectedColorId || !selectedSizeId) {
                showToast('Please select both color and size', 'error');
                return;
            }

            const allvariants = JSON.parse('{!! addslashes(json_encode($allvariants)) !!}');
            const variant = allvariants.find(v =>
                v.color_id.toString() === selectedColorId &&
                v.size_id.toString() === selectedSizeId
            );

            if (!variant) {
                showToast('Selected combination is not available', 'error');
                return;
            }

            const originalText = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
            this.disabled = true;

            try {
                const response = await fetch('/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        varient_id: variant.id,
                        quantity: quantity,
                        price: parseFloat('{{ $final_price }}')
                    })
                });

                const data = await response.json();

                if (data.success) {
                    updateCartCounts(data.cartCount);
                    showToast('Product added to cart successfully', 'success');
                } else {
                    showToast(data.message || 'Failed to add product to cart', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to add product to cart', 'error');
            } finally {
                this.innerHTML = originalText;
                this.disabled = false;
            }
        });
    }
});




















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

            // document.getElementById('addToCart').addEventListener('click', async function() {
            //     const productId = document.getElementById('productID').value;
            //     const quantity = document.getElementById('quantity').value;
            //     const selectedColor = document.querySelector('.color-option.active');
            //     const selectedSize = document.querySelector('.size-option.active');

            //     // Extract the selected color and size IDs
            //     const selectedColorId = selectedColor ? selectedColor.getAttribute('data-color') : null;
            //     const selectedSizeId = selectedSize ? selectedSize.getAttribute('data-size') : null;

            //     // Debugging: Check selected values
            //     console.log('Selected Color ID:', selectedColorId);
            //     console.log('Selected Size ID:', selectedSizeId);

            //     // Validation
            //     if (!selectedColorId || !selectedSizeId) {
            //         showToast('Please select both color and size', 'error');
            //         return;
            //     }

            //     // Get product variants data from Blade
            //     const allvariants = JSON.parse('{!! addslashes(json_encode($allvariants)) !!}');

            //     console.log('Variants:', allvariants); // Debugging: Check the available variants

            //     // Find the correct variant based on selected color and size
            //     const variant = allvariants.find(v =>
            //         v.color_id.toString() === selectedColorId &&
            //         v.size_id.toString() === selectedSizeId
            //     );

            //     console.log('Matched Variant:', variant); // Debugging: Check if a variant was found

            //     if (!variant) {
            //         showToast('Selected combination is not available', 'error');
            //         return;
            //     }

            //     // Show loading state
            //     const addToCartBtn = this;
            //     const originalText = addToCartBtn.innerHTML;
            //     addToCartBtn.innerHTML =
            //         '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
            //     addToCartBtn.disabled = true;

            //     try {
            //         const response = await fetch('/add-to-cart', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            //                     .content,
            //                 'Accept': 'application/json'
            //             },
            //             body: JSON.stringify({
            //                 product_id: productId,
            //                 varient_id: variant.id, // Corrected key name
            //                 quantity: quantity,
            //                 price: parseFloat('{{ $final_price }}')
            //             })
            //         });

            //         const data = await response.json();

            //         if (data.success) {
            //             updateCartCounts(data.cartCount);



            //             // window.dataLayer = window.dataLayer || [];
            //             // window.dataLayer.push({
            //             //     event: 'add_to_cart',
            //             //     ecommerce: {
            //             //         currency: 'BDT',
            //             //         value: parseFloat('{{ $final_price }}') * quantity,
            //             //         items: [{
            //             //             item_id: '{{ $product->id }}',
            //             //             item_name: '{{ $product->product_name }}',
            //             //             price: parseFloat('{{ $final_price }}'),
            //             //             quantity: parseInt(quantity),
            //             //             item_category: '{{ $product->category->name ?? 'Uncategorized' }}',
            //             //             item_brand: '{{ $product->brand->name ?? 'No Brand' }}',
            //             //             item_variant: '{{ $product->product_code }}'
            //             //         }]
            //             //     }
            //             // });







            //             showToast('Product added to cart successfully', 'success');
            //         } else {
            //             showToast(data.message || 'Failed to add product to cart', 'error');
            //         }
            //     } catch (error) {
            //         console.error('Error:', error);
            //         showToast('Failed to add product to cart', 'error');
            //     } finally {
            //         // Restore button state
            //         addToCartBtn.innerHTML = originalText;
            //         addToCartBtn.disabled = false;
            //     }
            // });

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

        async function addToCartFromRecommended(event, productId, variantId, price, productName, brandName, categoryName,
            productCode) {
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

                    // // GTM tracking
                    // window.dataLayer = window.dataLayer || [];
                    // window.dataLayer.push({
                    //     event: 'add_to_cart',
                    //     ecommerce: {
                    //         currency: 'BDT',
                    //         value: price,
                    //         items: [{
                    //             item_id: productId,
                    //             item_name: productName,
                    //             price: price,
                    //             quantity: 1,
                    //             item_category: categoryName,
                    //             item_brand: brandName,
                    //             item_variant: productCode
                    //         }]
                    //     }
                    // });

                    // Show success message (optional)
                    showToast('Product added to cart!', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to add product to cart', 'error');
            }
        }








        // function copyProductLink() {
        //     const shareText = `{{ $shareText }}\n{{ url()->current() }}`;

        //     if (navigator.clipboard) {
        //         navigator.clipboard.writeText(shareText).then(() => {
        //             // Create a temporary notification
        //             const notification = document.createElement('div');
        //             notification.textContent = 'Product link with price copied!';
        //             notification.style.cssText = `
    //         position: fixed; top: 20px; right: 20px; z-index: 1000;
    //         background: #28a745; color: white; padding: 10px 20px;
    //         border-radius: 4px; font-size: 14px;
    //     `;
        //             document.body.appendChild(notification);

        //             setTimeout(() => {
        //                 document.body.removeChild(notification);
        //             }, 3000);
        //         });
        //     } else {
        //         // Fallback for older browsers
        //         const textArea = document.createElement('textarea');
        //         textArea.value = shareText;
        //         document.body.appendChild(textArea);
        //         textArea.select();
        //         document.execCommand('copy');
        //         document.body.removeChild(textArea);
        //         alert('Product link with price copied!');
        //     }
        // }








        document.addEventListener('DOMContentLoaded', function() {
            const body = document.getElementById('descBody');
            const btn = document.getElementById('descToggle');
            if (!body || !btn) return;

            // Hide toggle if content doesn't overflow
            const needsToggle = body.scrollHeight > body.clientHeight + 2;
            if (!needsToggle) btn.style.display = 'none';

            btn.addEventListener('click', () => {
                body.classList.toggle('collapsed');
                btn.textContent = body.classList.contains('collapsed') ? 'Read more' : 'Read less';
            });
        });
    </script>
@endpush
