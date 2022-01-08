<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Ready;
use Carbon\Carbon;
use Storage;

class ReadyController extends Controller
{
    public function download($token)
    {
        $ready = Ready::find(decrypt($token));
        $path = Storage::disk('local')->path($ready->path);

        $download = new Download();
        $download->set_id = $ready->set_id;
        $download->ip = request()->ip();
        $download->save();

        $filename = $ready->set->name . '-' . Carbon::now()->format('d-m-Y-h:i') . '.pdf';

        activity("downloads")
            ->performedOn($download)
            ->causedBy(request()->ip())
            ->event("downloaded")
            ->log("Downloaded " . $filename);


        return response()->download($path, $filename);
    }
}
