<div class="col-md-12 col-xs-12 col-sm-12 ">
    <div class="panel panel-success" style="margin-top: 10px;">
        <div class="panel-heading">
            <h2 class="panel-title">Sucesso</h2>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" id="mensagem">
                    <h3 style="text-align: center;">

                    {{$message}} - PROPOSTA Nº: {{$idproposta}}
                    </h3>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12" style="align-items: center;">
                    <center>
                        <div class="btn-group">
                            <a href="{{route('cotacao.cotar')}}">
                                <button type="button" class="btn btn-success">NOVA PROPOSTA</button>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('cotacao.pdf',$idproposta)}}" target="_blank">
                                <button type="button" class="btn btn-danger">PDF</button>
                            </a>
                        </div>
                       @role('diretor')
                        <div class="btn-group">
                            <a href="#">
                                <button type="button" href="#" class="btn btn-info">ENVIAR VIA EMAIL</button>
                            </a>
                        </div>
                        @endrole
                    </center>

                </div>
            </div>

        </div>
    </div>


</div>

