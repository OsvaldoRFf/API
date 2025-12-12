<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class RestCountriesService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.restcountries.url');
    }

    /**
     * Obtener todos los países
     */
    public function getAllCountries(): array
    {
        return $this->request('/all');
    }

    /**
     * Buscar país por nombre
     */
    public function getCountryByName(string $name): array
    {
        return $this->request("/name/{$name}");
    }

    /**
     * Buscar país por código
     */
    public function getCountryByCode(string $code): array
    {
        return $this->request("/alpha/{$code}");
    }

    /**
     * Método centralizado para peticiones HTTP
     */
    protected function request(string $endpoint): array
    {
        try {
            $response = Http::timeout(10)->get($this->baseUrl . $endpoint);

            if ($response->failed()) {
                return [
                    'error' => true,
                    'status' => $response->status(),
                    'message' => 'Error al consultar RestCountries'
                ];
            }

            return $response->json();

        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
