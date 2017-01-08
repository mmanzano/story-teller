<?php

namespace App\Http\Controllers;

use App\Message;
use App\Story;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'edit', 'create', 'edit', 'update', 'destroy']);
    }

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
            $parent->time = $message->created_at->diffInSeconds($parent->created_at);
        }

        $message->save();

        return redirect()->to(route('stories.show', $story->id) . '#' . $message->id);
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
