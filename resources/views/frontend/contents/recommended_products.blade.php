{{-- Create this as: resources/views/frontend/contents/recommended_products.blade.php --}}

@if($recommendedProducts->count() > 0)
<section class="recommended-products-section py-5">
    <div class="container">
        <div class="section-header text-center mb-4">
            <h2 class="section-title">You May Also Like</h2>
            <p class="section-subtitle text-muted">Discover similar products that might interest you</p>
        </div>
        
        <div class="row g-3">
            @foreach($recommendedProducts as $product)
                @php
                    // Calculate final price with discount
                    $discount_type = $product->discount_type;
                    $discount_amount = $product->discount_amount ?? 0;
                    $sale_price = $product->sale_price;
                    $final_price = $sale_price;
                    
                    if ($discount_amount > 0) {
                        if ($discount_type === 'fixed') {
                            $final_price = $sale_price - $discount_amount;
                        } elseif ($discount_type === 'percentage') {
                            $final_price = $sale_price - ($sale_price/100) * $discount_amount;
                        }
                    }
                @endphp
                
                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="recommended-product-card">
                        <div class="product-image-container">
                            <a href="{{ route('product.details', $product->id) }}">
                                <img class="product-main-image" 
                                     src="{{ asset('uploads/products/' . $product->product_image) }}" 
                                     alt="{{ $product->product_name }}">
                                
                                @if($product->galleryImages->isNotEmpty())
                                    <img class="product-hover-image" 
                                         src="{{ asset('uploads/gallery/' . $product->galleryImages->first()->image) }}" 
                                         alt="{{ $product->product_name }}">
                                @endif
                            </a>
                            
                            {{-- Stock badge --}}
                            <span class="stock-badge {{ $product->variants->sum('stock_quantity') > 0 ? 'in-stock' : 'out-of-stock' }}">
                                {{ $product->variants->sum('stock_quantity') > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                            
                            {{-- Discount badge --}}
                            @if($discount_amount > 0)
                                <span class="discount-badge">
                                    @if($discount_type === 'percentage')
                                        {{ $discount_amount }}% OFF
                                    @else
                                        ৳{{ $discount_amount }} OFF
                                    @endif
                                </span>
                            @endif
                            
                            {{-- Quick add to cart button --}}
                            <button onclick="addRecommendedToCart(
                                event,
                                {{ $product->id }},
                                {{ $product->variants->first()->id ?? 0 }},
                                {{ $final_price }},
                                '{{ addslashes($product->product_name) }}',
                                '{{ addslashes($product->brand->name ?? 'No Brand') }}',
                                '{{ addslashes($product->category->name ?? 'Uncategorized') }}',
                                '{{ addslashes($product->product_code) }}'
                            )" class="quick-add-btn" title="Add to Cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                        
                        <div class="product-info">
                            <h6 class="product-title">
                                <a href="{{ route('product.details', $product->id) }}">
                                    {{ Str::limit($product->product_name, 50) }}
                                </a>
                            </h6>
                            
                            <div class="product-price">
                                @if($discount_amount > 0)
                                    <span class="current-price">৳{{ number_format($final_price, 0) }}</span>
                                    <span class="original-price">৳{{ number_format($sale_price, 0) }}</span>
                                @else
                                    <span class="current-price">৳{{ number_format($sale_price, 0) }}</span>
                                @endif
                            </div>
                            
                            {{-- Rating (if you have a rating system) --}}
                            <div class="product-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= 4 ? 'filled' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="rating-count">({{ rand(10, 99) }})</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        {{-- View more button --}}
        <div class="text-center mt-4">
            <a href="{{ route('category.products', $recommendedProducts->first()->category_id ?? 1) }}" 
               class="btn btn-outline-primary">
                View More Products
            </a>
        </div>
    </div>
</section>

@push('ecomcss')
<style>
.recommended-products-section {
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.section-header .section-title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.section-header .section-subtitle {
    font-size: 1rem;
    margin-bottom: 0;
}

.recommended-product-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.recommended-product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-image-container {
    position: relative;
    overflow: hidden;
    padding-bottom: 75%; /* 4:3 Aspect Ratio */
    height: 0;
}

.product-main-image,
.product-hover-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.3s ease;
}

.product-hover-image {
    opacity: 0;
}

.recommended-product-card:hover .product-main-image {
    opacity: 0;
}

.recommended-product-card:hover .product-hover-image {
    opacity: 1;
}

.stock-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    z-index: 2;
}

.stock-badge.in-stock {
    background-color: #28a745;
    color: white;
}

.stock-badge.out-of-stock {
    background-color: #dc3545;
    color: white;
}

.discount-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #dc3545;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    z-index: 2;
}

.quick-add-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: #240808;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    cursor: pointer;
    z-index: 2;
}

.recommended-product-card:hover .quick-add-btn {
    opacity: 1;
}

.quick-add-btn:hover {
    background: #1a0606;
    transform: scale(1.1);
}

.product-info {
    padding: 1rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-title {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    line-height: 1.4;
}

.product-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-title a:hover {
    color: #240808;
}

.product-price {
    margin-bottom: 0.5rem;
}

.current-price {
    font-weight: 600;
    color: #240808;
    font-size: 1rem;
}

.original-price {
    text-decoration: line-through;
    color: #999;
    font-size: 0.85rem;
    margin-left: 0.5rem;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: auto;
}

.stars {
    display: flex;
    gap: 2px;
}

.stars i {
    font-size: 0.8rem;
    color: #ddd;
}

.stars i.filled {
    color: #ffc107;
}

.rating-count {
    font-size: 0.8rem;
    color: #666;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .section-header  {
        font-size: 1.5rem;
    }
    .section-title{
        font-size: 15px;
        font-family:'poppins' sans-serif;
    }
    
    .product-image-container {
        padding-bottom: 100%; /* Square aspect ratio on mobile */
    }
    
    .quick-add-btn {
        opacity: 1; /* Always visible on mobile */
        width: 35px;
        height: 35px;
    }
    
    .product-title {
        font-size: 0.85rem;
    }
    
    .current-price {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .recommended-products-section {
        padding: 2rem 0;
    }
    
    .product-info {
        padding: 0.75rem;
    }
}
</style>
@endpush

@push('ecomjs')
<script>
async function addRecommendedToCart(event, productId, variantId, price, productName, brandName, categoryName, productCode) {
    try {
        const clickedButton = event.currentTarget;
        const originalIcon = clickedButton.innerHTML;
        
        // Show loading state
        clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        clickedButton.disabled = true;

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

            // Show success feedback
            clickedButton.innerHTML = '<i class="fas fa-check"></i>';
            clickedButton.style.backgroundColor = '#28a745';
            
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

            // Show toast notification
            showToast('Product added to cart!', 'success');
            
        } else {
            showToast('Failed to add product to cart', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Something went wrong', 'error');
    } finally {
        // Reset button after 2 seconds
        setTimeout(() => {
            clickedButton.innerHTML = originalIcon;
            clickedButton.style.backgroundColor = '#240808';
            clickedButton.disabled = false;
        }, 2000);
    }
}

function showToast(message, type = 'success') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(toast);
    
    // Show with animation
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Remove after delay
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}













</script>
@endpush
@endif