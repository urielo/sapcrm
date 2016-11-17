<div class="col-md-12" data-target="#{{"produto-$produto->idproduto-$preco->idprecoproduto"}}" id="divp-{{$produto->idproduto}}-{{$preco->idprecoproduto}}">
    <div class="checkbox">
        <label>



            {!! Form::checkbox('produtos[]',$produto->idproduto, false ,[
                            'data-val-idproduto' => $produto->idproduto,
                            'data-val-tiposeguro' => $produto->tipodeseguro,
                            'data-val-tipoproduto' => $produto->tipoproduto,
                            'data-val-menorparc' => $preco->vlrminprimparc,
                            'data-val-vllmi'=>$preco->lmiproduto,
                            'data-val-vlproduto' => $preco->premioliquidoproduto,
                            'id'=> "produto-$produto->idproduto-$preco->idprecoproduto",
                            'data-target-preco'=>"#preco-$produto->idproduto-$preco->idprecoproduto",
                            'data-target-div'=>"#divp-$produto->idproduto-$preco->idprecoproduto",
                            'class'=>"class-produto",
                            'data-set'=> 0,
                            'href'=> ($produto->tipoproduto == 'master' ? route('produtosopcional') : '#' ),
            ])  !!}

            <strong>  {{ $produto->nomeproduto }}  {!! ($preco->lmiproduto > 0 ? "/ <samall>LMI: R$ ".format('real',$preco->lmiproduto)."</samall >": '')  !!}
                - R$
                <span id="preco-{{$produto->idproduto}}-{{$preco->idprecoproduto}}">
                    {!!  number_format($preco->premioliquidoproduto, 2, ',', '.') !!}
                </span>
            </strong>
        </label>
        <div>
            <a class="detalhe-toggle" href="#detalhe-produto-{{$produto->idproduto}}-{{$preco->idprecoproduto}}" id="span-"
               {{$produto->idproduto}}-{{$preco->idprecoproduto}} data-toggle="collapse">
                <small>Detalhes <span class="glyphicon glyphicon-triangle-right" data-change="glyphicon-triangle-bottom"
                                      aria-hidden="true"></span></small>
            </a>
            <div class="detalhe collapse alert alert-info"
                 id="detalhe-produto-{{$produto->idproduto}}-{{$preco->idprecoproduto}}">
                <p>
                    <b>Descrição: </b>{!! $produto->descproduto  !!}.
                    <br>
                    <b>Caracteristaca: </b> {!! $produto->caractproduto !!}.
                    <br>
                    <br>
                    <b>Exigencia Vistoria: </b>{!! ($produto->ind_exige_vistoria ? 'Sim' : 'Não') !!}
                    <b>Exigencia Rastreador: </b>{!!  ($produto->ind_exige_rastreador ? 'Sim' : 'Não') !!}
                </p>
            </div>
        </div>
    </div>
</div>