<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Book;
use Booktop;

class CorrectingBooktopWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'correctingBooktopWeek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {  
        $booktopWeeks = Booktop::getBooktopWeeks([],'id_asc',0,0);
        foreach($booktopWeeks AS $booktopWeek)
        {
            $book = Book::getBookById($booktopWeek->book_id);
            if(!$book)
            {
                $booktopWeek->forceDelete();
            }
        }

    }
}
