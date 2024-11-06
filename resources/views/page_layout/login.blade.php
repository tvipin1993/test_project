@extends('page_layout.page_layout')
@section('title')
    Login Page
@endsection
@php
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
    <div class="content ">

        <div class="card border border-secondary" style="width: 30rem;">
            <div class="card-body">
                @include('alerts.alert')
                <h5 class="card-title text-center">Login</h5>
                <form method="post" action="{{ route('user-login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email_id">Email address</label>
                        <input type="email" name="email" class="form-control" id="email_id"
                            aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="password_id">Password</label>
                        <input type="password" name="password" class="form-control" id="password_id" placeholder="Password">
                        @error('password')
                            <span class="text-danger" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <br>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <div class="text-center mt-2">
                    <a href="{{ route('customer-register-form') }}">Create an account</a>
                </div>
            </div>
        </div>

    </div>
@endsection
