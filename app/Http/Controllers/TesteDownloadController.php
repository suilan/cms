<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PDF;
use Input;


class TesteDownloadController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function download()
	{
		$json = Input::get('json');

		$content = json_decode($json,true);
		$dados = $content->dados;

        $pdf = PDF::loadView('myPDF', compact('dados'));
		$pdf->setPaper('A4', 'portrait');
		return $pdf->stream('demo.pdf');
	}
}
