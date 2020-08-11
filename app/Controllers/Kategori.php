<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Kategori extends ResourceController
{
    protected $modelName = 'App\Models\Unit_usaha_model';
    protected $format    = 'json';

    public function index()
    {
        // ------------------------------------------------------------------------
        // rows kategori atau tabel unit_usaha
        // ------------------------------------------------------------------------
        $this->model->where('id_kat_unit_usaha', 1);
        $this->model->orderBy('title', 'asc');
        $rows = $this->model->findAll();

        // ------------------------------------------------------------------------
        // modification json output value type: int
        // ------------------------------------------------------------------------
        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id'                => intval($value['id_unit_usaha']),
                'title'             => $value['title'],
                'rows' => $this->getSubKategori($value['id_unit_usaha']),
            ];
        }
        return $this->setResponseAPI($rows_all,200);
    }

    protected function getSubKategori($id)
    {
        $subKategori = new \App\Models\Sub_kat_imprint_model();
        $rows = $subKategori->where('id_unit_usaha',$id)->findAll();

        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id'                => intval($value['id_sub_kat_imprint']),
                'title'             => $value['title'],
            ];
        }

        return $rows_all;
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