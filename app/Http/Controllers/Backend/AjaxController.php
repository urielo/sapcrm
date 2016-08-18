<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Fipes;
use App\Model\Combos;
use App\Model\Produtos;
use App\Model\PrecoProdutos;
use App\Model\CategoriaFipes;
use App\Model\FipeAnoValor;
use App\Model\Profissoes;
use App\Model\RamoAtividades;

class AjaxController extends Controller
{

    public function modelo(Request $request)
    {

        $like = $request->input('term');
        $fipe = Fipes::where('modelo', 'ilike', "%{$like}%")
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


        echo '<option selected value="0">Ano - Valor - Combus</option>';
        foreach ($anovalor as $value):


            echo '<option value=\'' . json_encode(['ano' => $value->ano, 'combus' => $value->idcombustivel, 'valor' => $value->valor]) . '\'>' . $value->ano . ' - ' . ($value->idcombustivel == 1 ? 'Gasolina' : ($value->idcombustivel == 2 ? 'Alcool' : 'Disel')) . ' - R$ ' . number_format($value->valor, 2, ',', '.') . '</option>';

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
        $idade = date('Y') - ($request->input('ano') > 1 ? $request->input('ano') : date('Y'));
        $tipo = $request->input('tipo');
        $categoria = CategoriaFipes::where('codefipe', '=', $cdfipe)
            ->where('idseguradora', '=', 2)
            ->get();
        $categoria = $categoria[0]->idcategoria;

//        echo '<pre>';
//        var_dump();
//        echo '</pre>';

        $retorno = [];
        $combos = [];

        foreach (Produtos::whereTipoproduto('master')->whereCodstatus('1')->orderBy('idproduto', 'ASC')->get() as $produto):
//            $roubo = $produto->idproduto == 1 ? TRUE : $produto->idproduto == 2 ? TRUE : $produto->idproduto == 19 ? TRUE : $produto->idproduto == 20 ? TRUE : FALSE;
//            $rcf = $produto->idproduto == 3 ? TRUE : $produto->idproduto == 13 ? TRUE : $produto->idproduto == 14 ? TRUE : FALSE;
//            $ass = $produto->idproduto == 12 ? TRUE : $produto->idproduto == 4 ? TRUE : $produto->idproduto == 15 ? TRUE : $produto->idproduto == 11 ? TRUE : FALSE;
            foreach (Combos::whereIdprodutomaster($produto->idproduto)->get() as $combo) {
                $combos['idproduto' . $combo->idprodutomaster][] = $combo->idprodutoopcional;
            }
            foreach (PrecoProdutos::where('idproduto', '=', $produto->idproduto)->get() as $preco):
                $retorno[] = ['produtos' => $produto];
                if ($tipo == $produto->idtipoveiculo):
                    if ($valor >= $preco->vlrfipeminimo && $valor <= $preco->vlrfipemaximo && $idade <= $preco->idadeaceitamax):

                        $retorno[] = [
                            'html' =>
                                '<div class="col-md-12" id="divp' . $produto->idproduto . '">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="produtos[]" value=\'' . json_encode(['idproduto' => $produto->idproduto, 'menorparc' => $preco->vlrminprimparc, 'vlproduto' => $preco->premioliquidoproduto]) . '\' id="porduto' . $produto->idproduto . '"> <strong>  ' . $produto->nomeproduto . ' - R$ <span id="preco' . $produto->idproduto . '">' . number_format($preco->premioliquidoproduto, 2, ',', '.') . '</span> </strong>
                    </label>
                    <div id="acordion' . $produto->idproduto . '">
                        <h6>Detalhes</h6>
                        <div>
                            <p>
                                <b>Descrição: </b>' . $produto->descproduto . '.
                                <br>
                                <b>Caracteristaca:  </b> ' . $preco->caractproduto . '.
                                <br>
                                <br>
                                <b>Exigencia Vistoria:  </b>' . ($produto->indexigenciavistoria ? 'Sim' : 'Não') . '
                                <b>Exigencia Rastreador:  </b>' . ($preco->indobrigrastreador ? 'Sim' : 'Não') . ' 
                            </p>
                        </div>
                    </div>
                </div>
            </div> ',
                            'acordion' => '#acordion' . $produto->idproduto,
                            'chkid' => '#porduto' . $produto->idproduto,
                            'precospan' => '#preco' . $produto->idproduto,
                            'divp' => '#divp' . $produto->idproduto,
                            'idproduto' => $produto->idproduto,


                        ];
                    endif;
                elseif ($preco->idcategoria == $categoria):
                    $retorno[] = [
                        'html' =>
                            '<div class="col-md-12" id="divp' . $produto->idproduto . '">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="produtos[]" value=\'' . json_encode(['idproduto' => $produto->idproduto, 'menorparc' => $preco->vlrminprimparc, 'vlproduto' => $preco->premioliquidoproduto]) . '\' id="porduto' . $produto->idproduto . '"> <strong>  ' . $produto->nomeproduto . ' - R$ <span id="preco' . $produto->idproduto . '">' . number_format($preco->premioliquidoproduto, 2, ',', '.') . '</span> </strong>
                    </label>
                    <div id="acordion' . $produto->idproduto . '">
                        <h6>Detalhes</h6>
                        <div>
                            <p>
                                <b>Descrição: </b>' . $produto->descproduto . '.
                                <br>
                                <b>Caracteristaca:  </b> ' . $preco->caractproduto . '.
                                <br>
                                <br>
                                <b>Exigencia Vistoria:  </b>' . ($produto->indexigenciavistoria ? 'Sim' : 'Não') . '
                                <b>Exigencia Rastreador:  </b>' . ($preco->indobrigrastreador ? 'Sim' : 'Não') . ' 
                            </p>
                        </div>
                    </div>
                </div>
            </div> ',
                        'acordion' => '#acordion' . $produto->idproduto,
                        'chkid' => '#porduto' . $produto->idproduto,
                        'precospan' => '#preco' . $produto->idproduto,
                        'divp' => '#divp' . $produto->idproduto,
                        'idproduto' => $produto->idproduto,


                    ];

                elseif ($tipo == $produto->idtipoveiculo):
                    if ($idade >= $preco->idadeaceitamin && $idade <= $preco->idadeaceitamax):
                        $retorno[] = [
                            'html' =>
                                '<div class="col-md-12" id="divp' . $produto->idproduto . '">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="produtos[]" value=\'' . json_encode(['idproduto' => $produto->idproduto, 'menorparc' => $preco->vlrminprimparc, 'vlproduto' => $preco->premioliquidoproduto]) . '\' id="porduto' . $produto->idproduto . '"> <strong>  ' . $produto->nomeproduto . ' - R$ <span id="preco' . $produto->idproduto . '">' . number_format($preco->premioliquidoproduto, 2, ',', '.') . '</span> </strong>
                    </label>
                    <div id="acordion' . $produto->idproduto . '">
                        <h6>Detalhes</h6>
                        <div>
                            <p>
                                <b>Descrição: </b>' . $produto->descproduto . '.
                                <br>
                                <b>Caracteristaca:  </b> ' . $preco->caractproduto . '.
                                <br>
                                <br>
                                <b>Exigencia Vistoria:  </b>' . ($produto->indexigenciavistoria ? 'Sim' : 'Não') . '
                                <b>Exigencia Rastreador:  </b>' . ($preco->indobrigrastreador ? 'Sim' : 'Não') . ' 
                            </p>
                        </div>
                    </div>
                </div>
            </div> ',
                            'acordion' => '#acordion' . $produto->idproduto,
                            'chkid' => '#porduto' . $produto->idproduto,
                            'precospan' => '#preco' . $produto->idproduto,
                            'divp' => '#divp' . $produto->idproduto,
                            'idproduto' => $produto->idproduto,


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
        $tipo = $request->input('tipo');
        $categoria = CategoriaFipes::where('codefipe', '=', $cdfipe)
            ->where('idseguradora', '=', 2)
            ->get();
        $categoria = $categoria[0]->idcategoria;


        $retorno = [];


        foreach (Combos::whereIdprodutomaster($idproduto)->get() as $combo):
            $produto = Produtos::find($combo->idprodutoopcional);

            foreach ($produto->precoproduto as $preco):
                $preco;
                #$retorno[] = ['produtos' => $produto];

                if ($valor >= $preco->vlrfipeminimo && $tipo == $produto->idtipoveiculo && $preco->idcategoria == ($preco->idcategoria == $categoria ? $categoria : null) && $valor <= $preco->vlrfipemaximo && $idade <= $preco->idadeaceitamax):

                    $retorno[] = [
                        'html' =>
                            '<div class="col-md-12" id="divp' . $produto->idproduto . '">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="produtos[]" value=\'' . json_encode(['idproduto' => $produto->idproduto, 'tiposeguro' => $produto->tipodeseguro, 'menorparc' => $preco->vlrminprimparc, 'vlproduto' => $preco->premioliquidoproduto]) . '\' id="porduto' . $produto->idproduto . '"> <strong>  ' . $produto->nomeproduto . ' - R$ <span id="preco' . $produto->idproduto . '">' . number_format($preco->premioliquidoproduto, 2, ',', '.') . '</span> </strong>
                    </label>
                    <div id="acordion' . $produto->idproduto . '">
                        <h6>Detalhes</h6>
                        <div>
                            <p>
                                <b>Descrição: </b>' . $produto->descproduto . '.
                                <br>
                                <b>Caracteristaca:  </b> ' . $preco->caractproduto . '.
                                <br>
                                <br>
                                <b>Exigencia Vistoria:  </b>' . ($produto->indexigenciavistoria ? 'Sim' : 'Não') . '
                                <b>Exigencia Rastreador:  </b>' . ($preco->indobrigrastreador ? 'Sim' : 'Não') . ' 
                            </p>
                        </div>
                    </div>
                </div>
            </div> ',
                        'acordion' => '#acordion' . $produto->idproduto,
                        'chkid' => '#porduto' . $produto->idproduto,
                        'precospan' => '#preco' . $produto->idproduto,
                        'idproduto' => $produto->idproduto,
                        'tiposeguro' => $produto->tipodeseguro,
                        'divp' => '#divp'.$produto->idproduto,


                    ];


                elseif ($tipo == $produto->idtipoveiculo && $preco->vlrfipeminimo == null && $preco->idcategoria == null && $idade >= $preco->idadeaceitamin && $idade <= $preco->idadeaceitamax):
                    $retorno[] = [
                        'html' =>
                            '<div class="col-md-12" id="divp' . $produto->idproduto . '">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="produtos[]" value=\'' . json_encode(['idproduto' => $produto->idproduto, 'tiposeguro' => $produto->tipodeseguro, 'menorparc' => $preco->vlrminprimparc, 'vlproduto' => $preco->premioliquidoproduto]) . '\' id="porduto' . $produto->idproduto . '"> <strong>  ' . $produto->nomeproduto . ' - R$ <span id="preco' . $produto->idproduto . '">' . number_format($preco->premioliquidoproduto, 2, ',', '.') . '</span> </strong>
                    </label>
                    <div id="acordion' . $produto->idproduto . '">
                        <h6>Detalhes</h6>
                        <div>
                            <p>
                                <b>Descrição: </b>' . $produto->descproduto . '.
                                <br>
                                <b>Caracteristaca:  </b> ' . $preco->caractproduto . '.
                                <br>
                                <br>
                                <b>Exigencia Vistoria:  </b>' . ($produto->indexigenciavistoria ? 'Sim' : 'Não') . '
                                <b>Exigencia Rastreador:  </b>' . ($preco->indobrigrastreador ? 'Sim' : 'Não') . ' 
                            </p>
                        </div>
                    </div>
                </div>
            </div> ',
                        'acordion' => '#acordion' . $produto->idproduto,
                        'chkid' => '#porduto' . $produto->idproduto,
                        'precospan' => '#preco' . $produto->idproduto,
                        'idproduto' => $produto->idproduto,
                        'tiposeguro' => $produto->tipodeseguro,
                        'divp' => '#divp'.$produto->idproduto,


                    ];

                endif;


            endforeach;
        endforeach;

        return response()->json($retorno);
    }
}
