<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ filled($title ?? null) ? $title.' - '.config('app.name', 'Corporate CMS') : config('app.name', 'Corporate CMS') }}</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <meta name="description" content="{{ $description ?? 'Corporate CMS' }}">
    <meta name="title" content="{{ $title ?? 'Corporate CMS' }}">
    <meta name="keywords" content="{{ $keywords ?? 'Corporate CMS' }}">
    <meta name="author" content="{{ $author ?? 'Corporate CMS' }}">
    <meta name="robots" content="index, follow">
    {{-- Custom Meta Tags --}}
    @yield('meta_tags')
    @fluxAppearance
    @vite(['resources/scss/frontend/app.scss', 'resources/js/app.js'])
    @hasSection('page_css')
        @vite([trim($__env->yieldContent('page_css'))])
    @endif
    @yield('plugin')
    @yield('css')
</head>
<body class="@yield('classes_body')" @yield('body_data')>
    <main>
        @include('frontend.partials.header')
        @yield('content')
        @include('frontend.partials.footer')
    </main>
    @fluxScripts
    @yield('modal')
    @yield('js')
    <!--Start of Tawk.to Script-->
    <!-- <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/69faaa6ab4023f1c343544e8/1jntijc7k';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script> -->
    <!--End of Tawk.to Script-->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const quickForms = document.querySelectorAll('.quick-inquiry-form');
        quickForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                // Form validation check
                if (!form.checkValidity()) {
                    event.stopPropagation();
                    form.classList.add('was-validated');
                    return;
                }

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sending...';

                // Gather data
                const formData = {
                    name: form.querySelector('[name="name"]').value,
                    phone: form.querySelector('[name="phone"]').value,
                    subject: form.querySelector('[name="subject"]').value || 'Quick Inquiry',
                    message: form.querySelector('[name="message"]').value,
                    email: 'inquirer@lumos.lk', // fallback email since quick inquiry doesn't ask for email
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
                    submitBtn.innerHTML = originalText;
                    if (data.status === 'success') {
                        form.reset();
                        form.classList.remove('was-validated');
                        alert('Your inquiry was successfully sent. A representative will contact you shortly.');
                    } else {
                        alert('Submission failed. Please try again.');
                    }
                })
                .catch(err => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    alert('An error occurred. Please try again.');
                });
            });
        });
    });
    </script>
</body>
</html>
