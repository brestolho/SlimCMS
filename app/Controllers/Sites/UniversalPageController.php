<?php

namespace App\Controllers\Sites;

use \Psr\Http\Message\ServerRequestInterface as request;
use App\Source\Factory\PageFactory;
use App\Source\Factory\SectionFactory;
use App\Models\Pages;
use App\Models\Sections;

class UniversalPageController extends BaseController
{
	public function homeAction(request $req, $res){
		$this->data['pageData'] = PageFactory::getPageWithRequest($req);
		$this->setRequestResult($req, $res);

		$this->render('public\main\pages\home.twig');
	}

	public function detailAction(request $req, $res){
		$this->data['pageData'] = PageFactory::getPageWithRequest($req);
		$this->setRequestResult($req, $res);

		$this->render('public\main\pages\detail_page.twig');
	}

	public function sectionAction(request $req, $res){
		$this->data['pageData'] = SectionFactory::getSectionWithRequest($req);
		$this->setRequestResult($req, $res);

		$this->data['subSections'] = Sections::where('path', 'LIKE', '%/'.$this->data['pageData']->id.'/%')->get();
		$this->data['pagesLinks'] = Pages::where('category_id', $this->data['pageData']->id)->get();

//p($this->data['subSections']);
//p($this->data['pagesLinks'], 1);
		$this->render('public\main\pages\section_page.twig');
	}

	public function notFound(request $req, $res){
		$this->setRequestResult($req, $res);

		return $this->render('public\main\pages\404.twig');
	}
}
