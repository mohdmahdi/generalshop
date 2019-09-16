<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index(){
        $tags=Tag::paginate(env('PAGINATION_COUNT'));
        return view('admin.tags.tags')->with([
            'tags'=> $tags,
            'showLinks' => true,
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'tag_name' => 'required'
        ]);

        $tagName= $request->input('tag_name');
        $tag = Tag::where('tag', '=', $tagName )->get();

        if(count($tag) > 0 ){
            Session::flash('message' , 'tag (' .$tagName. ') already Exist ');
            return redirect()->back();
        }

        $newTag = new Tag();
        $newTag->tag = $tagName;
        $newTag->save();
        Session::flash('message' , 'tag (' .$tagName. ') has been added ');
        return redirect()->back();
    }

    public function search(Request $request){

        $request->validate([
            'tag_search' =>'required'
        ]);

        $searchTerm = $request->input('tag_search');

        $tags =Tag::where(
            'tag' ,'Like','%' .$searchTerm.'%'
        )->get();

        if(count($tags)> 0) {
            return view('admin.tags.tags')->with([
                'tags' => $tags,
                'showLinks' => false,
            ]);
        }
        \Illuminate\Support\Facades\Session::flash('message','Nothing Found!!!');
        return redirect()->back();

    }

    public function delete(Request $request){
        $request->validate([

            'tag_id' => 'required'
        ]);
        $tagID = $request->input('tag_id');
        $tag = Tag::destroy($tagID);
        Session::flash('message' , 'Tag has been Deleted ');
        return redirect()->back();

    }

    private function tagNameExists($tagName){

        $tag = Tag::where(
            'tag','=',$tagName
        )->first();

        if(!is_null($tag)){
            \Illuminate\Support\Facades\Session::flash('message','tag Name('.$tagName.') already exist');
            return false;
        }

        return true;
    }

    public function update(Request $request){
        $request->validate([

            'tag_name' => 'required',
            'tag_id' => 'required'
        ]);

        $tagName = $request->input('tag_name');
        $tagID = $request->input('tag_id');

        if(!$this->tagNameExists($tagName)){
            \Illuminate\Support\Facades\Session::flash('message','tag already exist');
            return redirect()->back();
        }

        $tag = Tag::find($tagID);
        $tag->tag = $tagName;
        $tag->save();
        \Illuminate\Support\Facades\Session::flash('message','tag has been updated. ');
        return redirect()->back();

    }




}
