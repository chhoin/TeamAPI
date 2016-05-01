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
		// $category = $this->c->orderBy ( 'cat_id', 'desc' )->get ();
		// $article = $this->a->join ( 'tbl_categories', 'tbl_categories.cat_id', '=', 'tbl_articles.cat_id_for' )
		// 					->select ( 'tbl_articles.*', 'tbl_categories.cat_name' )
		// 					->orderBy ( 'art_id', 'desc' )
		// 					->paginate ( $this->limite );
		// return view ( 'admin.article', compact ( 'article', 'category' ) );
		return view('admin.article');
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
	public function store(ArticleRequest $request) {
		date_default_timezone_set ( 'Asia/Phnom_Penh' );
		$create_date = date ( "Y-m-d H:i:s" );
		
		$img = Input::file ( 'ART_IMG' );
		if (! empty ( $img )) {
			$img->move ( 'asset/img/article/', $img->getClientOriginalName () );
			$img = "asset/img/article/" . $img->getClientOriginalName ();
		} 
		else {
			$img = "asset/img/default.jpg";
		}
		
		$data = array (
				[ 
					'title' => $request->get ( 'title' ),
					'description' => $request->get ( 'description' ),
					'image' => $img,
					'cat_id_for' => $request->get ( 'category' ),
					'created_at' => $create_date 
				] 
		);
	
        $insert = $this->a->insert($data);
        if($insert) {
	        	return response()->json([
	        			'STATUS'=> true,
	        			'MESSAGE'=>'Artilce was inserted',
	        			'CODE' => 200
	        	], 200);
        }else{
        	return response()->json([
        		'STATUS'=> false ,
        		'MESSAGE' => 'Artilce not insert', 
        		'CODE'=> 400
        		], 200);
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
		$article =$this->a->where('art_id', $id)->first();

    	if(!$article){
    		return response()->json([
    				'STATUS'=> false,
    				'MESSAGE' => 'record not found', 
    				'CODE'=> 400
			], 200);
    	}
    	else{
    		return response()->json([
    				'STATUS'=> true,
    				'MESSAGE'=>'record found',
    				'DATA' => $article
    		], 200);
    	}
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		// $category = $this->c->orderBy ( 'cat_id', 'desc' )->get ();
		// $my_id = preg_replace ( '#[^0-9]#', '', $id );
		// if (! empty ( $my_id )) {
		// 	$article = $this->a->where ( 'art_id', $id )->first ();
		// 	return view ( 'admin.editarticle', compact ( 'article', 'category' ) );
		// } else {
		// 	return redirect ( 'article' );
		// }
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request        	
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function update(ArticleRequest $request, $id) {
		date_default_timezone_set ( 'Asia/Phnom_Penh' );
		$create_date = date ( "Y-m-d H:i:s" );
		
		$img = Input::file ( 'ART_IMG' );
		// die($request->get('category'));
		if (! empty ( $img )) {
			$img->move ( 'asset/img/article/', $img->getClientOriginalName () );
			$img = "asset/img/article/" . $img->getClientOriginalName ();
		} 
		else {
			$img = $request->get ( 'OLD_IMG' );
		}
		
		$art_id = preg_replace ( '#[^0-9]#', '', $id );
		$update = $this->a->where('art_id', $art_id)->first();

		if( !$update ) {
    		return response()->json([
    				'STATUS'=> false,
    				'MESSAGE' => 'record not found', 
    				'CODE'=> 400
			], 200);
    	}
    	else {
    		$process = $this->a->where ( 'art_id', $art_id )->update ( [ 
						'title' => $request->get ( 'title' ),
						'description' => $request->get ( 'description' ),
						'image' => $img,
						'cat_id_for' => $request->get ( 'category' ),
						'updated_at' => $create_date 
				] );
    		if( $process ){
    			return response()->json([
    				'STATUS'=> true,
    				'MESSAGE' => 'article was updated', 
    				'CODE'=> 400
				], 200);
    		}
    	}
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$id = preg_replace ( '#[^0-9]#', '', $id );
		$delete = $this->a->where('art_id', $id);
		if( $delete->delete() ){
        	return response()->json([
        			'STATUS' => true,
        			'MESSAGE' => 'article was deleted',
        			'CODE' => 422
        	], 200);
        }
        else {
        	return response()->json(
        		['STATUS'=> false,
        		'MESSAGE' => 'article not found', 
        		'CODE'=> 400
        		], 200);
        }
	}
	/**
	 * list all article created 2016-3-23 10:00 PM
	 */
	public function all() {
		$article = $this->a->all();
    	if(!$article){
    		return response()->json(['STATUS'=> false ,'MESSAGE' => 'Not Found', 'CODE'=> 400], 200);
    	}else{
    		return response()->json([
    				'STATUS'=>'true',
    				'MESSAGE'=>'record found',
    				'DATA' => $article
    		], 200);
    	}
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
    	$page = preg_replace ( '#[^0-9]#', '', $page );
    	$item = preg_replace ( '#[^0-9]#', '', $limit );
    	$offset = $page * $item - $item;
    	
    	
    	$count = $this->a->count();
    	$totalpage = 0;
    	if ($count % $item > 0){
    		$totalpage = floor($count / $item) +1;
    	}else {
    		$totalpage = $count / $item ;
    	}
    	
    	$pagination = [
    			'TOTALPAGE' => $totalpage ,
    			'TOTALRECORD' => $count ,
    			'CURRENTPAGE'  => $page,
    			'SHOWITEM'  => $item
    	];
    	
    	$product = $this->a->skip($offset)->take($item)->orderBy('art_id', 'desc')->get();
    	
    	if(!$product || $page > $totalpage) {
    		return response()->json([
    			'STATUS'=> false ,
    			'MESSAGE' => 'Not Found', 
    			'CODE'=> 400
    			], 200);
    	}
    	else {
    		return response()->json([
    				'STATUS'=> true ,
    				'MESSAGE'=>'record found',
    				'DATA' => $product,
    				'PAGINATION' => $pagination
    		], 200);
    	} 
    }

	/**
	 * search
	 */
	public function search($page, $limit, $keySearch)
    {
    	$keySearch = preg_replace ( '#[^0-9A-Za-z\s-_]#', '', $keySearch );
    	$page = preg_replace ( '#[^0-9]#', '', $page );
    	$item = preg_replace ( '#[^0-9]#', '', $limit );
    	$offset = $page * $item - $item;
    	 
    	 
    	$count = $this->a->where ( 'title', 'like',  $keySearch . '%' )->count();
    	$totalpage = 0;
    	if ($count % $item > 0 ) {
    		$totalpage = floor($count / $item) +1;
    	}else {
    		$totalpage = $count / $item ;
    	}
    	 
    	$pagination = [
    			'TOTALPAGE' => $totalpage ,
    			'TOTALRECORD' => $count ,
    			'CURRENTPAGE'  => $page,
    			'SHOWITEM'  => $item
    	];
    	 
    	$article = $this->a->where ( 'title', 'like',  $keySearch . '%' )->skip($offset)->take($item)->orderBy('art_id', 'desc')->get();
    	 
    	if(!$article  || $page > $totalpage){
    		return response()->json([
    			'STATUS'=>  false ,
    			'MESSAGE' => 'Not Found', 
    			'CODE'=> 400
    			], 200);
    	}
    	else {
    		return response()->json([
    				'STATUS'=> true ,
    				'MESSAGE'=>'record found',
    				'DATA' => $article,
    				'PAGINATION' => $pagination
    		], 200);
    	}
    }
}
