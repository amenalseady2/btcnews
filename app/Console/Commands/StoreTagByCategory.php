<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Book;


class StoreTagByCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storeTagByCategory';

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
        $bookCategories = Book::getBookCategories([],'id_desc',0,0);

        foreach ($bookCategories as $key => $bookCategory) {
            $bookTag = Book::getBookTagByName($bookCategory->name); 
            if(!$bookTag)
            {   
                $storeData = [];
                $storeData['name'] = $bookCategory->name;
                $storeData['weight'] = 0;
                Book::storeBookTag($storeData);
            }
        }

        $bookTags = Book::getBookTags([],'weight_desc',0,0);
        $books = Book::getBooks([],'id_desc',0,0);

        foreach($books AS $book)
        {
            $tagCount = Book::getBookTagsByBookId($book->id);
            if(count($tagCount) == 0)
            {
                $fristCategory  = $bookCategories->find($book->frist_category_id);
                $secondCategory = $bookCategories->find($book->second_category_id);

                $fristTag = $bookTags->where('name',$fristCategory->name)->first();
                $secondTag = $bookTags->where('name',$secondCategory->name)->first();

                $bookTagIds = [];
                $bookTagIds[] = $fristTag->id;
                $bookTagIds[] = $secondTag->id;

                $bookTagDetailData = [];
                $bookTagDetailData['book_id'] = $book->id;
                $bookTagDetailData['book_tag_ids'] = $bookTagIds;
                Book::storeBookTagDetailWithBookIdAndBookTagIds($bookTagDetailData);

            }
        }
    }
}
