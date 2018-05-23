<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Model\ComicsPages;

class handleBookImageZipResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $bookId;
    private $fullFileResourcePath;
    private $chapterId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookId,$fullFileResourcePath,$chapter_id = 0)
    {
        $this->bookId = $bookId;
        $this->fullFileResourcePath = $fullFileResourcePath;
        $this->chapterId = $chapter_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ComicsPages::handleBookImageResource($this->bookId,$this->fullFileResourcePath,$this->chapterId);
    }
}
