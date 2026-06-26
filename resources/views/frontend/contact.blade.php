@extends('frontend.app')

@section('page_css', 'resources/scss/frontend/pages/contact.scss')
@section('classes_body', 'contact-page')

@section('content')
    {{-- Reusable Banner Partial --}}
    @include('frontend.partials.banner', [
        'title' => "Contact Lumos: Sri Lanka's Elite Kids Room & Nursery Designers",
        'bgImage' => 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&q=80&w=1600',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Contact']
        ]
    ])

    {{-- Main Contact Section --}}
    <section class="contact-page-section py-5 my-5">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill text-uppercase letter-spacing-1">Get In Touch</span>
                    <h2 class="display-6 fw-bold text-dark mb-3">Begin Your Design Journey</h2>
                    <p class="lead text-muted max-w-600 mx-auto">
                        Whether you are planning a cozy baby nursery, an interactive playroom, or looking for bespoke kids furniture, let's create something magical together.
                    </p>
                </div>
            </div>

            <div class="row g-5 align-items-stretch mb-5">
                {{-- Left Column: Contact Details --}}
                <div class="col-lg-5 d-flex flex-column justify-content-between gap-4">
                    
                    {{-- Card 1: Location --}}
                    <div class="contact-info-card p-4 d-flex align-items-start gap-4">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-2 fs-5">Visit Our Design Studio</h4>
                            <p class="text-secondary mb-0">358/2F, Kandy Road, Indighamula, Weboda, Sri Lanka.</p>
                            <a href="https://maps.google.com/?q=Lumos+Nursery+Design+Sri+Lanka" target="_blank" class="text-primary fw-bold text-decoration-none small mt-2 d-inline-block">Get Directions &rarr;</a>
                        </div>
                    </div>

                    {{-- Card 2: Calls & Messaging --}}
                    <div class="contact-info-card p-4 d-flex align-items-start gap-4">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-2 fs-5">Quick Contact</h4>
                            <p class="text-secondary mb-1"><strong>Phone:</strong> <a href="tel:0717199302" class="text-secondary text-decoration-none hover-primary">071 719 9302</a></p>
                            <p class="text-secondary mb-1"><strong>WhatsApp:</strong> <a href="https://wa.me/94717199302" target="_blank" class="text-secondary text-decoration-none hover-primary">+94 71 719 9302</a></p>
                            <p class="text-secondary mb-0"><strong>Email:</strong> <a href="mailto:hello@lumoskids.com" class="text-secondary text-decoration-none hover-primary">hello@lumoskids.com</a></p>
                        </div>
                    </div>

                    {{-- Card 3: Opening Hours --}}
                    <div class="contact-info-card p-4 d-flex align-items-start gap-4">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-2 fs-5">Studio Hours</h4>
                            <p class="text-secondary mb-1"><strong>Mon - Sat:</strong> 9:00 AM - 6:00 PM</p>
                            <p class="text-secondary mb-0"><strong>Sunday:</strong> By Appointment Only</p>
                        </div>
                    </div>

                </div>

                {{-- Right Column: Interactive Consultation Form --}}
                <div class="col-lg-7">
                    <div class="contact-form-card p-4 p-lg-5">
                        <h3 class="fw-bold text-dark mb-4 fs-4">Request a Design Consultation</h3>
                        
                        {{-- Form Status Success Banner --}}
                        <div class="alert alert-success submit-success-alert d-none mb-4 p-4 align-items-start gap-3" id="formSuccessAlert" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-success mt-1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <div>
                                <h5 class="alert-heading fw-bold mb-1">Inquiry Sent Successfully!</h5>
                                <p class="mb-0 text-secondary small">Thank you for contacting Lumos. Eng. Janith Wijesinghe or one of our nursery specialists will reach out to you within 24 hours.</p>
                            </div>
                        </div>

                        <form id="consultationForm" novalidate>
                            <div class="row g-4">
                                {{-- Full Name --}}
                                <div class="col-md-6">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" placeholder="Enter your name" required>
                                    <div class="invalid-feedback">Please enter your name.</div>
                                </div>

                                {{-- Phone Number --}}
                                <div class="col-md-6">
                                    <label for="phoneNumber">Phone Number</label>
                                    <input type="tel" class="form-control" id="phoneNumber" placeholder="e.g. 077 123 4567" required>
                                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                                </div>

                                {{-- Email Address --}}
                                <div class="col-12">
                                    <label for="emailAddress">Email Address</label>
                                    <input type="email" class="form-control" id="emailAddress" placeholder="name@example.com" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>

                                {{-- Type of Project --}}
                                <div class="col-12">
                                    <label for="projectType">Type of Project</label>
                                    <select class="form-select" id="projectType" required>
                                        <option value="" disabled selected>Select project category...</option>
                                        <option value="nursery">Baby Nursery Setup</option>
                                        <option value="playroom">Kids Playroom Transformation</option>
                                        <option value="furniture">Bespoke Child-Safe Furniture</option>
                                        <option value="backdrop">Custom Starry Wall Backdrop / Decor</option>
                                        <option value="commercial">Commercial Kids Play Zone</option>
                                        <option value="other">Other Inquiry</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a project category.</div>
                                </div>

                                {{-- Messages --}}
                                <div class="col-12">
                                    <label for="projectMessage">Share Your Requirements</label>
                                    <textarea class="form-control" id="projectMessage" rows="5" placeholder="Tell us about your baby's room size, theme preference, or custom furniture ideas..." required></textarea>
                                    <div class="invalid-feedback">Please describe your requirements.</div>
                                </div>

                                {{-- Submit --}}
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 w-100 py-3 fw-bold shadow-sm transition-all" id="btnSubmitForm">
                                        Send Consultation Inquiry &rarr;
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Styled Full-Width Map wrapper --}}
            <div class="row pt-4">
                <div class="col-12">
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.8804071375753!2d80.0097653!3d7.0232422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2fb87d55df27d%3A0xea28f800808a2808!2sWeboda%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1716012435010!5m2!1sen!2slk" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('consultationForm');
    const successAlert = document.getElementById('formSuccessAlert');
    const submitBtn = document.getElementById('btnSubmitForm');

    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Client-side validation check
            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            // Animate submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Sending Your Inquiry...
            `;

            const formData = {
                name: document.getElementById('fullName').value,
                phone: document.getElementById('phoneNumber').value,
                email: document.getElementById('emailAddress').value,
                subject: 'Consultation: ' + document.getElementById('projectType').value,
                message: document.getElementById('projectMessage').value,
                _token: '{{ csrf_token() }}'
            };

            fetch('{{ route('contact.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send Consultation Inquiry &rarr;';
                if (data.status === 'success') {
                    form.reset();
                    form.classList.remove('was-validated');
                    successAlert.classList.remove('d-none');
                    successAlert.classList.add('d-flex');
                    successAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    alert('Submission failed. Please try again.');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send Consultation Inquiry &rarr;';
                alert('An error occurred. Please try again.');
            });
        });
    }
});
</script>
@endsection
