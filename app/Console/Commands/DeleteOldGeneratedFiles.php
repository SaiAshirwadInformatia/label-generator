<?php

namespace App\Console\Commands;

use App\Models\Ready;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteOldGeneratedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-generated-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $readyFiles = Ready::query()
            ->where('created_at', '<', now()->subDays(30))
            ->get();

        foreach ($readyFiles as $readyFile) {
            if (Storage::exists($readyFile->path)) {
                $this->warn('Deleting ' . $readyFile->path);
                Storage::delete($readyFile->path);
                $this->info('Deleted ' . $readyFile->path);
            }
            $this->warn('Deleting ' . $readyFile->id);
            $readyFile->delete();
            $this->info('Deleted ' . $readyFile->id);
        }
    }
}
