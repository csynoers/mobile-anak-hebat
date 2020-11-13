<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\Member_model';
    protected $format    = 'json';
    
    public function index() {
        return redirect()->to('/');
    }

    public function update($id=NULL)
    {
        /**
         * The id_member
         *
         * @var int
         */
        $id = $id;

        if ( empty($this->request->getRawInput('password')) ) {
            $data = [
                'nama' => $this->request->getRawInput('name'),
                'email' => $this->request->getRawInput('email'),
                'telp' => $this->request->getRawInput('phone')
            ];
        } else {
            $data = [
                'password' => $this->request->getRawInput('password'),
            ];
        }

        $where = [
            'id_member' => $id,
            'token' => $this->request->getRawInput('token')
        ];

        // $simpan = $this->model->updateThis($data,$where);
        // if($simpan){
        //     $msg = ['message' => 'Berhasil diubah'];
        //     $response = [
        //         'status' => 200,
        //         'error' => false,
        //         'result' => $msg,
        //     ];
        // } else {
        //     $msg = ['message' => 'Gagal diubah'];
        //     $response = [
        //         'status' => 404,
        //         'error' => true,
        //         'result' => $msg,
        //     ];
        // }

        return $this->setResponseAPI($response,200);
    }

    //Function Enkripsi Password
    public function enkrip( $value ) {
        $cryptKey 	= 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded 	= base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $value, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
        return( $qEncoded );
    }

    //Function Dekripsi Password
    public function dekrip( $value ) {
        $cryptKey	= 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded 	= rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $value ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
        return( $qDecoded );
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
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
            // ->setCache($options);
        return $this->respond($body, $statusCode);
    }
 
}