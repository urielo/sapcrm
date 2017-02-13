<div class="table-responsive apolice">
    <table class="table table-hover table-condensed table-datatable">
        <thead>
        <tr>
            <th>Segurado</th>
            <th>CPF/CNPJ</th>
            <th>Email</th>

            <th></th>

        </tr>
        </thead>
        <tbody>

        @foreach ($segurados as $segurado)
            <tr>
                <td><a href="{{route('segurado.edit', $segurado->clicpfcnpj)}}" class=""></a>{{$segurado->clinomerazao}}
                </td>
                <td>{{$segurado->clicpfcnpj}}</td>
                <td>{{$segurado->cliemail}}</td>
                <td>
                    <div class="btn-group" role="group">

                        <button type="button" class="btn btn-primary btn-xs modal-call" data-toggle="modal"
                                data-target=".modal-show"
                                data-url="{{route('segurado.edit',$crypt::encrypt($segurado->id))}}"
                                id="editar">Editar
                        </button>


                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>



