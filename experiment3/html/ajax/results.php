<?php //header("Cache-Control: no-cache, must-revalidate");
// session_start();

/*
 This file will generate our CSV table. There is nothing to display on this page, it is simply used
 to generate our CSV file and then exit. That way we won't be re-directed after pressing the export
 to CSV button on the previous page.
*/
//
//// convert the sent data into a flat array
//$data = json_decode(file_get_contents('php://input'), true);
//var_dump($data);
//
//// extract the headers from the array
//$headers = array_keys($data);
//
//// our main csv file
//$file_name = '../../results/results.csv';
//$exists = file_exists($file_name);
//
//// open a file handle to append new data
//$handle = fopen($file_name, 'a+');
//
//// if the file is empty, write a header line first
//if (!$exists){
//	fputcsv($handle, $headers);
//}
//
//// add the received data to the file
//fputcsv($handle, $data);
//
//// close the file
//fclose($handle);
//exit;

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Set the path to the CSV file
$filename = "../../results/results.csv";

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
