@extends('layouts.app')

@section('content')
    <story :story="{{ $story }}" :user="{{ Auth::user() }}" play="true"></story>
@endsection