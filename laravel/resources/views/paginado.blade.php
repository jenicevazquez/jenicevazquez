
<div class="row">

    <nav class="pull-right">
        @if($registros->lastPage()>1)
            <div class="input-group input-group-sm pull-right" style="width: 50px; margin-left: 15px">
                <span class="input-group-addon">Ir a pagina:</span>
                <input style="width: 50px" type="text" class="form-control jumpto" value="{!! $registros->currentPage() !!}">
            </div>
            <div class="input-group input-group-sm pull-right" style="width: 50px; margin-left: 15px">
                <span class="input-group-addon">Mostrando:</span>
                <input style="width: 50px" type="text" class="form-control showup" value="{!! $registros->perPage() !!}">
            </div>
            <ul class="pagination pull-right" style="margin:0 !important;">
                <li class="page-item">
                    <a class="page-link btnInicio" data-go="1" href="javascript:void(0)" >
                        <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="page-item btnAnterior">
                    <a class="page-link" href="javascript:void(0)" data-go="{!! $registros->currentPage()-1 !!}">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link disabled" href="javascript:void(0)">Pagina <span class="currentPage">{!! $registros->currentPage() !!}</span> de <span class="totalPages">{!! $registros->lastPage() !!}</span></a>
                </li>
                <li class="page-item btnSiguiente">
                    <a href="javascript:void(0)" class="page-link" data-go="{!! $registros->currentPage()+1 !!}">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="page-item btnUltimo">
                    <a class="page-link" href="javascript:void(0)" data-go="{!! $registros->lastPage() !!}" >
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        @endif
        <div class="navbar-header pull-right">
            <span class="navbar-brand" style="font-size: 12px">{!! $registros->total() !!} resultados</span>
        </div>
    </nav>

</div>
<style>
    span.navbar-brand{
        float: left;
        padding: 5px 15px;
        font-size: 14px;
        height: auto;
    }
</style>