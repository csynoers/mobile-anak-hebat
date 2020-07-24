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
                'gambar'    => "https://anakhebatindonesia.com/joimg/slide/{$value['gambar']}",
                'deskripsi' => $value['deskripsi'],
                'urutan'    => intval($value['urutan']),
            ];
        }
        return $this->respond($rows_all,200);
    }

    public function create()
    {
        $validation =  \Config\Services::validation();
        $name   = $this->request->getPost('title');
        $seo = $this->request->getPost('seo');
        
        $data = [
            'title' => $name,
            'seo' => $seo
        ];
        
        if($validation->run($data, 'books_insert') == FALSE){
            $response = [
                'status' => 500,
                'error' => true,
                'data' => $validation->getErrors(),
            ];
            return $this->respond($response, 500);
        } else {
            $simpan = $this->model->insertBooks($data);
            if($simpan){
                $msg = ['message' => 'Created Book successfully'];
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $msg,
                ];
                return $this->respond($response, 200);
            }
        }
    }

    public function show($id = NULL)
    {
        $get = $this->model->getBooks($id);
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
        return $this->respond($response, $code);
    }
    
    public function edit($id = NULL)
    {
        $get = $this->model->getBooks($id);
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
        return $this->respond($response, $code);
    }

    public function update($id = NULL)
    {
        $validation =  \Config\Services::validation();
        // getRawInput() digunakan untuk menangkap data dari method PUT,DELETE,PATCH
        $data   = $this->request->getRawInput();

        if($validation->run($data, 'books_update') == FALSE){
            $response = [
                'status' => 500,
                'error' => true,
                'data' => $validation->getErrors(),
            ];
            return $this->respond($response, 500);
        } else {
            $simpan = $this->model->updateBooks($data,$id);
            if($simpan){
                $msg = ['message' => 'Updated book successfully'];
                $response = [
                    'status' => 200,
                    'error' => false,
                    'data' => $msg,
                ];
                return $this->respond($response, 200);
            }
        }
    }

    public function delete($id = NULL)
    {
        $hapus = $this->model->deleteBooks($id);
        if($hapus){
            $code = 200;
            $msg = ['message' => 'Deleted book successfully'];
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $msg,
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
        return $this->respond($response, $code);
    }    
}