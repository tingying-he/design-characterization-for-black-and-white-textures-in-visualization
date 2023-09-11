<?php
// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Set the path to the CSV file
$filename = "../../results/measurements.csv";

// Check if CSV file exists; if not, create it and add headers
if (!file_exists($filename)) {
    $headers = array_keys($data);
    $headerString = implode(",", $headers);
    file_put_contents($filename, $headerString . PHP_EOL);
}

// Get the existing CSV content
$csvData = file_get_contents($filename);

// Find the header keys and their positions
$headers = str_getcsv(trim(explode(PHP_EOL, $csvData)[0]));
$headerPositions = array_flip($headers);

// Initialize the row with empty values
$row = array_fill(0, count($headers), '');

// Fill in the row with values from the data array
foreach ($data as $key => $value) {
    if (isset($headerPositions[$key])) {
        $row[$headerPositions[$key]] = $value;
    }
}

// Append the row to the CSV content
$rowString = implode(",", $row);
file_put_contents($filename, $csvData . $rowString . PHP_EOL);
?>