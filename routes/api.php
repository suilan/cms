<?php

use Illuminate\Http\Request;
use App\User;
use App\ArquivoBoleto;
use App\Notificacoes;
use App\Devedor;
use App\NotificacaoDevedor;
use App\NotificacaoDevedorSt;
use App\DevedorContato;
use Illuminate\Support\Facades\Log;

use App\Mail\VerifyMail;

use Carbon\Carbon;

use App\Mail\RecoveryPassword;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/authetication', function (Request $request) {    
    $obj = json_decode($request->getContent(), true);

    $credentials = [];
    $credentials["email"] = $obj["email"];
    $credentials["password"]  = $obj["password"];

    $token = $obj["token"];

    if (Auth::attempt($credentials, $request->has('remember'))){
        $user = User::find(Auth::user()->id);

        // if ($user->verified != 1) {
        //     return response([
        //         "codigo" => 1,
        //         "resposta" => "Você precisa confirmar sua conta. Foi enviado um código de veridicação para você. Por favor, cheque seu e-mail."
        //     ], 200)
        //     ->header('Content-Type', 'application/json');
        // } else {
            $user->token_notificacao = $token;
            $user->save();

            return response([
                "codigo" => 0,
                "resposta" => ["usuario" => Auth::user()]
            ], 200)
            ->header('Content-Type', 'application/json');
        // }
    } else {
        return response([
            "codigo" => 1,
            "resposta" => "Usuário e/ou senha inválidos"
        ], 200)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('/changepassword', function (Request $request) {
    $obj = json_decode($request->getContent(), true);

    $credentials = [];
    $credentials["email"] = $obj["email"];
    $credentials["password"]  = $obj["password"];

    if (Auth::attempt($credentials, $request->has('remember'))){

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($obj["newPassword"]);
        $user->save();

        return response([
            "codigo" => 0,
            "resposta" => "Senha alterada com sucesso."
        ], 200)
        ->header('Content-Type', 'application/json');
    } else {
        return response([
            "codigo" => 1,
            "resposta" => "Usuário e/ou senha inválidos"
        ], 200)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('/newpassword', function (Request $request) {
    $obj = json_decode($request->getContent(), true);

    $user = User::where("email", "=", $obj["email"])->first();
    $user->password = Hash::make($obj["newPassword"]);
    $user->save();

    return response([
        "codigo" => 0,
        "resposta" => "Senha alterada com sucesso."
    ], 200)
    ->header('Content-Type', 'application/json');
});

Route::post('/recoverypassworld', function (Request $request) {
    $remember_token = mt_rand(100000, 999999);
    $obj = json_decode($request->getContent(), true);

    $user = User::where("email", "=", $obj["email"])->first();

    if ($user){
        $user->remember_token = $remember_token;
        $user->save();

        Mail::to($user->email)->send(new RecoveryPassword($user));

        return response([
            "codigo" => 0,
            "resposta" => "Token enviado para o e-mail."
        ], 200)
        ->header('Content-Type', 'application/json');
    } else {
        return response([
            "codigo" => 1,
            "resposta" => "E-mail não encontrado na base de dados."
        ], 200)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('/consultaboletos', function (Request $request) {
    $obj = json_decode($request->getContent(), true);

    $registros = ArquivoBoleto::join('arquivo_remessa_boleto_dets','arquivo_remessa_boleto_dets.id_arquivo_boleto','=','arquivo_remessa_boletos.id')
        ->select('arquivo_remessa_boleto_dets.id as id','nome_apresentante','especie_titulo',DB::raw('date_format(data_emissao_titulo,"%d/%m/%Y") as data_emissao_titulo'),
                DB::raw('date_format(STR_TO_DATE(vencimento_boleto,"%d%m%Y"),"%d/%m/%Y") as vencimento_boleto'),'valor_total_boleto','valor_custas_emolumento','valor_principal_titulo','impresso','codigo_barra_boleto')
        ->where(DB::raw('STR_TO_DATE(vencimento_boleto,"%d%m%Y")'),'>=',Carbon::now()->setTimezone('America/Fortaleza')->toDateString())
        ->where(function($query) use ($obj){
            $query ->where('documento_sacado','=',$obj['param'])
                   ->orWhere('protocolo','=',$obj['param']);
        })->get();

    if (sizeof($registros) > 0) {
        return response([
            "codigo" => 0,
            "resposta" => ["boletos" => $registros]
        ], 200)
        ->header('Content-Type', 'application/json');
    } else {
        return response([
            "codigo" => 1,
            "resposta" => "Não há boletos para esse documentos."
        ], 200)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('/validtoken', function (Request $request) {
    $obj = json_decode($request->getContent(), true);

    $user = User::where("remember_token", "=", $obj["token"])->first();

    if ($user){
        return response([
            "codigo" => 0,
            "resposta" => "Token validado com sucesso."
        ], 200)
        ->header('Content-Type', 'application/json');
    } else {
        return response([
            "codigo" => 1,
            "resposta" => "Token inválido."
        ], 200)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('/generatepassword', function (Request $request) {
    $obj = json_decode($request->getContent(), true);
    
    return response([
        "codigo" => 0,
        "resposta" => Hash::make($obj["password"])
    ], 200)
    ->header('Content-Type', 'application/json');
});


Route::post('/notificacoes', function(Request $request) {
    $obj = json_decode($request->getContent(), true);

    $notificacoes = 
    DB::select('
        select a.user_id, a.documento, a.created_at
        from notificacoes as a 
        where (
            select count(0) from notificacoes as b 
            where b.documento = a.documento 
            and b.`user_id` = a.user_id 
            and b.created_at >= a.created_at
        ) <= 3
        and a.user_id = ?
        order by a.documento asc, a.created_at desc
    ', [$obj["user_id"]]);
    
    if($notificacoes){
        return response([
            "codigo" => 0,
            "resposta" => ["notificacoes" => $notificacoes]
        ], 200)
        ->header('Content-Type', 'application/json');
    } else {
        return response([
            "codigo" => 1,
            "resposta" => "Token inválido."
        ], 200)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('/downloadpesquisa', function(Request $request) {
    $obj = json_decode($request->getContent(), false);
    
    $emailDestination = $obj->email;
    $token = $obj->token;
    $documento = $obj->documento;

    $result = file_get_contents('http://pesquisaprotesto.com.br/ws/consulta/'.$documento.'/'.$token);

    $json = json_decode($result, false);
    $dados = $json;

    $pdf = PDF::loadView('myPDF', compact('dados'));
    $pdf->setPaper('A4', 'portrait');

    Mail::send('emails.pesquisaprotesto',$request->all(),function($email) use ($pdf, $emailDestination){
        $email->from('contatoieptbma@gmail.com','Consulta Gratuita de Protesto');
        $email->subject('Consulta Gratuita de Protesto');
        $email->to($emailDestination);
        $email->attachData($pdf->output(), 'pesquisaprotesto'.date('dmYHis').'.pdf');
    });
    
    return response([
        "codigo" => 0,
        "resposta" => "Pfd enviado por email com sucesso."
    ], 200)
    ->header('Content-Type', 'application/json');
});

Route::get('usuarios/credenciados', function (Request $request) {
    $obj = json_decode($request->getContent(), true);

    $credentials = [];
    $credentials["email"] = $obj["email"];
    $credentials["password"]  = $obj["password"];

    if (Auth::attempt($credentials, $request->has('remember'))){

        $usuariosCredenciados = User::with('cidades')
        ->with('representantes','representantes.cidades')
        ->whereNotNull('adesao_at')
        ->where('cartorio_id', "=" , Auth::user()->cartorio_id);

        if( array_key_exists('dataConsulta', $obj)){
            $usuariosCredenciados = $usuariosCredenciados->where(DB::raw('date_format(adesao_at,"%Y%m%d")'), '>=', $obj["dataConsulta"]);
        }

        $usuariosCredenciados = $usuariosCredenciados->get();

        return response()->json([
            "codigo" => 0,
            "resposta" => ["usuarios" => $usuariosCredenciados]
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    } else {
        return response()->json([
            "codigo" => 1,
            "resposta" => "Usuário e/ou senha inválidos"
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('devedores', function (Request $request) {
    $obj = json_decode($request->getContent(), true);

    $devedores = $obj["devedores"];

    $credentials = [];
    $credentials["email"] = $obj["email"];
    $credentials["password"]  = $obj["password"];

    if (Auth::attempt($credentials, $request->has('remember'))){

        foreach ($devedores as $key => $devedor) {
            $devedorVerificar = Devedor::where('documento',$devedor["documento"])->first();

            if(!$devedorVerificar){
                $devedorNovo = new Devedor;
                $devedorNovo->tipo_doc = $devedor["tipo_doc"];
                $devedorNovo->documento =$devedor["documento"];
                $devedorNovo->nome = null;
                $devedorNovo->origem = 'ARPNET';
                $devedorNovo->save();

                foreach ($devedor["contatos"] as $key => $contato) {
                    $contatoNovo = new DevedorContato;
                    $contatoNovo->devedor_id = $devedorNovo->id;
                    $contatoNovo->contato = $contato["contato"];
                    $contatoNovo->tipo_contato = $contato["tipo_contato"];
                    $contatoNovo->origem = 'ARPNET-PROCOB';

                    $contatoNovo->save();
                }
            }  else {
                foreach ($devedor["contatos"] as $key => $contato) {
                    $contatoExiste = DevedorContato::where("contato","=",$contato["contato"])->first();

                    if(!$contatoExiste){
                        $contatoNovo = new DevedorContato;
                        $contatoNovo->devedor_id = $devedorVerificar->id;
                        $contatoNovo->contato = $contato["contato"];
                        $contatoNovo->tipo_contato = $contato["tipo_contato"];
                        $contatoNovo->origem = 'ARPNET-PROCOB';

                        $contatoNovo->save();
                    }
                }
            }
        }
        return response()->json([
            "codigo" => 0,
            "resposta" => "Dados atualizados com sucesso"
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    } else {
        return response()->json([
            "codigo" => 1,
            "resposta" => "Usuário e/ou senha inválidos"
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('devedores/completacadastro', function (Request $request) {
    $obj = json_decode($request->getContent(), true);

    $documento = $obj["documentoDevedor"];
    $contatos = $obj["contatos"];

    $credentials = [];
    $credentials["email"] = $obj["email"];
    $credentials["password"]  = $obj["password"];

    if (Auth::attempt($credentials, $request->has('remember'))){

        $devedor = Devedor::where('documento',$documento)->first();
        
        if($devedor){
            foreach ($contatos as $key => $value) {
                $contato = new DevedorContato;
                $contato->devedor_id = $devedor->id;
                $contato->contato = $value["contato"];
                $contato->tipo_contato = $value["tipo_contato"];
                $contato->origem = 'ARPNET-PROCOB';

                $contato->save();
            }

            return response()->json([
                "codigo" => 0,
                "resposta" => "Dados atualizados com sucesso"
            ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
            ->header('Content-Type', 'application/json');
        } else {
            return response()->json([
                "codigo" => 1,
                "resposta" => "Devedor não encontrado"
            ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
            ->header('Content-Type', 'application/json');
        }
    } else {
        return response()->json([
            "codigo" => 1,
            "resposta" => "Usuário e/ou senha inválidos"
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('notification/confirmamensagem/1588818629048-9194195375312', function (Request $request) { 
    $retorno = json_decode(json_encode($request->only(['SmsSid','SmsStatus','MessageStatus','To'])));

    $notificacaoDevedor = NotificacaoDevedor::where("mensagem_sid",$retorno->SmsSid)->first();

    if($notificacaoDevedor){
        $notificacaoDevedorSt = new NotificacaoDevedorSt;
        $notificacaoDevedorSt->notificacao_devedorid = $notificacaoDevedor->notificacao_devedor_id;
        $notificacaoDevedorSt->response = $request->getContent();
        $notificacaoDevedorSt->status = $retorno->SmsStatus;
        $notificacaoDevedorSt->save();

        return response()->json([
            "codigo" => 0,
            "resposta" => "Retorno recebido com sucesso"
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    } else {
        // $whatsapp = str_replace('whatsapp:+55','',$retorno->To);
        // $devedor
        // Log::debug($whatsapp);

        return response()->json([
            "codigo" => 1,
            "resposta" => "Mensagem não encontrada"
        ], 503, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    }
});

Route::post('devedores/completacadastroexterno', function (Request $request) {
    $obj = json_decode($request->getContent(), true);

    $contatos = $obj["novos"];

    $credentials = [];
    $credentials["email"] = $obj["email"];
    $credentials["password"]  = $obj["password"];

    if (Auth::attempt($credentials, $request->has('remember'))){
        foreach ($contatos as $key => $value) {
            $devedor = Devedor::where('documento',$value['documento'])->first();

            if (array_key_exists('email1', $value)) {
                $contato = new DevedorContato;
                $contato->devedor_id = $devedor->id;
                $contato->contato = $value["email1"];
                $contato->tipo_contato = 5;
                $contato->origem = 'COLETA_INTERNET';

                $contato->save();
            } else if (array_key_exists('email2', $value)) {
                $contato = new DevedorContato;
                $contato->devedor_id = $devedor->id;
                $contato->contato = $value["email2"];
                $contato->tipo_contato = 5;
                $contato->origem = 'COLETA_INTERNET';

                $contato->save();
            }
        }

        return response()->json([
            "codigo" => 0,
            "resposta" => "Dados atualizados com sucesso"
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    } else {
        return response()->json([
            "codigo" => 1,
            "resposta" => "Usuário e/ou senha inválidos"
        ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
        ->header('Content-Type', 'application/json');
    }
});

// Route::post('enviaremailconfirmacao', function () {
//     $users = User::where('verified',0)->whereRaw('
//     exists (
//         select 0 from verify_users u
//         where u.user_id = users.id
//     )
//     ')->where('papel_id',8)->get();

//     foreach ($users as $key => $user) {
//         Mail::to($user->email)->send(new VerifyMail($user));
//     }

//     return response()->json([
//         "codigo" => 0,
//         "resposta" => "E-mails enviados com sucesso."
//     ], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)
//     ->header('Content-Type', 'application/json');
// });