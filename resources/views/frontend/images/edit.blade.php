@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-4">
            <h3>Edit Image: "{{ $image->title }}"</h3>
        </div>
    </div>
    <hr>
    <form action="{{ route('images.update', ['collection_id' => $collection_id, 'image_id' => $image->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($errors->any())
            @foreach ($errors->all() as $err)
                <span>{{ $err }}</span>
            @endforeach
        @endif

        <div class="form-group m-3">
            <label for="exampleInputEmail1">Title:</label>
            <input name="title" type="text" class="form-control m-1" placeholder="Image Title" value="{{ $image->title }}">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group m-3">
            <label for="exampleInputPassword1">Description:</label>
            <input name="description" type="text" class="form-control m-1" placeholder="Image Description (optional)" value="{{ $image->description }}">
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        
        <div class="form-group m-3">
            <label for="exampleInputPassword1">Image:</label>
            <div>
                <img class="m-3" src="{{ Storage::url($image->url) }}" style="width:300px; height: auto;">
            </div>
            <input name="image" type="file" class="form-control m-1" placeholder="Add image here" value="{{ Storage::url($image->url) }}">
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <input type="hidden" name="collection_id" value="{{ $collection_id }}">

        <input type="submit" class="btn btn-success m-1" value="Add image">
    </form>
</div>
@endsection