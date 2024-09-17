@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <h1>{{ $image->title }}</h1>
    <hr>

    <div class="row d-flex align-items-center">
        @if ($image->description == null)
            <div >
                <img style="width: 800px; heigth: auto;" src="{{ Storage::url($image->url) }}" alt="{{ $image->title}}">
            </div>
        @else
            <div class="col-5">
                <p>{{ $image->description }}</p>
            </div>
            <div class="col-7">
                <img style="width: 600px; heigth: auto;" src="{{ Storage::url($image->url) }}" alt="{{ $image->title}}">
            </div>
        @endif
    </div>

</div>
@endsection