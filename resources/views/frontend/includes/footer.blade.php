<!-- WhatsApp Float Button -->
<div class="whatsapp-float">
    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', $settings->phone) }}?text=Hello%Chileghuri%2C%20I%20need%20help%20with..." target="_blank" class="whatsapp-btn">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

<!-- Copyright Section -->
<div class="copyright-section">
    <div class="container">
        <!-- Copyright Text -->
        <div class="text-center mb-4">
            <div class="copyright-text">
                Copyright © {{ date('Y') }} {{ $settings->site_name ?? 'Chieghuri' }}, All Rights Reserved
            </div>
        </div>
        
        <!-- Logo and Tagline -->
        <div class="text-center mb-4">
            <div class="footer-brand">
                <div class="brand-logo">
                    <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->site_name ?? 'Logo'  }} }}" alt="chileghuri" class="footer-logo">
                </div>
                
            </div>
        </div>
        
        <!-- Payment Icons -->
        <div class="text-center mb-4">
            <div class="payment-icons">
                <img src="{{ asset('frontend/images/visa.png') }}" alt="Visa" class="payment-icon">
                <img src="{{ asset('frontend/images/bkash.jpg') }}" alt="PayPal" class="payment-icon">
                <img src="{{ asset('frontend/images/nagad.png') }}" alt="Discover" class="payment-icon">
                <img src="{{ asset('frontend/images/dbbl.jpg') }}" alt="Mastercard" class="payment-icon">
            </div>
        </div>
        
        <!-- Bottom Links -->
        <div class="text-center">
            <div class="bottom-links">
                <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                <span class="separator">|</span>
                <a href="{{ route('terms.conditions') }}">Terms & Conditions</a>
                <span class="separator">|</span>
                <a href="{{ route('returns.exchanges') }}">Return & Refund Policy</a>
            </div>
        </div>
    </div>
</div>

<style>
.footer-logo {
    filter: brightness(0) invert(1);
}

</style>