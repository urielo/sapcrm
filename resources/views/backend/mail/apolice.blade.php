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
                    <h1> BEM VINDO!
                    </h1>
                    <p>
                        Estamos felizes por ter você conosco <br>
                        Agradecemos pela confiança em nós depositada <br>
                        Muito obrigado! <br>

                    </p>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12 email-box-2">

                    <p>
                        <span class="nome"> {{nomeCase($proposta->cotacao->segurado->clinomerazao)}}</span>,
                        segue em anexo a sua apólice de seguro!
                    </p>

                    <h3>
                        Em Caso de Roubo e Furto:
                    </h3>

                    <h1>
                        0800 77 25099 <br> (11) 2770-1601
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