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
        // limit rows with orderBy id_book
        // ------------------------------------------------------------------------
        $order = empty($this->request->getPostGet('order')) ? 'desc'  : $this->request->getPostGet('order') ;
        $this->model->orderBy('id_book', $order);

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
                'id'                => intval($value['id_book']),
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
                    'origin'    => "https://anakhebatindonesia.com/joimg/book/{$value['image']}",
                    'thumbnail' => "https://anakhebatindonesia.com/joimg/book/small/small_{$value['image']}"
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

    protected function get_unit_usaha($id)
    {
        $unitUsahaModel = new \App\Models\Unit_usaha_model();
        $rows = $unitUsahaModel->where('id_unit_usaha',$id)->findAll();

        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id'                => intval($value['id_unit_usaha']),
                'kat_unit_usaha'    => [
                    'id'    => intval($value['id_kat_unit_usaha']),
                    'rows'  => $this->get_kat_unit_usaha($value['id_kat_unit_usaha'])
                ],
                'title'             => $value['title'],
                'content'           => $value['content'],
                'image'             => $value['image'],
                'date'              => $value['date'],
                'seo'               => $value['seo'],
                'disc_value'        => $value['disc_value'],
            ];
        }

        return $rows_all;
    }

    protected function get_kat_unit_usaha($id)
    {
        $katUnitUsahaModel = new \App\Models\Kat_unit_usaha_model();
        $rows = $katUnitUsahaModel->where('id_kat_unit_usaha',$id)->findAll();

        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id'                => intval($value['id_kat_unit_usaha']),
                'title'             => $value['title'],
                'seo'               => $value['seo']
            ];
        }

        return $rows_all;
    }

    // protected function get_unit_usaha($id)
    // {
    //     $slideModel = new \App\Models\Slide_model();
    //     return $slideModel->find($id);
    // }
}