@extends('layouts.emails')

@section('title','Email Seguro-AUTOPRATICO')

@section('content')
    <div class="row email-body">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-12 email-header">

                    <a href="www.seguroautopratico.com.br"><img title="SeguroAUTOPRATICO" src="{{theme('images/logo.png')}}" alt="Seguro AUTOPRATICO"></a>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12 email-box-1">
                    <h1> Agradecemos a sua confiança!
                    </h1>
                    <p>
                        Aguardamos a confirmação da sua proposta <br>
                        E nos colocamos a disposição para quaisquer esclarecimentos<br>
                        Muito obrigado! <br>

                    </p>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12 email-box-2">

                    <p>
                       Segue em anexo a sua cotação de seguro!
                    </p>

                    <h3>
                       Essa cotação tem validade até:
                    </h3>

                    <h1>
                        {{date('d/m/Y', strtotime($cotacao->dtvalidade))}}
                    </h1>

                </div>
            </div>


        </div>
    </div>

    <footer>
        <div class="row">
            <div class="col-md-8 col-md-offset-2 email-footer">
                <span> &copy; SeguroAUTOPRATICO {{date('Y')}}</span>
            </div>
        </div>
    </footer>
@stop