@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-2">
            <h3>Member Login</h3>
        </div>
    </div>
    <hr>

    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <form action="{{ route('auth.login.post') }}" method="POST">
                @csrf
        
                @if ($errors->any())
                    @foreach ($errors->all() as $err)
                        <span>{{ $err }}</span>
                    @endforeach
                @endif
        
                <div class="form-group m-3">
                    <label for="exampleInputEmail1">Email:</label>
                    <input name="email" type="email" class="form-control m-1" aria-describedby="emailHelp" placeholder="Enter email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group m-3">
                    <label for="exampleInputPassword1">Password:</label>
                    <input name="password" type="password" class="form-control m-1" placeholder="Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <input type="submit" class="btn btn-primary m-3" value="Login">
            </form>
        </div>
    </div>

</div>
@endsection
