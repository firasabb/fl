<?php

namespace App\Http\Controllers;

use App\PreArt;
use App\Art;
use App\PreDownload;
use App\Download;
use App\Tag;
use App\Category;
use App\Type;
use App\Cover;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Auth;
use Storage; 
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;


class PreArtController extends Controller
{


    public function __construct(){

        $this->middleware('role:admin|moderator|user');

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prearts = PreArt::orderBy('id', 'asc')->paginate(1);
        $categories = Category::all(); 
        $types = Type::all();
        return view('admin.prearts.prearts', ['prearts' => $prearts, 'categories' => $categories, 'types' => $types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $types = Type::all();
        return view('prearts.create', ['categories' => $categories, 'types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Preart $preart)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:15|max:200',
            'description' => 'string|max:500|nullable',
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'type_id' => 'required|integer',
            'tags' => 'required|string|max:150',
            'uploads' => 'required|array',
            'uploads.*' => 'file|max:100000',
            'featured' => 'file|max:20000|mimes:jpeg,bmp,png,mpeg4-generic,ogg,x-wav,x-msvideo,x-ms-wmv',
            'cover' => 'file|mimes:jpeg,bmp,png|nullable'
        ]);
        if($validator->fails()){
            return redirect('/add/art/')->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        if(!Arr::has(Storage::cloud()->directories(), 'predownloads')){
            Storage::cloud()->makeDirectory('downloads');
        }
        if(!Arr::has(Storage::cloud()->directories(), 'featured')){
            Storage::cloud()->makeDirectory('featured');
        }
        if(!Arr::has(Storage::cloud()->directories(), 'covers')){
            Storage::cloud()->makeDirectory('covers');
        }

        $type = Type::findOrFail($request->type_id);


        $preart = new PreArt();
        $preart->title = $request->title;
        $preart->description = $request->description;
        $preart->user_id = $user->id;
        $preart->type()->associate($type);
        $preart->save();
    
        $unique = uniqid();

        $featured = $request->featured;
        $download = new PreDownload();
        $download->name = $preart->title;
        $download->featured = 1;
        $path = $featured->store('featured/' . $unique, 's3');
        $download->url = $path;
        $download->preart()->associate($preart);
        $download->save();

        $uploads = $request->uploads;
        if($uploads){
            foreach($uploads as $upload){
                $download = new PreDownload();
                $download->name = $preart->title;
                $path = $upload->store('downloads/' . $unique, 's3');
                $download->url = $path;
                $preart->downloads()->save($download);
            }
        }

        $categories = $request->categories;
        foreach($categories as $category){
            $category = Category::findOrFail($category);
            $preart->categories()->attach($category);
        }

        $tags = $request->tags;
        $tags = explode(', ', $tags);
        foreach($tags as $tag){
            $tag = Tag::Where('name', 'LIKE', $tag)->firstOrFail();
            $preart->tags()->attach($tag);
        }

        if($request->cover){
            $cover = new Cover();
            $uploadedCover = $request->cover;
            $path = $uploadedCover->store('covers/' . $unique, 's3');
            $cover->url = $path;
            $cover->preart()->associate($preart);
            $cover->save();
        }

        if($user->hasAnyRole(['admin', 'moderator'])){
            $this->adminAddArt($preart->id);
        }

        return redirect('/home')->with('status', 'Your Art Has Been Created! Once it is approved, it is going to be public...');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreArt  $preart
     * @return \Illuminate\Http\Response
     */
    public function show(PreArt $preart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreArt  $preart
     * @return \Illuminate\Http\Response
     */
    public function edit(PreArt $preart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreArt  $preart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preart $preart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Preart  $preart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $preart = PreArt::findOrFail($id);
        $predownloads = $preart->downloads;
        foreach($predownloads as $predownload){
            Storage::cloud()->delete($predownload->url);
        }
        $cover = $preart->covers->first();
        if(!empty($cover)){
            Storage::cloud()->delete($cover->url);
        }
        $preart->delete();

        return redirect('admin/dashboard/prearts/')->with('status', 'Art has been deleted!');
    }

    /** 
    *
    * Approve the preart for users not admins
    *
    * @param Request
    * @return Response
    *
    */

    public function approve(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:15|max:200',
            'art_id' => 'required|integer',
            'description' => 'string|max:500|nullable',
            'categories' => 'required|array',
            'categories.*' => 'string',
            'tags' => 'required|string|max:150',
            'type_id' => 'required|integer',
            'upload' => 'array',
            'uploads.*' => 'string|max:200',
            'user_id' => 'required|integer'
        ]);

        if($validator->fails()){

            return redirect()->back()->withErrors($validator)->withInput();

        }

        $preart = PreArt::findOrFail($request->art_id);

        $art = $this->makeNewArt($request); 


        $predownloads = $preart->downloads()->get();

        $this->predownloadsToDownloads($art, $predownloads);

        $categories = $request->categories;
        foreach($categories as $category){
            $category = Category::findOrFail($category);
            $art->categories()->attach($category);
        }

        $tags = $request->tags;
        $tags = explode(', ', $tags);
        foreach($tags as $tag){
            $tag = Tag::Where('name', 'LIKE', $tag)->firstOrFail();
            $art->tags()->attach($tag);
        }
        
        if(!empty($preart->covers)){
            $cover = new Cover;
            $cover->url = $preart->cover->first()->url;
            $cover->art()->associate($art);
            $cover->save();
        }

        $preart->delete();

        return redirect('/admin/dashboard/prearts/')->with('status', 'The Art has been approved!');

    }


    /** 
    *
    * Approve the preart for admins
    *
    * @param Request
    * @return Response
    *
    */


    public function adminAddArt($preart_id){

        $preart = PreArt::findOrFail($preart_id);
        $predownloads = $preart->downloads;
        $art = $this->makeNewArt($preart);

        $predownloads = $preart->downloads()->get();

        $this->predownloadsToDownloads($art, $predownloads);

        $categories = $preart->categories;
        foreach($categories as $category){
            $art->categories()->attach($category);
        }

        $tags = $preart->tags;
        foreach($tags as $tag){
            $art->tags()->attach($tag);
        }

        if(!empty($preart->covers)){
            $cover = new Cover;
            $cover->url = $preart->covers->first()->url;
            $cover->art()->associate($art);
            $cover->save();
        }
        

        $preart->delete();

        return redirect('/admin/dashboard/arts/')->with('status', 'A new art has been added by an admin.');
    }




    public function suggestTags(Request $request){

        if($request->ajax()){

            $tag = $request->tag;
            $exist = $request->exist;
        
            if($tag){

                $whereArr = array();

                if($exist){
                    foreach($exist as $existTag){
                        $where = ['name', '!=', $existTag];
                        array_push($whereArr, $where);
                    }
                }
                $where = ['name', 'LIKE', '%' . $tag . '%'];
                array_push($whereArr, $where);
                $searchResults = Tag::where($whereArr)->get();

                $response = array(
                    'status' => 'success',
                    'results' => $searchResults
                );
        
                return response()->json($response);

            }

            $response = array(
                'status' => 'error',
                'message' => 'no tag has been searched for'
            );

            return response()->json($response);
        }
        
    }



    /**
     * 
     * Make new Art Helper Method
     * 
     * @param Object: preart or Request
     * @return New Art
     * 
     */


    private function makeNewArt($obj){

        $type = Type::findOrFail($obj->type_id);
        $art = new Art();
        $art->title = $obj->title;
        $art->description = $obj->description;
        $url = Str::slug($obj->title, '-');
        $checkIfUrlExists = Art::where('url', 'LIKE', $url)->first();
        if($checkIfUrlExists){
            $url = $url . uniqid('-');
        }
        $art->url = $url;
        $art->user_id = $obj->user_id;
        $art->type()->associate($type);
        $art->save();
        return $art;

    }


    /**
     * 
     * 
     * PreDownloads to Downloads Helper Method
     * @param Object Art
     * @param Objects Predownloads
     * Void
     * 
     */


    private function predownloadsToDownloads($art, $predownloads) : void{

        foreach($predownloads as $predownload){
            $download = new Download();
            $download->name = $predownload->name;
            $download->featured = $predownload->featured;
            $download->url = $predownload->url;
            $download->art()->associate($art);
            $download->save();
        }
    }

}
