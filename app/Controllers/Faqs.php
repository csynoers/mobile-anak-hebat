<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Faqs extends ResourceController
{
    protected $modelName = 'App\Models\Faq_model';
    protected $format    = 'json';

    public function index()
    {
        // ------------------------------------------------------------------------
        // rows penerbit atau tabel faq
        // ------------------------------------------------------------------------
        $rows = $this->model->findAll();

        // ------------------------------------------------------------------------
        // modification json output value type: int
        // ------------------------------------------------------------------------
        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id' => intval($value['id_faq']),
                'q'  => $value['pertanyaan'],
                'a'  => $value['jawaban'],
            ];
        }
        return $this->setResponseAPI($rows_all,200);
    }

    protected function setResponseAPI($body,$statusCode)
    {
        $options = [
            'max-age'  => 1200*24,
            's-maxage' => 3600*24,
            'etag'     => 'abcde'
        ];
        
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setCache($options);
        return $this->respond($body, $statusCode);
    }
 
}