<?php

namespace App\Http\Controllers;

use App\EventoInscricao;
use Illuminate\Http\Request;
use Input;

class AdminCredenciamentoEventoController extends Controller
{

    public function __construct()
    {
        view()->share('page_title', 'Credenciamento de eventos');
        view()->share('page_description', 'Pesquisa de CPF para credenciamento');
    }

    public function index()
    {
        $qtd_inscritos = EventoInscricao::where('evento_id', '=', 16)->count('*');
        $qtd_confirmados = EventoInscricao::where('confirmado', '=', 1)->where('evento_id', '=', 16)
            ->count();
        $qtd_credenciados = EventoInscricao::where('credenciado', '=', 1)->where('evento_id', '=', 16)
            ->count();
        return view('admin.credenciamento.home')
            ->with('status', '')
            ->with('qtd_inscritos',$qtd_inscritos)
            ->with('qtd_credenciados',$qtd_credenciados)
            ->with('qtd_confirmados',$qtd_confirmados);
    }

    public function show($id)
    {
        $cpfCredenciamento = Input::get('cpfParticipante');
        $nomeParticipante = '%' . str_replace(' ', '%', Input::get('nomeParticipante')) . '%';

        $inscrito = EventoInscricao::orWhere('cpf', '=', $cpfCredenciamento)->where('evento_id', '=', 16)
            ->where('evento_id', '=', 16);

        if (strtoupper($nomeParticipante) != '%%') {
            $inscrito = $inscrito->orWhere('nome', 'like', strtoupper($nomeParticipante))->where('evento_id', '=', 16);
        }

        $inscrito = $inscrito->first();

        if ($inscrito != null) {
            return view('admin.credenciamento.visualizar')
                ->with('inscrito', $inscrito)
                ->with('status', '');
        } else {
            return view('admin.credenciamento.home')
                ->with('status', 'CPF e/ou Nome não foi localizado na base de dados do evento.');
        }
    }

    public function update($id, Request $request)
    {
        // Credenciamento
        $inscrito = EventoInscricao::where('cpf', '=', $id)->where('evento_id', '=', 16)->first();
        $tipoCredenciamento = Input::get('tipoCredenciamento');
        $qtd_inscritos = EventoInscricao::where('evento_id', '=', 16)->count('*');
        $qtd_confirmados = EventoInscricao::where('confirmado', '=', 1)->where('evento_id', '=', 16)
            ->count();
        $qtd_credenciados = EventoInscricao::where('credenciado', '=', 1)->where('evento_id', '=', 16)
            ->count();

        if ($tipoCredenciamento == 1) {
            $inscrito->credenciado = 1;
            $inscrito->save();
            return view('admin.credenciamento.home')
                ->with('status', 'Credenciamento de entrada realizado com sucesso para o CPF: ' . $inscrito->cpf)
                ->with('qtd_credenciados',$qtd_credenciados)
                ->with('qtd_confirmados',$qtd_confirmados);
        } else {
            $inscrito->credenciamento_saida = 1;
            $inscrito->save();
            return view('admin.credenciamento.home')
                ->with('status', 'Credenciamento de saída realizado com sucesso para o CPF: ' . $inscrito->cpf)
                ->with('qtd_credenciados',$qtd_credenciados)
                ->with('qtd_confirmados',$qtd_confirmados);
        }
    }
}
