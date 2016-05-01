<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\TblFile;
use App\Http\Requests\FileRequest;
use App\Http\Requests\ImageRequest;
use File as FileManager;

/**
 * FileController created on 01/4/2016
 *
 * @author Sok Kimchhoin
 *        
 */
class FileController extends Controller {
	private $f;
	
	/**
	 * __construct
	 *
	 * @param TblFile $f        	
	 */
	function __construct(TblFile $f) {
		$this->f = $f;
	}
	
	/**
	 * file
	 */
	public function file() {
		$file = $this->f->all ();
		
		if (! $file) {
			return response ()->json ( [ 
					'STATUS' => false,
					'MESSAGE' => 'Not Found',
					'CODE' => 400 
			], 200 );
		} else {
			return response ()->json ( [ 
					'STATUS' => true,
					'MESSAGE' => 'record found',
					'DATA' => $file 
			], 200 );
		}
	}
	
	/**
	 * uploadFile
	 * 
	 * @param FileRequest $request        	
	 */
	public function uploadFile(FileRequest $request) {
		
		// storeFile is the function that we confige path of file
		$path = $this->storeFile ( $request );
		
		$upload = $this->f->insert ( [ 
				'path' => $path 
		] );
		
		if ($upload) {
			return response ()->json ( [ 
					'STATUS' => true,
					'MESSAGE' => 'file was uploaded',
					'PATH' => $path,
					'CODE' => 200 
			], 200 );
		} else {
			return response ()->json ( [ 
					'STATUS' => false,
					'MESSAGE' => 'file can not upload',
					'CODE' => 400 
			], 200 );
		}
	}
	
	/**
	 * uploadImage
	 * 
	 * @param ImageRequest $request        	
	 */
	public function uploadImage(ImageRequest $request) {
		
		// storeFile is the function that we confige path of file
		$path = $this->storeImage( $request );
		
		$upload = $this->f->insert ( [ 
				'path' => $path 
		] );
		
		if ($upload) {
			return response ()->json ( [ 
					'STATUS' => true,
					'MESSAGE' => 'image was uploaded',
					'PATH' => $path,
					'CODE' => 200 
			], 200 );
		} else {
			return response ()->json ( [ 
					'STATUS' => false,
					'MESSAGE' => 'image can not upload',
					'CODE' => 400 
			], 200 );
		}
	}
	
	/**
	 *
	 * @param unknown $request        	
	 * @return string
	 */
	function storeFile($request) {
		$file = $request->file ( 'file' );
		
		$path = '/files/file/';
		$name = sha1 ( Carbon::now () ) . '.' . $file->guessExtension ();
		
		$file->move ( public_path () . $path, $name );
		
		return $path . $name;
	}
	
	/**
	 *
	 * @param unknown $request        	
	 * @return string
	 */
	function storeImage($request) {
		$file = $request->file ( 'image' );
		
		$path = '/files/image/';
		$name = sha1 ( Carbon::now () ) . '.' . $file->guessExtension ();
		
		$file->move ( public_path () . $path, $name );
		
		return $path . $name;
	}
}
