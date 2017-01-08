@extends('layouts.app')

@section('content')
    <story :story="{{ $story }}"
           @if (Auth::check())
                :user="{{ Auth::user() }}"
           @else
                :user="{ id: null }"
           @endif
       play="false"></story>
@endsection