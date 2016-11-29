@extends('layouts.backend')

@section('content')




    <div class="col-xs-12 col-sm-12 ">


        <div class="panel panel-@yield('panelcolor') black" style="margin-top: 10px;">
            <div class="panel-heading panel-heading-sm">
                <h2 class="panel-title" style="text-align: center;">@yield('heading')</h2>
            </div>
            {{--<h2 class="title-s" >@yield('heading')</h2>--}}

            <div class="scroll" style="height: 450px; overflow-x: auto;" id="body-panel">
                <div class="panel-body">


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




                    @yield('contentSeg')


                </div>

                @yield('footer')


            </div>
        </div>

        <div class="horizont-center">
            @yield('pagination')
        </div>


    </div>


@stop

@section('script')
    @yield('script')
@stop
