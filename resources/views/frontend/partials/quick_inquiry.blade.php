{{-- Quick Inquiry Form Section --}}
<section class="quick-inquiry-section py-5">
    <div class="container">
        <div class="quick-inquiry-card p-4 p-lg-5">
            <div class="row align-items-center g-5">

                {{-- Left: Copy --}}
                <div class="col-lg-5">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Quick Inquiry</span>
                    <h3 class="fw-bold text-dark mb-3 fs-2">Interested? Let's Talk.</h3>
                    <p class="text-secondary mb-4" style="line-height: 1.8;">
                        Drop us a quick message and our team will get back to you within 24 hours. No obligation, just a friendly chat about your dream nursery.
                    </p>
                    <div class="d-flex flex-column gap-3">
                        <a href="https://wa.me/94717199302" target="_blank" class="quick-contact-link d-flex align-items-center gap-3 text-decoration-none">
                            <div class="qc-icon bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.7 8.38 8.38 0 0 1 3.8.9L21 3z"></path></svg>
                            </div>
                            <div>
                                <span class="fw-bold text-dark d-block small">WhatsApp Us</span>
                                <span class="text-success very-small">+94 71 719 9302</span>
                            </div>
                        </a>
                        <a href="tel:0717199302" class="quick-contact-link d-flex align-items-center gap-3 text-decoration-none">
                            <div class="qc-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            </div>
                            <div>
                                <span class="fw-bold text-dark d-block small">Call Our Studio</span>
                                <span class="text-primary very-small">071 719 9302</span>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Right: Form --}}
                <div class="col-lg-7">
                    <form class="quick-inquiry-form" action="#" method="POST" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold text-dark small">Your Name</label>
                                <input type="text" name="name" class="form-control qi-input" placeholder="E.g. Priyani Perera" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold text-dark small">Phone / WhatsApp</label>
                                <input type="tel" name="phone" class="form-control qi-input" placeholder="+94 7X XXX XXXX" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark small">Service / Product of Interest</label>
                                <input type="text" name="subject" class="form-control qi-input" value="{{ $service['title'] ?? ($product['title'] ?? '') }}" placeholder="Which service or product?">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark small">Your Message</label>
                                <textarea name="message" class="form-control qi-input" rows="4" placeholder="Tell us about your nursery vision, timeline, and any special requirements..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold w-100">
                                    Send Inquiry
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="ms-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
