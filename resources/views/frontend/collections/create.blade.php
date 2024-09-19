@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-4">
            <h2>Add New Collection</h2>
        </div>
        <hr>
        <div class="col-4">
            <form action="{{ route('collections.store') }}" method="POST" >
                @csrf
                <input type="text" name="name">
                <input type="submit" value="Create Collection">
            </form>
        </div>
    </div>
</div>
@endsection
