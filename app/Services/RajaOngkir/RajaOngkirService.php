<?php
 
namespace App\Services\RajaOngkir;
 
use Illuminate\Support\Facades\Http;

class RajaOngkirService {

    /**
     *
     * Rajaongkir courier list.
     *
     * @access  protected
     * @type array
     */
    protected $couriersList = [
        'jne'       => 'Jalur Nugraha Ekakurir (JNE)',
        'pos'       => 'POS Indonesia (POS)',
        'tiki'      => 'Citra Van Titipan Kilat (TIKI)',
        'wahana'    => 'Wahana Prestasi Logistik (WAHANA)',
        'sicepat'   => 'SiCepat Express (SICEPAT)',
        'j&t'       => 'J&T Express (J&T)',
        'pahala'    => 'Pahala Kencana Express (PAHALA)',
        'jet'       => 'JET Express (JET)',
    ];

    public function __construct()
    {
        $this->apiKey         = config('rajaongkir.api_key');
        $this->baseUrl        = config('rajaongkir.base_url');
        $this->provinceUrl    = $this->baseUrl . 'province';
        $this->cityUrl        = $this->baseUrl . 'city';
        $this->subdistrictUrl = $this->baseUrl . 'subdistrict';
        $this->costUrl        = $this->baseUrl . 'cost';
        $this->response       = collect();
    }

    /**
     * Curl request API caller.
     *
     * @param string $url
     * @param array $params
     * @param string $type
     *
     * @return  object|error Throw error if failed.
     */
    public function apiRequest(string $url, array $params = [], $type = 'get')
    {
        $request = Http::withHeaders(['key' => $this->apiKey]);
        $response = $type === 'get' ? $request->get($url, $params) : $request->post($url, $params);
        $successfulResponse = $response->successful() && $response->object()->rajaongkir->status->description === 'OK';

        if($successfulResponse) {
            $this->response = $response->object()->rajaongkir->results;

            return $this;   
        } 
    
        return $response->throw();
    }

    /**
     * @return  collection|error Throw error if failed.
     */
    public function courier()
    {
        $this->response = collect($this->couriersList)->sort();

        return $this;
    }

    /**
     * @return  collection|error Throw error if failed.
     */
    public function get()
    {
        return collect($this->response);
    }

    /**
     * Get list of provinces.
     *
     * @return  object|error Throw error if failed.
     */
    public function provinces()
    {
        return $this->apiRequest($this->provinceUrl);
    }

    /**
     * Get detail of single province.
     *
     * @param string $provinceId Province ID
     *
     * @return  object|error Throw error if failed.
     */
    public function province(string $provinceId)
    {
        $params = ['id' => $provinceId];

        return $this->apiRequest($this->provinceUrl, $params);
    }

    /**
     * Get list of cities.
     *
     * @return  object|error Throw error if failed.
     */
    public function cities()
    {
        return $this->apiRequest($this->cityUrl);
    }

    /**
     * Get detail of single city.
     *
     * @param string $cityId City ID
     *
     * @return  array|error Throw error if failed.
     */
    public function city(string $cityId)
    {
        $params = ['id' => $cityId];

        return $this->apiRequest($this->cityUrl, $params);
    }

    /**
     * Get list of province cities.
     *
     * @param string $provinceId Province ID
     *
     * @return  object|error Throw error if failed.
     */
    public function cityByProvince(string $provinceId)
    {
        $params = ['province' => $provinceId];

        return $this->apiRequest($this->cityUrl, $params);
    }

    /**
     * Get detail of single subdistrict.
     *
     * @param string $subdistrictId Subdistrict ID
     *
     * @return  array|error Throw error if failed.
     */
    public function subdistrict(string $subdistrictId)
    {
        $params = ['id' => $subdistrictId];

        return $this->apiRequest($this->subdistrictUrl, $params);
    }

    /**
     * Get list of city subdistricts.
     *
     * @param string $cityId City ID
     *
     * @return  object|error Throw error if failed.
     */
    public function subdistrictByCity(string $cityId)
    {
        $params = ['city' => $cityId];

        return $this->apiRequest($this->subdistrictUrl, $params);
    }

    /**
     *
     * Get cost calculation.
     *
     * @param array $origin ID kota/kabupaten atau kecamatan asal
     * @param array $destination ID kota/kabupaten atau kecamatan tujuan
     * @param array $weight Berat kiriman dalam gram
     * @param string $courier Courier Code
     *
     * @return  object|error Throw error if failed.
     * @see      https://rajaongkir.com/dokumentasi/pro#cost-ringkasan
     *
     */
    public function getCost(string $origin, string $destination, int $weight, string $courier ) 
    {
        $params['courier']         = strtolower( $courier );
        $params['originType']      = 'subdistrict';
        $params['destinationType'] = 'subdistrict';
        $params['weight']          = $weight;
        $params['origin']          = $origin;
        $params['destination']     = $destination;
        $cost = $this->apiRequest($this->costUrl, $params, 'post')->get();
        
        return $this->formatCost($cost);
    }

    /**
     *
     * format cost return from api into proper format.
     *
     * @param cost $cost object return from api
     *
     * @return  object|error Throw error if failed.
     */
    public function formatCost($cost)
    {
        $cost     = $cost[0];
        $services = $cost->costs;
        $formattedCost = [];
        $formattedCost['courierCode'] = $cost->code;
        $formattedCost['courierName'] = $cost->name;
        $formattedCost['services'] = [];

        foreach($services as $service) {
            $courierService      = $service->cost[0];
            $arr['service']      = $service->service;
            $arr['description']  = $service->description;
            $arr['cost']         = $courierService->value;
            $arr['costRupiah']   = 'Rp '.\Helper::number_formats($service->cost[0]->value, 'view', 0);
            $arr['estimatedDay'] = $courierService->etd == '1-1' ? '1 Hari' : $courierService->etd . ' Hari';
            $arr['note']         = $courierService->note;

            array_push($formattedCost['services'], $arr);
        }
        
        return $formattedCost;
    }
}