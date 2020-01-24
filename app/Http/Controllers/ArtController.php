<?php

namespace App\Http\Controllers;

use App\Art;
use App\Category;
use App\Tag;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Storage;

class ArtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $art = Art::where('url', $url)->firstOrFail();
        
        return view('art.show', ['art' => $art]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Art $art
     * @return \Illuminate\Http\Response
     */
    public function edit(Art $art)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Art $art)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Art  $art
     * @return \Illuminate\Http\Response
     */
    public function destroy(art $art)
    {
        //
    }


    public function adminIndex($arts = null)
    {
        if(!$arts){
            $arts = Art::orderBy('id', 'desc')->paginate(10);
        } else {
            $arts = $arts->paginate(20);
        }
        return view('admin.arts.arts', ['arts' => $arts]);
    }


    public function adminShow($id)
    {
        $art = Art::findOrFail($id);
        $types = Type::all();
        $categories = Category::all();
        $hasCategories = $art->categories->pluck('id');
        return view('admin.arts.show', ['art' => $art, 'categories' => $categories, 'hasCategories' => $hasCategories, 'types' => $types]);
    }


    /**
     * 
     * Update the art
     * @param request
     * @return response
     * 
     */
    public function adminEdit(Request $request, $id)
    {
        $art = Art::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:15|max:200',
            'description' => 'string|max:500|nullable',
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'options' => 'array',
            'options.*' => 'string|max:200',
            'tags' => 'string|max:150',
            'type_id' => 'integer'
        ]);

        if($validator->fails()){
            return redirect()->route('admin.show.art', ['id' => $id])->withErrors($validator)->withInput();
        } 

        $art->title = $request->title;
        $art->url = $request->url;
        $art->description = $request->description;
        $type = Type::findOrFail($request->type_id);
        $art->type()->associate($type);
        $art->categories()->sync($request->categories);
        $tagsArr = array();
        $tags = $request->tags;
        $tags = explode(', ', $tags);
        foreach($tags as $tag){
            $tag = Tag::where('name', 'LIKE', $tag)->first();
            array_push($tagsArr, $tag->id);
        }
        $art->tags()->sync($tagsArr);
        //$art->options = $request->options;
        $art->save();

        return redirect()->route('admin.show.art', ['id' => $id])->with('status', 'This category has been edited');
    }


    public function adminDestroy($id)
    {
        $art = Art::findOrFail($id);
        $downloads = $art->downloads;
        foreach($downloads as $download){
            Storage::cloud()->delete($download->url);
        }
        $cover = $art->covers->first();
        if(!empty($cover)){
            Storage::cloud()->delete($cover->url);
        }
        $art->delete();
        return redirect('/admin/dashboard/arts/')->with('status', 'The art has been deleted!');
    }


    public function adminSearchArts(Request $request){
        
        $validator = Validator::make($request->all(), [
            'id' => 'integer|nullable',
            'title' => 'string|nullable',
            'url' => 'string|nullable'
        ]);

        if($validator->fails() || empty($request->all())){
            return redirect()->route('admin.index.arts')->withErrors($validator)->withInput();
        }

        $id = $request->id;
        $title = $request->title;
        $url = Str::slug($request->url);
        
        $where_arr = array();

        if($id){

            $id_where = ['id', '=', $id];
            array_push($where_arr, $id_where);

        } if($title){

            $title_where = ['title', 'LIKE', '%' . $title . '%'];
            array_push($where_arr, $title_where);

        } if($url){

            $url_where = ['url', 'LIKE', '%' . $url . '%'];
            array_push($where_arr, $url_where);

        }

        $arts = Art::where($where_arr);

        if(empty($arts)){
            return $this->adminIndex();
        }
        return $this->adminIndex($arts);
    }


}
