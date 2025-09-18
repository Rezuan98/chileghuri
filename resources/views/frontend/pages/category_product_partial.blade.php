@if ($product->isEmpty())
    <div class="col-12 text-center py-5">
        <div
            style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 16px; padding: 40px; margin: 20px 0;">
            <i class="fas fa-search fa-4x text-muted mb-4"></i>
            <h4 class="text-muted mb-3">No products found</h4>
            <p class="text-muted mb-4">We couldn't find any products matching your search criteria.</p>

        </div>
    </div>
@else
    @foreach ($product as $products)
        <?php
        // Calculate final price with discount
        $discount_type = $products->discount_type;
        $discount_amount = $products->discount_amount ?? 0;
        $sale_price = $products->sale_price;
        $final_price = $sale_price;
        
        if ($discount_amount > 0) {
            if ($discount_type === 'fixed') {
                $final_price = $sale_price - $discount_amount;
            } elseif ($discount_type === 'percentage') {
                $final_price = $sale_price - ($sale_price / 100) * $discount_amount;
            }
        }
        
        // Ensure final price is not negative
        $final_price = max(0, $final_price);
        ?>
        <div class="cat-grid-col">
            <div class="cat-product-box">


                <div class="cat-product-image">
                    <a href="{{ route('product.details', $products->id) }}">
                        <img class="cat-primary-image" src="{{ asset('/uploads/products/' . $products->product_image) }}"
                            alt="{{ $products->product_name }}" loading="lazy">
                        @if ($products->galleryImages->isNotEmpty())
                            <img class="cat-hover-image"
                                src="{{ asset('/uploads/gallery/' . $products->galleryImages->first()->image) }}"
                                alt="{{ $products->product_name }}" loading="lazy">
                        @endif
                    </a>

                    @if ($products->total_stock > 0)
                        <button
                            onclick="addToCartFromCategory(
                event,
                {{ $products->id }},
                {{ $products->variants->first()->id }},
                {{ $final_price }},
                '{{ addslashes($products->product_name) }}',
                '{{ addslashes($products->brand->name ?? 'No Brand') }}',
                '{{ addslashes($products->category->name ?? 'Uncategorized') }}',
                '{{ addslashes($products->product_code) }}'
            )"
                            class="cat-plus-btn" title="Add to Cart">
                            <i class="fas fa-plus"></i>
                        </button>
                    @else
                    <button class="cat-plus-btn" title="Add to Cart">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        @endif

                </div>

                <div class="cat-product-info">
                    <p class="cat-product-title" title="{{ $products->product_name }}">{{ $products->product_name }}
                    </p>

                    <div class="cat-product-price">
    <div class="fp-price-row d-flex justify-content-between align-items-center">
        <!-- LEFT: always current price + stock -->
        <div class="price-left d-flex align-items-baseline gap-2">
            <span class="fp-current-price">
                ৳{{ number_format(($discount_amount > 0 && $final_price < $sale_price) ? $final_price : $sale_price, 0) }}
            </span>
            <span style="font-size: 10px;" class="stock small text-muted">({{ $products->total_stock }} in stock)</span>
        </div>

        <!-- RIGHT: original price only if discounted -->
        @if ($discount_amount > 0 && $final_price < $sale_price)
            <div class="price-right">
                <span class="original-product-price text-muted text-decoration-line-through">
                    ৳{{ number_format($sale_price, 0) }}
                </span>
            </div>
        @endif
    </div>
</div>

                </div>
            </div>
        </div>
    @endforeach
@endif

<script>
    async function addToCartFromCategory(event, productId, variantId, price, productName, brandName, categoryName,
        productCode) {
        try {
            const clickedButton = event.currentTarget;
            const originalContent = clickedButton.innerHTML;

            // Show loading state
            clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            clickedButton.disabled = true;
            clickedButton.style.background = '#6c757d';

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
                // Update cart count
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = data.cartCount;
                });

                // Show success state
                clickedButton.innerHTML = '<i class="fas fa-check"></i>';
                clickedButton.style.background = '#4F0808';

                // Open cart sidebar
                if (typeof toggleCart === 'function') {
                    toggleCart();
                }

                // // Google Analytics tracking
                // if (typeof window.dataLayer !== 'undefined') {
                //     window.dataLayer.push({
                //         event: 'add_to_cart',
                //         ecommerce: {
                //             currency: 'BDT',
                //             value: price,
                //             items: [{
                //                 item_id: productId,
                //                 item_name: productName,
                //                 price: price,
                //                 quantity: 1,
                //                 item_category: categoryName,
                //                 item_brand: brandName,
                //                 item_variant: productCode
                //             }]
                //         }
                //     });
                // }

                // Show notification
                if (typeof showNotification === 'function') {

                }

            } else {
                throw new Error(data.message || 'Failed to add product to cart');
            }

        } catch (error) {
            console.error('Error:', error);

            // Show error notification
            if (typeof showNotification === 'function') {
                showNotification('Failed to add product to cart. Please try again.', 'error');
            }

            // Show error state
            clickedButton.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
            clickedButton.style.background = '#dc3545';
        } finally {
            // Reset button after 2 seconds
            setTimeout(() => {
                clickedButton.innerHTML = '<i class="fas fa-plus"></i>';
                clickedButton.disabled = false;
                clickedButton.style.background = '#4F0808';
            }, 2000);
        }
    }
</script>
