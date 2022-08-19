<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SRI Sync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>

<div class="container">
    @include('commons.menu')
    <div class="pt-2">
        @include('commons.errors')
        @include('commons.success')
        <form action="{{route('main')}}">
            <div class="row">
                <div class="col-md-3 col-4">
                    <input value="{{$query}}" name="query" type="text" class="form-control" placeholder="Buscar">
                </div>
                <div class="col-md-3 col-4">
                    <select class="form-select" aria-label="Default select example" name="filter">
                        <option @if(strlen($filter)==0) value="" selected @endif>Filtro</option>
                        @foreach($filters as $key=>$name)
                            <option @if($filter==$key) selected @endif value="{{$key}}">{{$name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-success">
                        Buscar
                    </button>
                </div>
            </div>
        </form>
        <div >
            <div class="table-responsive">

                <table class="table">
                    <tr>
                        <th>numero_ruc</th>
                        <th>razon_social</th>
                        <th>nombre_comercial</th>
                        <th>estado_contribuyente</th>
                        <th>clase_contribuyente</th>
                        <th>fecha_inicio_actividades</th>
                        <th>fecha_actualizacion</th>
                        <th>fecha_suspension_definitiva</th>
                        <th>fecha_reinicio_actividades</th>
                        <th>obligado</th>
                        <th>tipo_contribuyente</th>
                        <th>numero_establecimiento</th>
                        <th>nombre_fantasia_comercial</th>
                        <th>estado_establecimiento</th>
                        <th>descripcion_provincia</th>
                        <th>descripcion_canton</th>
                        <th>descripcion_parroquia</th>
                        <th>codigo_ciiu</th>
                        <th>actividad_economica</th>
                        <th>sistemas</th>
                    </tr>
                    @foreach($rucs as $ruc)
                        <tr>
                            <td>{{$ruc->numero_ruc}}</td>
                            <td>{{$ruc->razon_social}}</td>
                            <td>{{$ruc->nombre_comercial}}</td>
                            <td>{{$ruc->estado_contribuyente}}</td>
                            <td>{{$ruc->clase_contribuyente}}</td>
                            <td>{{$ruc->fecha_inicio_actividades}}</td>
                            <td>{{$ruc->fecha_actualizacion}}</td>
                            <td>{{$ruc->fecha_suspension_definitiva}}</td>
                            <td>{{$ruc->fecha_reinicio_actividades}}</td>
                            <td>{{$ruc->obligado}}</td>
                            <td>{{$ruc->tipo_contribuyente}}</td>
                            <td>{{$ruc->numero_establecimiento}}</td>
                            <td>{{$ruc->nombre_fantasia_comercial}}</td>
                            <td>{{$ruc->estado_establecimiento}}</td>
                            <td>{{$ruc->descripcion_provincia}}</td>
                            <td>{{$ruc->descripcion_canton}}</td>
                            <td>{{$ruc->descripcion_parroquia}}</td>
                            <td>{{$ruc->codigo_ciiu}}</td>
                            <td>{{$ruc->actividad_economica}}</td>
                            <td>{{$ruc->sistemas}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="pt-3 text-center">
                {{ $rucs->links() }}


            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>
