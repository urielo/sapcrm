<div class="table-responsive apolice">
    <table class="table table-hover table-condensed table-datatable">
        <thead>
        <tr>
            <th>#ID</th>
            <th>Placa</th>
            <th>Fipe</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Ano</th>
            <th>Status</th>
            <th></th>

        </tr>
        </thead>
        <tbody>

        @foreach ($veiculos as $veiculo)
            <tr>
                <td><a href="#" data-toggle="modal" data-target=".modal-show" data-url="{{route('veiculo.edit', $crypt::encrypt($veiculo->veicid))}}" class="modal-call"></a>{{$veiculo->veicid}}</td>
                <td>{{format('placa',$veiculo->veicplaca)}}</td>
                <td>{{$veiculo->fipe->codefipe}}</td>
                <td>{{$veiculo->fipe->marca}}</td>
                <td>{{$veiculo->fipe->modelo}}</td>
                <td>{{$veiculo->veicano}}</td>
                <td>{{$veiculo->status->descricao}}</td>
                <td><div class="btn-group" role="group">

                        <button type="button" class="btn btn-primary btn-xs modal-call" data-toggle="modal"
                                data-target=".modal-show"
                                data-url="{{route('veiculo.edit',$crypt::encrypt($veiculo->veicid))}}"
                                id="editar">Editar
                        </button>


                    </div></td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>