<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Info;
use App\Http\Requests;

class PageController extends Controller
{
	public function index(){
		$info = Info::all();
		return view ('index')->with('info', $info);
	}
    public function create(){
    	return view ('insert');
    }
  	public function store(Request $request){
  		$info = new Info;
  		$info->first_name = $request->first_name;
  		$info->last_name = $request->last_name;
  		$info->save();
  		return  ('sucess');
  	}
}
