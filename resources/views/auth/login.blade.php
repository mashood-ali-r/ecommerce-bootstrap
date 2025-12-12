@extends('layouts.app')

@section('title', 'Sign In - EEZEPC.com')

@section('content')
    <div class="auth-page d-flex align-items-center justify-content-center"
        style="min-height: calc(100vh - 160px); background: linear-gradient(135deg, #131921 0%, #232f3e 50%, #37475a 100%);">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                    <!-- Auth Card -->
                    <div class="auth-card"
                        style="background: #fff; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,0.3); overflow: hidden;">

                        <!-- Header with Brand -->
                        <div class="text-center pt-4 pb-3" style="border-bottom: 1px solid #f0f0f0;">
                            <a href="{{ route('home') }}" class="text-decoration-none">
                                <span
                                    style="font-size: 28px; font-weight: 700; color: #131921; letter-spacing: -0.5px;">EEZEPC</span><span
                                    style="font-size: 28px; font-weight: 700; color: #ff9900;">.com</span>
                            </a>
                        </div>

                        <!-- Form Body -->
                        <div class="p-4">
                            <h4 class="mb-4 fw-bold" style="color: #131921;">Sign In</h4>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="alert alert-danger py-2 px-3"
                                    style="border-radius: 8px; font-size: 14px; border-left: 4px solid #d32f2f;">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login.post') }}">
                                @csrf

                                <!-- Email Field -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold"
                                        style="font-size: 13px; color: #131921;">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="background: #f7f7f7; border: 1px solid #d5d9d9; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa-solid fa-envelope" style="color: #666;"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" required autofocus
                                            style="border: 1px solid #d5d9d9; border-left: none; border-radius: 0 8px 8px 0; padding: 12px 15px; font-size: 14px;"
                                            placeholder="your@email.com">
                                    </div>
                                </div>

                                <!-- Password Field -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="password" class="form-label fw-semibold mb-0"
                                            style="font-size: 13px; color: #131921;">Password</label>
                                        <a href="#" style="font-size: 12px; color: #007185; text-decoration: none;">Forgot
                                            password?</a>
                                    </div>
                                    <div class="input-group mt-1">
                                        <span class="input-group-text"
                                            style="background: #f7f7f7; border: 1px solid #d5d9d9; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa-solid fa-lock" style="color: #666;"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" required
                                            style="border: 1px solid #d5d9d9; border-left: none; border-radius: 0 8px 8px 0; padding: 12px 15px; font-size: 14px;"
                                            placeholder="Enter your password">
                                    </div>
                                </div>

                                <!-- Remember Me -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                            style="border-radius: 4px; width: 18px; height: 18px; border: 1px solid #d5d9d9;">
                                        <label class="form-check-label ms-1" for="remember"
                                            style="font-size: 13px; color: #555;">Keep me signed in</label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-lg fw-semibold"
                                        style="background: linear-gradient(180deg, #f7ca65 0%, #f0ad4e 100%); border: 1px solid #c79a3b; color: #131921; border-radius: 8px; padding: 12px; font-size: 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: all 0.2s;">
                                        Sign In
                                    </button>
                                </div>
                            </form>

                            <!-- Terms -->
                            <p class="text-center mb-0" style="font-size: 11px; color: #888;">
                                By signing in, you agree to our <a href="#" style="color: #007185;">Terms of Use</a> and <a
                                    href="#" style="color: #007185;">Privacy Policy</a>.
                            </p>
                        </div>

                        <!-- Divider -->
                        <div class="px-4 py-2">
                            <div class="d-flex align-items-center">
                                <hr class="flex-grow-1" style="border-color: #ddd;">
                                <span class="px-3" style="font-size: 12px; color: #767676;">New to EEZEPC?</span>
                                <hr class="flex-grow-1" style="border-color: #ddd;">
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="px-4 pb-4">
                            <div class="d-grid">
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary"
                                    style="border: 1px solid #d5d9d9; border-radius: 8px; padding: 10px; font-size: 13px; color: #131921; background: linear-gradient(180deg, #f7f8fa 0%, #e7e9ec 100%); transition: all 0.2s;">
                                    Create your EEZEPC account
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Links -->
                    <div class="text-center mt-4">
                        <div style="font-size: 12px;">
                            <a href="#" class="text-white text-decoration-none me-3" style="opacity: 0.7;">Conditions of
                                Use</a>
                            <a href="#" class="text-white text-decoration-none me-3" style="opacity: 0.7;">Privacy
                                Notice</a>
                            <a href="#" class="text-white text-decoration-none" style="opacity: 0.7;">Help</a>
                        </div>
                        <p class="mt-2 mb-0" style="font-size: 11px; color: rgba(255,255,255,0.5);">© 2024 EEZEPC.com. All
                            rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .auth-card input:focus {
            border-color: #f0ad4e !important;
            box-shadow: 0 0 0 3px rgba(240, 173, 78, 0.15) !important;
            outline: none;
        }

        .auth-card .input-group:focus-within .input-group-text {
            border-color: #f0ad4e;
        }

        .auth-card .btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .auth-card .form-check-input:checked {
            background-color: #f0ad4e;
            border-color: #c79a3b;
        }
    </style>
@endsection