<?php namespace App;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model {

	protected $table = 'eventos';

	public function getOtherImage( $width, $height ){

  		$newPath = '';
  		if( $this->imagem_arquivo )
  		{
	  		if( substr_count($this->imagem_arquivo, '.') ){
				$newPath = str_replace('.','-'.$width.'x'.$height.'.',$this->imagem_arquivo);
			}
			else{
				$newPath = $this->imagem_arquivo.'-'.$width.'x'.$height;
			}

			// var_dump($newPath);
			// exit;

			// if the image dont exists, create it
			if( !file_exists(public_path().$newPath) && file_exists(public_path().$this->imagem_arquivo) ){
				$img = Image::make(public_path().$this->imagem_arquivo)
					->fit($width, $height)
					->save(public_path().$newPath);
			}
		}

		return $newPath;
	}

	public function eraseAuxImgs( ){
		
		$sizes = array(array(100,50),array(200,200),array(314,200),array(310,200));
		$newPath = '';
		if( $this->imagem_arquivo )
		{
			foreach ($sizes as $s) {
				if( substr_count($this->imagem_arquivo, '.') ){
					$newPath = str_replace('.','-'.$s[0].'x'.$s[1].'.',$this->imagem_arquivo);
				}
				else{
					$newPath = $this->imagem_arquivo.'-'.$s[0].'x'.$s[1];
				}

				@unlink(public_path().$newPath);
			}
		}

		return $newPath;
	}
}
