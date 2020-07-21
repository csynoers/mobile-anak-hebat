<?php namespace App\Controllers;

// use App\Models\Tes;

class Auth extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Toko Buku Online',
			'view' 	=> 'auth/register',
		];
		$this->render_pages($data);
	}

	//--------------------------------------------------------------------

}
