<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    private $access_token;
    private $client;
    private $header;
    private $response;
    private $collection;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => env('END_POINT_RAPID_API'),
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        $this->header = [];

        if (\Session::has('access_token')) {
            $this->access_token = \Session::get('access_token');
        }
    }

    public function get($url, $options = [])
    {

//        self::captureData($options, "GET REQUEST - " . $url);
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => env('END_POINT_RAPID_API'),
            'defaults' => [
                'exceptions' => true
            ]
        ]);

        $this->header = [
            'Accept' => 'application/json',
            'x-rapidapi-host' => 'dev132-cricket-live-scores-v1.p.rapidapi.com',
            'x-rapidapi-key' => 'd37de1fd31mshb98f1f1302cc5d7p11ff67jsne88a584bc0c1',
        ];

        $postData = ['headers' => $this->header, 'query' => $options];

        try{
            $this->response = $this->client->get($url,$postData);
        }catch (RequestException $exp){
            $this->response = $exp->getResponse();
        }
        return $this;
    }


    public function getAuth($url, $options = [])
    {

        self::captureData($options, "GET REQUEST - " . $url);
        if (\Session::has('access_token')) {
            $this->access_token = \Session::get('access_token');
            $this->header = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Accept' => 'application/json',
            ];
        }

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => \Config::get('app.api_url'),
            'defaults' => [
                'exceptions' => false
            ],
        ]);

        if (isset($options['_token'])) {
            unset($options['_token']);
        }

        $postData = ['headers' => $this->header, 'query' => $options];

        try{
            $this->response = $this->client->get($url,$postData);
        }catch (RequestException $exp){
            $this->response = $exp->getResponse();
        }

        return $this;
    }


    public function put($url, $options = [], $files = [])
    {

        self::captureData($options, "POST REQUEST - " . $url);
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => \Config::get('app.api_url'),
            'defaults' => [
                'exceptions' => false
            ],
            'debug' => false,
            'http_errors' => false

        ]);




        if (\Session::has('access_token')) {

            $this->access_token = \Session::get('access_token');
            $this->header = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Accept' => 'application/json',
            ];
        }

        if ($files && is_array($files) && !empty ($files)) {

            if(isset($options['image']) || isset($options['panaromic_images'])){
                unset($options['image']);
                unset($options['panaromic_images']);
            }

            $data = $files;
            if(!empty($options)){

                foreach ($options as $key => $value) {
                    $data [] = [
                        'name' => $key,
                        'contents' => $value
                    ];
                }
            }


            $this->response = $this->client->put($url, [
                'headers' => $this->header,
                'multipart' => $data,

            ]);

        } else {

            $this->response = $this->client->put($url, [
                'headers' => $this->header,
                'form_params' => (array)$options
            ]);
        }

        return $this;
    }

    public function post($url, $options = [], $files = [],$isJson = false)
    {


        self::captureData($options, "POST REQUEST - " . $url);
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => \Config::get('app.api_url'),
            'defaults' => [
                'exceptions' => true
            ],
            'debug' => false,
            'http_errors' => false

        ]);


        if(isset($options['image']) || isset($options['panaromic_images'])){
            unset($options['image']);
            unset($options['panaromic_images']);
        }

        if (\Session::has('access_token')) {

            $this->access_token = \Session::get('access_token');
            $this->header = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Accept' => 'application/json',
            ];

        }else {
            $this->header = [
                'Accept' => 'application/json',
            ];
        }

        if ($files && is_array($files) && !empty ($files)) {


            $data = $files;
            foreach ($options as $key => $value) {
                $data [] = [
                    'name' => $key,
                    'contents' => $value
                ];
            }

            // dd($data);
            $this->response = $this->client->post($url, [
                'headers' => $this->header,
                'multipart' => $data,
            ]);

        }elseif (is_array($options)) {

            $this->response = $this->client->post($url, [
                'headers' => $this->header,
                'form_params' => (array)$options
            ]);
        }
        else {

            $this->response = $this->client->post($url, [
                'headers' => $this->header,
                'json' => $options
            ]);

        }
        return $this;
    }

    public function json_post($url, $options = [], $files = [])
    {


        self::captureData($options, "JSON POST REQUEST - " . $url);
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => \Config::get('app.api_url'),
            'defaults' => [
                'exceptions' => true
            ],
            'debug' => false,
            'http_errors' => false

        ]);


        if(isset($options['image'])){
            unset($options['image']);
        }

        if (\Session::has('access_token')) {

            $this->access_token = \Session::get('access_token');
            $this->header = [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Accept' => 'application/json',
            ];


        }else {
            $this->header = [
                'Accept' => 'application/json',
            ];
        }

        if ($files && is_array($files) && !empty ($files)) {


            $data = $files;
            foreach ($options as $key => $value) {
                $data [] = [
                    'name' => $key,
                    'contents' => $value
                ];
            }

            $this->response = $this->client->post($url, [
                'headers' => $this->header,
                'multipart' => $data,

            ]);


        }else{

            $this->response = $this->client->post($url, [
                'headers' => $this->header,
                'json' => (array)$options
            ]);
        }
        return $this;
    }

    public function delete($url, $options = [])
    {
        self::captureData($options, "DELETE REQUEST - " . $url);

        if (isset($options['_token'])) {
            unset($options['_token']);
        }
        if (!is_null($this->access_token)) {
            $options['access_token'] = $this->access_token;
        }


        $this->response = $this->client->delete($url, [
            'json' => $options,
        ]);

        return $this;
    }

    public function patch($url, $options = [])
    {
        if (isset($options['_token'])) {
            unset($options['_token']);
        }
        if (!is_null($this->access_token)) {
            $options['access_token'] = $this->access_token;
        }
        $this->response = $this->client->patch($url, [
            'body' => $options
        ]);
        return $this;
    }


    public function getResponseData()
    {
        switch ($this->response->getStatusCode()) {
            case 401:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 400:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 403:

                $data = json_decode($this->response->getBody()->getContents());
                return [
                    'success' => false,
                    'description' => $data->detail,
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 422:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 412:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 404:

                $data = json_decode($this->response->getBody()->getContents());
                return [
                    'success' => false,
                    'description' => $data->description,
                    'data' => $data->payload,
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 500:
                $data = json_decode($this->response->getBody()->getContents());
                return [
                    'success' => false,
                    'description' => $data->description,
                    'data' => $data->payload,
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 502:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 200:

                $data = json_decode($this->response->getBody()->getContents());

                return [
                    'success' => $data->success,
                    'data' => $data->payload,
                    'description' => $data->description,
                    'status_code' => $this->getResponseCode()
                ];
                break;
            default:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
        }
    }
    public function getResponse()
    {

        switch ($this->response->getStatusCode()) {
            case 401:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 400:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 403:
                $data = json_decode($this->response->getBody()->getContents());
                // dd($data);
                return [
                    'success' => false,
                    'description' => $data->detail,
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 422:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 412:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 404:

                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 500:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 502:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            case 200:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
            default:
                return [
                    'data' => json_decode($this->response->getBody()->getContents()),
                    'status_code' => $this->getResponseCode()
                ];
                break;
        }
    }


    public function getOtherResponse($response)
    {

        switch ($response['status_code']) {
            case 401:
                return $response['data']->description;
                break;
            case 400:
                return $response['data']->description;
                break;
            case 403:
                return $response['data']->detail;
                break;
            case 422:
                return $response['data']->description;
                break;
            case 412:
                return $response['data']->description;
                break;
            case 404:
                return $response['data']->description;
                break;
            case 500:
                return $response['data']->description;
                break;
            case 201:
                return $response['data']->description;
                break;
            default:
                return $response['data']->description;
                break;
        }
    }

    public function getExceptiponResponse($code)
    {

        $message = 'Something went wrong.';
        switch ($code) {
            case 401:
                $message = 'Something went wrong.';
                break;
            case 400:
                $message = 'Something went wrong.';
                break;
            case 403:
                $message = 'Something went wrong.';
                break;
            case 422:
                $message = 'Something went wrong.';
                break;
            case 412:
                $message = 'Something went wrong.';
                break;
            case 404:
                $message = 'Something went wrong.';
                break;
            case 500:
                $message = 'Something went wrong.';
                break;
            case 201:
                $message = 'Something went wrong.';
                break;
            default:
                $message = 'Something went wrong.';
                break;


                return $message;
        }
    }

    public function getResponseBody()
    {
        if ($this->response) {
            self::captureData($this->response->getBody()->getContents(), ' INCOMING DATA - GET RESPONSE BODY');
        }
        return $this->response->getBody()->getContents();
    }

    public function getResponseCode()
    {
        return $this->response->getStatusCode();
    }

    public function collection(array $dataSet)
    {
        $this->collection = new \Illuminate\Support\Collection($dataSet);
        return $this;
    }

    public function authorizeActions()
    {

        if (!is_null($this->collection)) {
            if ($this->collection->has('data')) {
                $this->collection = $this->collection->map(function ($object) {
                    if (is_array($object)) {
                        foreach ($object as $key => $array) {
                            $object[$key] = array_merge($array, $this->getAllowedActions($array));
                        }
                    }
                    return $object;
                });
            }
        }
        return $this->collection;
    }

    public function collectionToArray()
    {
        if (!is_null($this->collection)) {
            return $this->collection->toArray();
        }
        return [];
    }

    public function collectionToJson()
    {
        if (!is_null($this->collection)) {
            return $this->collection->toJson();
        }
        return [];
    }

    public function paginate(
        $filters = [],
        $items,
        $perPage = 15,
        $page = null,
        $baseUrl = null,
        $options = [],
        $total_items = 0
    ) {

        $page = $page ?: (Pagination\LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $lap = new Pagination\LengthAwarePaginator($items, $total_items, $perPage, $page, $options);

        if ($baseUrl) {
            $lap->setPath($baseUrl);
        }

        $lap->appends($filters);
        return $lap;
    }
}
