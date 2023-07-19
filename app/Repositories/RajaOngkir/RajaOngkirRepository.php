<?php

namespace App\Repositories\RajaOngkir;

use App\Services\RajaOngkir\RajaOngkirService;

class RajaOngkirRepository
{
    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function getProvinces()
    {
        $provinces = $this->rajaOngkir->provinces()->get();
        $provinces = collect(json_decode($provinces));

        return $provinces;
    }

    public function getProvinceById($id)
    {
        $province = $this->rajaOngkir->province($id)->get()['province'];

        return $province;
    }

    public function getCities()
    {
        $cities = $this->rajaOngkir->city()->get();
        $cities = collect(json_decode($cities));    

        return $cities;
    }

    public function getCityById($id)
    {
        $city = $this->rajaOngkir->city($id)->get()['city_name'];

        return $city;
    }

    public function getSubdistrictById($id)
    {
        $subdistrict = $this->rajaOngkir->subdistrict($id)->get()['subdistrict_name'];

        return $subdistrict;
    }

    public function getSubdistrictDetailById($id)
    {
        $subdistrict = $this->rajaOngkir->subdistrict($id)->get();

        return $subdistrict;
    }
    
    public function getCouriers()
    {
        return $this->rajaOngkir->courier()->get();
    }

    public function getCourierById($id)
    {
        $courier = $this->rajaOngkir->courier()->get()[$id];

        return $courier;
    }

    public function getCitiesByProvince($provinceId)
    {
        $cities = $this->rajaOngkir->cityByProvince($provinceId)->get();
        $cities = collect(json_decode($cities));

        return $cities;
    }

    public function getSubdistrictsByCity($cityId)
    {
        $subdistricts = $this->rajaOngkir->subdistrictByCity($cityId)->get();

        return $subdistricts;
    }

    public function getAddress($subdistrictId)
    {
        if(is_null($subdistrictId)) return '-';

        $address = $this->rajaOngkir->subdistrict($subdistrictId)->get();

        return $address['subdistrict_name'] .', '. $address['city'] .', '. $address['province'];
    }

    public function getCost($subdistrictId, $subdistrictDestination, $berat, $kurir)
    {
        return $this->rajaOngkir->getCost($subdistrictId, $subdistrictDestination, $berat, $kurir);
    }
}