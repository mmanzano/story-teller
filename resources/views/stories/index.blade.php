@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Stories <a href="{{ route('stories.create') }}" class="btn btn-success">Create Story</a></div>
                    <div class="panel-body">


                        @unless ($stories->count())
                            <h1>No Stories now</h1>
                        @else
                            <ul class="list-group">
                                @foreach($stories as $story)
                                    <li class="list-group-item list-group-item-text">
                                        <a href="{{ route('stories.show', $story->id) }}">{{ $story->title }}</a>
                                        @if(Auth::check() && Auth::user()->isAdmin)
                                            <span class="bg-info" style="padding:10px">{{ $story->user->name }}</span>
                                        @endif

                                        <span class="bg-info" style="padding:10px">{{ $story->author }}</span>


                                        @if($story->private)
                                            <span class="bg-danger" style="padding:10px">private</span>
                                        @else
                                            <span class="bg-success" style="padding:10px">public</span>
                                        @endif
                                        @if($story->in_front)
                                            <span class="bg-success" style="padding:10px">In Front</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection