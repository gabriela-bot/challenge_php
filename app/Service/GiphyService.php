<?php

namespace App\Service;

use App\Exceptions\InvalidApi;
use Exception;
use Illuminate\Support\Facades\Http;

class  GiphyService
{

    protected $baseUrl;
    protected $apiKey;

    public function __construct(string $baseUrl = null, string $apiKey = null)
    {
        $this->setBaseUrl($baseUrl);
        $this->setApiKey($apiKey);
    }

    public function searchGif(string $q, int $limit = 25,int $offset = 0)
    {
        try {

            $response = Http::baseUrl($this->getBaseUrl())
                ->withQueryParameters([
                    'api_key' => $this->getApiKey(),
                    'q' => $q,
                    'limit' => $limit,
                    'offset' => $offset
                ])->get('/gifs/search');

            if($response->ok()){
                return $response->json()['data'];
            }

        } catch (Exception $exception){
            throw new InvalidApi([
                'meta' => [
                    'msg' => $exception->getMessage(),
                    'status' => 500
                ]
            ]);
        }

        throw new InvalidApi($response->json());

    }

    public function getById(string $id, bool $returnEmptyOnError = false)
    {
        try {

            $response = Http::baseUrl($this->getBaseUrl())
                ->withUrlParameters([
                    'id' => $id,
                ])
                ->withQueryParameters([
                    'api_key' => $this->getApiKey(),
                ])->get('/gifs/{id}');

            if($response->ok()){
                return $response->json()['data'];
            }

        } catch (Exception $exception){
            if ($returnEmptyOnError) {
                return [];
            }

            throw new InvalidApi([
                'meta' => [
                    'msg' => $exception->getMessage(),
                    'status' => 500
                ]
            ]);
        }

        if ($returnEmptyOnError) {
            return [];
        }

        throw new InvalidApi($response->json());
    }


    public function setBaseUrl(string $url = null)
    {
        if($url){
            $this->baseUrl = $url;
        }  else {
            $this->baseUrl = config('giphy.base_url');
        }
        return $this;
    }

    public function getBaseUrl() : string
    {
        return $this->baseUrl;
    }


    public function setApiKey(string $key = null)
    {
        if($key){
            $this->apiKey = $key;
        }  else {
            $this->apiKey = config('giphy.api_key');
        }
        return $this;
    }

    public function getApiKey() : string
    {
        return $this->apiKey;
    }

}
