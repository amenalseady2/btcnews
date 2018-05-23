<?php
namespace App\Http\Controllers\Rpc;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Rpc\BookPdf\StoreRequest;
use Output;
use Utility;
use Book;
use Passport;

class BookPdfController extends BaseController
{
	public function store(StoreRequest $storeRequest)
	{
		$bookSourceTypes = Book::getBookSourceTypes();
		$bookFileTypes = Book::getBookFileTypes();
		$bookStatus = Book::getBookStatus();
		$bookRecommends = Book::getBookRecommends();
		$bookDefaultPubDate = Book::getBookDefaultPubDate();
		$bookDefaultImage = Book::getBookDefaultImage();
		$sourceTag = $storeRequest->input('source_tag');
	 	$pdfUrl = $storeRequest->input('pdf_url');
	 	$pdfSize = Utility::getUrlHeaderSize($pdfUrl);
	 	$virtualPassport = Passport::getBookSourceVirtualPassportOne();
		$book = Book::getBookBySourceTag($sourceTag);

		$bookData = [];
		$bookData['user_passport_id']	= $virtualPassport->id;
		$bookData['frist_category_id'] 	= $storeRequest->input('frist_category_id');
		$bookData['second_category_id']	= $storeRequest->input('second_category_id');
		$bookData['name'] 		  		= Utility::clearSpecialStringTag($storeRequest->input('name'));
		$bookData['author'] 		  	= $storeRequest->input('author');
		$bookData['image'] 		  		= $storeRequest->input('image',$bookDefaultImage);
		$bookData['description'] 		= Utility::clearSpecialStringTag($storeRequest->input('description',$bookData['name']));
		$bookData['book_tag_ids']		= $storeRequest->input('book_tag_ids',[]);
		$bookData['pub_date'] 		  	= $storeRequest->input('pub_date',$bookDefaultPubDate);
		$bookData['file_type'] 		  	= $bookFileTypes['pdf'];
		$bookData['source_type'] 		= $bookSourceTypes['collection'];
		$bookData['recommend'] 		  	= $storeRequest->input('recommend',$bookRecommends['off']);
		$bookData['status'] 		  	= $storeRequest->input('status',$bookStatus['on']);
		$bookData['weight'] 		  	= $storeRequest->input('weight',0);
		$bookData['source_tag'] 		= $storeRequest->input('source_tag');

		if($pdfSize)
		{
			$bookData['size'] = $pdfSize;
		}

		if($book)
		{
			$book = Book::updateBook($book->id,$bookData);			
		}else{
			$book = Book::storeBook($bookData);
		}

		$bookPdfContent = Book::getBookPdfContentByBookId($book->id);
		if($bookPdfContent)
		{
			$updatePdfContentData = [];
			$updatePdfContentData['url'] = $pdfUrl;	
			$bookPdfContent =  Book::updateBookPdfContent($bookPdfContent->id,$updatePdfContentData);
		}else{
			$storePdfContentData = [];
			$storePdfContentData['book_id'] = $book->id;
			$storePdfContentData['url'] = $pdfUrl;	
			$bookPdfContent =  Book::storeBookPdfContent($storePdfContentData);
		}

 		Book::destroyBookTagDetailByBookId($book->id);

		$tags = $storeRequest->input('tags');
		$bookTagIds = [];
		if($tags)
		{
			foreach($tags AS $tag)
			{
				$bookTag = Book::getBookTagByName($tag);
				if(!$bookTag){

					$bookTagStoreData =[];
					$bookTagStoreData['name'] = $tag;
					$bookTagStoreData['weight'] = 0;
					$bookTag = Book::storeBookTag($bookTagStoreData);
				}

				$bookTagIds[] = $bookTag->id;
			}

			$bookTagDetailData = [];
			$bookTagDetailData['book_id'] = $book->id;
			$bookTagDetailData['book_tag_ids'] = $bookTagIds;
			Book::storeBookTagDetailWithBookIdAndBookTagIds($bookTagDetailData);
		}

		return Output::success();
	}
}
