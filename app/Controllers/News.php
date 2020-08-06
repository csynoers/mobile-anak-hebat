<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class News extends ResourceController
{
    protected $modelName = 'App\Models\Articles_model';
    protected $format    = 'json';

    public function index()
    {
        // ------------------------------------------------------------------------
        // filter query string by status '1 or 0' 
        // ------------------------------------------------------------------------
        $this->model->where('status', 1);

        // ------------------------------------------------------------------------
        // filter query string by category(c) 'article or karir' 
        // ------------------------------------------------------------------------
        $get_category = $this->request->getPostGet('c');
        if ( $get_category ) {
            $this->model->where('category', $get_category);
        }
        
        // ------------------------------------------------------------------------
        // limit rows with orderBy id_articles
        // ------------------------------------------------------------------------
        $order = empty($this->request->getPostGet('order')) ? 'desc'  : $this->request->getPostGet('order') ;
        $this->model->orderBy('id_articles', $order);

        // ------------------------------------------------------------------------
        // limit rows with pagination
        // ------------------------------------------------------------------------
        $rows = $this->model->paginate(9);
        $rows_all['link'] = $this->model->pager->links();
        $rows_all['simple_links'] = $this->model->pager->simpleLinks();

        // ------------------------------------------------------------------------
        // modification json output value type: intVal(ref::https://www.php.net/manual/en/function.intval.php),rawurlencode(ref::https://www.php.net/manual/en/function.rawurlencode.php)
        // ------------------------------------------------------------------------
        foreach ($rows as $key => $value) {
            // RAW URL Encode image name
            $value['image'] = rawurlencode($value['image']);

            $rows_all['rows'][] = [
                'id'=>intVal($value['id_articles']),
                'title'=>$value['title'],
                'content'=>$value['content'],
                'image'=>[
                    'origin'    => "https://anakhebatindonesia.com/joimg/articles/". $value['image'],
                    'thumbnail' => "https://anakhebatindonesia.com/joimg/articles/small/small_" . $value['image']
                ],
                'create_at'=>$value['date'],
                'slug'=>$value['seo'],
                'category'=>$value['category'],
                'status'=>$value['status'],
            ];
        }
        return $this->setResponseAPI($rows_all,200);
    }

    public function show($id = NULL)
    {
        $get = $this->model->getBooks($id);

        // ------------------------------------------------------------------------
        // modification image value
        // ------------------------------------------------------------------------
        $get->image = rawurlencode($get->image);
        $get->image = [
            'origin'    => "https://anakhebatindonesia.com/joimg/book/{$get->image}",
            'thumbnail' => "https://anakhebatindonesia.com/joimg/book/small/small_{$get->image}"
        ];
        $get->price = [
            'idr' => [
                'value' => intval($get->harga),
                'text'  => $this->currencyIDR($get->harga),
            ]
        ];
        $get->discount = [
            'value' => intval($get->diskon),
            'text'  => "{$get->diskon}%",
            'price' => [
                'idr' => [
                    'value'     => $get->harga-($get->harga*$get->diskon)/100,
                    'text'      => $this->currencyIDR($get->harga-($get->harga*$get->diskon)/100)
                ]
            ]
        ];
        $get->weight = [
            'kg'    => floatval($get->berat),
            'gram'  => floatval($get->berat)*1000
        ];

        // ------------------------------------------------------------------------
        // get data authors, penerbit and kategori
        // ------------------------------------------------------------------------
        $get->authors = $this->getAuthors($get->id_author);
        $get->penerbit = $this->getPenerbit($get->id_unit_usaha);
        $get->kategori = $this->getKategori($get->id_sub_kat_imprint);
        
        if ($get->stok == 'Y') {
            $get->stok = "Gudang Anak Hebat Indonesia";
        }elseif($get->stok == 'S'){
            $get->stok = "Gudan Supplier";
        }else{
            $get->stok = "- Habis -";
        }

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

    protected function getAuthors($id)
    {
        # generate where in
        $id = array_filter(explode(',',$id), 'strlen');

        $authorModel = new \App\Models\Author_model();
        $rows = $authorModel->whereIn('id_author',$id)->findAll();

        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id'                => intval($value['id_author']),
                'title'             => $value['name'],
                'seo'               => $value['seo'],
            ];
        }

        return $rows_all;
    }

    protected function getPenerbit($id)
    {
        $unitUsahaModel = new \App\Models\Unit_usaha_model();
        $rows = $unitUsahaModel->where('id_unit_usaha',$id)->findAll();

        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id'                => intval($value['id_unit_usaha']),
                'title'             => $value['title'],
                'seo'               => $value['seo'],
            ];
        }

        return $rows_all;
    }

    protected function getKategori($id)
    {
        $kategori = new \App\Models\Sub_kat_imprint_model();
        $rows = $kategori->where('id_sub_kat_imprint',$id)->findAll();

        foreach ($rows as $key => $value) {
            $rows_all[] = [
                'id'                => intval($value['id_sub_kat_imprint']),
                'title'             => $value['title'],
                'seo'               => $value['seo']
            ];
        }

        return $rows_all;
    }

    protected function currencyIDR($angka){
	
        $hasil_rupiah = number_format($angka,0,',','.');
        return $hasil_rupiah;
     
    }

    protected function setResponseAPI($body,$statusCode)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        // echo '<pre>';
        // print_r($this);
        // echo '</pre>';
        return $this->respond($body, $statusCode);
    }
 
}