<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * ProductRequest created on 16/03/2016
 * 
 * @author Sok Kimchhoin
 *
 */
class ProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        		'pro_name' => 'required|min:3|max:255|regex:/^[0-9A-Za-z\s-_]+$/',
				'pro_description' => 'required|min:3|',
				'pro_prize' => 'required|max:255|regex:/^[\s0-9$]+$/'
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
