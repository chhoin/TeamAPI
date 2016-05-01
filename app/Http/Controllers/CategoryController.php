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
		
	}
	
	/**
	 * Store a newly created resource in storage.
	 * Using CategoryRequest to Validate Field
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(CategoryRequest $request) {
		
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function update(CategoryRequest $request) {
		
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		
	}
	
	/**
	 * search
	 *
	 * @param SearchRequest $request        	
	 */
	public function search(SearchRequest $request) {
	
	}
}
