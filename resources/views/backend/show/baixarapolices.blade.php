<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Apolices</h4>
    <div class="row">
        <div class="col-md-4">
            <b>Proposta:</b> {{$proposta->idproposta}}
        </div>
        <div class="col-md-8"><b>Corretor(a): </b>{{nomeCase($proposta->cotacao->corretor->corrnomerazao)}}</div>
        <div class="col-md-8"><b>Segurado(a): </b>{{nomeCase($proposta->cotacao->segurado->clinomerazao)}}</div>
    </div>


</div>


<div class="modal-body">


    @if($proposta->has('certificado'))

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    {!!Form::open([ 'method' => 'post', 'route' => ['apolices.download']  ]) !!}
                    {!! Form::hidden('filename','Certificado_'.$proposta->idproposta) !!}
                    {!! Form::hidden('base64',$proposta->certificado->pdf_base64) !!}

                    <button type="submit" class="btn btn-danger btn-sm" target="_blank">Baixar
                    </button>

                    {!!Form::close()!!}

                </div>
            </div>
        </div>
    @endif

</div>

{{--<div class="modal-footer">--}}

{{--<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>--}}
{{--<button type="submit" class="btn btn-success">Emitir</button>--}}

{{--</div>--}}

