<div class="table-responsive apolice">
    <table class="table table-hover table-condensed table-datatable">
        <thead>
        <tr>
            <th># Cotação</th>
            <th>CPF/CNPJ</th>
            <th >Veiculo</th>
            <th>Emissão</th>
            <th>Usuário</th>
            @if(Auth::user()->hasRole('admin'))
                <th>Corretor(a)</th>
            @endif
            <th>Status</th>
            <th></th>

        </tr>
        </thead>
        <tbody>
        @foreach ($cotacoes as $cotacao)
            <tr>
                <th><a href="#" class="">{{$cotacao->idcotacao}}</a></th>
                <th><a href="#" class=""> {{format('cpfcnpj',$cotacao->segurado->clicpfcnpj)}}</a></th>
                <td style="font-size: 12px; width: 15%;">  {!! $cotacao->fipe->marca !!} - {{$cotacao->fipe->modelo}}</td>
                <td>{!! date('d/m/Y', strtotime($cotacao->dtcreate)) !!}</td>
                <td style="font-size: 12px; width: 10%;">{!!   strtoupper($cotacao->usuario->nome) !!}</td>
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
                                Proposta
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
        </tbody>
    </table>
</div>
