<?php

namespace App\Jobs;

use App\Enums\SyncStatus;
use App\Models\Ruc;
use App\Models\Sync;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class SriSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $syncId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($syncId = null)
    {
        if ($syncId == null) {
            $sync = Sync::create([]);
            $syncId = $sync->id;
        }

        $this->syncId = $syncId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sync = Sync::find($this->syncId);

        if ($sync == null)
            return;
        $sync->msg = "Buscando links";
        $sync->percent = 1;
        $sync->save();

        //se obtiene el código html de la página del SRI donde se encuentran los links de los archivos a descargar
        $client = new Client();
        try {
            $res = $client->request('GET', 'https://www.sri.gob.ec/RUC');
        } catch (GuzzleException $e) {
            $sync->msg = "Error al conectarse al sitio. {$sync->percent}%: " . $e->getMessage();
            $sync->status = SyncStatus::$ERROR;
            $sync->save();
            return;
        }
        $body = $res->getBody();
        /*mediante una expresión regular se obtiene los links de descarga que contienen el csv con los datos de los rucs
        organizados por provincias*/
        preg_match_all('/https:\/\/www.sri.gob.ec\/o\/sri-portlet-biblioteca-alfresco-internet(.*)zip/', $body, $links);
        $links = $links[0];
        //ser verifica que se haya encontrado el número de archivos necesarios
        if (count($links) < 24) {
            $sync->msg = "Se encontraron " . count($links) . " provincias. ";
            $sync->status = SyncStatus::$ERROR;
            $sync->save();
            return;
        }


        $sync->msg = "Links Encontrados";
        $sync->percent = 5;
        $sync->save();

        //se actualizará el porcentaje de avance de acuerdo a los archivos descargados y almacenados
        $percentByFile = floor(95 / count($links));
        foreach ($links as $link) {
            $filename = pathinfo($link, PATHINFO_FILENAME);
            $sync->msg = "Descargando " . $filename;
            $sync->percent += $percentByFile;
            $sync->save();
            if (!Storage::exists('sri'))
                Storage::makeDirectory('sri');
            try {
                //descarga el archivo zip
                $client->request('GET', $link, [
                    'sink' => Storage::path('sri/' . $filename . '.zip')
                ]);
                $sync->msg = "Almacenando datos: " . $filename;
                //abre el archivo zip para obtener los datos del csv
                if (($gestor = fopen('zip://' . Storage::path('sri/' . $filename . '.zip') . '#' . $filename . '.txt', "r")) !== FALSE) {
                    $init = true;
                    $header = [];
                    //almacena los rucs
                    while (($datos = fgetcsv($gestor, 1000, "\t")) !== FALSE) {
                        if (count($datos) > 1) {
                            $datos = array_map('utf8_encode', $datos);
                            if ($init) {
                                $init = false;
                                $header = array_map("strtolower", $datos);
                            } else {
                                $datos = array_combine($header, $datos);
                                //$actividadComercial = $datos[18];
                                Ruc::create($datos);
                            }
                        }
                    }
                    fclose($gestor);
                }
            } catch (GuzzleException $e) {
                $sync->msg = "Error {$sync->percent}%: " . $e->getMessage();
                $sync->save();
                return;
            }
        }
        $sync->msg = "Descarga Completada";
        $sync->status = SyncStatus::$COMPLETE;
        $sync->percent = 100;
        $sync->save();

    }
}
