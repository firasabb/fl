<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Validator;
use URL;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->paginate();
        return view('tags.tags', ['tags' => $tags]);
    }


    public function adminIndex()
    {
        $tags = Tag::orderBy('id', 'desc')->paginate();
        return view('admin.tags.tags', ['tags' => $tags]);
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
    public function adminAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'url' => 'required|string'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/tags')->withErrors($validator)->withInput();
        } 

        $tag = new Tag();
        $tag->name = strToLower($request->name);
        $tag->url = URL::to('/tag') . '/' . Str::slug(htmlspecialchars($request->url), '-');
        $tag->save();

        return redirect('/admin/dashboard/tags')->with('status', 'A tag has been created!');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function adminShow($id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.tags.show', ['tag' => $tag]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function adminEdit(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function adminDestroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect('/admin/dashboard/tags/')->with('status', 'A tag has been deleted!');
    }
}
