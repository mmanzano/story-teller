<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Message;
use App\Story;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Story $story, Message $parent = null)
    {
        if (is_null($parent)) {
            $message = $story->messages->first();
        } else {
            $message = $story->messages->where('parent', $parent->id)->first();
        }

        return response()->json($message);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Story $story)
    {
        $messages = $story->messages;

        return response()->json($messages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Story $story)
    {
        $parent = $story->messages()->latest()->first();

        $message = new Message;
        $message->story_id = $story->id;
        $message->body = $request->get('body');
        $message->save();

        if (!is_null($parent)) {
            $message->parent = $parent->id;
            $message->time = $message->created_at->diffInSeconds($parent->created_at);
        }

        $message->save();

        return response()->json($story->messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $message->body = $request->get('body');

        $message->save();

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $son = Message::where('parent', $message->id)->first();

        if ($son) {
            $son->parent = $message->parent;
            $son->save();
        }

        $message->delete();
    }
}
