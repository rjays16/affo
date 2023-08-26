<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="container mt-5">
    <h2>Rolling Consensus Data</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Request ID</th>
            <th>FSYM ID</th>
            <th>Metric</th>
            <th>Fiscal Year</th>
            <th>Fiscal End Date</th>
            <th>Mean</th>
            <th>Median</th>
            <th>Standard Deviation</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $responseBody = $rollingConsensusData->getBody()->getContents();

        if (!empty($responseBody)) {
            $data = json_decode($responseBody, true);
            if (isset($data['data'])) {
                $perPage = 10;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $totalItems = count($data['data']);
                $startIndex = ($currentPage - 1) * $perPage;
                $dataSlice = array_slice($data['data'], $startIndex, $perPage);

                // Iterate through the data slice and display it in the table
                foreach ($dataSlice as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['requestId'] . '</td>';
                    echo '<td>' . $row['fsymId'] . '</td>';
                    echo '<td>' . $row['metric'] . '</td>';
                    echo '<td>' . $row['fiscalYear'] . '</td>';
                    echo '<td>' . $row['fiscalEndDate'] . '</td>';
                    echo '<td>' . $row['mean'] . '</td>';
                    echo '<td>' . $row['median'] . '</td>';
                    echo '<td>' . $row['standardDeviation'] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="8">No data available</td></tr>';
            }
        } else {
            echo '<tr><td colspan="8">Error retrieving data</td></tr>';
        }
        ?>
        </tbody>
    </table>
    <nav aria-label="Pagination">
        <ul class="pagination">
            <?php
            // Calculate and generate pagination links
            $totalPages = ceil($totalItems / $perPage);
            for ($page = 1; $page <= $totalPages; $page++) {
                $activeClass = ($page == $currentPage) ? ' active' : '';
                echo '<li class="page-item' . $activeClass . '"><a class="page-link" href="?page=' . $page . '">' . $page . '</a></li>';
            }
            ?>
        </ul>
    </nav>
</div>
