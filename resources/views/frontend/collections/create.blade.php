@extends('frontend.layouts.master')

@section('content')
    <h2>Add New Collection</h2>
    <hr>
    <form action="{{ route('collections.store') }}" method="POST" >
        @csrf
        <input type="text" name="name">
        <input type="submit" value="Create Collection">
    </form>
@endsection
