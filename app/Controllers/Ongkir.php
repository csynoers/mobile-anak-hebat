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
            'pos',
            'tiki',
            'jne',
            // 'pcp',
            // 'esl',
            // 'rpx',
            // 'pandu',
            'wahana',
            'jnt',
            // 'pahala',
            // 'cahaya',
            // 'sap',
            'jet',
            // 'indah',
            // 'dse',
            // 'slis',
            // 'first',
            // 'ncs',
            // 'star'
        ],
        'international' => [
            'pos',
            'tiki',
            'slis',
            'expedito',
            'jne',
        ],
	];
	
	public function cost()
	{
		$this->getCost();
	}
	public function cost_all($destination=574,$weight=1700)
	{
        if ( empty($_GET['destination']) && empty($_GET['weight']) ) {
            echo 'error. destination and weight not be empty';
            die();
        }
		
        $destination = $_GET['destination'];
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
				foreach ($value_kurir->costs as $key_costs => $value_costs) {
					foreach ($value_costs->cost as $key_cost => $value_cost) {
						$data[]= [
							'code'=> $value_kurir->code,
							'name'=> $value_kurir->name,
							'service'=> $value_costs->service,
							'description'=> $value_costs->description,
                            'value'=> $value_cost->value,
                            'etd'=> $value_cost->etd,
                            'note'=> $value_cost->note,
						];
					}
				}
			}
        }

        // shorting array by etd value
        usort($data, function($a, $b) {
            return $a['value'] <=> $b['value'];
        });

		return $this->setResponseAPI($data, 200);
	}

	public function getCost($data) {
        $curl = curl_init();
        $CURLOPT_POSTFIELDS = "origin=501&originType=city&destination=574&destinationType=subdistrict&weight=1700&courier=jne";

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "origin=501&originType=city&destination={$data['destination']}&destinationType=subdistrict&weight={$data['weight']}&courier={$data['courier']}",
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
			return $response;
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

    /* InternationalOrigin */
    public function international_origin() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/v2/internationalOrigin",
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
            echo "cURL Error #:" . $err;
            // $this->setResponseAPI(json_decode($data), 200);
        } else {
            // echo $response;
            return $this->setResponseAPI(json_decode($response), 200);
        }
    }

    /* InternationalDestination */
    public function international_destination() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/v2/internationalDestination",
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
            echo "cURL Error #:" . $err;
            // $this->setResponseAPI(json_decode($data), 200);
        } else {
            // echo $response;
            return $this->setResponseAPI(json_decode($response), 200);
        }
    }

    /* InternationalCost */
    protected function international_cost($data) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/v2/internationalCost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=39&destination={$data['destination']}&weight={$data['weight']}&courier={$data['courier']}",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: db98dd4f0d799996b1cc75ad62fd5564"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
            // $this->setResponseAPI(json_decode($data), 200);
        } else {
            // echo $response;
            return $this->isJson($response) ? $response : '{"rajaongkir":{"results":[]}}' ;
        }
    }

    /* InternationalCostALL */
    public function international_cost_all($destination=108,$weight=1400)
	{
        if ( empty($_GET['destination']) && empty($_GET['weight']) ) {
            echo 'error. destination and weight not be empty';
            die();
        }
		
        $destination = $_GET['destination'];
        $weight = $_GET['weight'];

		$data= [];
		foreach ($this->supportedCouriers['international'] as $keyCourier => $valueCourier) {
			$configGetCost= [
				'destination'=> $destination,
				'weight'=> $weight,
				'courier'=> $valueCourier,
            ];
            $kurir = json_decode($this->international_cost($configGetCost))->rajaongkir;

            if ( $kurir->currency ) {
                $currency = $kurir->currency->value;
            }

            // $data[] = $kurir;
			foreach ($kurir->results as $key_kurir => $value_kurir) {
                foreach ($value_kurir->costs as $key_costs => $value_costs) {
                    $data[]= [
                        'code'=> $value_kurir->code,
                        'name'=> $value_kurir->name,
                        'service'=> $value_costs->service,
                        'cost'=> ($value_costs->currency=='USD') ? ($value_costs->cost*$currency) : $value_costs->cost ,
                        'currency'=> 'IDR' ,
                        'etd'=> $value_costs->etd,
                    ];
				}
			}
        }

        // shorting array by cost
        usort($data, function($a, $b) {
            return $a['cost'] <=> $b['cost'];
        });

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
		return $this->setResponseAPI($data, 200);
    
    }

    // get List ciurier waybill
    public function waybill_couriers() {
        $couriers = [
            [
                'pos' => 'POS Indonesia (POS)',
            ],
            [
                'tiki' => 'Citra Van Titipan Kilat (TIKI)',
            ],
            [
                'jne' => 'Jalur Nugraha Ekakurir (JNE)',
            ],
            // 'pcp' => '',
            // 'esl',
            // 'rpx',
            // 'pandu',
            [
                'wahana' => 'Wahana Prestasi Logistik (WAHANA)',
            ],
            [
                'jnt' => 'J&T Express (J&T)',
            ],
            // 'pahala',
            // 'cahaya',
            // 'sap',
            [
                'jet' => 'JET Express (JET)',
            ]
            // 'indah',
            // 'dse',
            // 'slis',
            // 'first',
            // 'ncs',
            // 'star'
        ];

        return $this->setResponseAPI($couriers,200);
    }
    
    /* Waybill */
    public function waybill() {
        $curl = curl_init();

        if ( empty($_GET['waybill']) && empty($_GET['courier']) ) {
            echo 'error. No Resi dan Kurir tidak boleh kosong';
            die();
        }

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "waybill={$_GET['waybill']}&={$_GET['courier']}",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: db98dd4f0d799996b1cc75ad62fd5564"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $this->setResponseAPI($err,400);
        } else {
            return $this->setResponseAPI(json_decode($response),200);
        }
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

    protected function isJson($str) {
        $json = json_decode($str);
        return $json && $str != $json;
    }
}
