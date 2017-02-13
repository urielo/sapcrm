{!!Form::open([ 'method' => 'post', 'route' => ['veiculo.update_']  ]) !!}
<div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" style="text-align: center;">Editar Veiculo
        <h4>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row" id="veiculo-row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        {{Form::hidden('id',$veiculo->veicid)}}

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row info-veiculo">

                                    <div class="col-md-4">
                                        <strong>Marca: </strong> {{$veiculo->fipe->marca}}

                                    </div>

                                    <div class="col-md-8">
                                        <strong>Modelo: </strong> {{$veiculo->fipe->modelo}}

                                    </div>
                                    <div class="col-md-3">
                                        <strong>Fipe: </strong> {{$veiculo->veiccodfipe}}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Valor: </strong>
                                        R$ {{format('real',$veiculo->fipe->anovalor()->where('idcombustivel',$veiculo->veictipocombus)->where('ano',$veiculo->veicano)->first()->valor)}}
                                    </div>

                                    <div class="col-md-2">
                                        <strong>Ano: </strong> {{$veiculo->veicano}}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Combustivel: </strong> {{$veiculo->combustivel->nm_comb}}
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3">
                                <label class="label label-default" for="placa">Placa</label>
                                <div class="input-group input-group-sm ">
                                    <input class="form-control form-control-sm placa" type="text"
                                           data-target-chassi="#chassi"
                                           data-target-renavan="#renavan"
                                           data-target-municipio="#munplaca"
                                           data-target-uf="#placauf"
                                           data-target-anorenav="#anorenav"
                                           data-target-cor="#veiccor"
                                           placeholder="AAA-9999"
                                           name="placa" id="placa" value="{{old('placa') ? old('placa') : $veiculo->veicplaca}}"/>
                                                        {{--<span class="input-group-btn">--}}
                                                             {{--<button class="btn btn-primary btn-sm" data-target="#placa"--}}
                                                                     {{--href="{{route('veiculo.search')}}" type="button"--}}
                                                                     {{--id="search-placa">--}}
                                                                 {{--<span class="glyphicon glyphicon-search"></span>--}}
                                                             {{--</button>--}}
                                                        {{--</span>--}}
                                </div>
                            </div>

                            <div class="col-md-5  ">
                                <div class="form-group form-group-sm">
                                    <label class="label label-default"
                                           for="munplaca">Município </label>
                                    <input class="form-control form-control-sm" type="text"
                                           name="munplaca" id="munplaca" value="{{old('munplaca') ? old('munplaca') : $veiculo->veicmunicplaca}}"/>
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <div class="form-group form-group-sm">

                                    {!! Form::label('placa_uf','UF',['class'=>'label label-default']) !!}
                                    {!! Form::select('placa_uf',
                                    $ufs,
                                    old('placa_uf') ? old('placa_uf') : $veiculo->veiccdufplaca ? $veiculo->veiccdufplaca:1,
                                    ['class'=>'selectpicker form-control form-control-sm',
                                    'data-live-search'=>'true',
                                    'data-style'=>'btn-secondary btn-sm',
                                    'id'=>'placa_uf']) !!}

                                </div>
                            </div>
                            <div class="col-md-2  ">
                                <div class="form-group form-group-sm">
                                    <label for="anof" class="label label-default">Fabricação</label>


                                    <select name="anof" id="anof"
                                            class="form-control form-control-sm" value="{{old('anof')}}">

                                        @if($veiculo->veicano == 0)

                                            <option value="{{date('Y')}}">{{date('Y')}}</option>

                                        @else
                                            @for($i = $veiculo->veicano; $i >= $veiculo->veicano - 1; $i--)
                                                @if(old('anof') == $i || $veiculo->veianofab == $i )
                                                    <option value="{{$i}}" selected>{{$i}}</option>

                                                @else
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endif

                                            @endfor
                                        @endif


                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3  ">
                                <div class="form-group form-group-sm">
                                    <label class="label label-default" for="renavan">Renavan</label>
                                    <input class="form-control form-control-sm" type="text"
                                           tipoinput="renavan" stats="1" name="renavan"
                                           id="renavan" value="{{old('renavan') ? old('renavan') : $veiculo->veicrenavam}}"/>
                                </div>
                            </div>
                            <div class="col-md-2  ">
                                <div class="form-group form-group-sm">
                                    <label class="label label-default" for="anorenav">Ano Renavan</label>
                                    <select name="anorenav" id="anorenav"
                                            class="form-control form-control-sm">
                                        @for($i = ($veiculo->veicano == 0 ? date('Y') :$veiculo->veicano); $i <= date('Y'); $i++)
                                            @if(old('anorenav') == $i || $veiculo->veicanorenavam == $i)
                                                <option value="{{$i}}" selected>{{$i}}</option>

                                            @else
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4  ">
                                <div class="form-group form-group-sm">
                                    <label class="label label-default" for="chassi">Chassi </label>
                                    <input class="form-control form-control-sm" stats="1"
                                           tipoinput="chassi" type="text"
                                           name="chassi" id="chassi" value="{{old('chassi') ? old('chassi') : $veiculo->veicchassi }}"/>
                                </div>
                            </div>
                            <div class="col-md-3  ">
                                <div class="form-group form-group-sm">
                                    <label class="label label-default" for="veiccor">Cor</label>
                                    <input class="form-control form-control-sm" type="veiccor"
                                           name="veiccor" id="veiccor" value="{{old('veiccor') ? old('veiccor'): $veiculo->veicor }}"/>
                                </div>
                            </div>

                            <div class="col-md-3 ">
                                <div class="form-group form-group-sm">
                                    <label class="label label-default" for="veicultilizacao">Ultilização</label>
                                    <select name="veicultilizacao" id="veicultilizacao"
                                            class="form-control form-control-sm">
                                        @foreach($tipoultiveics::orderBy('idutilveiculo', 'ASC')->get() as $tipoulti)
                                            <option value="{{$tipoulti->idutilveiculo}}" {{old('veicultilizacao') == $tipoulti->idutilveiculo || $veiculo->veiccdutilizaco == $tipoulti->idutilveiculo ? 'selected':''}}
                                            >{{$tipoulti->descutilveiculo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group form-group-sm">
                                    <label class="label label-default" for="indcahssiremarc">Chassi
                                        Remarcado?</label>
                                    <select name="indcahssiremarc" id="indcahssiremarc"
                                            class="form-control form-control-sm">
                                        <option value="0">Não</option>
                                        <option value="1">Sim</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group form-group-sm">
                                    <label class="label label-default" for="indleilao">Comprado em Leilão? </label>
                                    <select name="indleilao" id="indleilao"
                                            class="form-control form-control-sm">
                                        <option value="0">Não</option>
                                        <option value="1">Sim</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-danger">Salvar</button>
</div>
{!!Form::close()!!}
