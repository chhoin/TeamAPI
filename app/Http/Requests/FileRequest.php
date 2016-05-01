<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * CreateFileRequest created on 01/4/2016
 *
 * @author Sok Kimchhoin
 *
 */
class FileRequest extends Request {

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
		return 
		[
			'file' => 'required|max:50000|mimes:doc,docx,pdf,txt'
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
