<!DOCTYPE html>
<html lang="en">
@section('htmlheader_title','Configuracion')
@section('htmlheader')
    @include('layouts.partials.htmlheader')
@show
@section('scripts')
    @include('layouts.partials.scripts')
@show
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    @include('layouts.partials.mainheader')
    @include('layouts.partials.sidebar')
    <div class="content-wrapper">
        <section class="content">

            <div class="col-xs-12" style="padding-top: 30px">
                <aside class="col-sm-2 col-xs-12">
                    <div class="list-group submenu-config">
                        <button type="button" class="list-group-item {{ (Request::is('config') ? 'selected' : '') }}"><a href="{{ url('config') }}"><i class='fa fa-cogs'></i> <span>General</span></a></button>
                        <button type="button" class="list-group-item {{ (Request::is('config/scaece') ? 'selected' : '') }}"><a href="{{ url('config/scaece') }}"><i class='fa fa-folder'></i> <span>SCAECE</span></a></button>
                        <button type="button" class="list-group-item {{ (Request::is('config/scaef') ? 'selected' : '') }}"><a href="{{ url('config/scaef') }}"><i class='fa fa-folder'></i> <span>SCAEF</span></a></button>
                    </div>
                </aside>
                <div class="col-sm-10 col-xs-12">
                    <div>
                        @yield('main-content')
                    </div>
                </div>
            </div>

        </section>
    </div>
    @include('layouts.partials.controlsidebar')
</div>
<style>
    .table-border-bottom{
        border-bottom: 1px solid #aaa;
        border-top: 1px solid #aaa;
    }
    .table-border-bottom > tr > td{
        border-bottom: 1px solid #ebedf0;
        border-top:none !important;
    }

    .box{
        box-shadow: none !important;
    }
    .sidebar-submenu li{
        border: none !important;
    }
    .sidebar-submenu{
        border-bottom: none !important;
        border-right:  1px solid #dadada;
        min-height: 50px;
        position: relative;
        word-wrap: break-word;
    }
    .fieldName{
        font-weight: bold;
        font-family: Helvetica, Arial, sans-serif;
    }
    .field{
        color:#90949c;
        font-family: Helvetica, Arial, sans-serif;
    }
    .box-title{
        padding: 6px 0 16px;
    }
    .fa-pencil-alt{
        color: #365899;
    }
    .caja{
        background: #f5f6f7;
        border-bottom: 1px solid #e9ebee;
        border-top: 1px solid #e9ebee;
        padding: 10px;
    }
    .correos{
        list-style: square;
    }
    .correos .email{
        color: #0c0c0c;
        margin-right: 3px;
    }
    .correosList{
        margin: 10px;
    }
    .submenu-config{
        border-radius: 3px;
    }
    .submenu-config button:hover{
        background: #F2F3F5;
    }
    .submenu-config button{
        width: 100%;
    }
    .submenu-config button a{
        color: #1d2129;
        display: block;
        text-align: left;
        font-size: 14px;
        line-height: 20px;
        opacity: .7;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-family: Helvetica, Arial, sans-serif;
    }
    .submenu-config button a i{
        margin-right: 8px;
    }
    .list-group-item.selected{
        background: white;
    }
    .list-group-item.selected a{
        font-weight: bold;
        color: #0c0c0c;
        opacity: 1;

    }
    .config-list{
        font-family: Helvetica, Arial, sans-serif !important;
    }
</style>
</body>
</html>
