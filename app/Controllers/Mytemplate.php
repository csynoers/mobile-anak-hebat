<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Books extends ResourceController
{
    protected $modelName = 'App\Models\Books_model';
    protected $format    = 'json';

    public function index()
    {
        // ------------------------------------------------------------------------
        // filter query string release book best seller,coming soon and new release
        // ------------------------------------------------------------------------
        $release = [
            'best-seller' => 'best_seller',
            'coming-soon' => 'coming_soon',
            'new-release' => 'new_release'
        ];
        $get_release = $this->request->getPostGet('release');
        if ( $get_release ) {
            $this->model->where($release[$get_release], $release[$get_release]);
        }

        // ------------------------------------------------------------------------
        // limit rows with pagination
        // ------------------------------------------------------------------------
        $rows = $this->model->paginate(9);
        $rows_all['link'] = $this->model->pager->links();
        $rows_all['simple_links'] = $this->model->pager->simpleLinks();

        // ------------------------------------------------------------------------
        // modification json output value type: String,int,float
        // ------------------------------------------------------------------------
        foreach ($rows as $key => $value) {
            $rows_all['rows'][] = [
                'id_book'           => intval($value['id_book']),
                'id_unit_usaha'     => intval($value['id_unit_usaha']),
                'id_sub_kat_imprint'=> intval($value['id_sub_kat_imprint']),
                'title'             => $value['title'],
                'seo'               => $value['seo'],
                'id_author'         => $value['id_author'],
                'isbn'              => $value['isbn'],
                'ukuran'            => $value['ukuran'],
                'kertas_isi'        => $value['kertas_isi'],
                'tebal'             => intval($value['tebal']),
                'sinopsis'          => $value['sinopsis'],
                'keunggulan'        => $value['keunggulan'],
                'image'             => [
                    'origin' => $value['image']
                ],
                'stok'              => $value['stok'],
                'harga'             => intval($value['harga']),
                'diskon'            => intval($value['diskon']),
                'best_seller'       => $value['best_seller'],
                'coming_soon'       => $value['coming_soon'],
                'new_release'       => $value['new_release'],
                'status'            => $value['status'],
                'date'              => $value['date'],
                'berat'             => floatval($value['berat']),
                'jenis_cover'       => $value['jenis_cover'],
            ];
        }
        // print_r($rows_all);
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