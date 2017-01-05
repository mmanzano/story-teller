@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Story {{ $story->title }}

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('stories.destroy', $story->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="form-group">
                                <div class="col-md-6">
                                    <a href="{{ route('stories.edit', $story->id) }}" class="btn btn-primary">
                                        Edit
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-danger">
                                        Delete Story
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body">
                        @unless ($messages->count())
                            <h1>No messages now</h1>
                        @else
                            <ul class="list-group">
                                @foreach($messages as $message)
                                    <li class="list-group-item list-group-item-text"><a href="{{ route('messages.edit', ['story' => $story->id, 'message' => $message->id]) }}">{{ $message->body }}</a></li>
                                @endforeach
                            </ul>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection