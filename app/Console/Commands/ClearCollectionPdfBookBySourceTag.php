<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Book;

class ClearCollectionPdfBookBySourceTag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearCollectionPdfBookBySourceTag {sourceTag}';

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
        $sourceTag = $this->argument('sourceTag');

        $fileds = [];
        $fileds['source_tag'] = $sourceTag;
        $books = Book::getBooks($fileds,'id_asc',0,0);
        $bookIds = $books->pluck('id')->toArray();

        $fileds =[];
        $fileds['book_ids'] = $bookIds;
        $bookPdfContents = Book::getBookPdfContents($fileds,'id_desc',0,0);

        foreach($bookPdfContents AS $bookPdfContent)
        {
            $bookPdfContent->forceDelete();
        }

        foreach($books AS $book)
        {
            $book->forceDelete();
        }

        return 'ok';
    }
}
