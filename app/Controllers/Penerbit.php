<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Penerbit extends ResourceController
{
    protected $modelName = 'App\Models\Unit_usaha_model';
    protected $format    = 'json';

    public function index()
    {
        // ------------------------------------------------------------------------
        // rows penerbit atau tabel unit_usaha
        // ------------------------------------------------------------------------
        $rows = $this->model->findAll();

        // ------------------------------------------------------------------------
        // modification json output value type: int
        // ------------------------------------------------------------------------
        foreach ($rows as $key => $value) {
            // RAW URL Encode image name
            $value['image'] = rawurlencode($value['image']);

            $rows_all[] = [
                'id'                => intval($value['id_unit_usaha']),
                'id_kat_unit_usaha' => intval($value['id_kat_unit_usaha']),
                'title'             => $value['title'],
                'content'           => $value['content'],
                'image'             => [
                    'origin'    => "https://anakhebatindonesia.com/joimg/unit_usaha/" . $value['image'],
                    'thumbnail' => "https://anakhebatindonesia.com/joimg/unit_usaha/small/small_" .$value['image']
                ],
                'date'              => $value['date'],
                'seo'               => $value['seo'],
                'disc_value'        => intval($value['disc_value']),
            ];
        }
        return $this->setResponseAPI($rows_all,200);
    }

    public function show($id = NULL)
    {
        $get = $this->model->getUnitUsaha($id);

        // ------------------------------------------------------------------------
        // modification image value
        // ------------------------------------------------------------------------
        $get->image = rawurlencode($get->image);
        $get->image = [
            'origin'    => "https://anakhebatindonesia.com/joimg/unit_usaha/{$get->image}",
            'thumbnail' => "https://anakhebatindonesia.com/joimg/unit_usaha/small/small_{$get->image}"
        ];

        // ------------------------------------------------------------------------
        // modification json output value type: int
        // ------------------------------------------------------------------------
        $get->id_unit_usaha     = intval($get->id_unit_usaha);
        $get->id_kat_unit_usaha = intval($get->id_kat_unit_usaha);
        $get->disc_value        = intval($get->disc_value);

        $row = [
            'id'=> $get->id_unit_usaha,
            'parent_id'=> $get->id_kat_unit_usaha,
            'title'=> $get->title,
            'content'=> $get->content,
            'image'=> $get->image,
            'create_at'=> $get->date,
            'slug'=> $get->seo,
            'disc_value'=> $get->disc_value
        ];

        if($get){
            $code = 200;
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $row,
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
            'max-age'  => 1200,
            's-maxage' => 3600,
            'etag'     => 'abcde'
        ];
        
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setCache($options);
        return $this->respond($body, $statusCode);
    }
 
}