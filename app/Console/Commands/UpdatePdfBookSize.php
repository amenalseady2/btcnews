<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Book;
use Utility;

class UpdatePdfBookSize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatePdfBookSize';

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

        $bookFileTypes = Book::getBookFileTypes();

        $fileds = [];
        $fileds['file_type'] = $bookFileTypes['pdf'];
        $books = Book::getBooks($fileds,'id_asc',0,0);
        $bookIds = $books->pluck('id')->toArray();

        $fileds =[];
        $fileds['book_ids'] = $bookIds;
        $bookPdfContents = Book::getBookPdfContents($fileds,'id_desc',0,0);

        foreach($bookPdfContents AS $bookPdfContent)
        {
            $size = Utility::getUrlHeaderSize($bookPdfContent->url);
            
            $data = [];
            $data['size'] = $size;
            Book::updateBook($bookPdfContent->book_id,$data);
        }

        return 'ok';
    }
}
