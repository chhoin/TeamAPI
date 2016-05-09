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
			return response()->json([
				'STATUS'=> false,
				'MESSAGE'=> 'not founded',
				'CODE'=> 400,
			],200);
		}
		else{
			return response()->json([
				'STATUS'=> true,
				'MESSAGE'=> 'Founded',
				'DATA'=> $category,
			],200);
		}
	}
	
	/**
	 * Store a newly created resource in storage.
	 * Using CategoryRequest to Validate Field
	 * @param \Illuminate\Http\Request $request        	
	 * @return \Illuminate\Http\Response
	 */
	public function store(CategoryRequest $request) {
		$category = $request->all();
		$insert = $this->c->insert($category);
		if($insert){
			return response()->json([
				'STATUS'=> true,
				'MESSAGE'=> 'founded',
				'CODE'=> 200,
			],200);
		}
		else{
			return response()->json([
				'STATUS'=> false,
				'MESSAGE'=> 'not founded',
				'CODE'=> 404,
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
		$my_id=preg_replace('#[^0-9]#','',$id);
		$category = $this->c->where('cat_id',$my_id)->first();
		if($category){
			return response()->json([
				'STATUS'=> true,
				'MESSAGE'=> 'founded',
				'DATA'=> $category,
			],200);
		}
		else{
			return response()->json([
				'STATUS'=> false,
				'MESSAGE'=> 'not founded',
				'CODE'=> 404,
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
	public function update(CategoryRequest $request,$id) {
			$my_id = preg_replace('#[^0-9]#','',$id);
                $myUpdate = $this->c->where('cat_id',$my_id)->first();
                if($myUpdate){
                    $this->c->where('cat_id',$my_id)
                            ->update([
                                'cat_name' => $request->get('cat_name')
                            ]);
                    return response()->json([
                        'STATUS'=> true,
                        'MASSAGE'=> 'Updated!',
                        'CODE'=> 200
                    ],200);
                }
                else{
                    return response()->json([
                        'STATUS'=> false,
                        'MASSAGE'=> 'Not found',
                        'CODE'=> 404
                    ],200);
                }
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$my_id=preg_replace('#[^0-9]#','',$id);
		$category = $this->c->where('cat_id',$my_id)->delete();
		if(!empty($my_id)&&$category){
			return response()->json([
					'STATUS'=> true,
					'MASSAGE'=> 'Deleted!',
					'CODE'=> 200
				],200);
		}
		else{
			return response()->json([
				'STATUS'=> false,
				'MASSAGE'=> 'Not found',
				'CODE'=> 404
			],200);
		}
	}
	
	/**
	 * search
	 *
	 * @param
	 */
	public function search( $page,$limit, $key) {
		$key = preg_replace('#[^a-zA-Z\s-_]#','',$key);
		$limit = preg_replace('#[^0-9]#','',$limit);
		$page = preg_replace('#[^0-9]#','',$page);

		$totalpage=0;
		$offset = $page/$limit -$limit;
		$count =$this->c->where('cat_name','like',$key.'%')->count();

		if($count %$limit >0){
			$totalpage= floor($count /$limit) + 1;
		}
		else{
			$totalpage= $count /$limit;
		}
		$pagination =[
			'TOTALPAGE' => $totalpage,
			'TOTALRECORD' => $count,
			'CURRENTPAGE' => $page,
			'SHOWITEM' => $limit
		];
		$category = $this->c->where ( 'cat_name', 'like',  $key . '%' )->skip($offset)->take($limit)->orderBy('cat_id', 'desc')->get();

		if(!$category  || $page > $totalpage){
			return response()->json([
				'STATUS'=>  false ,
				'MESSAGE' => 'Not Found',
				'CODE'=> 400
			], 200);
		}else{
			return response()->json([
				'STATUS'=> true ,
				'MESSAGE'=>'record found',
				'DATA' => $category,
				'PAGINATION' => $pagination
			], 200);
		}
	}

	/***********
	 * list product
	 *
	 *
	 */
	public function listCategory($page, $limit){
		$page = preg_replace('#[^0-9]#','',$page);
		$limit = preg_replace('#[^0-9]#','',$limit);
		$offset = $page*$limit -$limit;

		$count = $this->c->count();
		$totalpage = 0;
		if($count % $limit > 0){
			$totalpage = floor($count / $limit) +1;
		}
		else{
			$totalpage = $count / $limit;
		}

		$pagination =[
				'TOTALPAGE' => $totalpage,
				'TOTALRECORD' => $count,
				'CURRENTPAGE' => $page,
				'SHOWITEM' => $limit
		];
		$category = $this->c->skip($offset)->take($limit)->orderBy('cat_id','desc')->get();
		if(!$category || $page > $totalpage){
			return response()->json([
				'STATUS' => false,
				'MESSAGE'=> 'Not found',
				'CODE' 	=> '404'
			],200);
		}
		else{
			return response()->json([
				'STATUS' => true,
				'MESSAGE'=> 'Record found',
				'DATA' => $category,
				'PAGINATION'=>$pagination
			],200);
		}

	}

}
