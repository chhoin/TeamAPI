<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tbl_category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SearchRequest;


/**
 * CategoryController Created on 12/03/2016
 *
 * @author Kimchhoin Sok
 *        sokkimchhoin@gmail.com
 */
class CategoryController extends Controller {
	
	private $limite = 2;
	
	private $c;
	
	/**
	 * __construct
	 *
	 * @param Tbl_category $c        	
	 */
	function __construct(Tbl_category $c) {
		$this->c = $c;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('admin.category');
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}
	/**
	 * Show all category
	 */
	public function all() {
		
		$category = $this->c->all();
		if(!$category){
			return response()->json(['STATUS'=> false ,'MESSAGE' => 'Not Found', 'CODE'=> 400], 200);
		}else{
			return response()->json([
					'STATUS'=>'true',
					'MESSAGE'=>'record found',
					'DATA' => $category
			], 200);
		}
	}
	
	/**
	 * Store a newly created resource in storage.
	 * Using CategoryRequest to Validate Field
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(CategoryRequest $request) {
		/* $this->c->cat_name = $request->category;
		$this->c->save();
		Session::flash('message', 'Insert Successful');
		return redirect('category'); */
 		$category = array (
				[ 
					'cat_name' => $request->get ( 'category' ),
					'created_at' => date("Y/m/d") ,
					'updated_at' => date("Y/m/d")
				] 
		);
		$insert = $this->c->insert($category);
		if($insert) {
			return response()->json([
					'STATUS'=> true,
					'MESSAGE'=>'Cate was inserted',
					'CODE' => 200
			], 200);
		}else{
			return response()->json(['STATUS'=> false ,'MESSAGE' => 'Cate not insert', 'CODE'=> 400], 200);
		}
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$my_id = preg_replace ( '#[^0-9]#', '', $id );
		if (! empty ( $my_id )) {
			$cat = $this->c->where ( 'cat_id', $id )->first ();
			return view ( 'admin.viewcategory', compact ( 'cat' ) );
		} else {
			return redirect ('category');
		}
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$my_id = preg_replace ('#[^0-9]#', '', $id );
		if (!empty ($my_id)) {
			$cat = $this->c->where ('cat_id', $id)->first();
			return view ('admin.editcategory', compact('cat'));
		} 
		else {
			return redirect ('category');
		}
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function update(CategoryRequest $request) {
		$my_id = preg_replace ('#[^0-9]#', '', $request->id);
		if (! empty ($my_id)) {
			$this->c->where ('cat_id', $my_id )->update ( [ 
					'cat_name' => $request->get ( 'category' ) 
			] );
			\Session::flash ('message', 'Update Successful');
			return redirect ('category');
		}
		$this->edit ();
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$my_id = preg_replace ( '#[^0-9]#', '', $id );
		if (! empty ( $my_id )) {
			$this->c->where ( 'cat_id', $my_id )->delete ();
			\Session::flash ( 'messageDelete', 'Delete Successful' );
			return redirect ( 'category' );
		} else {
			return redirect ( 'category' );
		}
	}
	
	/**
	 * search
	 *
	 * @param SearchRequest $request        	
	 */
	public function search(SearchRequest $request) {
		$key = $request->get( 'key' );
		$category = $this->c->where ( 'cat_name', 'like', '%' . $key . '%' )->orderBy ( 'cat_id', 'desc' );
		if(!$category){
			return response()->json(['STATUS'=> false ,'MESSAGE' => 'Not Found', 'CODE'=> 400], 200);
		}else{
			return response()->json([
					'STATUS'=>'true',
					'MESSAGE'=>'record found',
					'DATA' => $category
			], 200);
		}
	}
}
