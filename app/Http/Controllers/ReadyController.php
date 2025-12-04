<?php

namespace App\Http\Controllers;

use App\Models\{Download, Ready};
use Exception;
use Storage;
use Carbon\Carbon;
use Hashids\Hashids;

class ReadyController extends Controller
{
    public function download($token)
    {
        try {
            $id = Hashids::decode($token)[0] ?? null;
            if ($id == null) {
                abort(400, 'Invalid download token');
            }
        } catch (Exception $e) {
            abort(400, 'Invalid download token');
        }
        $ready = Ready::findOrFail($id);
        $path = Storage::disk('local')->path($ready->path);

        $download = new Download();
        $download->set_id = $ready->set_id;
        $download->ip = request()->ip();
        $download->save();

        $filename = $ready->set->name . '-' . Carbon::now()->format('d-m-Y-h:i') . '.pdf';

        activity('downloads')
            ->performedOn($download)
            // ->causedBy(request()->ip())
            ->event('downloaded')
            ->log('Downloaded ' . $filename);

        return response()->download($path, $filename);
    }
}
