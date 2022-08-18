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
        $syncs = Sync::orderBy('id', 'DESC')->get();
        return view('main', [
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
