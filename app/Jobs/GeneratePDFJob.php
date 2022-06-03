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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = app()->make(PDFGeneratorService::class);

        $ready          = new Ready();
        $ready->user_id = $this->set->label->user->id;
        $ready->set_id  = $this->set->id;

        $directory = Carbon::now()->format('Y' . DIRECTORY_SEPARATOR . 'm');
        if (!Storage::disk('local')->exists($directory)) {
            Storage::disk('local')->makeDirectory($directory);
        }
        $fileName   = $directory . DIRECTORY_SEPARATOR . time() . '.pdf';
        $outputPath = Storage::disk('local')->path($fileName);

        $ready->path       = $fileName;
        $ready->started_at = Carbon::now();
        $ready->save();

        $service->process($this->set)
            ->save($outputPath);

        $ready->completed_at = Carbon::now();
        $ready->records      = $service->count();
        $ready->save();

        activity('ready')
            ->performedOn($ready)
            ->causedBy($this->set->label->user)
            ->event('generated')
            ->log('PDF Ready with records ' . $service->count());

        Mail::to($this->set->label->user)
            ->queue(new PDFReadyMail($ready));
    }
}
