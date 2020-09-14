<?php namespace App;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model {

	protected $table = 'albuns';

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

	public function eraseImage( $width, $height ){
		
		$newPath = '';
		if( $this->imagem )
		{
			if( substr_count($this->imagem, '.') ){
				$newPath = str_replace('.','-'.$width.'x'.$height.'.',$this->imagem);
			}
			else{
				$newPath = $this->imagem.'-'.$width.'x'.$height;
			}

			@unlink(public_path().$newPath);
		}

		return $newPath;
	}
}
