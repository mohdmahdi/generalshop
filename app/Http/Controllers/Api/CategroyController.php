<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Resources\CategoryResource;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategroyController extends Controller
{
    public function index(){

       return CategoryResource::collection(Category::paginate());


    }

    public function show($id){

        return new CategoryResource(Category::find($id));


    }
}
