@extends('layouts.auth-master')
@extends('layouts.partials.navbar')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="register-form" method="POST" action="{{ route('register.perform') }}" class="border p-4 shadow-sm rounded">

                    @csrf

                    <h1 class="h3 mb-3 fw-bold text-center">Register</h1>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{-- <label for="first_name" class="form-label">First Name</label> --}}
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required="required" autofocus>
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{-- <label for="last_name" class="form-label">Last Name</label> --}}
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required="required">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        {{-- <label for="email" class="form-label">Email Address</label> --}}
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <span id="error-confirm-email" class="text-danger"></span>
                    </div>

                    <div class="form-group mb-3">
                        {{-- <label for="password" class="form-label">Password</label> --}}
                        <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        {{-- <label for="password_confirmation" class="form-label">Confirm Password</label> --}}
                        <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required="required">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                        <span id="error-confirm-password" class="text-danger"></span>
                    </div>

                    <button class="w-100 btn btn-lg btn-dark" type="submit">Register</button>

                    @include('auth.partials.copy')
                </form>
            </div>
        </div>
    </div>

    <script>
        const registerForm = document.getElementById('register-form');
        const inputs = document.querySelectorAll('input');
        const emailError = document.getElementById('error-confirm-email');
        const passwordConfirmError = document.getElementById('error-confirm-password');

        validateEmailField = () => {
            const email = document.querySelector('input[name="email"]');
            let pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            if (!email.value.match(pattern)) {
                email.style.borderColor = '#dc3545';
                emailError.textContent = 'Email format is incorrect';
                return false;
            } else {
                emailError.textContent = '';
                emailError.style.borderColor = '#28a745';
            }
        }

        validatePasswordFields = () => {
            const password = document.querySelector('input[name="password"]');
            const confirmPassword = document.querySelector('input[name="password_confirmation"]');

                if (password.value.length < 8) {
                    password.style.borderColor = '#dc3545';
                    confirmPassword.style.borderColor = '#dc3545';
                    passwordConfirmError.textContent = 'Password should be at least 8 characters long';
                    return false;
                } else if (password.value !== confirmPassword.value) {
                    password.style.borderColor = '#dc3545';
                    confirmPassword.style.borderColor = '#dc3545';
                    passwordConfirmError.textContent = 'Passwords do not match';
                    return false;
                }  else {
                    passwordConfirmError.textContent = '';
                    password.style.borderColor = '#28a745';
                    confirmPassword.style.borderColor = '#28a745';
                    return true;
                }
            }

        // automatic validation
        validatedField = (input) => {

            if (!input.checkValidity()) {
                input.style.borderColor = '#dc3545';
            } else {
                input.style.borderColor = '#28a745';
            }

            if (input.name === 'email') {
                validateEmailField();
            } else if (input.name === 'password' || input.name === 'password_confirmation') {
                validatePasswordFields();
            }
        }

        inputs.forEach(input => {
            input.addEventListener('blur', () => validatedField(input));
        });

        // On submit validation
        registerForm.addEventListener('submit', (event) => {
            let isValid = true;

            inputs.forEach(input => {

                if (!input.checkValidity()) {
                    input.style.borderColor = '#dc3545';
                    isValid = false;
                } else {
                    input.style.borderColor = '#28a745';
                    isValid = true;
                }
            });

            const password = document.querySelector('input[name="password"]');
            const confirmPassword = document.querySelector('input[name="password_confirmation"]');

            if (password.value !== confirmPassword.value) {
                password.style.borderColor = '#dc3545';
                confirmPassword.style.borderColor = '#dc3545';
                isValid = false;
                passwordConfirmError.textContent = 'Passwords do not match';
            } else if (password.value.length < 8) {
                password.style.borderColor = '#dc3545';
                confirmPassword.style.borderColor = '#dc3545';
                isValid = false;
                passwordConfirmError.textContent = 'Password should be at least 8 characters long';
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>

@endsection
