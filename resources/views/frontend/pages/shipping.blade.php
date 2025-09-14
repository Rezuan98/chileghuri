@extends('frontend.master.master')
@section('keyTitle', 'Shipping Details')

@push('ecomcss')
<style>
:root{--brand-600:#9A0000;--brand-700:#4f0808;--ink:#0f172a;--muted:#6b7280;--hairline:#e6e8ef;--bg:#ffffff;--bg-soft:#fafafa;--shadow:0 8px 24px rgba(16,24,40,.08);} @media(prefers-color-scheme:dark){:root{--ink:#f3f4f6;--muted:#a1a1aa;--hairline:#2a2a2a;--bg:#0b0b0b;--bg-soft:#0f0f0f;--shadow:0 8px 24px rgba(0,0,0,.35);}}

/* Page layout & cards */
.card{border:1px solid var(--hairline);border-radius:14px;box-shadow:var(--shadow);background:var(--bg);} 
.card .card-body{padding:1.25rem 1.25rem;} 
.container.py-5{scroll-margin-top:24px;} 

/* Headings & helpers */
h3.mb-4{font-weight:700;color:var(--ink);letter-spacing:.2px;margin-bottom:1.25rem!important;} 
.required:after{content:'*';color:#ef4444;margin-left:3px;} 

/* Inputs */
.form-control,.form-select{height:44px;border:1px solid var(--hairline);border-radius:10px;background:var(--bg);color:var(--ink);transition:border-color .2s ease,box-shadow .2s ease,background .2s ease;} 
.form-control:focus,.form-select:focus{border-color:var(--brand-600);box-shadow:0 0 0 .2rem rgba(154,0,0,.18);} 
.form-control[readonly]{background:var(--bg-soft);} 
.is-invalid,.form-control.is-invalid,.form-select.is-invalid{border-color:#ef4444!important;box-shadow:none;} 
.invalid-feedback{font-size:.8rem;} 

/* Payment methods wrapper */
.payment-methods{border:1px solid var(--hairline);border-radius:14px;padding:1rem;background:var(--bg-soft);} 
.payment-methods .form-check{margin:0;} 
.form-check-input{position:absolute;opacity:0;pointer-events:none;} 
.form-check-label{display:block;width:100%;} 

/* Payment tiles */
.payment-option{display:flex;align-items:center;gap:12px;padding:.9rem;border:1px solid var(--hairline);border-radius:12px;background:var(--bg);transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease,background .18s ease;} 
.payment-option:hover{transform:translateY(-1px);box-shadow:0 10px 24px rgba(16,24,40,.10);} 
.form-check-input:checked+.form-check-label .payment-option{border-color:rgba(154,0,0,.35);background:linear-gradient(180deg,rgba(154,0,0,.04),transparent);} 

/* Payment icons */
.payment-icon{width:44px;height:44px;border-radius:10px;background:linear-gradient(180deg,#f6f7f9,#eef1f6);display:flex;align-items:center;justify-content:center;margin:0;font-size:1.1rem;color:#495057;box-shadow:inset 0 1px 0 rgba(255,255,255,.6);} 
.bkash-icon{background:#e2136e;color:#fff;box-shadow:inset 0 1px 0 rgba(255,255,255,.25);} 

/* Payment details text */
.payment-details strong{display:block;font-size:1rem;color:var(--ink);} 
.payment-details p{font-size:.86rem;margin:0;color:var(--muted);} 

/* Selected tile aura */
.form-check-input:checked+.form-check-label .payment-option::after{content:'';display:block;position:absolute;inset:-2px;border-radius:12px;pointer-events:none;border:2px solid rgba(154,0,0,.25);} 

/* bKash box */
.bkash-payment-section{margin-top:1rem;padding:1rem;border:2px dashed #e2136e;border-radius:12px;background:linear-gradient(180deg,#fff7fb,#fff);} 
.bkash-payment-section .alert{background:#e2136e;color:#fff;border:none;border-radius:10px;padding:.75rem 1rem;} 
.bkash-payment-section .alert h6{margin:0 0 .5rem;font-weight:700;} 
.bkash-payment-section ol{padding-left:1.1rem;margin:0;} 
.bkash-payment-section .form-control:focus{border-color:#e2136e;box-shadow:0 0 0 .2rem rgba(226,19,110,.25);} 
.form-text{color:var(--muted);} 

/* Order summary (sticky on desktop) */
.col-lg-4 .card{position:sticky;top:24px;} 
.card-title{font-weight:700;} 
.border-top{border-top:1px solid var(--hairline)!important;} 
hr{border-top:1px solid var(--hairline);} 

/* Buttons */
.btn{border-radius:12px;font-weight:700;padding:.85rem 1rem;box-shadow:0 8px 20px rgba(154,0,0,.15);transition:transform .15s ease,box-shadow .15s ease,opacity .15s ease;} 
.btn:hover{transform:translateY(-1px);box-shadow:0 12px 26px rgba(154,0,0,.22);} 
.btn:disabled{opacity:.7;box-shadow:none;} 

/* Alerts (global tone) */
.alert-info{background:linear-gradient(180deg,#f0f7ff,#eaf2ff);border:1px solid #cfe3ff;color:#0f3d87;border-radius:10px;} 

/* Mobile tweaks */
@media(max-width:768px){.payment-option{flex-direction:column;align-items:flex-start;text-align:left;} .payment-icon{margin:0 0 .5rem 0;} .card .card-body{padding:1rem;} .col-lg-4 .card{position:static;}}

/* Tiny polish on labels */
label.form-label{font-weight:600;color:var(--ink);margin-bottom:.35rem;}
.payment-methods input[type="radio"]{
  appearance: auto !important;
  -webkit-appearance: radio !important;
  display: inline-block !important;
  width: auto !important;
  height: auto !important;
  opacity: 1 !important;
}
.payment-methods label { cursor: pointer; }

</style>
@endpush


@section('contents')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                @if (!Auth::check())
                    <div class="alert alert-info mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('user.login') }}" class="btn btn-sm btn-primary">Login</a>
                        </div>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-4">Shipping Information</h3>

                        <form action="{{ route('store.order') }}" method="POST" id="shippingForm">
                            @csrf

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h6>Please fix the following errors:</h6>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label class="form-label required">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ Auth::check() ? Auth::user()->name : old('name') }}"
                                        {{ Auth::check() ? 'readonly' : '' }}>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label class="form-label required">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ Auth::check() ? Auth::user()->email : old('email') }}"
                                        {{ Auth::check() ? 'readonly' : '' }}>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label class="form-label required">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}"
                                        {{ Auth::check() ? 'readonly' : '' }}>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- City/Delivery Area -->
                                <div class="col-md-6">
                                    <label class="form-label required">Delivery Area</label>
                                    <select class="form-select @error('city') is-invalid @enderror" name="city"
                                        id="deliveryLocation">
                                        <option value="{{ $deliveryCharge1->charge ?? '70' }}"
                                            {{ old('city') == ($deliveryCharge1->charge ?? '70') ? 'selected' : '' }}>
                                            Inside Dhaka (৳{{ $deliveryCharge1->charge ?? '70' }})
                                        </option>
                                        <option value="{{ $deliveryCharge2->charge ?? '110' }}"
                                            {{ old('city') == ($deliveryCharge2->charge ?? '110') ? 'selected' : '' }}>
                                            Outside Dhaka (৳{{ $deliveryCharge2->charge ?? '110' }})
                                        </option>
                                    </select>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label class="form-label required">Delivery Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" value="{{ Auth::check() ? Auth::user()->address : old('address') }}"
                                        placeholder="House no, Road no, Area">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Postal Code -->
                                <div class="col-md-6">
                                    <label class="form-label required">Postal Code</label>
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                        name="postal_code" value="{{ old('postal_code') }}">
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Payment Method -->
                                <div class="col-12 mb-4">
                                    <h6 class="mb-3">Payment Method</h6>
                                    <div class="payment-methods">
                                        <!-- Cash on Delivery -->
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                id="cod" value="cod" 
                                                {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}
                                                onchange="togglePaymentFields()">
                                            <label class="form-check-label" for="cod">
                                                <div class="payment-option">
                                                    <div class="payment-icon">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </div>
                                                    <div class="payment-details">
                                                        <strong>Cash on Delivery</strong>
                                                        <p class="text-muted mb-0">Pay when you receive your order</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <!-- Bkash Payment -->
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                id="bkash" value="bkash" 
                                                {{ old('payment_method') == 'bkash' ? 'checked' : '' }}
                                                onchange="togglePaymentFields()">
                                            <label class="form-check-label" for="bkash">
                                                <div class="payment-option">
                                                    <div class="payment-icon bkash-icon">
                                                        <img src="{{ asset('frontend/images/bkashlogo.svg') }}"
                                                            alt="Bkash" style="width: 30px; height: 30px;">
                                                    </div>
                                                    <div class="payment-details">
                                                        <strong>Bkash</strong>
                                                        <p class="text-muted mb-0">Pay using Bkash mobile banking</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>







{{-- <div class="payment-methods space-y-2">
  <h5 class="font-semibold">Payment Method</h5>

  <label for="cod" class="inline-flex items-center gap-2">
    <input type="radio" name="payment_method" id="cod" value="cod" checked class="accent-black">
    <span>Cash on Delivery</span>
  </label>

  <label for="sslcommerz" class="inline-flex items-center gap-2">
    <input type="radio" name="payment_method" id="sslcommerz" value="sslcommerz" class="accent-black">
    <span>Online Payment (Card/Mobile Banking)</span>
  </label>

  <label for="bkash" class="inline-flex items-center gap-2">
    <input type="radio" name="payment_method" id="bkash" value="bkash" class="accent-black">
    <span>Bkash</span>
  </label>
</div> --}}



















                                    <!-- Bkash Payment Fields -->
                                    <div id="bkash-fields" class="bkash-payment-section" 
                                         style="display: {{ old('payment_method') == 'bkash' ? 'block' : 'none' }};">
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-info-circle"></i> Bkash Payment Instructions:</h6>
                                            <ol class="mb-0">
                                                <li>Send money to: <strong>{{ $settings->phone ?? '017764815056' }}</strong></li>
                                                <li>Use the total amount: <strong>৳<span id="total-amount">0.00</span></strong></li>
                                                <li>Enter your mobile number and transaction ID below</li>
                                            </ol>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="bkash_mobile" class="form-label">Your Bkash Mobile Number <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('bkash_mobile') is-invalid @enderror" 
                                                           id="bkash_mobile"
                                                           name="bkash_mobile" 
                                                           value="{{ old('bkash_mobile') }}"
                                                           placeholder="01XXXXXXXXX"
                                                           pattern="^01[3-9]\d{8}$" 
                                                           maxlength="11">
                                                    <div class="form-text">Enter your 11-digit mobile number</div>
                                                    @error('bkash_mobile')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="bkash_transaction_id" class="form-label">Transaction ID <span class="text-danger">*</span></label>
                                                    <input type="text" 
                                                           class="form-control @error('bkash_transaction_id') is-invalid @enderror" 
                                                           id="bkash_transaction_id"
                                                           name="bkash_transaction_id" 
                                                           value="{{ old('bkash_transaction_id') }}"
                                                           placeholder="8N7A5B2C3D"
                                                           maxlength="20">
                                                    <div class="form-text">Enter the transaction ID from Bkash</div>
                                                    @error('bkash_transaction_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Notes -->
                                <div class="col-12">
                                    <label class="form-label">Order Notes (Optional)</label>
                                    <textarea class="form-control" name="order_notes" rows="3" placeholder="Special notes for delivery">{{ old('order_notes') }}</textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" style="background-color: #9A0000;" class="btn  w-100">
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Order Summary</h4>

                        <!-- Cart Items -->
                        <div class="mb-4">
                            @foreach ($cartItems as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span>{{ $item->product->product_name }}</span>
                                        <small class="text-muted d-block">
                                            {{ $item->variant->color->name ?? 'N/A' }} /
                                            {{ $item->variant->size->name ?? 'N/A' }}
                                        </small>
                                        <small class="text-muted">x {{ $item->quantity }}</small>
                                    </div>
                                    <span>৳{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Totals -->
                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>৳{{ number_format(
                                    $cartItems->sum(function ($item) {
                                        return $item->price * $item->quantity;
                                    }),
                                    2,
                                ) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span id="shippingCost">৳{{ number_format($deliveryCharge1->charge ?? 70, 2) }}</span>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong id="orderTotal">৳{{ number_format(
                                    $cartItems->sum(function ($item) {
                                        return $item->price * $item->quantity;
                                    }) + ($deliveryCharge1->charge ?? 70),
                                ) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('ecomjs')
    <script>
        // GTM tracking
        // window.dataLayer = window.dataLayer || [];
        // window.dataLayer.push({
        //     event: 'begin_checkout',
        //     ecommerce: {
        //         currency: 'BDT',
        //         value: {{ $cartItems->sum(function($item) { return $item->price * $item->quantity; }) }},
        //         items: [
        //             @foreach($cartItems as $item)
        //             {
        //                 item_id: {{ $item->product->id }},
        //                 item_name: '{{ $item->product->product_name }}',
        //                 price: {{ $item->price }},
        //                 quantity: {{ $item->quantity }},
        //                 item_category: '{{ $item->product->category->name ?? "Uncategorized" }}',
        //                 item_brand: '{{ $item->product->brand->name ?? "No Brand" }}',
        //                 item_variant: '{{ ($item->variant->color->name ?? "") . " / " . ($item->variant->size->name ?? "") }}'
        //             }{{ !$loop->last ? ',' : '' }}
        //             @endforeach
        //         ]
        //     }
        // });

        // Form validation and submission
        document.addEventListener('DOMContentLoaded', function() {
            const shippingForm = document.getElementById('shippingForm');
            
            // Initialize fields based on old values
            if (document.getElementById('bkash').checked) {
                togglePaymentFields();
            }
            
            // Form submission handler
            shippingForm.addEventListener('submit', function(e) {
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
                
                console.log('Form submitting with payment method:', paymentMethod);
                
                // Validate Bkash fields if Bkash is selected
                if (paymentMethod === 'bkash') {
                    const bkashMobile = document.getElementById('bkash_mobile').value.trim();
                    const bkashTransactionId = document.getElementById('bkash_transaction_id').value.trim();
                    
                    if (!bkashMobile || !bkashTransactionId) {
                        e.preventDefault();
                        alert('Please fill in all required Bkash payment fields');
                        return false;
                    }
                    
                    // Validate mobile number format
                    const mobilePattern = /^01[3-9]\d{8}$/;
                    if (!mobilePattern.test(bkashMobile)) {
                        e.preventDefault();
                        alert('Please enter a valid Bangladeshi mobile number (01XXXXXXXXX)');
                        return false;
                    }
                    
                    if (bkashTransactionId.length < 5) {
                        e.preventDefault();
                        alert('Please enter a valid transaction ID');
                        return false;
                    }
                }
                
                // Log all form data for debugging
                const formData = new FormData(this);
                console.log('All form data being submitted:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ':', value);
                }
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                
                return true;
            });
        });

        function togglePaymentFields() {
            const bkashFields = document.getElementById('bkash-fields');
            const bkashRadio = document.getElementById('bkash');
            const bkashMobile = document.getElementById('bkash_mobile');
            const bkashTransactionId = document.getElementById('bkash_transaction_id');

            if (bkashRadio.checked) {
                bkashFields.style.display = 'block';
                bkashMobile.required = true;
                bkashTransactionId.required = true;
                updateTotalAmount();
                
                console.log('Bkash payment selected - fields are now required');
            } else {
                bkashFields.style.display = 'none';
                bkashMobile.required = false;
                bkashTransactionId.required = false;
                
                console.log('COD payment selected - Bkash fields cleared');
            }
        }

        function updateTotalAmount() {
            const subtotal = parseFloat({{ $cartItems->sum(function($item) { return $item->price * $item->quantity; }) }});
            const shipping = parseFloat(document.getElementById('deliveryLocation').value);
            const total = subtotal + shipping;
            
            // Update amount in the DOM
            document.getElementById('total-amount').textContent = total.toFixed(2);
            
            console.log('Total amount updated:', total);
        }

        // Delivery location change handler
        document.getElementById('deliveryLocation').addEventListener('change', function() {
            const shippingCost = parseFloat(this.value);
            const subtotal = parseFloat({{ $cartItems->sum(function($item) { return $item->price * $item->quantity; }) }});
            const total = subtotal + shippingCost;

            document.getElementById('shippingCost').textContent = '৳' + shippingCost.toFixed(2);
            document.getElementById('orderTotal').textContent = '৳' + total.toFixed(2);

            // Also update Bkash total amount
            updateTotalAmount();
        });
    </script>
@endpush