<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Validator;
use URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }


    public function adminIndex($categories = null)
    {
        if(!$categories){
            $categories = Category::orderBy('id', 'desc')->paginate(20);
        } else {
            $categories = $categories->paginate(20);
        }
        return view('admin.categories.categories', ['categories' => $categories]);
    }


    public function adminAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'url' => 'required|string'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/categories')->withErrors($validator)->withInput();
        } 

        $category = new Category();
        $category->name = strToLower($request->name);
        $request->url = Str::slug($request->url, '-');
        $check = Category::where(['deleted_at' => NULL, 'url' => $request->url])->first();
        if(!empty($check)){
            return redirect('/admin/dashboard/categories/')->withErrors('The url has already been taken.')->withInput();
        }
        $category->url = $request->url;
        $category->save();

        return redirect('/admin/dashboard/categories')->with('status', 'A new category has been created!');


    }


    public function adminEdit(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:40',
            'url' => 'string'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/category/' . $id)->withErrors($validator)->withInput();
        } 

        $category->name = strToLower($request->name);
        $request->url = Str::slug($request->url, '-');
        if($request->url != $category->url){
            $check = Category::where(['deleted_at' => NULL, 'url' => $request->url])->first();
            if(!empty($check)){
                return redirect('/admin/dashboard/category/' . $id)->withErrors('The url has already been taken.')->withInput();
            }
            $category->url = $request->url;
        }
        $category->save();

        return redirect('/admin/dashboard/category/' . $id)->with('status', 'This category has been edited');
    }


    public function adminShow($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.show', ['category' => $category]);
    }


    public function adminDestroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect('/admin/dashboard/categories/')->with('status', 'A category has been deleted!');
    }


    public function adminSearchCategories(Request $request){
        
        $users = array();

        $validator = Validator::make($request->all(), [
            'id' => 'integer|nullable',
            'name' => 'string|max:300|nullable'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/categories/')->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $id = $request->id;
        
        $where_arr = array();

        if($name){

            $name_where = ['name', 'LIKE', '%' . $name . '%'];
            array_push($where_arr, $name_where);

        } if ($id){

            $id_where = ['id', '=', $id];
            array_push($where_arr, $id_where);

        } if(empty($request->all())) {
            return '';
        }

        $categories = Category::where($where_arr);

        if(empty($categories)){
            return $this->adminIndex();
        }
        return $this->adminIndex($categories);
    }

    
}
