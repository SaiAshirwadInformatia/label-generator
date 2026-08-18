<?php

namespace App\Jobs;

use App\Mail\PDFReadyMail;
use App\Models\Ready;
use App\Models\Set;
use App\Services\PDFGeneratorService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GeneratePDFJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Set $set)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
   public function handle()
{
    $service = app(PDFGeneratorService::class);
    $disk = Storage::disk('public');

$directory = now()->format('Y/m') . '/' .
    str($this->set->label->name)->camel()->ucfirst();

$disk->makeDirectory($directory);

$fileName = $directory . '/' .
    str($this->set->name)->camel()->ucfirst() .
    '-' . now()->format('d-m-Y-H-i-A') . '.pdf';

$outputPath = $disk->path($fileName);

$ready = Ready::create([
    'user_id'    => $this->set->label->user->id,
    'set_id'     => $this->set->id,
    'path'       => $fileName,
    'started_at' => now(),
]);

$service->processChunked($this->set, $outputPath);

$ready->update([
    'completed_at' => now(),
    'records'      => $service->count(),
]);

    $service->processChunked($this->set, $outputPath);

    $ready->update([
        'completed_at' => now(),
        'records'      => $service->count(),
    ]);

    Log::info('PDF Check', [
        'exists' => $disk->exists($fileName),
        'path'   => $outputPath,
    ]);

    $ready = Ready::with(['user', 'set'])->findOrFail($ready->id);

    Mail::to($ready->user->email)
        ->send(new PDFReadyMail($ready));
}
}