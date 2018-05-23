<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Book;

class handleBookEpubResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $bookId;
    private $type;
    private $fullFileResourcePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookId,$type,$fullFileResourcePath)
    {
        $this->bookId = $bookId;
        $this->type = $type;
        $this->fullFileResourcePath = $fullFileResourcePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Book::handleBookEpubResource($this->bookId,$this->type,$this->fullFileResourcePath);
    }
}
