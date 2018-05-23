<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Book;

class CountSmallBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countSmallBook';

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
        $fileds['size_lte'] = 1024*100;
        //$fileds['size_gte'] = 1;
        $books = Book::getBooks($fileds,'id_asc',0,0);
        $countData = [];

        foreach($books AS $book)
        {
            $sourceTag = $book->source_tag;
            if($sourceTag)
            {
                $sourceTagData = explode("_", $sourceTag);
                $sourceKey = $sourceTagData[0];

                if(isset($countData[$sourceKey]))
                {
                    $countData[$sourceKey]++;
                }else{
                    $countData[$sourceKey] = 1;
                }
            }
        }

        dd($countData);

    }
}
