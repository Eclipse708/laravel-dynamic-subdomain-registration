@extends('layouts.auth-master')
@extends('layouts.partials.navbar')

<style>
 input:invalid {
  border-color: red;
}

input:valid {
  border-color: green;
}
</style>

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="{{ route('register.perform') }}" class="border p-4 shadow-sm rounded">

                    @csrf

                    <h1 class="h3 mb-3 fw-bold text-center">Register</h1>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                {{-- <label for="first_name" class="form-label">First Name</label> --}}
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required="required" autofocus>
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
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
                    </div>

                    <button class="w-100 btn btn-lg btn-dark" type="submit">Register</button>

                    @include('auth.partials.copy')
                </form>
            </div>
        </div>
    </div>
@endsection
