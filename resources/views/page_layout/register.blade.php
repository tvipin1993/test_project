@extends('page_layout.page_layout')
@section('title')
    Register Page
@endsection
@php
    $user_role = 2;
    $path = url()->current();
    $trimmed_path = ltrim(request()->segment(1));
    if ($trimmed_path == 'admin-register') {
        $user_role = 1;
    }
    $role = 'visiter';
    if (Cookie::get('user_details')) {
        $user_now = json_decode(Cookie::get('user_details'));
        $role = $user_now->role == 1 ? 'admin' : 'customer';
    }
@endphp

@section('bodypart')
    <!----------- Header Section ------------------>

    <div class="my_header bg-primary text-white">
        @if ($role == 'visiter')
            <a href="#" class="logo"> Welcome to JWT User Role Management by Vipin </a>
            <div class="my_header-right">
                <a href="{{ route('admin-register-form') }}">Admin</i></a>
            </div>
        @else
            <a href="#" class="logo"> {{ ucwords($role) }} Dashboard</a>
            <div class="my_header-right">

                <a href="#"> {{ strtoupper($user_now->name ?? '') }}</a>
                <a href="{{ route('logout') }}"><i class="fa fa-sign-out" style="font-size:36px"></i></a>
            </div>
        @endif

    </div>
    <!----------- Header Section ends ------------------>
    {{-- ///////////////  Body Starts //////////////////////////// --}}
    <div class="content ">

        <div class="card border border-secondary" style="width: 30rem;">
            <div class="card-body">
                @include('alerts.alert')
                <h5 class="card-title text-center">Register</h5>
                <form method="post" action="{{ route('do-customer-register') }}">
                    @csrf
                    <input type="text" name="user_role" value="{{ $user_role }}" hidden>
                    <div class="form-group">
                        <label for="name_id">Name</label>
                        <input type="text" name="name" class="form-control" id="name_id"
                            placeholder="Enter your name" required value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="email_id">Email address</label>
                        <input type="email" name="email" class="form-control" id="email_id"
                            aria-describedby="emailHelp" placeholder="Enter email" required value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="phone_id">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" id="phone_id"
                            placeholder="Enter phone number" required value="{{ old('phone') }}">
                        @error('phone')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="password_id">Password</label>
                        <input type="password" name="password" class="form-control" id="password_id" placeholder="Password"
                            required value="{{ old('password') }}">
                        @error('password')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="cpassword_id">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="cpassword_id"
                            placeholder="Confirm Password" required>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
