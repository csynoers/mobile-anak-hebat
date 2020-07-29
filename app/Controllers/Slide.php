<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Slide extends ResourceController
{
    protected $modelName = 'App\Models\Slide_model';
    protected $format    = 'json';

    protected function getHttpResponseCode($theURL) {
        $headers = get_headers($theURL);
        return substr($headers[0], 9, 3);
    }
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
                    'original' => "https://anakhebatindonesia.com/joimg/slide/" . rawurlencode($value['gambar']),
                ],
                'deskripsi' => $value['deskripsi'],
                'urutan'    => intval($value['urutan']),
            ];
        }
        return $this->setResponseAPI($rows_all,200);
    }
    
    protected function setResponseAPI($body,$statusCode)
    {
        $options = [
            'max-age'  => 1200,
            's-maxage' => 3600,
            'etag'     => 'abcde'
        ];
        
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setCache($options);
        // echo '<pre>';
        // print_r($this);
        // echo '</pre>';
        return $this->respond($body, $statusCode);
    }
}