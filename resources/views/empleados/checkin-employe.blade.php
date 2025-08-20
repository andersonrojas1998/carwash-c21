@extends('layout.master')
@section('content')
<div class="card">
    <div class="card-header bg-light">
        <h4>Trabajadores presentes hoy</h4>
        <button class="btn btn-success float-right" data-toggle="modal" data-target="#mdl_checkin">Registrar llegada</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dt_checkin" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Hora de llegada</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($llegadas as $key => $llegada)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $llegada->empleado->name }}</td>
                        <td>{{ $llegada->hora_llegada }}</td>
                        <td>
                            <span class="badge badge-{{ $llegada->estado == 'activo' ? 'success' : 'danger' }}">{{ $llegada->estado }}</span>                            
                        </td>
                        <td>
                            <button class="btn btn-xs btn-primary  btn_toggle_estado" data-id="{{ $llegada->id }}" data-estado="{{ $llegada->estado == 'activo' ? 'ocupado' : 'activo' }}">
                                Cambiar a {{ $llegada->estado == 'activo' ? 'Ocupado' : 'Activo' }}
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para registrar llegada -->
<div class="modal fade" id="mdl_checkin" tabindex="-1" role="dialog" aria-labelledby="mdlCheckinLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form_checkin" method="POST" >
         {{ csrf_field() }}
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title">Registrar llegada de trabajador</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="id_empleado">Trabajador</label>
                <select id="id_empleado" name="id_empleado" class="form-control select2" required>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="hora_llegada">Hora de llegada</label>
                <input type="time" id="hora_llegada" name="hora_llegada" class="form-control" required value="{{ date('H:i') }}">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Registrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('custom-scripts')
<script src="{{ asset('/lib/teacher.js') }}"></script>
@endpush