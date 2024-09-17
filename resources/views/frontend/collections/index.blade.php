@extends('frontend/layouts/master')

@section('content')
<div class="container">
    <h1>Collections</h1>
    <a href="{{ route('collections.create') }}">+ Add New Collection</a>
    <hr>
    @foreach ($collections as $collection)
        <a href="{{ route('images.index', [ 'collection_id' => $collection->id ]) }}">
            <h3>{{ $collection->name }} ({{ $collection->images_count }})</h3>
        </a>
        @if (!$loop->last)
        <hr>
        @endif
    @endforeach
</div>

@endsection