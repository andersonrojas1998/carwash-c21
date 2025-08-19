@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between bd-highlight mb-3">
            <div class="d-flex justify-content-start bd-highlight">
                <div class="p-4 bg-light">
                    <h4>REGISTRO DE VENTAS</h4>
                </div>
            </div>
            <div class="d-flex justify-content-end bd-highlight">
                <div class="pr-3 pt-3" title="Registrar venta" data-toggle="tooltip">
                    <a href="{{route('venta.create')}}" class="text-body">
                        <span class="mdi mdi-car-wash mdi-36px"></span>
                    </a>
                </div>
                <!--<div class="pr-3 pt-3" title="Registrar venta de la tienda" data-toggle="tooltip">
                    <a href="{{route('venta.create-market')}}" class="text-body">
                        <span class="mdi mdi-shopping mdi-36px"></span>
                    </a>
                </div>-->
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm" id="table-sell">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Placa</th>
                        <th># Telefono</th>
                        <th>Tipo vehiculo</th>
                        <th>Atendido por</th>
                        <th>Valor Total.</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)

                    <tr>
                        <th>{{$venta->id}}</th>
                        <td>{{date('Y-m-d h:i',strtotime($venta->fecha) )}}</td>
                        <th class="text-primary">{{$venta->cliente->nombre}}</th>
                        <th>
                            @if($venta->placa)
                                <div class="bg-warning py-2 px-1 text-center border border-dark rounded">
                                    {{$venta->placa}}
                                </div>
                            @else
                                Sin registro
                            @endif
                        </th>
                        <td>
                            @if($venta->cliente->telefono)
                                {{$venta->cliente->telefono}}
                            @else
                                Sin registro
                            @endif
                        </td>
                        <td>
                            @if($venta->detalle_paquete != null)
                                {{$venta->detalle_paquete->tipo_vehiculo->descripcion}}
                            @else
                                No aplica
                            @endif
                        </td>
                        <td>
                            @if($venta->user->identificacion=="000")
                            <label class="badge  badge-xs text-black badge-warning">{{$venta->user->name}}</label>
                            @else
                            {{$venta->user->name}}
                            @endif
                        </td>
                        <th class="text-danger">$ {{ number_format($venta->total_venta,0,',','.')}}</th>
                        <td>
                            @php $color="danger"; 
                            if($venta->estado_venta->id==1) 
                                $color="primary"; 
                             else $color="success";
                            @endphp
                        <label class="badge  badge-lg text-white badge-{{$color}}">{{$venta->estado_venta->nombre  }}</label>
                        </td>
                        <td>
                        @if($venta->estado_venta->id<>2 &&  $venta->estado_venta->id<>3)
                            <a id="btn_show_change_user" data-venta="{{ $venta->id }}" data-id="{{ $venta->user->id }}" title="Cambio de Prestador" data-toggle="modal" data-target="#modal_edit_user_service"    data-toggle="tooltip">
                                <i class="mdi mdi-account-convert text-primary mdi-24px"></i>
                            </a>
                            <a href="{{route('venta.edit',[$venta->id])}}" data-venta="{{ $venta->id }}" data-id="{{ $venta->user->id }}" title="Editar Venta"   data-toggle="tooltip">
                                <i class="mdi mdi-pencil-box-outline text-primary mdi-24px"></i>
                            </a>
                        @endif                           
                            <a href="{{route('venta.show',[$venta->id])}}" title="Ver detalle" data-toggle="tooltip">
                                <i class="mdi mdi-point-of-sale text-warning mdi-24px"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('venta.mdl_changeUser')

    @if(session('success'))
        <input type="hidden" id="succes_message" value="{{session('success')}}">
    @endif

    @if(session('fail'))
        <input type="hidden" id="fail_message" value="{{session('fail')}}">
    @endif
</div>




@endsection
@push('custom-scripts')
    {{-- {!! Html::script('js/validate.min.js') !!} --}}
    {{-- {!! Html::script('js/validator.messages.js') !!} --}}
    {!! Html::script('lib/sell.js') !!}
@endpush