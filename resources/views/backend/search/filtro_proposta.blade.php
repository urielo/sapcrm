<div class="row">
    <div class="col-md-6 col-lg-offset-3">
        <div class="input-group input-group-sm">
    <span class="input-group-btn">
        <select id="tipo-consulta"
                class=" tipo-consulta selectpicker form-control" data-target="#input-pesquisa"
                data-style='btn-default btn-sm'>
            <option value="placa">Placa</option>
            <option value="cpfcnpj">CPF/CNPJ</option>
            <option value="nome">Nome</option>
        </select>
    </span>
            <input class="form-control input-consulta placa" type="text" placeholder="AAA-0000" id="input-pesquisa"
                   name="pesquisa_value">
    <span class="input-group-btn btn-up">
        <button class="btn btn-xs btn-default buscar" type="button"
                data-tipo-consulta="#tipo-consulta"
                data-input-pesquisa="#input-pesquisa"
                data-target="#result"
                data-url="{{route('busca.result','proposta')}}">
            <i class="glyphicon glyphicon-search"></i></button>
    </span>
        </div>
    </div>
</div>
