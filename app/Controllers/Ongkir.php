<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Ongkir extends ResourceController
{
	protected $format    = 'json';
	/**
     * List of Supported Account Types
     *
     * @access  protected
     * @type    array
     */
    protected $supportedAccountTypes = [
        'starter',
        'basic',
        'pro',
    ];

    /**
     * Supported Couriers
     *
     * @access  protected
     * @type    array
     */
    protected $supportedCouriers = [
        'starter' => [
            'jne',
            'pos',
            'tiki',
        ],
        'basic'   => [
            'jne',
            'pos',
            'tiki',
            'pcp',
            'esl',
            'rpx',
        ],
        'pro'     => [
            'jne',
            'pos',
            'tiki',
            'rpx',
            'esl',
            'pcp',
            'pandu',
            'wahana',
            'sicepat',
            'j&t',
            'pahala',
            'cahaya',
            'sap',
            'jet',
            'indah',
            'slis',
            'expedito*',
            'dse',
            'first',
            'ncs',
            'star',
            'lion',
            'ninja-express',
            'idl',
            'rex',
        ],
	];
	
	public function cost()
	{
		$this->getCost();
	}
	public function cost_all($destination=114,$weight=1700)
	{
		if ( ! empty($_GET['destination']) ) 
			$destination = $_GET['destination'];

		if ( ! empty($_GET['weight']) ) 
			$weight = $_GET['weight'];


		$data= [];
		foreach ($this->supportedCouriers['pro'] as $keyCourier => $valueCourier) {
			$configGetCost= [
				'destination'=> $destination,
				'weight'=> $weight,
				'courier'=> $valueCourier,
			];
			
			$kurir = json_decode($this->getCost($configGetCost))->rajaongkir->results;
			foreach ($kurir as $key_kurir => $value_kurir) {
				$code= strtoupper( $value_kurir->code );
				foreach ($value_kurir->costs as $key_costs => $value_costs) {
					$service= $value_costs->service;
					foreach ($value_costs->cost as $key_cost => $value_cost) {
						$data[]= [
							'code'=> $code,
							'service'=> $service,
							'etd'=> $value_cost->etd .($code=='POS'? null : ' HARI' ),
							'value'=> $value_cost->value,
						];
					}
				}
			}
		}
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// return $data;
		// echo json_encode($data);
		return $this->setResponseAPI($data, 200);
	}

	public function getCost($data=NULL) {
        $curl = curl_init();
        $CURLOPT_POSTFIELDS = "origin=501&destination=574&weight=1700&courier=jne";

        if ( $data ) {
            # code...
        }

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		// CURLOPT_POSTFIELDS => "origin=501&destination={$data['destination']}&weight={$data['weight']}&courier={$data['courier']}",
		CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
		CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: db98dd4f0d799996b1cc75ad62fd5564"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
    }

    public function subdistrict($city=39) {
        if ( ! empty($_GET['city']) ) 
            $city = $_GET['city'];
            
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city={$city}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: db98dd4f0d799996b1cc75ad62fd5564"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
			$data = "cURL Error #:" . $err;
		} else {
			$data = $response;
        }

        return $this->setResponseAPI(json_decode($data), 200);
    }

    public function subdistrictall() {
        $data = [];
        foreach ($this->city() as $key => $value) {
            $data[] = $this->subdistrict($value->city_id);
        }
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

	//--------------------------------------------------------------------
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
