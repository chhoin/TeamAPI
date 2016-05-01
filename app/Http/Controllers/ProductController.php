<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tbl_product;
use App\Http\Requests\ProductRequest;


/**
 * ProductController created on 16/03/2016
 * 
 * @author Sok Kimchhoin
 *
 */
class ProductController extends Controller
{
	
	private $limite = 2;
	
	private $p;
	
	/**
	 * __construct
	 *
	 * @param Tbl_product $c
	 */
	function __construct(Tbl_product $p) {
		$this->p = $p;
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return view('admin.product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = $request->all();
   
        $insert = $this->p->insert($product);
        if($insert) {
	        	return response()->json([
						        			'STATUS'=> true,
						        			'MESSAGE'=>'Product was inserted',
						        			'CODE' => 200
						        	], 200);
        }else{
        	return response()->json([
				        			'STATUS'=> false ,
				        			'MESSAGE' => 'Product not insert', 
				        			'CODE'=> 400
				        			], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$id = preg_replace ( '#[^0-9]#', '', $id );
    	$product =$this->p->where('pro_id', $id)->first();
    	
    	if(!$product){
    		return response()->json([
    									'STATUS'=> false ,
    									'MESSAGE' => 'Not Found', 
    									'CODE'=> 400
    				    			], 200);
    	}else{
    		return response()->json([
					    				'STATUS'=> true,
					    				'MESSAGE'=>'record found',
					    				'DATA' => $product
					    			], 200);
    	}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
    	$id = preg_replace ( '#[^0-9]#', '', $id );
    	$update = $this->p->where('pro_id',$id)->first();
    	if(!$update) {
    		return response()->json([
    									'STATUS'=> false,
    									'MESSAGE' => 'Product not found',
    									'CODE'=> 400
    					    		], 200);
    	}else {
    		
    		$this->p->where ('pro_id', $id )->update ( [ 
                    'pro_name' => $request->get ( 'pro_name' ),
                    'pro_description' => $request->get('pro_description'),
                    'pro_prize' => $request->get('pro_prize')
            ] );
    		
    			return response()->json([
    					'STATUS'=> true,
    					'MESSAGE'=>'Product was updated',
    					'CODE' => 200
    			], 200);
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$id = preg_replace ( '#[^0-9]#', '', $id );
        if(!empty($id) && $this->p->where('pro_id', $id)->delete()){
        	return response()->json([
        			'STATUS' => true,
        			'MESSAGE' => 'Product was deleted',
        			'CODE' => 200
        	], 200);
        }else {
        	return response()->json([
        								'STATUS'=> false,
        								'MESSAGE' => 'Not Found',
        								'CODE'=> 400
        			        	], 200);
        }
        
        
      
    }
    
    /**
     * all
     */
    public function all()
    {
    	$product = $this->p->all();
    	if(!$product){
    		return response()->json([
    									'STATUS'=> false ,
    									'MESSAGE' => 'Not Found',
    									'CODE'=> 400
    				    		], 200);
    	}else{
    		return response()->json([
					    				'STATUS'=> true,
					    				'MESSAGE'=>'record found',
					    				'DATA' => $product
					    		], 200);
    	}
    }
    
    
    /**
     * listProduct
     * 
     * @param unknown $page
     * @param unknown $limit
     * 
     */
    public function listProduct($page, $limit)
    {
    	$page = preg_replace ( '#[^0-9]#', '', $page );
    	$item = preg_replace ( '#[^0-9]#', '', $limit );
    	$offset = $page * $item - $item;
    	
    	
    	$count = $this->p->count();
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
    	
    	$product = $this->p->skip($offset)->take($item)->orderBy('pro_id', 'desc')->get();
    	
    	if(!$product || $page > $totalpage){
    		return response()->json([
    									'STATUS'=> false ,
    									'MESSAGE' => 'Not Found', 
    									'CODE'=> 400
    				    		], 200);
    	}else{
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
     *
     * @param unknown $page
     * @param unknown $limit
     * 
     */
    public function search($page, $limit, $keySearch)
    {
    	$keySearch = preg_replace ( '#[^0-9A-Za-z\s-_]#', '', $keySearch );
    	$page = preg_replace ( '#[^0-9]#', '', $page );
    	$item = preg_replace ( '#[^0-9]#', '', $limit );
    	$offset = $page * $item - $item;
    	 
    	 
    	$count = $this->p->where ( 'pro_name', 'like',  $keySearch . '%' )->count();
    	$totalpage = 0;
    	if ($count % $item > 0 ){
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
    	 
    	$product = $this->p->where ( 'pro_name', 'like',  $keySearch . '%' )->skip($offset)->take($item)->orderBy('pro_id', 'desc')->get();
    	 
    	if(!$product  || $page > $totalpage){
    		return response()->json([
    									'STATUS'=>  false ,
    									'MESSAGE' => 'Not Found',
    									'CODE'=> 400
    				    		], 200);
    	}else{
    		return response()->json([
    				'STATUS'=> true ,
    				'MESSAGE'=>'record found',
    				'DATA' => $product,
    				'PAGINATION' => $pagination
    		], 200);
    	}
    }
}
