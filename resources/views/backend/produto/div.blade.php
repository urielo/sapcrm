<div class="col-md-12" id="divp-{{$produto->idproduto}}-{{$preco->idprecoproduto}}">
    <div class="checkbox">
        <label>
            <input type="checkbox" name="produtos[]" value='{!!json_encode(['idproduto' => $produto->idproduto,'tiposeguro' => $produto->tipodeseguro, 'menorparc' => $preco->vlrminprimparc,'vllmi'=>$preco->lmiproduto, 'vlproduto' => $preco->premioliquidoproduto])!!}' id="produto-{{$produto->idproduto}}-{{$preco->idprecoproduto}}"> <strong>  {{ $produto->nomeproduto }}  {!! ($preco->lmiproduto > 0 ? "/ <samall>LMI: R$ ".format('real',$preco->lmiproduto)."</samall >": '')  !!}  - R$ <span id="preco-{{$produto->idproduto}}-{{$preco->idprecoproduto}}">{!!  number_format($preco->premioliquidoproduto, 2, ',', '.') !!} </span> </strong>
        </label>
        <div>
            <a href="#detalhe-produto-{{$produto->idproduto}}-{{$preco->idprecoproduto}}"  id="span-"{{$produto->idproduto}}-{{$preco->idprecoproduto}} data-toggle="collapse"><small>Detalhes <span class="glyphicon glyphicon-triangle-right" data-change="glyphicon-triangle-bottom" aria-hidden="true" ></span></small></a>
            <div class="detalhe collapse alert alert-info" id="detalhe-produto-{{$produto->idproduto}}-{{$preco->idprecoproduto}}">
                <p>
                    <b>Descrição: </b>{!! $produto->descproduto  !!}.
                    <br>
                    <b>Caracteristaca:  </b> {!! $produto->caractproduto !!}.
                    <br>
                    <br>
                    <b>Exigencia Vistoria:  </b>{!! ($produto->indexigenciavistoria ? 'Sim' : 'Não') !!}
                    <b>Exigencia Rastreador:  </b>{!!  ($preco->indobrigrastreador ? 'Sim' : 'Não') !!}
                </p>
            </div>
        </div>
    </div>
</div>