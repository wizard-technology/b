<?php

namespace App\Http\Controllers;

use App\Logger;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tag::with('admin')->orderBy('tg_state')->orderBy('created_at')->get();
        return view('pages.tag.index', ['data' => $data]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
        ]);
        $tag = new Tag;
        $tag->tg_name = $request->name;
        $tag->tg_name_ku = $request->name_kurdish;
        $tag->tg_name_ar = $request->name_arabic;
        $tag->tg_name_pr = $request->name_persian;
        $tag->tg_name_kr = $request->name_kurmanji;
        $tag->tg_state =  $request->state == 'on' ? 1 : 0;
        $tag->tg_admin = session('dashboard');
        $tag->save();
        Logger::create([
            'log_name' => 'Hashtag',
            'log_action' => 'Create',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($tag->toArray())
        ]);
        return redirect()->back()->withSuccess('Added Tag Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        if (is_null($tag)) return response()->json([
            'message' => 'tag not found',
            'errors' => [
                'tag' => 'Wrong id'
            ]
        ], 404);
        return response()->json([
            'tag' => $tag
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $tag->tg_state = !$tag->tg_state;
        $tag->save();
        Logger::create([
            'log_name' => 'Hashtag',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($tag->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Tag Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'state' => 'sometimes|in:on,null',
        ]);

        $tag->tg_name = $request->name;
        $tag->tg_name_ku = $request->name_kurdish;
        $tag->tg_name_ar = $request->name_arabic;
        $tag->tg_name_pr = $request->name_persian;
        $tag->tg_name_kr = $request->name_kurmanji;
        $tag->tg_state =   $request->state == 'on' ? 1 : 0;
        $tag->tg_admin = session('dashboard');
        $tag->save();
        Logger::create([
            'log_name' => 'Hashtag',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($tag->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Tag Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {

        try {
            $tag->delete();
            Logger::create([
                'log_name' => 'Hashtag',
                'log_action' => 'Delete',
                'log_admin' => session('dashboard'),
                'log_info' => json_encode($tag->toArray())
            ]);
            return redirect()->back()->withSuccess('Deleted Tag Successfully !');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['er' => 'Maybe has relation !']);
        }
    }
}
