<?php
/*
 This file will generate our CSV table for each individual participant. It only logs the information related to real experiments (saved in the variable called trial_measure)
*/

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Set the path to the CSV file
$filename = "../../results/individual_texture/" . $data["participant_id"] . '.csv';

// Check if the CSV file exists
if (!file_exists($filename)) {
    // If it doesn't exist, create it with the headers as the first row
    $fp = fopen($filename, 'w');
    fputcsv($fp, array_keys($data));
}else{
    // Add the data to the CSV file as a new row
    $fp = fopen($filename, 'a');
}
fputcsv($fp, $data);
fclose($fp);

?>