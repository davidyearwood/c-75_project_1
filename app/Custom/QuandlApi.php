<?php
namespace App\Custom\Quandl;

use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client; 

class QuandlAPI 
{
    protected $hostname = 'https://www.quandl.com/';
    protected $path = 'api/v3/datasets/WIKI/';
    protected $expirationDateInMinutes = 720;
    
    public function __construct() 
    {
    
    }
    
    
    public function getURL($symbol) 
    {
        return $this->hostname . $this->path . $this->setFile($symbol);
    }
    
    public function getStock($symbol)
    {
        $resource = Cache::remember($symbol, $this->expirationDateInMinutes, function() use($symbol){
            $client = new Client();
            $response = $client->request('GET', $this->getURL($symbol));
            $statusCode = $response->getStatusCode();
            
            if ($statusCode > 100 && $statusCode < 300) {
                $httpBody = json_decode($response->getBody()->getContents());
                $d = ['price' => $httpBody->dataset->data[0][4],
                      'name' => $httpBody->dataset->name,
                      'date' => $httpBody->dataset->data[0][0],
                      'open' => $httpBody->dataset->data[0][1],
                      'high' => $httpBody->dataset->data[0][2],
                      'low' => $httpBody->dataset->data[0][3],
                      'close' => $httpBody->dataset->data[0][4],
                      'volume' => $httpBody->dataset->data[0][5]
                      ];
                      
                return $d; 
            }
        });
        
        return $resource; 
    }
    
    private function setFile($symbol) 
    { 
        return $symbol . '.json';
    }
}