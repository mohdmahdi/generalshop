<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){

        $units=Unit::paginate(env('PAGINATION_COUNT'));

        return view('admin.units.units')->with(
            ['units'=> $units]);
    }


}
