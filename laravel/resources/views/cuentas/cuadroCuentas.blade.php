@foreach($registros as $registro)
    @php($porcentaje = ($registro->deuda*100)/$registro->limite)
    <div class="col-lg-3 col-12" onclick="openCuenta(this)" data-id="{!! $registro->id !!}" data-nombre="{!! $registro->nombre !!}">
        <div class="info-box {!! $porcentaje>35? ($porcentaje>80? "bg-danger":"bg-warning"):"bg-success" !!} ">
            <span class="info-box-icon">
                    <img src="/img/{!! $registro->nombre !!}.jpg" alt="">
                </span>
            <div class="info-box-content">
                <span class="info-box-text">{!! $registro->nombre !!}</span>
                <span class="info-box-number">{!! number_format($registro->saldo,2) !!}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: {!! $porcentaje !!}%"></div>
                </div>
                <span class="progress-description">
                  {!! number_format($registro->deuda,2) !!} Deuda
                </span>
            </div>
        </div>
    </div>
@endforeach