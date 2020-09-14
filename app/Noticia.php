<?php namespace App;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model {
	
 	protected $table = 'noticias';

  	public function getOtherImage( $width, $height ){

  		$newPath = '';
  		if( $this->imagem )
  		{
	  		if( substr_count($this->imagem, '.') ){
				$newPath = str_replace('.','-'.$width.'x'.$height.'.',$this->imagem);
			}
			else{
				$newPath = $this->imagem.'-'.$width.'x'.$height;
			}

			// if the image dont exists, create it
			if( !file_exists(public_path().$newPath) && file_exists(public_path().$this->imagem) ){
				$img = Image::make(public_path().$this->imagem)
					->fit($width, $height)
					->save(public_path().$newPath);
			}
		}

		return $newPath;
	}

	public function eraseAuxImgs( ){
		
		$sizes = array(array(100,50),array(200,200),array(314,200),array(310,200),array(410,220));
		$newPath = '';
		if( $this->imagem )
		{
			foreach ($sizes as $s) {
				if( substr_count($this->imagem, '.') ){
					$newPath = str_replace('.','-'.$s[0].'x'.$s[1].'.',$this->imagem);
				}
				else{
					$newPath = $this->imagem.'-'.$s[0].'x'.$s[1];
				}

				@unlink(public_path().$newPath);
			}
		}

		return $newPath;
	}
}
