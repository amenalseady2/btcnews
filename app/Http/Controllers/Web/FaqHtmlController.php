<?php
namespace App\Http\Controllers\Web;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\Web\FaqHtml\ShowRequest;
use Faq;

class FaqHtmlController extends BaseController
{
	public function show(ShowRequest $showRequest,$id)
	{
		$faqHtml  = Faq::getFaqHtmlById($id);
		$data = [];
		$data['faqHtml'] = $faqHtml;
		return view('web/faq/show',$data);
	}

}
