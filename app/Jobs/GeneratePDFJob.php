<?php

namespace App\Jobs;

use App\Mail\PDFReadyMail;
use App\Models\Ready;
use App\Models\Set;
use App\Models\User;
use App\Services\PDFGeneratorService;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class GeneratePDFJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Set $set;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Set $set)
    {
        $this->set = $set;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = app()->make(PDFGeneratorService::class);

        $ready = new Ready();
        $ready->user_id = $this->set->label->user->id;
        $ready->set_id = $this->set->id;

        $directory = Carbon::now()->format('Y' . DIRECTORY_SEPARATOR . 'm');
        if (!Storage::disk('local')->exists($directory)) {
            Storage::disk('local')->makeDirectory($directory);
        }
        $fileName = $directory . DIRECTORY_SEPARATOR . time() . '.pdf';
        $outputPath = Storage::disk('local')->path($fileName);

        $ready->path = $fileName;
        $ready->started_at = Carbon::now();
        $ready->save();

        $service->process($this->set)
            ->save($outputPath);

        $ready->completed_at = Carbon::now();
        $ready->records = $service->count();
        $ready->save();

        activity("ready")
            ->performedOn($ready)
            ->causedBy($this->set->label->user)
            ->event("generated")
            ->log("PDF Ready with records " . $service->count());

        Mail::to($this->set->label->user)
            ->queue(new PDFReadyMail($ready));
    }
}
