<?php

namespace App\Http\Controllers\Backend;

use App\Model\Descontos;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Fipes;
use App\Model\Contingencia;
use App\Model\Combos;
use App\Model\Produtos;
use App\Model\PrecoProdutos;
use App\Model\CategoriaFipes;
use App\Model\FipeAnoValor;
use App\Model\Profissoes;
use App\Model\RamoAtividades;
use App\Model\Segurado;
use App\Model\Veiculos;


class AjaxController extends Controller
{

    public function modelo(Request $request)
    {
        $tipo = $request->input('tipoveiculo');
        $like = $request->input('term');
        $fipe = Fipes::where('tipoveiculo_id', $tipo)
            ->where('modelo', 'ilike', "%{$like}%")
            ->Orwhere('marca', 'ilike', "%{$like}%")
            ->where('tipoveiculo_id', $tipo)
            ->where('idstatus','!=',29)
            ->take(100)
            ->orderBy('marca', 'ASC')
            ->orderBy('modelo', 'ASC')
            ->get();
        $return = [];


        foreach ($fipe as $value):


            $return[] = ['id' => $value->codefipe, 'category' => $value->marca, 'label' => $value->modelo . ' (' . $value->preiodo . ')'];

        endforeach;

        return response()->json($return);
    }

    public function profissao(Request $request)
    {

        $like = $request->input('term');
        $profissaos = Profissoes::where('nm_ocupacao', 'ilike', "%{$like}%")
            ->take(100)
            ->orderBy('nm_ocupacao', 'ASC')
            ->get();
        $return = [];


        foreach ($profissaos as $value):


            $return[] = ['id' => $value->id_ocupacao, 'label' => $value->nm_ocupacao];

        endforeach;

        return response()->json($return);
    }

    public function ramoatividade(Request $request)
    {

        $like = $request->input('term');
        $profissaos = RamoAtividades::where('nome_atividade', 'ilike', "%{$like}%")
            ->take(100)
            ->orderBy('nome_atividade', 'ASC')
            ->get();
        $return = [];


        foreach ($profissaos as $value):


            $return[] = ['id' => $value->id_ramo_atividade, 'label' => $value->nome_atividade];

        endforeach;

        return response()->json($return);
    }

    public function anovalor(Request $request)
    {
        $anovalor = FipeAnoValor::where('codefipe', '=', $request
            ->input('cdfipe'))
            ->orderBy('ano', 'ASC')
            ->get();
        
        foreach ($anovalor as $value):


            echo '<option data-comustivel="'.$value->idcombustivel.'"    data-valor="'.$value->valor.'" value="' . $value->ano . '">' . $value->ano . ' - ' . ($value->idcombustivel == 1 ? 'Gasolina' : ($value->idcombustivel == 2 ? 'Alcool' : 'Disel')) . ' - R$ ' . number_format($value->valor, 2, ',', '.') . '</option>';

        endforeach;
    }

    public function anofab(Request $request)
    {
        $fipe = Fipes::where('codefipe', '=', $request
            ->input('cdfipe'))
            ->get();


        foreach ($fipe as $anofab):
            $anofab = explode(',', $anofab->preiodo);

            foreach ($anofab as $value):
                $i = strstr($value, '-', TRUE);
                $ii = str_replace('-', '', strstr($value, '-'));
                for ($i; $i <= ($ii > date('Y') + 1 ? date('Y') + 1 : $ii); $i++):
                    echo '<option value="' . $i . '">' . $i . '</option>';
                endfor;
            endforeach;

        endforeach;
    }

    public function produtosmaster(Request $request)
    {
        $cdfipe = $request->input('cdfipe');
        $valor = $request->input('valor');
        $comissao = $request->input('comissao');
        $renova = $request->input('renova');
        $idade = date('Y') - ($request->input('ano') > 1 ? $request->input('ano') : date('Y'));
        $tipo = ($request->input('tipo') == 8 ? 1 : $request->input('tipo'));
        $categoria = CategoriaFipes::where('codefipe', '=', $cdfipe)
            ->where('idseguradora', '=', 2)
            ->get();
        $categoria = $categoria[0]->idcategoria;


        $fipe = Fipes::find($cdfipe);
        $retorno = [];
        $combos = [];

        foreach (Produtos::whereTipoproduto('master')->whereCodstatus('1')->orderBy('idproduto', 'ASC')->get() as $produto):

            foreach (Combos::whereIdprodutomaster($produto->idproduto)->get() as $combo) {
                $combos['idproduto' . $combo->idprodutomaster][] = $combo->idprodutoopcional;
            }


            foreach ($produto->precoproduto as $preco):
                $retorno[] = ['produtos' => $produto];

                if($renova == 1){
                    $preco->premioliquidoproduto = $preco->premioliquidoproduto - Descontos::where('tipo','renova')->first()->valor;
                }

                if ($tipo == $preco->idtipoveiculo):
                    if ($valor >= $preco->vlrfipeminimo && $valor <= $preco->vlrfipemaximo && $idade <= $preco->idadeaceitamax && $tipo == $preco->idtipoveiculo):

                        if ( $produto->idproduto == 1) {
                            $vlcont = Contingencia::where('ind_idstatus_fipe', $fipe->idstatus)->first();
                            $preco->premioliquidoproduto = $preco->premioliquidoproduto + $vlcont->valor;
                        }


                            $retorno[] = [
                                'html' => (string) view('backend.produto.div',compact('preco','produto')),
                                'acordion' => '#acordion' . $produto->idproduto,
                                'chkid' => '#produto-'. $produto->idproduto.'-'.$preco->idprecoproduto,
                                'precospan' => '#preco-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                                'divp' => '#divp-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                                'idproduto' => $produto->idproduto,
                                'span' => "span-".$produto->idproduto."-".$preco->idprecoproduto,
                            ];



                    endif;
                elseif ($preco->idcategoria == $categoria && $tipo == $preco->idtipoveiculo):
                    $retorno[] = [
                        'html' => (string) view('backend.produto.div',compact('preco','produto')),
                        'acordion' => '#acordion' . $produto->idproduto,
                        'chkid' => '#produto-'. $produto->idproduto.'-'.$preco->idprecoproduto,
                        'precospan' => '#preco-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                        'divp' => '#divp-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                        'idproduto' => $produto->idproduto,
                        'span' => "span-".$produto->idproduto."-".$preco->idprecoproduto,
                    ];

                elseif ($tipo == $preco->idtipoveiculo):
                    if ($idade >= $preco->idadeaceitamin && $idade <= $preco->idadeaceitamax && $tipo == $preco->idtipoveiculo):
                        $retorno[] = [
                            'html' => (string) view('backend.produto.div',compact('preco','produto')),
                            'acordion' => '#acordion' . $produto->idproduto,
                            'chkid' => '#produto-'. $produto->idproduto.'-'.$preco->idprecoproduto,
                            'precospan' => '#preco-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                            'divp' => '#divp-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                            'idproduto' => $produto->idproduto,

                            'span' => "span-".$produto->idproduto."-".$preco->idprecoproduto,
                        ];
                    endif;

                endif;


            endforeach;
        endforeach;

        return response()->json($retorno);
    }

    public function produtosopcional(Request $request)
    {
        $cdfipe = $request->input('cdfipe');
        $valor = $request->input('valor');
        $idproduto = $request->input('idproduto');
        $idade = date('Y') - ($request->input('ano') > 1 ? $request->input('ano') : date('Y'));
        $tipo = ($request->input('tipo') == 8 ? 1 : $request->input('tipo'));
        $categoria = CategoriaFipes::where('codefipe', '=', $cdfipe)
            ->where('idseguradora', '=', 2)
            ->get();
        $categoria = $categoria[0]->idcategoria;


        $retorno = [];


        foreach (Combos::whereIdprodutomaster($idproduto)->get() as $combo):
            $produto = Produtos::whereIdproduto($combo->idprodutoopcional)->whereCodstatus(1)->first();
            
            if($produto){

                foreach ($produto->precoproduto as $preco):
                    $preco;
                    #$retorno[] = ['produtos' => $produto];

                    if ($valor >= $preco->vlrfipeminimo && $tipo == $preco->idtipoveiculo && $preco->idcategoria == ($preco->idcategoria == $categoria ? $categoria : null) && $valor <= $preco->vlrfipemaximo && $idade <= $preco->idadeaceitamax && $tipo == $preco->idtipoveiculo):

                        $retorno[] = [
                            'html' => (string) view('backend.produto.div',compact('preco','produto')),
                            'acordion' => '#acordion' . $produto->idproduto,
                            'chkid' => '#produto-'. $produto->idproduto.'-'.$preco->idprecoproduto,
                            'precospan' => '#preco-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                            'divp' => '#divp-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                            'idproduto' => $produto->idproduto,
                            'span' => "span-".$produto->idproduto."-".$preco->idprecoproduto,
                            'tiposeguro'=> $produto->tipodeseguro
                        ];


                    elseif ($tipo == $preco->idtipoveiculo && $preco->vlrfipeminimo == null && $preco->idcategoria == null && $idade >= $preco->idadeaceitamin && $idade <= $preco->idadeaceitamax && $tipo == $preco->idtipoveiculo):
                        $retorno[] = [
                            'html' => (string) view('backend.produto.div',compact('preco','produto')),
                            'acordion' => '#acordion' . $produto->idproduto,
                            'chkid' => '#produto-'. $produto->idproduto.'-'.$preco->idprecoproduto,
                            'precospan' => '#preco-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                            'divp' => '#divp-' . $produto->idproduto.'-'.$preco->idprecoproduto,
                            'idproduto' => $produto->idproduto,
                            'span' => "span-".$produto->idproduto."-".$preco->idprecoproduto,
                            'tiposeguro'=> $produto->tipodeseguro
                        ];

                    endif;


                endforeach; 
            }
           
        endforeach;

        return response()->json($retorno);
    }

    public function setMiddleware($middleware)
    {
        $this->middleware = $middleware;
    }

    public function inputscomplete(Request $request)
    {

        $retorno = new \stdClass();

        switch ($request->elemento) {

            case 'segurado':
                $segurado = Segurado::find(getDataReady($request->cpfcnpj));

                if ($segurado) {

                    ($request->tipo == 1 ? $retorno->segnome = nomeCase($segurado->clinomerazao) : $retorno->segrazao = nomeCase($segurado->clinomerazao));
                    ($request->tipo == 1 ? $retorno->segdatanasc = date('d/m/Y', strtotime($segurado->clidtnasc)) : $retorno->segdatafund = date('d/m/Y', strtotime($segurado->clidtnasc)));
                    ($request->tipo == 1 ? $retorno->segsexo = $segurado->clicdsexo : '');
                    ($request->tipo == 1 ? $retorno->segestadocivil = $segurado->clicdestadocivil : '');
                    ($request->tipo == 1 ? $retorno->segrg = $segurado->clinumrg : '');
                    ($request->tipo == 1 ? $retorno->segrgoe = $segurado->cliemissorrg : '');
                    ($request->tipo == 1 ? $retorno->segrguf = $segurado->clicdufemissaorg : '');
                    ($request->tipo == 1 ? (empty($segurado->clidtemissaorg) ? '' : $retorno->segrgdtemissao = date('d/m/Y', strtotime($segurado->clidtemissaorg))) : '');
                    ($request->tipo == 1 ? $retorno->segcdprofissao = $segurado->clicdprofiramoatividade : $retorno->segcdramoatividade = $segurado->clicdprofiramoatividade);
                    ($request->tipo == 1 ? $retorno->segprofissao = $segurado->profissao->nm_ocupacao : $retorno->segramoatividade = $segurado->ramosatividade->nome_atividade);
                    $retorno->segdddcel = $segurado->clidddcel;
                    $retorno->segnmcel = format('fone', $segurado->clinmcel);
                    $retorno->segdddfone = $segurado->clidddfone;
                    $retorno->segnmfone = format('fone', $segurado->clinmfone);
                    $retorno->segemail = $segurado->cliemail;
                    $retorno->segcep = format('cep', $segurado->clicep);
                    $retorno->segendlog = $segurado->clinmend;
                    $retorno->segnmend = $segurado->clinumero;
                    $retorno->segendcompl = $segurado->cliendcomplet;
                    $retorno->segendcidade = $segurado->clinmcidade;
                    $retorno->segenduf = $segurado->clicduf;
                    $retorno->status = true;

                } else {
                    $retorno->status = false;
                }
                break;

            case 'veiculo':
                $veiculo = Veiculos::where('veicplaca', 'ilike', '%' . $request->placa . '%')->first();
                return response()->json($veiculo);
                break;
            default:

                $retorno->status = false;
        }


        return response()->json($retorno);

    }
}
