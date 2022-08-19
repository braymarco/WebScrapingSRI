<?php

namespace App\Http\Controllers;

use App\Jobs\SriSyncJob;
use App\Models\Ruc;
use App\Models\Sync;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class MainController extends Controller
{
    public function main()
    {
        $filter = '';
        $query = '';
        $filters = [
            'razon_social'=>"Razón Social",
            'numero_ruc'=>"Número de Ruc",
            'descripcion_provincia'=>"Provincia",
            'descripcion_canton'=>"Cantón",
            'descripcion_parroquia'=>"Parroquia",
            'actividad_economica'=>"Actividad Económica"
        ];
        if ($this->request->has('query')) {
            $query = $this->request->get('query');
            if ($this->request->has('filter') && $this->request->filter!==null) {
                $filter = $this->request->filter;
                if (in_array($filter, array_keys($filters))) {
                    $rucs = Ruc::where($filter, 'like', "%{$query}%");
                } else {
                    return back()->withErrors(['error' => "Filtro inválido"]);
                }
            } else {
                $rucs = Ruc::where('razon_social', 'like', "%{$query}%")
                    ->orWhere('numero_ruc', 'like', "%{$query}%")
                    ->orWhere('descripcion_provincia', 'like', "%{$query}%")
                    ->orWhere('descripcion_canton', 'like', "%{$query}%")
                    ->orWhere('descripcion_parroquia', 'like', "%{$query}%")
                    ->orWhere('actividad_economica', 'like', "%{$query}%");
            }
            $rucs = $rucs->paginate(40);
        } else {
            $rucs = Ruc::paginate(40);
        }
        return view('main', [
            'rucs' => $rucs,
            'filter'=>$filter,
            'filters'=>$filters,
            'query'=>$query,
        ]);
    }

    public function syncPage()
    {
        $syncs = Sync::orderBy('id', 'DESC')->get();
        return view('sync', [
            'syncs' => $syncs
        ]);
    }

    public function sync()
    {
        $sync = Sync::create([]);
        $data = SriSyncJob::dispatch($sync->id);
        $job = $data;

        return back()->with(['msg' => "Sincronización iniciada"]);
    }


}
