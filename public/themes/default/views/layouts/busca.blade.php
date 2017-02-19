@extends('layouts.backend')
@section('content')

    <div class="col-xs-12 col-sm-12 ">

        <div class="panel panel-@yield('panelcolor')  @yield('panel_class') black" style="margin-top: 10px;">
            <div class="panel-heading panel-heading-sm">
                <h2 class="panel-title" style="text-align: center;">@yield('heading')</h2>
            </div>

            <div class="scroll" style="height: 450px; overflow-x: auto;" id="body-panel">
                <div class="panel-body">

                    @include('layouts.alerts')
                    @yield('content_body')

                </div>

                @yield('table')
                @yield('footer')

            </div>
        </div>

    </div>
    @yield('modal')


@stop

@section('script')
    @yield('script')
@stop
