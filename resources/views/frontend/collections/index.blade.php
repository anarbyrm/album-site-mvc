@extends('frontend/layouts/master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="w-100">
            <div class="d-flex justify-content-center">
                <div>
                    <h1>Collections</h1>
                    <a href="{{ route('collections.create') }}">+ Add New Collection</a>
                </div>
            </div>
            <hr>

            @foreach ($collections as $collection)
                <a href="{{ route('images.index', [ 'collection_id' => $collection->id ]) }}">
                    <h3>{{ $collection->name }} ({{ $collection->images_count }})</h3>
                </a>

                <form action="{{ route('collections.delete', [ 'id' => $collection->id ]) }}" method="POST">
                    @csrf
                    <input type="submit" value="Remove">
                </form>

                @if (!$loop->last)
                    <hr>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
