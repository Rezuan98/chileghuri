<section id="featured-products-section" class="featured-products">
    <div class="container-fluid mt-2">
        <div class="featured-header">
            <h3 class="featured-title">Featured Products</h3>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($featured as $product)
                        @if ($product->featured)
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
                            <div class="col-md-3 col-lg-3 mt-4">
                                <div class="featured-box">
                                    <div class="featured-image">
                                        <a href="{{ route('product.details', $product->id) }}">
                                            <img class="primary-image"
                                                src="{{ asset('uploads/products/' . $product->product_image) }}"
                                                alt="{{ $product->product_name }}">
                                            {{-- Out of Stock Badge --}}
                                            @if ($product->variants_sum_stock_quantity == 0)
                                                <div class="out-of-stock-band">Out of Stock</div>
                                            @endif

                                            @if ($product->galleryImages->isNotEmpty())
                                                <img class="hover-image"
                                                    src="{{ asset('uploads/gallery/' . $product->galleryImages->first()->image) }}"
                                                    alt="{{ $product->product_name }}">
                                            @endif
                                        </a>

                                        @if ($product->variants_sum_stock_quantity > 0)
                                            <button
                                                onclick="addToCartFromFeatured(
                                    {{ $product->id }},
                                    {{ $product->variants->first()->id }},
                                    {{ $final_price }},
                                    '{{ addslashes($product->product_name) }}',
                                    '{{ addslashes($product->brand->name ?? 'No Brand') }}',
                                    '{{ addslashes($product->category->name ?? 'Uncategorized') }}',
                                    '{{ addslashes($product->product_code) }}'
                                )"
                                                class="plus-btn" title="Add to Cart">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @else
                                            <button class="plus-btn" title="Add to Cart">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @endif

                                    </div>

                                    <div class="fp-product-info">
                                        <div class="fp-product-price">
                                            <p class="fp-product-title">
                                                <a href="{{ route('product.details', $product->id) }}"
                                                    style="color: inherit; text-decoration: none;">
                                                    {{ $product->product_name }}
                                                </a>
                                            </p>

                                            {{-- Only show discount pricing if there's actually a discount --}}
                                            @if ($discount_amount > 0 && $final_price < $sale_price)
                                                <div class="fp-price-row d-flex justify-content-between">
                                                    <div class="first">
                                                        <span class="fp-current-price">Tk{{ $final_price }}</span>
                                                        <span
                                                            style="font-size: 10px;">({{ $product->variants_sum_stock_quantity }}
                                                            Instock)</span>
                                                    </div>

                                                    <span class="original-product-price">Tk{{ $sale_price }}</span>
                                                </div>
                                            @else
                                                <span class="fp-current-price">Tk{{ $sale_price }}</span>
                                                <span
                                                    style="font-size: 10px;">({{ $product->variants_sum_stock_quantity }}
                                                    Instock)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('ecomjs')
    <script>
        async function addToCartFromFeatured(productId, variantId, price, productName, brandName, categoryName,
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

                    toggleCart();

                    // ✅ Fire add_to_cart event dynamically
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
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
@endpush

@push('ecomcss')
    <style>
        .featured-header {
            margin-bottom: 15px;
            margin-top: 15px;
        }

        .featured-title {
            font-family: "Conthic", sans-serif;
            font-weight: 400;
            font-size: 30px;
            color: #666;
            text-align: left;
            margin: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
            width: 100%;
        }
    </style>
@endpush
