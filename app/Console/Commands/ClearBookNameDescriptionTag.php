<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Book;
use Utility;

class ClearBookNameDescriptionTag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearBookNameDescriptionTag';

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
        $fileds = [];
        $books = Book::getBooks($fileds,'id_asc',0,0);
        foreach($books AS $book)
        {
            $description = Utility::clearSpecialStringTag($book->description);
            $name        = Utility::clearSpecialStringTag($book->name);  

            $updateData = [];
            $updateData['description'] = $description;
            $updateData['name'] = $name;
            Book::updateBook($book->id,$updateData);
        }

        return 'ok';
    }
}
