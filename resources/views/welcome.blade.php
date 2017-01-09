@extends('layouts.app')

@section('head')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
            font-weight: 100;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Story Teller
                </div>

                <div class="links">
                    <a href="{{ route('stories.index') }}">View Stories</a>
                    <a href="{{ route('stories.create') }}">Create Story</a>
                </div>
            </div>
@endsection