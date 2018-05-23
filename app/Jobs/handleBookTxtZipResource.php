<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Book;

class handleBookTxtZipResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $bookId;
    private $fullFileResourcePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookId,$fullFileResourcePath)
    {
        $this->bookId = $bookId;
        $this->fullFileResourcePath = $fullFileResourcePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Book::handleBookTxtResource($this->bookId,$this->fullFileResourcePath);
    }
}
