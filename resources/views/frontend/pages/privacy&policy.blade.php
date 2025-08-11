@extends('frontend.master.master')

@section('keyTitle', 'Privacy Policy')

@section('contents')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Privacy Policy</h2>

                    <p class="text-muted text-center"><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>

                    <hr>

                    <h4 class="text-primary">1. Introduction</h4>
                    <p>Welcome to <strong>chileghuri</strong> ("we," "us," or "our"). This Privacy Policy explains how we collect, use, disclose, and protect your personal information when you visit our website, <a href="{{ url('/') }}" class="text-decoration-none">{{ url('/') }}</a>, and use our services. By using our website, you agree to the collection and use of information in accordance with this policy.</p>

                    <h4 class="text-primary mt-4">2. Information We Collect</h4>
                    <h5 class="text-secondary">2.1 Personal Information</h5>
                    <p>When you interact with our website, we may collect the following personal information:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Account Information:</strong> Name, email address, phone number, and password when you create an account.</li>
                        <li class="list-group-item"><strong>Order Information:</strong> Billing and shipping addresses, payment information, and order history.</li>
                        <li class="list-group-item"><strong>Contact Information:</strong> Information you provide when contacting our customer service or subscribing to newsletters.</li>
                        <li class="list-group-item"><strong>Profile Information:</strong> Any additional information you choose to provide in your user profile.</li>
                    </ul>

                    <h5 class="text-secondary mt-3">2.2 Non-Personal Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Technical Information:</strong> Browser type, device information, IP address, operating system, and referring website.</li>
                        <li class="list-group-item"><strong>Usage Information:</strong> Pages visited, time spent on our website, search terms, and interaction with our content.</li>
                        <li class="list-group-item"><strong>Cookies and Tracking:</strong> We use cookies and similar technologies to enhance user experience and analyze website performance.</li>
                    </ul>

                    <h4 class="text-primary mt-4">3. How We Use Your Information</h4>
                    <p>We use your information for the following purposes:</p>
                    <ul>
                        <li><strong>Order Processing:</strong> To process and fulfill your orders, send confirmations, and provide customer support.</li>
                        <li><strong>Account Management:</strong> To create and manage your user account and provide personalized services.</li>
                        <li><strong>Communication:</strong> To respond to your inquiries, send important updates, and provide customer service.</li>
                        <li><strong>Marketing:</strong> To send promotional emails, newsletters, and special offers (you can opt-out at any time).</li>
                        <li><strong>Website Improvement:</strong> To analyze website usage, improve our services, and enhance user experience.</li>
                        <li><strong>Security:</strong> To detect, prevent, and address fraud, security issues, and technical problems.</li>
                        <li><strong>Legal Compliance:</strong> To comply with applicable laws, regulations, and legal processes.</li>
                    </ul>

                    <h4 class="text-primary mt-4">4. Sharing of Information</h4>
                    <p>We do not sell, trade, or rent your personal information to third parties. However, we may share your information in the following circumstances:</p>
                    <ul>
                        <li><strong>Service Providers:</strong> With trusted third-party service providers who assist us in operating our website, processing payments (Cash on Delivery services, mobile banking), shipping orders, and providing customer support.</li>
                        <li><strong>Business Transfers:</strong> In connection with any merger, sale of company assets, financing, or acquisition of all or a portion of our business.</li>
                        <li><strong>Legal Requirements:</strong> When required by law, court order, or to protect our rights, property, or safety, or that of our users or others.</li>
                        <li><strong>Consent:</strong> With your explicit consent for any other purpose not described in this policy.</li>
                    </ul>

                    <h4 class="text-primary mt-4">5. Data Security</h4>
                    <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include:</p>
                    <ul>
                        <li>SSL encryption for data transmission</li>
                        <li>Secure servers and databases</li>
                        <li>Regular security assessments</li>
                        <li>Access controls and authentication procedures</li>
                    </ul>
                    <p>However, please note that no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>

                    <h4 class="text-primary mt-4">6. Your Rights and Choices</h4>
                    <p>You have the following rights regarding your personal information:</p>
                    <ul>
                        <li><strong>Access:</strong> Request access to your personal information that we hold.</li>
                        <li><strong>Correction:</strong> Request correction of inaccurate or incomplete personal information.</li>
                        <li><strong>Deletion:</strong> Request deletion of your personal information, subject to certain legal limitations.</li>
                        <li><strong>Opt-out:</strong> Unsubscribe from marketing communications at any time.</li>
                        <li><strong>Data Portability:</strong> Request a copy of your personal information in a portable format.</li>
                        <li><strong>Withdraw Consent:</strong> Withdraw your consent for data processing where we rely on consent.</li>
                    </ul>
                    <p>To exercise any of these rights, please contact us at <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a>.</p>

                    <h4 class="text-primary mt-4">7. Cookies and Tracking Technologies</h4>
                    <p>We use cookies and similar tracking technologies to:</p>
                    <ul>
                        <li>Remember your preferences and settings</li>
                        <li>Keep you logged in to your account</li>
                        <li>Analyze website traffic and user behavior</li>
                        <li>Provide personalized content and advertisements</li>
                        <li>Improve website functionality and performance</li>
                    </ul>
                    <p>You can manage your cookie preferences through your browser settings. However, disabling cookies may affect some website functionality.</p>

                    <h4 class="text-primary mt-4">8. Children's Privacy</h4>
                    <p>Our website is not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe that your child has provided us with personal information, please contact us, and we will delete such information from our records.</p>

                    <h4 class="text-primary mt-4">9. Third-Party Links and Services</h4>
                    <p>Our website may contain links to third-party websites, social media platforms, or services that are not operated by us. We are not responsible for the privacy practices of these third parties. We encourage you to review the privacy policies of any third-party websites you visit.</p>

                    <h4 class="text-primary mt-4">10. Data Retention</h4>
                    <p>We retain your personal information for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required or permitted by law. When we no longer need your personal information, we will securely delete or anonymize it.</p>

                    <h4 class="text-primary mt-4">11. International Data Transfers</h4>
                    <p>Your information may be transferred to and processed in countries other than your country of residence. We ensure that such transfers comply with applicable data protection laws and implement appropriate safeguards to protect your information.</p>

                    <h4 class="text-primary mt-4">12. Changes to This Privacy Policy</h4>
                    <p>We may update this Privacy Policy from time to time to reflect changes in our practices, technology, legal requirements, or other factors. We will notify you of any material changes by posting the updated policy on our website with a revised "Last Updated" date. Your continued use of our website after such changes constitutes acceptance of the updated policy.</p>

                    <h4 class="text-primary mt-4">13. Contact Information</h4>
                    <p>If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:</p>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1"><strong>📧 Email:</strong> <a href="mailto:{{ $settings->email }}" class="text-decoration-none">{{ $settings->email }}</a></p>
                        <p class="mb-1"><strong>📞 Phone:</strong> <a href="tel:{{ $settings->phone }}" class="text-decoration-none">{{ $settings->phone }}</a></p>
                        <p class="mb-0"><strong>📍 Address:</strong> {{ $settings->address }}</p>
                    </div>

                    <div class="text-center mt-5">
                        <p class="text-muted"><em>Your privacy is important to us. Thank you for trusting chileghuri with your personal information.</em></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection