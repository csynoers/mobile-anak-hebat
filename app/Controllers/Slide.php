<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Slide extends ResourceController
{
    protected $modelName = 'App\Models\Slide_model';
    protected $format    = 'json';

    public function index()
    {
        $rows = $this->model
            ->orderBy('urutan', 'desc')
            ->findAll();

        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id_slide'  => intval($value['id_slide']),
                'nama'      => $value['nama'],
                'image'     => [
                    'original' => "https://anakhebatindonesia.com/joimg/slide/{$value['gambar']}"
                ],
                'deskripsi' => $value['deskripsi'],
                'urutan'    => intval($value['urutan']),
            ];
        }
        return $this->respond($rows_all,200);
    } 
}