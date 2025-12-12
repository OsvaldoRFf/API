<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function index()
    {
        // Petición a la API de países
        $response = Http::get('https://restcountries.com/v3.1/all');

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo conectar a la API'], 500);
        }

        // Convertimos la respuesta a un arreglo
        $countries = $response->json();

        return view('countries.index', compact('countries'));
    }

    public function show($name)
    {
        $response = Http::get("https://restcountries.com/v3.1/name/{$name}");

        if ($response->failed()) {
            return response()->json(['error' => 'País no encontrado'], 404);
        }

        $country = $response->json()[0] ?? null;

        return view('countries.show', compact('country'));
    }
}
