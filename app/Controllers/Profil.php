<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Profil extends ResourceController
{
    protected $modelName = 'App\Models\Profil_model';
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
                'id' => intval($value['id_profil']),
                'title' => [
                    'in' => $value['title_indo'],
                    'us' => $value['title_ing'],
                ],
                'content' => [
                    'in' => $value['content_indo'],
                    'us' => $value['content_ing'],
                ],
            ];
        }
        return $this->setResponseAPI($rows_all,200);
    }

    public function show($id = NULL)
    {
        $row = $this->model->getProfil($id);
        $get = [
            'id' => intval($row->id_profil),
            'title' => [
                'in' => $row->title_indo,
                'us' => $row->title_ing,
            ],
            'content' => [
                'in' => $row->content_indo,
                'us' => $row->content_ing,
            ],
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