<?php
require_once('affo.php');

$affo_2018 = [20.6877, 1.3488, 5.41, 9.718572, 0.876, 4.03, 2.8844445, 3.314664, 1.558];
$affo_2022 = [29.55, 1.730392, 7.67, 13.472, 1.525, 5.76, 4.6847205, 6.51, 2.3966668];
$affo_2023 = [31.580322, 1.9092599, 8.20687, 14.3092, 1.7516667, 5.950237, 4.5821233, 6.572547, 2.5709147];
$affo_2024 = [34.269344, 2.12062, 8.51833, 15.595152, 2.0316668, 6.2513666, 4.69925, 7.045338, 2.736098];

$calculator = new affo($affo_2018, $affo_2022, $affo_2023, $affo_2024);

$growth_5y = $calculator->calculate_growth_5y();
$growth_current_year = $calculator->calculate_growth_current_year();
$affo_estimate_2y_fwd = $calculator->calculate_affo_estimate_2y_fwd();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adjusted funds from operations</title>
</head>
<body>
<h1>Quality Score Model</h1>
<h2>AFFO Growth (5Y)</h2>
<pre><?php print_r($growth_5y); ?></pre>

<h2>AFFO Growth (Current Year)</h2>
<pre><?php print_r($growth_current_year); ?></pre>

<h2>AFFO Estimate (2Y FWD)</h2>
<pre><?php print_r($affo_estimate_2y_fwd); ?></pre>
</body>
</html>
