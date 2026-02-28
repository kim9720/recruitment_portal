@extends('layouts.guest')

@section('content')
    <link rel="stylesheet" href="{{ asset('pagestyles/register.css') }}">

    <!-- Background Animation -->
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <!-- Centered Register Form -->
    <div class="register-container">
        <div class="register-card">
            <!-- Logo Header -->
            <div class="register-logo">
                <img src="{{ asset('assets/images/habari_logo.png') }}" alt="Habari Logo">
                <h1>Create Account <span>Habari Recruitment</span></h1>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-info">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="9"></line>
                        <line x1="9" y1="15" x2="9.01" y2="15"></line>
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Registration Form -->
            <form class="register-form" method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Login Credentials Section -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="section-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <h3>Login Credentials</h3>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input type="password" id="password" name="password" required autocomplete="new-password">
                                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                    <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            <div class="password-strength" id="password-strength"></div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="password_confirmation">Confirm Password *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                                <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                    <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="section-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <h3>Personal Information</h3>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="firstname">First Name *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" required autocomplete="given-name">
                            </div>
                            @error('firstname')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="middlename">Middle Name *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input type="text" id="middlename" name="middlename" value="{{ old('middlename') }}" required autocomplete="additional-name">
                            </div>
                            @error('middlename')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lastname">Last Name *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required autocomplete="family-name">
                            </div>
                            @error('lastname')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="6" r="3"></circle>
                                    <path d="M20.2 8C19.7 5 17.2 3 14 3c-3.87 0-7 3.13-7 7v3h2v-3c0-2.76 2.24-5 5-5s5 2.24 5 5v3h2V10a9.97 9.97 0 0 0-2.8-2z"></path>
                                </svg>
                                <select id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            @error('gender')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobilenumber1">Mobile Number 1 *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <input type="tel" id="mobilenumber1" name="mobilenumber1" value="{{ old('mobilenumber1') }}" required autocomplete="tel">
                            </div>
                            @error('mobilenumber1')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobilenumber2">Mobile Number 2 *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <input type="tel" id="mobilenumber2" name="mobilenumber2" value="{{ old('mobilenumber2') }}" required autocomplete="tel">
                            </div>
                            @error('mobilenumber2')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="adressline">Address Line *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="5 18 9 12 15 12 19 18"></polyline>
                                    <circle cx="12" cy="7" r="4"></circle>
                                    <path d="M4 21v-7"></path>
                                    <path d="M20 21v-7"></path>
                                </svg>
                                <input type="text" id="adressline" name="adressline" value="{{ old('adressline') }}" required autocomplete="street-address">
                            </div>
                            @error('adressline')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="region">Region *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 6h23"></path>
                                    <path d="M1 12h23"></path>
                                    <path d="M1 18h23"></path>
                                </svg>
                                <input type="text" id="region" name="region" value="{{ old('region') }}" required autocomplete="address-level1">
                            </div>
                            @error('region')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="reg_country">Country *</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" y1="9" x2="9" y2="9"></line>
                                    <line x1="9" y1="15" x2="15" y2="15"></line>
                                </svg>
                                <select id="reg_country" name="reg_country" required autocomplete="country-name">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}" {{ old('reg_country') == $country ? 'selected' : '' }}>
                                            {{ $country }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('reg_country')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <svg class="info-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="9"></line>
                        <line x1="9" y1="15" x2="9.01" y2="15"></line>
                    </svg>
                    <div>
                        <h4>What's Next?</h4>
                        <p>After registration, you'll be able to complete your profile by adding work experience, education details, and uploading your CV to access exclusive job opportunities.</p>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <span>Create Account</span>
                    <svg class="arrow-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </form>

            <div class="form-footer">
                <p>Already have an account? <a href="{{ route('login') }}" class="login-link">Sign In</a></p>
            </div>

            <!-- Back to Home Link -->
            <div class="back-home">
                <a href="{{ route('home') }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('.eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="m2.571 17.5 4.5-4.5"></path><path d="m17.429 6.5-4.5 4.5"></path><circle cx="12" cy="12" r="8"></circle>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        // Password Strength Indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength');

            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            strengthBar.className = 'password-strength';

            if (strength === 0) {
                strengthBar.innerHTML = '';
            } else if (strength === 1) {
                strengthBar.innerHTML = '<span class="weak">Weak</span>';
                strengthBar.classList.add('weak');
            } else if (strength === 2) {
                strengthBar.innerHTML = '<span class="medium">Medium</span>';
                strengthBar.classList.add('medium');
            } else if (strength === 3) {
                strengthBar.innerHTML = '<span class="good">Good</span>';
                strengthBar.classList.add('good');
            } else {
                strengthBar.innerHTML = '<span class="strong">Strong</span>';
                strengthBar.classList.add('strong');
            }
        });

        // Password Confirmation Match Validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;

            if (confirmPassword && password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        // Form Submission Loading State
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const submitBtn = document.querySelector('.btn-register');
            submitBtn.classList.add('loading');
            submitBtn.querySelector('span').textContent = 'Creating Account...';
        });

        // Add animation on load
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });

        // Form validation animations
        const inputs = document.querySelectorAll('.input-wrapper input, .input-wrapper select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Phone number formatting (Tanzania-specific)
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    if (value.startsWith('255')) {
                        // Already international
                    } else if (value.startsWith('0')) {
                        value = '255' + value.substring(1);
                    } else {
                        value = '255' + value;
                    }
                    if (value.length > 12) value = value.substring(0, 12);
                    e.target.value = '+' + value;
                }
            });
        });
    </script>

@endsection
