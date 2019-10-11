<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::paginate(env('PAGINATION_COUNT'));

        return view('admin.categories.categories')->with([
            'categories' =>$categories,
            'showLinks' => true,
        ]);
    }

    private function categoryNameExists($categoryName){

        $category = Category::where(
            'name','=',$categoryName
        )->first();

        if(!is_null($category)){
            \Illuminate\Support\Facades\Session::flash('message','unit Code('.$categoryName.') already exist');
            return false;
        }
        return true;
    }

    public function store(Request $request){

        $request->validate([
            'category_name' => 'required',
            'category_image' => 'required',
            'image_direction' => 'required',
        ]);

        $categoryName = $request->input('category_name');



        if(!$this->categoryNameExists($categoryName)){
            \Illuminate\Support\Facades\Session::flash('message' ,'category name already exists');
            return redirect()->back();
        }

        $category = new Category();
        $category->name = $categoryName;
        $category->image_direction = $request->input('image_direction');

        if($request->hasFile('category_image')){
            $image = $request->file('category_image');
            $path = $image->store('public');
            $category->image_url = $path;

        }

        $category->save();
        \Illuminate\Support\Facades\Session::flash('message' ,'category has been added');
        return redirect()->back();

    }

    public function update(Request $request){
        $request->validate([

            'category_id'   => 'required',
            'category_name' => 'required',
        ]);

        $categoryname = $request->input('category_name');
        $categoryID = $request->input('category_id');

        if(!$this->categoryNameExists($categoryname)){
            Session::flash('message' , 'category name already exist !! :) ');
            return back();
        }

        $category = Category::find($categoryID);
        $category->name = $categoryname;
        $category->save();
        Session::flash('message' , 'category edited successfully ');
        return back();


    }

    public function delete(Request $request){
        $request->validate([

            'category_id' => 'required'
        ]);
        $catID = $request->input('category_id');
        Category::destroy($catID);
        Session::flash('message' , 'Category has been Deleted ');
        return redirect()->back();

    }

    public function search(Request $request){
        $request->validate([
            'category_search' =>'required'
        ]);

        $searchTerm = $request->input('category_search');

        $categories = Category::where(
            'name' ,'Like','%' .$searchTerm.'%'
        )->get();

        if(count($categories)> 0) {
            return view('admin.categories.categories')->with([
                'categories' => $categories,
                'showLinks' => false,
            ]);
        }
        \Illuminate\Support\Facades\Session::flash('message','Nothing Found!!!');
        return redirect()->back();

    }


}
