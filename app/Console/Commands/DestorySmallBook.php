<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Book;

class DestorySmallBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destorySmallBook';

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
        $bookTypes = Book::getBookFileTypes();
        $fileds = [];
        $fileds['size_lte'] = 1024*10;
        $fileds['size_gte'] = 0;
        $books = Book::getBooks($fileds,'id_asc',0,0);

        $pdfBookIds = $books->where('file_type',$bookTypes['pdf'])->pluck('id')->toArray();
        $epubBookIds = $books->where('file_type',$bookTypes['epub'])->pluck('id')->toArray();

        if($pdfBookIds)
        {
            $fileds = [];
            $fileds['book_ids'] = $pdfBookIds;
            $bookPdfContents = Book::getBookPdfContents($fileds,'id_desc',0,0);
            foreach($bookPdfContents AS $bookPdfContent)
            {
                $bookPdfContent->forceDelete();
            }
        }

        if($epubBookIds)
        {
            $fileds = [];
            $fileds['book_ids'] = $epubBookIds;
            $bookEpubContents = Book::getBookEpubContents($fileds,'id_desc',0,0);
            foreach($bookEpubContents AS $bookEpubContent)
            {
                $bookEpubContent->forceDelete();
            }   
        }

        foreach($books AS $book)
        {
            $book->forceDelete();
        }
        
        dd("ok");
    }
}
