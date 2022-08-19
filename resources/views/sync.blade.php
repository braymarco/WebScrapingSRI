<!doctype html>
<html lang="en">
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
        <div class="text-center">
            <h5>Sincronización SRI</h5>
        </div>
        @include('commons.errors')
        @include('commons.success')
        <div>
            <form action="{{route('sri_sync')}}" method="POST">
                @csrf
                <button class="btn btn-success">Sincronizar</button>
            </form>
        </div>
        <div>

            <table class="table">
                <tr>
                    <th>Estado</th>
                    <th>Mensaje</th>
                    <th>Porcentaje</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Actualización</th>
                </tr>
                @foreach($syncs as $sync)
                    <tr class="bg-{{$sync->statusColor()}}">
                        <td>{{\App\Enums\SyncStatus::$MESSAGES[$sync->status]}}</td>
                        <td>{{$sync->msg}}</td>
                        <td>
                            <div class="progress-bar" role="progressbar" aria-label="Example with label"
                                 style="width: {{$sync->percent}}%;" aria-valuenow="{{$sync->percent}}" aria-valuemin="0" aria-valuemax="100">{{$sync->percent}}%
                            </div>
                        </td>
                        <td>{{$sync->created_at}}</td>
                        <td>{{$sync->updated_at}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>
