@extends('frontend/layouts/master')

@section('content')
<div class="container">
    <h1><a href="{{ route('collections.index') }}">&lArr;</a> Images</h1>
    <a href="{{ route('images.create', ['collection_id' => $collection_id ]) }}">+ Add Image</a>
    <hr>

    <div class="row">
        @foreach ($images as $image)
            <div class="card col-4 m-3" style="width: 18rem;">
                <img src="{{ Storage::url($image->url) }}" class="card-img-top" alt="{{ $image->title }}">
                <div class="card-body">
                <h5 class="card-title">{{ $image->title }}</h5>
                @if ($image->description)
                    <p class="card-text">{{ $image->description }}</p>            
                @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
