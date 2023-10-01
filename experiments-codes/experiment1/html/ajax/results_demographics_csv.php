<?php

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Set the path to the CSV file
$filename = "../../results/results_demographics.csv";

// Check if the CSV file exists
if (!file_exists($filename)) {
    // If it doesn't exist, create it with the headers as the first row
    $fp = fopen($filename, 'w');
    fputcsv($fp, array_keys($data));
    fclose($fp);
}

// Add the data to the CSV file as a new row
$fp = fopen($filename, 'a');
fputcsv($fp, array_values($data));
fclose($fp);

?>