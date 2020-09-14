<?php namespace App;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Model;

class NoticiaGaleria extends Model {
	
 	protected $table = 'noticias_galeria';


  	public function getOtherImage( $width, $height ){

  		$newPath = '';
  		// if( $this->path ){
	  		if( substr_count($this->path, '.') ){
				$newPath = str_replace('.','-'.$width.'x'.$height.'.',$this->path);
			}
			else{
				$newPath = $this->path.'-'.$width.'x'.$height;
			}

			// if the image dont exists, create it
			if( !file_exists(public_path().$newPath) && file_exists(public_path().$this->path) ){
				$img = Image::make(public_path().$this->path)
					->fit($width, $height)
					->save(public_path().$newPath);
			}
		// }
		return $newPath;
	}

	public function eraseAuxImgs( ){
		
		$sizes = array(array(100,50),array(200,200),array(314,200),array(310,200));
		$newPath = '';
		foreach ($sizes as $s) {
			if( substr_count($this->path, '.') ){
				$newPath = str_replace('.','-'.$s[0].'x'.$s[1].'.',$this->path);
			}
			else{
				$newPath = $this->path.'-'.$s[0].'x'.$s[1];
			}

			@unlink(public_path().$newPath);
		}

		return $newPath;
	}
}
