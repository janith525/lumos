<footer class="footer-section pt-5 pb-4 bg-dark text-white">
    <div class="container">
        <div class="row g-4 mb-5">
            {{-- Company Info --}}
            <div class="col-lg-4 text-center text-lg-start">
                <div class="footer-logo mb-4">
                    <img src="{{ !empty($settings['logo']) ? asset('storage/' . $settings['logo']) : asset('storage/logo/logo.png') }}" alt="Lumos Studio" height="80" class="brightness-0 invert">
                </div>
                <p class="text-white-50 mb-4 max-w-350 mx-auto mx-lg-0">
                    {{ $settings['footer_description'] ?? 'Sri Lanka\'s first and only specialized interior design studio dedicated to creating "tiny dreams" through bespoke nursery and baby room setups.' }}
                </p>
                <div class="social-links d-flex gap-3 justify-content-center justify-content-lg-start">
                    @if(!empty($settings['header_facebook']) && $settings['header_facebook'] !== '#')
                        <a href="{{ $settings['header_facebook'] }}" target="_blank" class="social-link bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-white icon-size-40">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        </a>
                    @endif
                    @if(!empty($settings['header_instagram']) && $settings['header_instagram'] !== '#')
                        <a href="{{ $settings['header_instagram'] }}" target="_blank" class="social-link bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-white icon-size-40">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                        </a>
                    @endif
                    @if(!empty($settings['header_linkedin']) && $settings['header_linkedin'] !== '#')
                        <a href="{{ $settings['header_linkedin'] }}" target="_blank" class="social-link bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-white icon-size-40">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-6 col-lg-2">
                <h5 class="fw-bold mb-4">Explore</h5>
                <ul class="list-unstyled footer-nav">
                    @php
                        $footerLinks = [];
                        if (!empty($settings['footer_links'])) {
                            $footerLinks = json_decode($settings['footer_links'], true) ?: [];
                        }
                        if (empty($footerLinks)) {
                            $footerLinks = [
                                ['label' => 'About Us', 'url' => '{{SITE_URL}}/about'],
                                ['label' => 'Services', 'url' => '{{SITE_URL}}/services?type=services'],
                                ['label' => 'Furniture', 'url' => '{{SITE_URL}}/services?type=products'],
                                ['label' => 'Gallery', 'url' => '{{SITE_URL}}/gallery']
                            ];
                        }
                    @endphp
                    @foreach($footerLinks as $item)
                        @php
                            $url = str_replace('{{SITE_URL}}', url('/'), $item['url']);
                        @endphp
                        <li class="mb-2"><a href="{{ $url }}" class="text-white-50 text-decoration-none hover-white transition-all">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Information --}}
            <div class="col-6 col-lg-3">
                <h5 class="fw-bold mb-4">Information</h5>
                <ul class="list-unstyled footer-nav">
                    <li class="mb-2"><a href="{{ route('faq') }}" class="text-white-50 text-decoration-none hover-white transition-all">FAQ</a></li>
                    <li class="mb-2"><a href="{{ route('safety') }}" class="text-white-50 text-decoration-none hover-white transition-all">Safety Guide</a></li>
                    <li class="mb-2"><a href="{{ route('privacy') }}" class="text-white-50 text-decoration-none hover-white transition-all">Privacy Policy</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-white-50 text-decoration-none hover-white transition-all">Contacts</a></li>
                </ul>
            </div>

            {{-- Contact Info --}}
            <div class="col-lg-3">
                <h5 class="fw-bold mb-4">Visit Studio</h5>
                <p class="text-white-50 mb-2 d-flex align-items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-1"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    {{ $settings['footer_address'] ?? '358/2F, Kandy Road, Indighamula, Weboda, Sri Lanka' }}
                </p>
                <p class="text-white-50 mb-2 d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    {{ $settings['footer_phone'] ?? '071 719 9302' }}
                </p>
                <p class="text-white-50 d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    {{ $settings['footer_email'] ?? 'hello@lumos.lk' }}
                </p>
            </div>
        </div>

        <div class="footer-bottom pt-4 border-top border-secondary border-opacity-20 text-center">
            <p class="small mb-0">
                &copy; {{ date('Y') }} {{ $settings['footer_copyright'] ?? 'Lumos Nursery Interior Studio. All rights reserved.' }}
                <span class="mx-2">|</span>
                Designed by <a href="https://www.lynx.lk" target="_blank" class="text-white-50 text-decoration-none hover-white transition-all">Lynx Creation</a>
            </p>
        </div>
    </div>
</footer>
