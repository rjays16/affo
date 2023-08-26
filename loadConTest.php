<?php
//error_reporting(E_ERROR | E_WARNING);
//include 'includes/saveSession.php';
//include 'includes/dbi_connect.php';

include 'includes/factset.php';

$fc = new factset();

$fields = array(
	'FirstName'	=> 'Mark',
	'LastName'	=> 'Schneider',
	'Email'		=> 'schneiders11@hotmail.com',
	'Password'	=> '44444444',
	'Price'	=> '44444444'
);


$asset_id = 'AAPL-USA';
$metrics = 'SALES';
$start_date = '2018-01-01';
$end_date = '2023-08-25';
$frequency = 'D';
$relative_fiscal_start = 1;
$relative_fiscal_end = 3;
$periodicity = 'ANN';
$currency = 'USD';

$rollingConsensusData = $fc->getRollingConsensus($asset_id, $metrics, $start_date, $end_date, $frequency, $relative_fiscal_start, $relative_fiscal_end, $periodicity, $currency);

//($asset_id, $metrics, $start_date, $end_date, $frequency, $relative_fiscal_start, $relative_fiscal_end, $periodicity, $currency)
//$cust = $fc->getRollingConsensus('AAPL-USA','SALES','2019-07-30','2020-07-30','AY',1,2,'ANN','USD');

//($asset_id, $metrics, $start_date, $end_date, $frequency, $periodicity, $currency)
$grpID = $fc->getFundamentals('AAPL-USA','FF_SALES','2019-07-30','2020-07-30','ANN','USD');

// echo "<pre>";
// print_r($grp);
// echo "</pre>";


$responseBody = $rollingConsensusData->getBody()->getContents();
// $dataArray = json_encode($rollingConsensusData, true);


if ($responseBody === null) {
    echo "Error decoding JSON response.";
} else {
    echo($responseBody);
}


?>