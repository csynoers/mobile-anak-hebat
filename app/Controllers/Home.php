<?php namespace App\Controllers;

use App\Models\Tes;
use App\Models\Books;

class Home extends BaseController
{
	public function index()
	{
		helper('text');
		$tes = new Tes();
		$books = new Books();

		$data = [
			'title' => 'Toko Buku Online',
			'view' 	=> 'home',
			'rows' 	=> [
				'slideshow' => $tes->get()->getResultObject(),
				'new_release' => $books->get_new_release()->getResultObject(),
				'coming_soon' => $books->get_coming_soon()->getResultObject(),
				'best_seller' => $books->get_best_seller()->getResultObject(),
			]  
		];
		$this->render_pages($data);
	}

	//--------------------------------------------------------------------

}
