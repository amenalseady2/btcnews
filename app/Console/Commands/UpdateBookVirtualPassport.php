<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Passport;
use User;
use Book;

class UpdateBookVirtualPassport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateBookVirtualPassport';

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
        $books = Book::getBooks([],'id_asc',0,0);
        foreach($books AS $book)
        {
            $passport = Passport::getBookSourceVirtualPassportOne();
            $updateData = [];
            $updateData['user_passport_id'] = $passport->id;
            Book::updateBook($book->id,$updateData);
        }
    }
}
