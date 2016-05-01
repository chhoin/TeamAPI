<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * SearchRequest Created on 12/03/2016
 * 
 * @author Sok Kimchhoin
 *        
 */
class SearchRequest extends Request {
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
				'key' => 'required|min:1|max:255|regex:/^[A-Za-z]+$/' 
		];
	}
}
