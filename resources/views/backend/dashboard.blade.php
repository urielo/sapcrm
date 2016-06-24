@extends('layouts.backend')


@section('content')
<div class="col-md-3">
    <div class="container">
        <!--<div class="row">-->
        <div class="col-sm-4 col-md-3 sidebar" id="sidebar">
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="list-group">
                <span href="#" class="list-group-item active">
                    Submenu
                    <span class="pull-right" id="slide-submenu">
                        <i class="fa fa-times"></i>
                    </span>
                </span>
                <a href="#" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Lorem ipsum
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-search"></i> Lorem ipsum
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-user"></i> Lorem ipsum
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Lorem ipsum <span class="badge">14</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Lorem ipsumr <span class="badge">14</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-envelope"></i> Lorem ipsum
                </a>
            </div>        
        </div>

    </div>
</div>
<div class="col-md-9">
<h1>Simple Sidebar</h1>
<p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
</div>
@endsection

