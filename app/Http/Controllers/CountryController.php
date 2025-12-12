<?php

namespace App\Http\Controllers;

use App\Services\RestCountriesService;

class CountryController extends Controller
{
    protected RestCountriesService $countries;

    public function __construct(RestCountriesService $countries)
    {
        $this->countries = $countries;
    }

    public function index()
    {
        return response()->json(
            $this->countries->getAllCountries()
        );
    }

    public function show($name)
    {
        return response()->json(
            $this->countries->getCountryByName($name)
        );
    }
}
