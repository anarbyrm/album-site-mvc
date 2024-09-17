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
                    <h5 class="card-title"><a href="{{ route('images.show', [ 'collection_id' => $collection_id, 'image_id' => $image->id ]) }}">{{ $image->title }}</a></h5>
                    @if ($image->description)
                        <p class="card-text">{{ $image->description }}</p>            
                    @endif
                    <div class="d-flex align-items-center">
                        <a class="btn btn-primary m-1" href="{{ route('images.edit', [ 'collection_id' => $collection_id, 'image_id' => $image->id ]) }}">Edit</a>
                        <form action="{{ route('images.remove', [ 'collection_id' => $collection_id, 'image_id' => $image->id ]) }}" method="POST">
                            @csrf
                            <input type="submit" value="Remove" class="btn btn-danger m-1">
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
