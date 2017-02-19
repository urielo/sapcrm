<div class="alert alert-danger hide" id="diverror">
    <strong>Erro: </strong>
    <div id="messageerror">
    </div>
</div>

@if(Session::has('sucesso'))
    <div class="alert alert-info" id="sucesso">
        <button type="button" class="close" aria-label="Close" id="fechasecesso">
            <span aria-hidden="true">&times;</span>
        </button>
        {!! Session::get('sucesso')!!}
    </div>
@elseif($errors->any())
    <div class="alert alert-danger" id="sucesso">
        <button type="button" class="close" aria-label="Close" id="fechasecesso">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@elseif(Session::has('error'))
    <div class="alert alert-danger" id="sucesso">
        <button type="button" class="close" aria-label="Close" id="fechasecesso">
            <span aria-hidden="true">&times;</span>
        </button>
        {!! Session::get('error') !!}
    </div>
@elseif(Session::has('atencao'))
    <div class="alert alert-warning" id="sucesso">
        <button type="button" class="close" aria-label="Close" id="fechasecesso">
            <span aria-hidden="true">&times;</span>
        </button>
        {!! Session::get('atencao')!!}
    </div>
@endif