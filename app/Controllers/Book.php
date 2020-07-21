<?php namespace App\Controllers;

use App\Models\Tes;
use App\Models\Books;
use App\Models\Units_usaha;
use App\Models\Sub_kat_imprint;
use App\Models\Authors;
use App\Models\Resensies;

class Book extends BaseController
{
	public function index()
	{
		helper('text');
		$tes = new Tes();
		$books = new Books();

		$data = [
			'title' => 'Detail Buku | Toko Buku Online',
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
	
	public function detail($id)
	{
		if ( $id ) {
			$books = new Books();
			$units_usaha = new Units_usaha();
			$sub_kat_imprint = new Sub_kat_imprint();
			$authors = new Authors();
			$resensies = new Resensies();

			# get single row from table "book"
			$row = $books->get($id)->getRow();

			# explode $row->id_author and filter array if value is empty
			$id_authors = array_filter(explode(",",$row->id_author), 'strlen');

			$data = [
				'title' => $row->title,
				'view' 	=> 'books/detail',
				'rows' 	=> [
					'authors' => $authors->getInId($id_authors)->getResultObject(),
					'book' => $row,
					'penerbit' => $units_usaha->get( $row->id_unit_usaha )->getRow(),
					'kategori' => $sub_kat_imprint->get( $row->id_sub_kat_imprint )->getRow(),
					'resensies' => $resensies->get($row->id_book)->getResultObject(),
				]  
			];
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
			$this->render_pages($data);
		}
	} 
	
	//--------------------------------------------------------------------

}
