@extends('layouts.auth-master')
@extends('layouts.partials.navbar')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <form method="post" class="border p-4 shadow-sm rounded" action="{{ route('login.perform') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                    <h1 class="h3 mb-3 fw-normal text-center">Login</h1>

                    @include('layouts.partials.messages')

                    <div class="form-group mb-3">
                        {{-- <label for="email" class="form-label">Email</label> --}}
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                        {{-- @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif --}}
                    </div>

                    <div class="form-group mb-3">
                        {{-- <label for="password" class="form-label">Password</label> --}}
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                        {{-- @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif --}}
                    </div>

                    <button class="w-100 btn btn-lg btn-dark" type="submit">Login</button>

                    <div class="mt-3 text-center">
                        @include('auth.partials.copy')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
