@foreach ($cotacoes as $cotacao)
    <tr class="row">
        <th><a href="#" class="">{{$cotacao->idcotacao}}</a></th>
        <th><a href="#" class=""> {{$cotacao->segurado->clicpfcnpj}}</a></th>
        <td>{!! date('d/m/Y', strtotime($cotacao->dtcreate)) !!}</td>
        <td>{!! date('d/m/Y', strtotime($cotacao->dtvalidade)) !!}</td>
        <td>{!! strtoupper($cotacao->usuario->nome) !!}</td>
        @if(Auth::user()->hasRole('admin'))
            <td>{{strtoupper(Auth::user()->corretor->corrnomerazao)}}</td>
        @endif

        <td>{{$cotacao->status->descricao}}</td>

        <td>
            <div class="btn-group btn-group-xs">
                <a class="btn btn-danger"
                   href="{{route('cotacao.pdf',$crypt::encrypt($cotacao->idcotacao))}}"
                   target="_blank">
                                    <span
                                            class="glyphicon glyphicon glyphicon-print"
                                            aria-hidden="true"></span> PDF

                </a>

                <a class="btn btn-success"
                   href="{{route('cotacao.reemitir',$crypt::encrypt($cotacao->idcotacao))}}"
                >
                                    <span
                                            class="glyphicon glyphicon glyphicon-edit"
                                            aria-hidden="true"></span> Reemitir

                </a>


                @if(!$cotacao->proposta && $cotacao->idstatus == 9)
                    <a class="btn btn-primary "
                       href="{{route('proposta.index',$crypt::encrypt($cotacao->idcotacao))}}">
                                    <span
                                            class="glyphicon glyphicon-expand" aria-hidden="true"></span>
                        Emitir proposta
                    </a>

                    <a type="button" class="btn btn-info btn-sm" data-toggle="modal"
                       data-target=".modal-show"
                       href="{{route('cotacao.showemail',$crypt::encrypt($cotacao->idcotacao))}}"
                       id="showinfo"><i class="glyphicon glyphicon-envelope"></i> Email
                    </a>

                @endif

            </div>


        </td>


    </tr>

@endforeach
