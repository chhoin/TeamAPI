<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tbl_article;
use App\Tbl_category;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Input;


/**
 * ArticleController Created on 12/03/2016
 *
 * @author Kimchhoin Sok
 *        sokkimchhoin@gmail.com
 */
class ArticleController extends Controller {
	private $limite = 3;
	private $a;
	private $c;
	
	/**
	 * __construct
	 *
	 * @param Tbl_article $a        	
	 * @param Tbl_category $c        	
	 */
	function __construct(Tbl_article $a, Tbl_category $c) {
		$this->a = $a;
		$this->c = $c;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$category=$this->c->get();
		return view('admin.article',compact('category'));
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
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$article=$request->all();
		$insert=$this->a->insert($article);
		if($insert){
			return response()->json([
				'STATUS'=>true,
				'MESSAGE'=>'Article wass added',
				'CODE'=>200
			],200);
		}else{
			return response()->json([
				'STATUS'=>false,
				'MESSAGE'=>'Added fail',
				'CODE'=>400
			],200);
		}
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$id=preg_replace('#[^0-9]#','',$id);
		$article=$this->a->where('art_id',$id)->first();
		if(!$article){
			return response()->json([
				'STATUS'=>false,
				'MESSAGE'=>'Record not found',
				'CODE'=>400
			],200);
		}else{
			return response()->json([
				'STATUS'=>true,
				'MESSAGE'=>'Record found',
				'CODE'=>200,
				'DATA'=>$article
			],200);
		}
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
	public function update(ArticleRequest $request, $id) {
		
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$id=preg_replace('#[^0-9]#','',$id);
		if(!empty($id) && $this->a->where('art_id',$id)->delete()){
			return response()->json([
				'STATUS'=>true,
				'MESSAGE'=>'Article was deleted',
				'CODE'=>200
			],200);
		}else{
			return response()->json([
				'STATUS'=>false,
				'MESSAGE'=>'Record not found',
				'CODE'=>400
			],200);
		}
	}
	/**
	 * list all article created 2016-3-23 10:00 PM
	 */
	public function all() {
		
	}

	/**
     * listArticle
     * 
     * @param unknown $page
     * @param unknown $limit
     * 
     */
    public function listArticle($page, $limit)
    {
    	$page=preg_replace('#[^0-9]#','',$page);
		$item=preg_replace('#[^0-9]#','',$limit);
		$offset=$page*$item-$item;
		$count=$this->a->count();
		if($count % $item > 0){
			$totalpage=floor($count / $item)+1;
		}
		else{
			$totalpage=$count / $item;
		}
		$pagination=[
			'TOTALPAGE'=>$totalpage,
			'TOTALRECORD'=>$count,
			'CURRENTPAGE'=>$page,
			'SHOWITEM'=>$item
		];
		$article=$this->a->skip($offset)->take($item)->orderBy('art_id','desc')->get();
		if(!$article || $page>$totalpage){
			return response()->json([
				'STATUS'=>flase,
				'MESSAGE'=>'Record not found',
				'CODE'=>400
			],200);
		}else{
			return response()->json([
				'STATUS'=>true,
				'MESSAGE'=>'Record found',
				'DATA'=>$article,
				'PAGINATION'=>$pagination
			],200);
		}
    }

	/**
	 * search
	 */
	public function search($page, $limit, $keySearch)
    {
    	
    }
}
