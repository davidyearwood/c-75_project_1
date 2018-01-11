<?php namespace App\HttpClient; 

use GuzzleHttp\Client; 
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\ClientException;

/**
 * @author David <dwhywood@gmail.com>
 *
 * 
 * API's @link https://www.quandl.com/tools/api (did not create)
 */

class QuandlClient 
{
    /**
     * 
     * Variables that are the host and path for the  
     * Quandl API. Expiration time is used for the 
     * caching. 
     * 
     */
    protected $hostname = 'https://www.quandl.com/';
    protected $path = 'api/v3/datasets/WIKI/';
    protected $expirationDateInMinutes = 720;
    protected $client; 
    protected $error; 
    
    /**
     * Instantiate's the http client 
     * 
     * 
     * @param Client 
     * @return QuandlAPi 
     */ 
    public function __construct(Client $httpClient) 
    {
        $this->client = $httpClient;
    }
    
    /**
     * Changes the default expiration date
     * 
     * @param Int
     * @return void 
     */
    public function setExpirationDateInMinutes($min) 
    {
        if (is_int($min)) {
            $this->expirationDateInMinutes = $min; 
        }
    }
    
    /**
     * Get the URL that is being used to retrieve 
     * the stock data. 
     * 
     * @param String $symbol
     * @return String
     */ 
    public function getURL($symbol) 
    {
        return $this->hostname . $this->path . $this->setFile($symbol);
    }
    
    /**
     * Retrieves the most recent stock data from
     * QuandlApi.
     * 
     * @throws ClientException 
     * 
     * @param String $symbol
     * @return Array
     */ 
    public function getStock($symbol)
    {
        $stock = Cache::remember($symbol, $this->expirationDateInMinutes, function() use($symbol){
            
            try {
                $request = $this->client->request('GET', $this->getURL($symbol));
            } catch (ClientException $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n"; // FOR DEV ENV ONLY
                // LOG ERROR
                // Internal server error redirect
            }
            
            if ($request->getStatusCode() === 200) {
                $body = json_decode($request->getBody()->getContents());
                $cachedData = [
                    'price' => $body->dataset->data[0][4],
                    'name' => $body->dataset->name,
                    'date' => $body->dataset->data[0][0],
                    'open' => $body->dataset->data[0][1],
                    'high' => $body->dataset->data[0][2],
                    'low' => $body->dataset->data[0][3],
                    'close' => $body->dataset->data[0][4],
                    'volume' => $body->dataset->data[0][5]
                ];
            } else {
                throw new Exception($request->getStatusCode()); 
            }
            
            return $cachedData;
                
        });
        
        return $stock; 
    }
    
    /**
     * Gets the error value
     * 
     * 
     * @return Array 
     */   
    public function getError() {
        $error = $this->error;
        $this->error = [];
        
        return $error;
    }
    
    /**
     * Creates a json file name
     * 
     * @param String $symbol
     * @return String 
     */
    private function setFile($symbol) 
    { 
        return $symbol . '.json';
    }
    
    /**
     * Sets the error array values
     * 
     * @param Array $e
     * @return void
     */    
    private function setError($e) {
        $this->error = [ 'api_error' => $e['api_error'],
                         'status_code' => $e['status_code'],
                         'message' => $e['message']]; 
    }
    
}