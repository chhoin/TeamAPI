<?php

namespace App\Http\Requests;

use Validator;
use App\Http\Requests\Request;

/**
 * CategoryRequest Created on 12/03/2016
 *
 * @author Kimchhoin Sok
 *        
 */
class CategoryRequest extends Request {
	
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
			'category' => 'required|min:2|regex:/^[a-zA-Z+\s]+$/'
		];
			
	}
	
	/**
	 * 
	 * @param array $errors
	 */
	public function response(array $errors) {
		return response()->json([
				'STATUS'=> false,
				'MESSAGE'=>'ERROR',
				'CODE' => 400,
				'ERROR' => $errors
		], 200);
	}
}
