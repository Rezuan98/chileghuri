@push('ecomcss')
<style>
    /* Loading spinner */
    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

</style>
@endpush





<section id="new-arrivals-section" class="new-arrivals-products">
    <div class="container-fluid">
          <header class="arrival-section-header v2">
  {{-- <span class="eyebrow">Featured</span> --}}
  <h2 class="arrival-section-title">New Arrival Products</h2>
  {{-- <a href="{{ route('home') }}#featured" class="section-cta">View all</a> --}}
</header>
        <div class="row">
            <div class="col-lg-12">
               <div class="row">
                
    @foreach($new_arrival as $product)
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
   
    <div class="col-md-3 col-lg-3">
        <div class="new-arrival-box">
            <div class="new-arrival-image">
                <a href="{{ route('product.details',$product->id) }}">
                    <img class="primary-image" src="{{ asset('uploads/products/' . $product->product_image) }}" alt="{{ $product->name }}">
                   
                   @if($product->variants_sum_stock_quantity == 0)
            <div class="out-of-stock-band">Out of Stock</div>
        @endif
                   
                    @if($product->galleryImages->isNotEmpty())
                    <img class="hover-image" src="{{ asset('uploads/gallery/' . $product->galleryImages->first()->image) }}" alt="{{ $product->name }}">
                    @endif
                </a>


@if($product->variants_sum_stock_quantity > 0)
 <button onclick="addToCartFromNewArrivals(
                    {{ $product->id }},
                    {{ $product->variants->first()->id?? '' }},
                    {{ $final_price }},
                    '{{ addslashes($product->product_name) }}',
                    '{{ addslashes($product->brand->name ?? 'No Brand') }}',
                    '{{ addslashes($product->category->name ?? 'Uncategorized') }}',
                    '{{ addslashes($product->product_code) }}'
                )" class="plus-btn" title="Add to Cart">
                    <i class="fas fa-plus"></i>
                </button>
@else
  <button  class="plus-btn" title="Add to Cart" >
    <i class="fas fa-plus"></i>
  </button>
@endif





               
            </div>

            <div class="nap-product-info">
                <div class="nap-product-price">
                    <a href="{{ route('product.details',$product->id) }}" class="nap-product-title" style="color: inherit; text-decoration: none;">
                        {{ $product->product_name }}
                    </a>
                    
                    {{-- Only show discount pricing if there's actually a discount --}}
                   @if($discount_amount > 0 && $final_price < $sale_price)
                                    <div class="fp-price-row d-flex justify-content-between">
                                     <div class="first">
                                        <span class="fp-current-price">Tk{{ $final_price }}</span>
                                        <span style="font-size: 10px;">({{ $product->variants_sum_stock_quantity }} Instock)</span>
                                     </div>
                                        
                                        <span class="original-product-price">Tk{{ $sale_price }}</span>
                                    </div>
                                    @else
                                    <span class="fp-current-price">Tk{{ $sale_price }}</span>
                                    <span style="font-size: 10px;">({{ $product->variants_sum_stock_quantity }} Instock)</span>
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

@push('ecomjs')

<script>
    async function addToCartFromNewArrivals(productId
        , variantId
        , price
        , productName
        , brandName
        , categoryName
        , productCode) {
        try {
            // Show loading state on the clicked button
            const clickedButton = event.currentTarget;
            clickedButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            clickedButton.disabled = true;

            // Set timeout to restore button after 3 seconds
            setTimeout(() => {
                clickedButton.innerHTML = '<i class="fas fa-plus"></i>';
                clickedButton.disabled = false;
            }, 3000);

            const response = await fetch('/add-to-cart', {
                method: 'POST'
                , headers: {
                    'Content-Type': 'application/json'
                    , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    , 'Accept': 'application/json'
                }
                , body: JSON.stringify({
                    product_id: productId
                    , varient_id: variantId
                    , quantity: 1
                    , price: price
                })
            });

            const data = await response.json();

            if (data.success) {
                // Update cart count
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(element => {
                    element.textContent = data.cartCount;
                });

                // Open cart sidebar
                toggleCart();







                // ✅ Fire add_to_cart event dynamically
        //         window.dataLayer = window.dataLayer || [];
        //         window.dataLayer.push({
        //             event: 'add_to_cart'
        //             , ecommerce: {
        //                 currency: 'BDT'
        //                 , value: price
        //                 , items: [{
        //                     item_id: productId
        //                     , item_name: productName
        //                     , price: price
        //                     , quantity: 1
        //                     , item_category: categoryName
        //                     , item_brand: brandName
        //                     , item_variant: productCode
        //                 }]
        //             }
        //         });
        //     }
        // } catch (error) {
        //     console.error('Error:', error);
        // }









         }
    } catch (error) {
        console.error('Error:', error);
    }
}


</script>

@endpush


@push('ecomcss')
<style>
.arrival-section-header {
    margin-bottom: 15px;
    margin-top:15px;
}

.arrival-section-title {
    font-family:"Conthic", sans-serif; font-weight:400;
    font-size: 30px;
    color: #666;
    font-weight: bold;
    text-align: left;
    margin: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #ccc;
    width: 100%;
}
</style>
    
@endpush