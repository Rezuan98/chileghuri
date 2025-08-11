@extends('frontend.master.master')

@section('keyTitle', 'Terms & Conditions')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Terms & Conditions</h2>

                    <p class="text-muted text-center"><strong>Effective Date:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <h4 class="text-primary">1. Introduction</h4>
                    <p>Welcome to <strong>chileghuri!</strong> These Terms and Conditions ("T&C") govern your use of our website,
                        <a href="{{ url('/') }}" class="text-decoration-none">{{ url('/') }}</a>, and the purchase of products from our online store.</p>

                    <h4 class="text-primary mt-4">2. Acceptance of Terms</h4>
                    <p>By accessing or using our website, you agree to be bound by these T&C. If you are under 18,
                        you must have parental or guardian consent to use our services and make purchases.</p>

                    <h4 class="text-primary mt-4">3. Use of the Website</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">You may use this website only for lawful purposes and in accordance with these terms.</li>
                        <li class="list-group-item">Prohibited activities include fraud, hacking, spamming, or disrupting our services.</li>
                        <li class="list-group-item">Users must be at least 18 years old or have parental permission to make purchases.</li>
                        <li class="list-group-item">You are responsible for maintaining the confidentiality of your account information.</li>
                    </ul>

                    <h4 class="text-primary mt-4">4. Product Information</h4>
                    <p>We make every effort to display accurate product descriptions, pricing, and availability. However, we do not guarantee
                        that all product descriptions or other content on the site are 100% error-free. Product colors may vary due to screen differences.
                        We reserve the right to correct any errors, inaccuracies, or omissions at any time without prior notice.</p>

                    <h4 class="text-primary mt-4">5. Ordering and Payment</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Orders can be placed online through our secure checkout system.</li>
                        <li class="list-group-item">We accept Cash on Delivery (COD) and other payment methods as displayed at checkout.</li>
                        <li class="list-group-item">All prices are listed in Bangladeshi Taka (BDT) and are subject to change without prior notice.</li>
                        <li class="list-group-item">chileghuri reserves the right to cancel any order due to pricing errors, stock issues, or fraudulent activity.</li>
                        <li class="list-group-item">Order confirmation will be sent via email once your order is successfully placed.</li>
                    </ul>

                    <h4 class="text-primary mt-4">6. Shipping and Delivery</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">We offer delivery services within Bangladesh with different charges for inside and outside Dhaka.</li>
                        <li class="list-group-item">Shipping costs and estimated delivery times are displayed at checkout.</li>
                        <li class="list-group-item">Estimated delivery times are provided but not guaranteed due to external factors.</li>
                        <li class="list-group-item">We are not responsible for delays caused by shipping carriers, weather conditions, or other circumstances beyond our control.</li>
                        <li class="list-group-item">Customers are responsible for providing accurate delivery information.</li>
                    </ul>

                    <h4 class="text-primary mt-4">7. Returns and Exchanges</h4>
                    <p>Returns and exchanges are accepted within <strong>7 days</strong> of delivery for eligible items.</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Returned items must be unused, in original condition, and in original packaging.</li>
                        <li class="list-group-item">Proof of purchase (receipt or order confirmation) is required for all returns.</li>
                        <li class="list-group-item">Customers are responsible for return shipping costs unless the return is due to an error on our part.</li>
                        <li class="list-group-item">Refunds will be processed within 5-7 business days after we receive the returned item.</li>
                        <li class="list-group-item">Certain items such as undergarments, customized products, or items marked as "Final Sale" are not eligible for return.</li>
                    </ul>

                    <h4 class="text-primary mt-4">8. Intellectual Property</h4>
                    <p>All website content, including text, images, logos, graphics, and software, is owned by chileghuri or its licensors.
                        Unauthorized reproduction, modification, distribution, or commercial use of our content is strictly prohibited and may result in legal action.</p>

                    <h4 class="text-primary mt-4">9. User Accounts</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">You are responsible for maintaining accurate account information.</li>
                        <li class="list-group-item">You must keep your password secure and not share it with others.</li>
                        <li class="list-group-item">You are responsible for all activities that occur under your account.</li>
                        <li class="list-group-item">We reserve the right to suspend or terminate accounts that violate these terms.</li>
                    </ul>

                    <h4 class="text-primary mt-4">10. Limitation of Liability</h4>
                    <p>chileghuri is not liable for any indirect, incidental, special, consequential, or punitive damages arising from the use of our website or products.
                        Our total liability for any claim shall not exceed the amount paid for the specific product giving rise to the claim.</p>

                    <h4 class="text-primary mt-4">11. Privacy Policy</h4>
                    <p>For information on how we collect, use, and protect your personal data, please refer to our
                        <a href="{{ route('privacy.policy') }}" class="text-decoration-none">Privacy Policy</a>.
                        By using our website, you consent to our privacy practices as described in our Privacy Policy.</p>

                    <h4 class="text-primary mt-4">12. Governing Law</h4>
                    <p>These Terms and Conditions are governed by the laws of Bangladesh. Any disputes arising from these terms or your use of our website
                        will be resolved in the courts of Dhaka, Bangladesh.</p>

                    <h4 class="text-primary mt-4">13. Force Majeure</h4>
                    <p>chileghuri shall not be liable for any failure or delay in performance due to circumstances beyond our reasonable control, including but not limited to
                        natural disasters, government actions, strikes, or technical failures.</p>

                    <h4 class="text-primary mt-4">14. Changes to Terms</h4>
                    <p>We reserve the right to modify these terms at any time without prior notice. Changes will be posted on this page with an updated effective date.
                        Your continued use of our website after changes are posted constitutes acceptance of the updated terms.</p>

                    <h4 class="text-primary mt-4">15. Severability</h4>
                    <p>If any provision of these terms is found to be invalid or unenforceable, the remaining provisions will continue to be valid and enforceable.</p>

                    <h4 class="text-primary mt-4">16. Contact Information</h4>
                    <p>If you have any questions regarding these Terms & Conditions, please contact us at:</p>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1"><strong>📧 Email:</strong> <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a></p>
                        <p class="mb-1"><strong>📞 Phone:</strong> <a href="tel:{{ $settings->phone }}" class="text-decoration-none">{{ $settings->phone }}</a></p>
                        <p class="mb-0"><strong>📍 Address:</strong> {{ $settings->address }}</p>
                    </div>

                    <div class="text-center mt-5">
                        <p class="text-muted"><em>Thank you for choosing chileghuri. We appreciate your business!</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection