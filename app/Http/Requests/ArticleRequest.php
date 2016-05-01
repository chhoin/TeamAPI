<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


/**
 * ArticleRequest Created on 12/03/2016
 *
 * @author Kimchhoin Sok
 *        
 */
class ArticleRequest extends Request {
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [ 
			'title' => 'required|min:3|max:255|regex:/^[0-9A-Za-z\s-_]+$/',
			'description' => 'required|min:3',
			'ART_IMG' => 'mimes:jpeg,jpg,bmp,png|max:1025px',
			'category' => 'required|max:255|regex:/^[0-9]$/'
		];
	}
	/**
     * response
     * @param array $errors
     */
	public function response(array $errors) {
    	return response()->json([
    				'STATUS'=> 'invalid',
    				'MESSAGE'=>'record found',
    				'CODE' => 400,
    				'ERROR' => $errors
    			], 200);
    }
    
}
