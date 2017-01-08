<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Story;
use Illuminate\Http\Request;

class StoriesController extends Controller
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
    public function index()
    {
        $stories = Story::where('in_front', false)->where('private', false)->get();

        if (request()->user()) {
            $stories = Story::where('in_front', false)->get()->filter(function($story) {
                if ($story->private) {
                    return $story->user_id == request()->user()->id;
                }

                return true;
            });
        }
        return response()->json($stories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return response()->view('stories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $story = new Story;
        $story->user_id = $request->user()->id;
        $story->title = $request->get('title');
        $story->private = $request->get('private') ? true : false;
        $story->in_front = $request->get('in_front') ? true : false;
        $story->save();

        return response()->json($story);
    }

    /**
     * Display the specified resource.
     *
     * @param  Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        $story = Story::with('messages')->find($story->id);

        return response()->json($story);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Story  $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        // return response()->view('stories.edit', ['story' => $story]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $story->title = $request->get('title');
        $story->private = $request->get('private') ? true : false;
        $story->in_front = $request->get('in_front') ? true : false;
        $story->save();

        $story = Story::with('messages')->find($story->id);

        return response()->json($story);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        $story->messages->map(function($message) {
            $message->delete();
        });

        $story->delete();

        return response()->json('Story Deleted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Story  $story
     * @return \Illuminate\Http\Response
     */
    public function play(Story $story)
    {
        $messages = $story->messages;

        return response()->view('stories.play', [
            'story' => $story,
            'messages' => $messages,
        ]);
    }
}
