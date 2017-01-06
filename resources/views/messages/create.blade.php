<form class="form-horizontal" role="form" method="POST" action="{{ route('messages.store', $story->id) }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <label for="name" class="col-md-4 control-label">Body</label>

        <div class="col-md-6">
            <textarea id="body" type="text" class="form-control" name="body" required autofocus>{{ old('body') }}</textarea>

            @if ($errors->has('body'))
                <span class="help-block">
                    <strong>{{ $errors->first('body') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                Create Message
            </button>
        </div>
    </div>
</form>