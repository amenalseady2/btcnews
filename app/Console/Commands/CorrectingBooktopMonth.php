<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Book;
use Booktop;

class CorrectingBooktopMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'correctingBooktopMonth';

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
        $booktopMonths = Booktop::getBooktopMonths([],'id_asc',0,0);
        foreach($booktopMonths AS $booktopMonth)
        {
            $book = Book::getBookById($booktopMonth->book_id);
            if(!$book)
            {
                $booktopMonth->forceDelete();
            }
        }
    }
}
