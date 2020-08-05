<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Penerbit extends ResourceController
{
    protected $modelName = 'App\Models\Unit_usaha_model';
    protected $format    = 'json';

    protected function getHttpResponseCode($theURL) {
        $headers = get_headers($theURL);
        return substr($headers[0], 9, 3);
    }
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
        helper('text');
        foreach ($rows as $key => $value) {
            $value['image'] = rawurlencode($value['image']);
            $rows_all['rows'][] = [
                'id'                => intval($value['id_book']),
                'id_unit_usaha'     => intval($value['id_unit_usaha']),
                'id_sub_kat_imprint'=> intval($value['id_sub_kat_imprint']),
                'title'             => $value['title'],
                'titleLimit'        => character_limiter($value['title'], 20),
                'seo'               => $value['seo'],
                'id_author'         => $value['id_author'],
                'isbn'              => $value['isbn'],
                'ukuran'            => $value['ukuran'],
                'kertas_isi'        => $value['kertas_isi'],
                'tebal'             => intval($value['tebal']),
                'sinopsis'          => $value['sinopsis'],
                'keunggulan'        => $value['keunggulan'],
                'image'             => [
                    'origin'    => "https://anakhebatindonesia.com/joimg/book/". $value['image'],
                    'thumbnail' => "https://anakhebatindonesia.com/joimg/book/small/small_" . $value['image']
                ],
                'stok'              => $value['stok'],
                'price'             => [
                    'idr' => [
                        'value' => intval($value['harga']),
                        'text'  => $this->currencyIDR($value['harga']),
                    ]
                ],
                'discount'          => [
                    'value' => intval($value['diskon']),
                    'text'  => "{$value['diskon']}%",
                    'price' => [
                        'idr' => [
                            'value'     => $value['harga']-($value['harga']*$value['diskon'])/100,
                            'text'      => $this->currencyIDR($value['harga']-($value['harga']*$value['diskon'])/100)
                        ]
                    ]
                ],
                'best_seller'       => $value['best_seller'],
                'coming_soon'       => $value['coming_soon'],
                'new_release'       => $value['new_release'],
                'status'            => $value['status'],
                'date'              => $value['date'],
                'weight'             => [
                    'kg'    => floatval($value['berat']),
                    'gram'  => floatval($value['berat'])*1000
                ],
                'jenis_cover'       => $value['jenis_cover'],
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