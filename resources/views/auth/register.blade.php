@extends('auth.app')

@section('content')
    <!-- Section: Design Block -->
    <section class="background-radial-gradient overflow-hidden">
        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                        The best choice <br />
                        <span style="color: hsl(218, 81%, 75%)">for your business</span>
                    </h1>
                    <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                        "Empowering businesses with seamless and efficient billing solutions for a smarter tomorrow.
                        Contact us to tailor features according to your needs!" </p>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <h2 class="text-center mb-4">{{ __('Register') }}</h2>
                            <form id="registerForm" method="POST" action="{{ route('register') }}">
                                @csrf
                                <!-- Username input -->
                                <div class="mb-4">
                                    <div class="form-outline">
                                        <input type="text" id="username"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autofocus />
                                        <label class="form-label" for="username">Username</label>
                                        <small>use at least 4 characters</small> @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- First name input -->
                                <div class="mb-4">
                                    <div class="form-outline">
                                        <input type="text" id="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                            value="{{ old('first_name') }}" required />
                                        <label class="form-label" for="first_name">First name</label>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Email input -->
                                <div class="mb-4">
                                    <div class="form-outline">
                                        <input type="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required />
                                        <label class="form-label" for="email">Email address</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Password input -->
                                <div class="mb-4">
                                    <div class="form-outline">
                                        <div class="input-group">
                                            <input type="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required />
                                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                <!-- SVG Icon for Eye Open -->
                                                <svg id="eyeOpen" width="1em" height="1em" viewBox="0 0 16 16"
                                                    class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                    style="display: none;">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
                                                    <path
                                                        d="M8 3a5 5 0 0 0-4.546 2.916A5.022 5.022 0 0 1 8 4a5.022 5.022 0 0 1 4.546 1.916A5 5 0 0 0 8 3zm0 10a5.022 5.022 0 0 0-4.546-1.916A5 5 0 0 0 8 13a5.022 5.022 0 0 0 4.546-1.916A5 5 0 0 0 8 13z" />
                                                </svg>
                                                <!-- SVG Icon for Eye Closed -->
                                                <svg id="eyeClosed" width="1em" height="1em" viewBox="0 0 16 16"
                                                    class="bi bi-eye-slash" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.359 11.238a5.96 5.96 0 0 0 2.7-3.228.5.5 0 1 0-.928-.372 4.96 4.96 0 0 1-2.324 2.815.5.5 0 0 0 .552.785zM11.318 12.6a5.96 5.96 0 0 0 1.806-2.264.5.5 0 1 0-.928-.372 4.96 4.96 0 0 1-1.53 1.933.5.5 0 0 0 .652.703zm-6.08.064a4.963 4.963 0 0 1 3.287-.845.5.5 0 0 0 .265-.932 5.962 5.962 0 0 0-4.26.913.5.5 0 0 0 .708.864zM8 5.058a2.948 2.948 0 0 0-1.68.607.5.5 0 0 0 .66.752 1.95 1.95 0 1 1 2.14 3.26.5.5 0 0 0 .622.782 2.95 2.95 0 1 0-1.742-5.401zm-5.657.85a5.962 5.962 0 0 0-2.324 2.815.5.5 0 1 0 .928.372 4.962 4.962 0 0 1 2.324-2.815.5.5 0 1 0-.928-.372z" />
                                                    <path
                                                        d="M1.354 1.146a.5.5 0 1 0-.708.708L2.947 3.846a.5.5 0 1 0 .708-.708L1.354 1.146zm13.292 13.708a.5.5 0 1 0 .708-.708l-1.93-1.93a.5.5 0 1 0-.708.708l1.93 1.93zM8 13a4.96 4.96 0 0 1-4.546-2.916A4.963 4.963 0 0 1 8 12a4.963 4.963 0 0 1 4.546-1.916A4.96 4.96 0 0 1 8 13z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <label class="form-label" for="password">Password</label>
                                        <small id="password-strength" class="form-text"></small>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }} </strong>
                                            </span>
                                        @enderror
                                        <small class="text-muted"> Must be at least 8 characters long and include at least
                                            one uppercase letter, one lowercase letter,
                                            one numeric digit, and one special character.</small>
                                    </div>
                                </div>
                                <!-- Confirm Password input -->
                                <div class="mb-4">
                                    <div class="form-outline">
                                        <div class="input-group">
                                            <input type="password" id="password_confirmation" class="form-control"
                                                name="password_confirmation" required />
                                            <span class="input-group-text" id="togglePasswordConfirmation"
                                                style="cursor: pointer;">
                                                <!-- SVG Icon for Eye Open -->
                                                <svg id="eyeOpenConfirm" width="1em" height="1em" viewBox="0 0 16 16"
                                                    class="bi bi-eye" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
                                                    <path
                                                        d="M8 3a5 5 0 0 0-4.546 2.916A5.022 5.022 0 0 1 8 4a5.022 5.022 0 0 1 4.546 1.916A5 5 0 0 0 8 3zm0 10a5.022 5.022 0 0 0-4.546-1.916A5 5 0 0 0 8 13a5.022 5.022 0 0 0 4.546-1.916A5 5 0 0 0 8 13z" />
                                                </svg>
                                                <!-- SVG Icon for Eye Closed -->
                                                <svg id="eyeClosedConfirm" width="1em" height="1em"
                                                    viewBox="0 0 16 16" class="bi bi-eye-slash" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.359 11.238a5.96 5.96 0 0 0 2.7-3.228.5.5 0 1 0-.928-.372 4.96 4.96 0 0 1-2.324 2.815.5.5 0 0 0 .552.785zM11.318 12.6a5.96 5.96 0 0 0 1.806-2.264.5.5 0 1 0-.928-.372 4.96 4.96 0 0 1-1.53 1.933.5.5 0 0 0 .652.703zm-6.08.064a4.963 4.963 0 0 1 3.287-.845.5.5 0 0 0 .265-.932 5.962 5.962 0 0 0-4.26.913.5.5 0 0 0 .708.864zM8 5.058a2.948 2.948 0 0 0-1.68.607.5.5 0 0 0 .66.752 1.95 1.95 0 1 1 2.14 3.26.5.5 0 0 0 .622.782 2.95 2.95 0 1 0-1.742-5.401zm-5.657.85a5.962 5.962 0 0 0-2.324 2.815.5.5 0 1 0 .928.372 4.962 4.962 0 0 1 2.324-2.815.5.5 0 1 0-.928-.372z" />
                                                    <path
                                                        d="M1.354 1.146a.5.5 0 1 0-.708.708L2.947 3.846a.5.5 0 1 0 .708-.708L1.354 1.146zm13.292 13.708a.5.5 0 1 0 .708-.708l-1.93-1.93a.5.5 0 1 0-.708.708l1.93 1.93zM8 13a4.96 4.96 0 0 1-4.546-2.916A4.963 4.963 0 0 1 8 12a4.963 4.963 0 0 1 4.546-1.916A4.96 4.96 0 0 1 8 13z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    </div>
                                </div>
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Section: Design Block -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => (data[key] = value));
                console.log(data);
                try {
                    const response = await fetch('{{ route('register') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const result = await response.json();

                    if (result.success) {
                        alert('Registration successful. You can now login.');
                        window.location.href = '{{ route('login') }}';
                    } else if (result.errors) {
                        console.error(result.errors);
                        alert(
                            'There were errors during registration. Please check the console for details.'
                        );
                    } else {
                        alert(result.error ||
                            'An internal server error occurred. Please try again later.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An internal server error occurred. Please try again later.');
                }
            });

            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('password-strength');

            // Real-time username validation
            usernameInput.addEventListener('input', async function() {
                const username = usernameInput.value;
                try {
                    const response = await fetch('{{ route('validate.username') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            username: username
                        })
                    });

                    const result = await response.json();
                    if (result.available) {
                        usernameInput.classList.remove('is-invalid');
                        usernameInput.classList.add('is-valid');
                    } else {
                        usernameInput.classList.remove('is-valid');
                        usernameInput.classList.add('is-invalid');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // Real-time email validation
            emailInput.addEventListener('input', async function() {
                const email = emailInput.value;
                try {
                    const response = await fetch('{{ route('validate.email') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    });

                    const result = await response.json();
                    if (result.available) {
                        emailInput.classList.remove('is-invalid');
                        emailInput.classList.add('is-valid');
                    } else {
                        emailInput.classList.remove('is-valid');
                        emailInput.classList.add('is-invalid');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // Real-time password strength check
            passwordInput.addEventListener('input', function(e) {
                const password = e.target.value;
                const strength = calculatePasswordStrength(password);
                passwordStrength.textContent = `Password strength: ${strength}`;
                if (strength === 'Strong') {
                    passwordStrength.classList.remove('text-danger');
                    passwordStrength.classList.add('text-success');
                } else {
                    passwordStrength.classList.remove('text-success');
                    passwordStrength.classList.add('text-danger');
                }
            });

            // Function to calculate password strength
            function calculatePasswordStrength(password) {
                let strength = 0;

                // Check if password meets recommended requirements
                const lowercaseRegex = /[a-z]/;
                const uppercaseRegex = /[A-Z]/;
                const digitRegex = /[0-9]/;
                const specialCharRegex = /[@$!%*?&]/;

                if (password.length >= 8) strength++;
                if (lowercaseRegex.test(password)) strength++;
                if (uppercaseRegex.test(password)) strength++;
                if (digitRegex.test(password)) strength++;
                if (specialCharRegex.test(password)) strength++;

                return strength >= 5 ? 'Strong' : strength >= 3 ? 'Medium' : 'Weak';
            }

            // Real-time password confirmation check
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            passwordConfirmationInput.addEventListener('input', function(e) {
                const confirmPassword = e.target.value;
                const password = passwordInput.value;

                if (confirmPassword !== password) {
                    passwordConfirmationInput.classList.add('is-invalid');
                } else {
                    passwordConfirmationInput.classList.remove('is-invalid');
                }
            });

            const togglePassword = document.querySelector('#togglePassword');
            const eyeOpen = document.querySelector('#eyeOpen');
            const eyeClosed = document.querySelector('#eyeClosed');

            togglePassword.addEventListener('click', function(e) {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                eyeOpen.style.display = eyeOpen.style.display === 'none' ? 'inline' : 'none';
                eyeClosed.style.display = eyeClosed.style.display === 'none' ? 'inline' : 'none';
            });

            const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
            const eyeOpenConfirm = document.querySelector('#eyeOpenConfirm');
            const eyeClosedConfirm = document.querySelector('#eyeClosedConfirm');

            togglePasswordConfirmation.addEventListener('click', function(e) {
                const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' :
                    'password';
                passwordConfirmationInput.setAttribute('type', type);
                eyeOpenConfirm.style.display = eyeOpenConfirm.style.display === 'none' ? 'inline' : 'none';
                eyeClosedConfirm.style.display = eyeClosedConfirm.style.display === 'none' ? 'inline' :
                    'none';
            });
        });
    </script>
