@extends('layouts.backend')



@section('content')

    <div class="col-md-10 col-md-offset-1 home-content">


        <div class="row">
            <div class="col-md-12">


                <h1>{{$textos::where('type','h1')->first()->title}}</h1>


                <div class="panel panel-info">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-info">
                                    <div class="panel-body subtitle">
                                        <p>{{$textos::where('type','p')->first()->text}}</p>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="row">
                        @foreach($textos::where('type','li')->where('status_id',1)->orderBy('order_li','asc')->orderBy('updated_at','desc')->limit(5)->get() as $li)
                        <div class="col-md-12">
                            <li>
                                <h2>{{$li->title}}</h2>
                                <p>{!!  html_entity_decode($li->text)   !!}</p>
                            </li>
                        </div>



                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

