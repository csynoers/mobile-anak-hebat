<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Modul extends ResourceController
{
    protected $modelName = 'App\Models\Modul_model';
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
            $rows_all[] = $value;
        }
        return $this->setResponseAPI($rows_all,200);
    }

    public function show($id = NULL)
    {
        $get = $this->model->getModul($id);

        if($get){
            $code = 200;
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $get,
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Not Found'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg,
            ];
        }
        return $this->setResponseAPI($response, $code);
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

    public function contact()
    {
        $get = [
            'content_1' => $this->model->getModul(12)->static_content,
            'content_2' => $this->model->getModul(16)->static_content,
            'content_3' => $this->model->getModul(17)->static_content,
        ];

        if($get){
            $code = 200;
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $get,
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Not Found'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg,
            ];
        }
        return $this->setResponseAPI($response, $code);
    }
 
}