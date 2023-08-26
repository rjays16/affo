<?php 
require_once 'vendor/autoload.php';
use GuzzleHttp\Client as GuzzleClient;

class factset {
    private $baseURL = "https://api.factset.com/";
    private $apiSerial;
    private $apiKey;

    private $gzClient;

    private $db;
    private $cacheDB;
    private $cacheDBUser;
    private $cacheDBPass;
    private $cacheDBMode = array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    
    public function __construct() {
        if ($_SERVER['SERVER_ADDR'] == '134.209.40.60') {
            $envPrefix = 'members';
        } else {
            $envPrefix = 'memdemo';
        }
        include("/home/ireitmember/web/$envPrefix.ireitinvestor.com/memSecret.php");

        $this->apiSerial = $secretCFG['fs']['apiSerial'];
        $this->apiKey = $secretCFG['fs']['apiKey'];

        $this->gzClient = new GuzzleClient([
            'base_uri' => $this->baseURL,
            'timeout' => 6.0,
            'http_errors' => false
        ]);
        
        $this->cacheDB = 'mysql:host='.$secretCFG['db']['host'].';dbname='.$secretCFG['db']['dbname'].';charset=utf8';
        $this->cacheDBUser = $secretCFG['db']['dbuser'];
        $this->cacheDBPass = $secretCFG['db']['dbpass'];
        
        try {
            $dbstring = $this->cacheDB;
            $this->db = new PDO($dbstring, $this->cacheDBUser, $this->cacheDBPass, $this->cacheDBMode);
        } catch (PDOException $e) {
            return false; /* DB CONNECTION NOT FOUND */
        }

        unset($secretCFG);
    }
    
//     public function getRollingConsensus($asset_id, $metrics, $start_date, $end_date, $frequency, $relative_fiscal_start, $relative_fiscal_end, $periodicity, $currency) {
//         $endpoint = "/content/factset-estimates/v2/rolling-consensus";
//         $params = array();
//         $params['headers'] = array(
//             'Accept'     => 'application/json',
//             'Content-Type' => 'application/json'
//         );
//         $params['auth'] = array($this->apiSerial, $this->apiKey);
//         $params['debug'] = false;
//         $params['query'] = array(
//             'ids' => [$asset_id],
//             'metrics' => [$metrics],
//             'startDate' => $start_date,
//             'endDate' => $end_date,
//             'frequency' => $frequency,
//             'relativeFiscalStart' => $relative_fiscal_start,
//             'relativeFiscalEnd' => $relative_fiscal_end,
//             'periodicity' => $periodicity,
//             'currency' => $currency
//         );

//         // var_dump($params);
//         // die();
//         $response = $this->gzClient->request('POST', $endpoint, $params);

//         return $response;
// /*
//         if ($http_code == 200) {
//             $data = json_decode($response, true);
//             return $data;
//         } else {
//             return "API request failed: HTTP $http_code";
//         }
// */
//     }

    // Working to getRollingConsensusData 
    public function getRollingConsensus($asset_id, $metrics, $start_date, $end_date, $frequency, $relative_fiscal_start, $relative_fiscal_end, $periodicity, $currency) {
        $endpoint = $baseURL."/content/factset-estimates/v2/rolling-consensus";
        $params = array(
            'headers' => array(
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ),
            'auth' => array($this->apiSerial, $this->apiKey),
            'json' => array(
                'ids' => array($asset_id),
                'metrics' => array($metrics),
                'startDate' => $start_date,
                'endDate' => $end_date,
                'frequency' => $frequency,
                'relativeFiscalStart' => $relative_fiscal_start,
                'relativeFiscalEnd' => $relative_fiscal_end,
                'periodicity' => $periodicity,
                'currency' => $currency
            ),
            'debug' => false
        );
    
        try {
            $response = $this->gzClient->request('POST', $endpoint, $params);
            return $response;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle the exception if needed
            return $e->getResponse();
        }
    }
    


    public function getFundamentals($asset_id, $metrics, $start_date, $end_date, $periodicity, $currency) {
        $endpoint = "/content/factset-fundamentals/v1/fundamentals";
        $params = array();
        $params['headers'] = array(
            'Accept'     => 'application/json',
            'Content-Type' => 'application/json'
        );
        $params['auth'] = array($this->apiSerial, $this->apiKey);
        $params['debug'] = false;
        $params['json'] = array(
            'ids' => [$asset_id],
            'metrics' => [$metrics],
            'fiscalPeriodStart' => $start_date,
            'fiscalPeriodEnd' => $end_date,
            'periodicity' => $periodicity,
            'currency' => $currency
        );

        $response = $this->gzClient->request('GET', $endpoint, $params);

        //var_dump($response);
        //echo $response->getBody();

        return json_decode($response->getBody());
    /*
        if ($http_code == 200) {
            $data = json_decode($response, true);
            return $data;
        } else {
            return "API request failed: HTTP $http_code";
        }
    */
    }

    public function DividendPerShare($asset_id, $category, $subcategory, $start_date, $end_date, $frequency, $relative_fiscal_start, $relative_fiscal_end, $periodicity, $currency) {
        $endpoint = "/content/factset-estimates/v2/metrics";
        $params = array();
        $params['headers'] = array(
            'Accept'     => 'application/json',
            'Content-Type' => 'application/json'
        );
        $params['auth'] = array($this->apiSerial, $this->apiKey);
        $params['debug'] = false;
        $params['query'] = array(
            'ids' => [$asset_id],
            'category' => $category,
            'subcategory' => $subcategory,
            'startDate' => $start_date,
            'endDate' => $end_date,
            'frequency' => $frequency,
            'relativeFiscalStart' => $relative_fiscal_start,
            'relativeFiscalEnd' => $relative_fiscal_end,
            'periodicity' => $periodicity,
            'currency' => $currency
        );
    
        $response = $this->gzClient->request('GET', $endpoint, $params);

        return $response;
    }
}
?>