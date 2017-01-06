@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Stories</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('stories.update', $story->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Title</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $story->title) }}" required autofocus>

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="private" class="col-md-4 control-label">Private</label>

                                <div class="col-md-6">
                                    <input id="private" type="checkbox" name="private"
                                           @if (old('private', $story->private))
                                           checked
                                            @endif
                                    >
                                </div>
                            </div>

                            @if (auth()->user()->isAdmin)
                                <div class="form-group">
                                    <label for="in_front" class="col-md-4 control-label">In front</label>

                                    <div class="col-md-6">
                                        <input id="in_front" type="checkbox" name="in_front"
                                            @if (old('in_front', $story->in_front))
                                                checked
                                            @endif
                                        >
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Edit Story
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection