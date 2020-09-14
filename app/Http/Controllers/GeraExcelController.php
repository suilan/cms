<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\EventoInscricao;
use Input;
use DB;
use App\User;
use App\Representante;
class GeraExcelController extends Controller
{
    public function downloadExcel($type)
	{
    if ( Input::get('pesquisar') || Input::get('inscricao') || Input::get('status')){
        $pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
        $inscricao = Input::get('inscricao');
        $status = Input::get('status');

        $inscritos = EventoInscricao::join('eventos','eventos.id','=','eventos_inscricao.evento_id')
  			    ->join('users','users.id','=','eventos.user_id')
            ->join('cidades','cidades.id','=','eventos_inscricao.cidade_id')
            ->where('evento_id','=',16)
            ->select('eventos_inscricao.nome',
                     'eventos_inscricao.cpf',
                     'eventos_inscricao.rg',
                     'eventos_inscricao.email',
                     'eventos_inscricao.telefone',
                     'eventos_inscricao.celular',
                     'cidades.nome as cidade',
                     'eventos_inscricao.empresa',
                     'eventos_inscricao.endereco',
                     'eventos_inscricao.created_at',
                     DB::raw("case when eventos_inscricao.inscricao = 1 then 'Notário / Registrador' when 2 then 'Funcionário de Cartório' when 3 then 'Profissionais do Direito' when 4 then 'Estudante' when 6 then 'Outros' else 'Não Informado' end as inscricao"),
                     'eventos_inscricao.confirmado'
                     );

        if ($pesquisar != "%%"){
    				$inscritos = $inscritos->where('eventos_inscricao.nome','like',$pesquisar)
    				->orWhere('eventos_inscricao.cpf','like',$pesquisar) ->where('evento_id','=',16)
    				->orWhere('eventos_inscricao.rg','like',$pesquisar) ->where('evento_id','=',16)
    				->orWhere('eventos_inscricao.email','like',$pesquisar) ->where('evento_id','=',16);
  			}
  			if($inscricao != "0"){
				    $inscritos = $inscritos->where('eventos_inscricao.inscricao','like',$inscricao);
  			}
  			if($status != "0"){
    				if($status == "1"){
					      $inscritos = $inscritos->where('eventos_inscricao.confirmado','=','1');
    				}elseif ($status == "2") {
      					$inscritos = $inscritos->where('eventos_inscricao.comprovante_url','<>','')
                ->whereNull('eventos_inscricao.confirmado');
    				}else{
                $inscritos = $inscritos->where('eventos_inscricao.comprovante_url','=','');
    				}
  			}
    }else{
        $inscritos = EventoInscricao::join('eventos','eventos.id','=','eventos_inscricao.evento_id')
        ->join('users','users.id','=','eventos.user_id')
        ->join('cidades','cidades.id','=','eventos_inscricao.cidade_id')
        ->where('evento_id','=',16)
        ->select('eventos_inscricao.nome',
                 'eventos_inscricao.cpf',
                 'eventos_inscricao.rg',
                 'eventos_inscricao.email',
                 'eventos_inscricao.telefone',
                 'eventos_inscricao.celular',
                 'cidades.nome as cidade',
                 'eventos_inscricao.empresa',
                 'eventos_inscricao.endereco',
                 'eventos_inscricao.created_at',
                 DB::raw("case when eventos_inscricao.inscricao = 1 then 'Notário / Registrador' when 2 then 'Funcionário de Cartório' when 3 then 'Profissionais do Direito' when 4 then 'Estudante' when 6 then 'Outros' else 'Não Informado' end as inscricao"),
                 'eventos_inscricao.confirmado'
                 );
    }

		$data = $inscritos->get()->toArray();

		Excel::create('Documento_Inscritos_Evento', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->export('xls');

    }
    
    public function downloadExcelCreden($type)
	{
    if ( Input::get('pesquisar') || Input::get('inscricao') || Input::get('status')){
        $pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
        $inscricao = Input::get('inscricao');
        $status = Input::get('status');

        $inscritos = EventoInscricao::join('eventos','eventos.id','=','eventos_inscricao.evento_id')
  			    ->join('users','users.id','=','eventos.user_id')
            ->join('cidades','cidades.id','=','eventos_inscricao.cidade_id')
            ->where('evento_id','=',16)
            ->where('credenciado','=',1)
            ->select('eventos_inscricao.nome',
                     'eventos_inscricao.cpf',
                     'eventos_inscricao.rg',
                     'eventos_inscricao.email',
                     'eventos_inscricao.telefone',
                     'eventos_inscricao.celular',
                     'cidades.nome as cidade',
                     'eventos_inscricao.empresa',
                     'eventos_inscricao.endereco',
                     'eventos_inscricao.created_at',
                     DB::raw("case when eventos_inscricao.inscricao = 1 then 'Notário / Registrador' when 2 then 'Funcionário de Cartório' when 3 then 'Profissionais do Direito' when 4 then 'Estudante' when 6 then 'Outros' else 'Não Informado' end as inscricao"),
                     'eventos_inscricao.confirmado'
                     );

        if ($pesquisar != "%%"){
    				$inscritos = $inscritos->where('eventos_inscricao.nome','like',$pesquisar)
    				->orWhere('eventos_inscricao.cpf','like',$pesquisar) ->where('evento_id','=',16)
    				->orWhere('eventos_inscricao.rg','like',$pesquisar) ->where('evento_id','=',16)
    				->orWhere('eventos_inscricao.email','like',$pesquisar) ->where('evento_id','=',16);
  			}
  			if($inscricao != "0"){
				    $inscritos = $inscritos->where('eventos_inscricao.inscricao','like',$inscricao);
  			}
  			if($status != "0"){
    				if($status == "1"){
					      $inscritos = $inscritos->where('eventos_inscricao.confirmado','=','1');
    				}elseif ($status == "2") {
      					$inscritos = $inscritos->where('eventos_inscricao.comprovante_url','<>','')
                ->whereNull('eventos_inscricao.confirmado');
    				}else{
                $inscritos = $inscritos->where('eventos_inscricao.comprovante_url','=','');
    				}
  			}
    }else{
        $inscritos = EventoInscricao::join('eventos','eventos.id','=','eventos_inscricao.evento_id')
        ->join('users','users.id','=','eventos.user_id')
        ->join('cidades','cidades.id','=','eventos_inscricao.cidade_id')
        ->where('evento_id','=',16)
        ->where('credenciado','=',1)
        ->select('eventos_inscricao.nome',
                 'eventos_inscricao.cpf',
                 'eventos_inscricao.rg',
                 'eventos_inscricao.email',
                 'eventos_inscricao.telefone',
                 'eventos_inscricao.celular',
                 'cidades.nome as cidade',
                 'eventos_inscricao.empresa',
                 'eventos_inscricao.endereco',
                 'eventos_inscricao.created_at',
                 DB::raw("case when eventos_inscricao.inscricao = 1 then 'Notário / Registrador' when 2 then 'Funcionário de Cartório' when 3 then 'Profissionais do Direito' when 4 then 'Estudante' when 6 then 'Outros' else 'Não Informado' end as inscricao"),
                 'eventos_inscricao.confirmado'
                 );
    }

		$data = $inscritos->get()->toArray();

		Excel::create('Documento_Inscritos_Evento', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->export('xls');

    }
    
    public function downloadExcelCredenIntimacao($type){
        $filter =  Input::get('startusCreden');

        if ($filter && $filter != 9) {
          if($filter < 5){
            if ($filter == 4) {
              $filter = 0;
            }
            $usuarioCredenciamento = User::where('papel_id',8)->where('creden', $filter)->orderBy('created_at','desc');
          } else {
            if($filter == 5){
              $usuarioCredenciamento = User::where('papel_id',8)->whereNotNull('adesao_at')->orderBy('adesao_at','desc');
            } else {
              $usuarioCredenciamento = User::where('papel_id',8)->whereNull('adesao_at')->orderBy('created_at','desc');
            }
          }
        } else {
          $usuarioCredenciamento = User::where('papel_id',8)->orderBy('created_at','desc');
        }
        
        $data = $usuarioCredenciamento->get()->toArray();

        Excel::create('Credenciados_Boletos_Aceite_Termo', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data) {
				$sheet->fromArray($data);
	        });
		})->export('xls');
    }

    public function downloadExcelCredenIntimacaoEmpresa($type){
		$filter = intval(Input::get('startusCreden'));
		$user = intval(Input::get('usuarioid'));
		
		if($user){
			$usuarioCredenciamento = Representante::join('users','users.id','=','representante.user_id')->where('users.id',$user);
		} else {
			$usuarioCredenciamento = Representante::join('users','users.id','=','representante.user_id');
		}
    
      if( Input::get('pesquisar') ){
              $pesquisar = '%'.str_replace(' ','%',Input::get('pesquisar')).'%';
    
              $usuarioCredenciamento = $usuarioCredenciamento->orWhere(function($query) use ($pesquisar){
                  $query->orWhere('cnpj','like',$pesquisar)
                        ->orWhere('razao','like',$pesquisar)
                        ->orWhere(DB::raw('replace(replace(replace(cnpj,".",""),"-",""),"/","")'),'like',$pesquisar);
              })->orderBy('representante.created_at','desc');
                  
      }
      elseif ($filter && $filter != 9) {
        if($filter < 5){
          if ($filter == 4) {
            $filter = 0;
          }
          $usuarioCredenciamento = $usuarioCredenciamento->where('papel_id',8)->where('creden', $filter)->orderBy('representante.created_at','desc');
        } else {
          if($filter == 5){
            $usuarioCredenciamento = $usuarioCredenciamento->where('papel_id',8)->whereNotNull('adesao_at')->orderBy('adesao_at','desc');
          } else {
            $usuarioCredenciamento = $usuarioCredenciamento->where('papel_id',8)->whereNull('adesao_at')->orderBy('representante.created_at','desc');
          }
        }
      } else {
        $usuarioCredenciamento = $usuarioCredenciamento->orderBy('representante.created_at','desc');
      }
      
      $data = $usuarioCredenciamento->get()->toArray();
    
      Excel::create('Credenciados_Boletos_Aceite_Termo', function($excel) use ($data) {
    $excel->sheet('mySheet', function($sheet) use ($data) {
      $sheet->fromArray($data);
        });
    })->export('xls');
    }
}