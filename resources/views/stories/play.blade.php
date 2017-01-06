@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Story {{ $story->title }}
                    </div>
                    <div class="panel-body">
                        @unless ($messages->count())
                            <h1>No messages now</h1>
                            @else
                                <ul class="list-group" id="messages">
                                </ul>
                            @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script>
        function sleep(sleepDuration){
            var now = new Date().getTime();
            while(new Date().getTime() < now + sleepDuration){ /* do nothing */ }
        }

        function getNextMessage(id) {
            if (id == undefined) {
                var url = "/stories/" + {{$story->id}} + '/messages/'
            } else {
                var url = "/stories/" + {{$story->id}} + '/messages/' + id
            }

            $.ajax({
                url: url,
                success: function(result) {
                    if (result.id !== undefined) {
                        $('#messages').append(
                            '<li class="list-group-item list-group-item-text">' + result.body + '</a></li>'
                        );
                        sleep(result.time * 1000);
                        getNextMessage(result.id);
                    }
                }
            });
        }

        getNextMessage();
    </script>
@endsection