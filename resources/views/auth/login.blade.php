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
                        Contact us to tailor features according to your needs!"
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- Email input -->
                                <div class="mb-4">
                                    <div class="form-outline">
                                        <input type="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus />
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
                                                required autocomplete="current-password" />
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
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4">Login</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Contact Us</h4>
                        <p>Email: roystek23@gmail.com</p>
                        <p>Phone: +971 528502524</p>
                    </div>
                    <div class="col-md-6">
                        <h4>Our Work</h4>
                        <p>"Quality is not an act, it's a habit." - Aristotle</p>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#" class="social-icon"><i class="fab fa-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-icon"><i class="fab fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-icon"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>&copy; 2024 ROYSTEK . All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

    </section>

    <!-- Section: Design Block -->
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        const eyeOpen = document.querySelector("#eyeOpen");
        const eyeClosed = document.querySelector("#eyeClosed");

        togglePassword.addEventListener("click", function() {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            eyeOpen.style.display = type === "text" ? "block" : "none";
            eyeClosed.style.display = type === "text" ? "none" : "block";
        });
    });
</script>
