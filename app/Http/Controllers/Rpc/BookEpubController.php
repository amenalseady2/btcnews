<?php
namespace App\Http\Controllers\Rpc;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Rpc\BookEpub\StoreRequest;
use Output;
use Utility;
use Book;
use Passport;

class BookEpubController extends BaseController
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
	 	$epubUrl = $storeRequest->input('epub_url');
	 	$epubSize = Utility::getUrlHeaderSize($epubUrl);
	 	$epubType = $storeRequest->input('epub_type');
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
		$bookData['file_type'] 		  	= $bookFileTypes['epub'];
		$bookData['source_type'] 		= $bookSourceTypes['collection'];
		$bookData['recommend'] 		  	= $storeRequest->input('recommend',$bookRecommends['off']);
		$bookData['status'] 		  	= $storeRequest->input('status',$bookStatus['on']);
		$bookData['weight'] 		  	= $storeRequest->input('weight',0);
		$bookData['source_tag'] 		= $storeRequest->input('source_tag');

		if($epubSize)
		{
			$bookData['size'] = $epubSize;
		}

		if($book)
		{
			$book = Book::updateBook($book->id,$bookData);			
		}else{
			$book = Book::storeBook($bookData);
		}

		$bookEpubContent = Book::getBookEpubContentByBookId($book->id);
		if($bookEpubContent)
		{
			$updateEpubContentData = [];
			$updateEpubContentData['url']  = $epubUrl;	
			$updateEpubContentData['type'] = $epubType;	
			$bookEpubContent =  Book::updateBookEpubContent($bookEpubContent->id,$updateEpubContentData);
		}else{
			$storeEpubContentData = [];
			$storeEpubContentData['book_id'] = $book->id;
			$storeEpubContentData['url']  = $epubUrl;
			$storeEpubContentData['type'] = $epubType;
			$bookEpubContent =  Book::storeBookEpubContent($storeEpubContentData);
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
