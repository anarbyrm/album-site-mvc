@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <h3>User Registration</h3>
    <hr>

    <form action="{{ route('auth.register.post') }}" method="POST">
        @csrf

        @if ($errors->any())
            @foreach ($errors->all() as $err)
                <span>{{ $err }}</span>
            @endforeach
        @endif

        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input name="email" type="email" class="form-control m-1" aria-describedby="emailHelp" placeholder="Enter email">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">New Password</label>
            <input name="password" type="password" class="form-control m-1" placeholder="New Password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input name="password_confirm" type="password" class="form-control m-1" placeholder="Confirm Password">
            @error('password_confirm')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <input type="submit" class="btn btn-primary m-1" value="Register">
    </form>
</div>
@endsection
