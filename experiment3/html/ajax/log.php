<?php 
/*
 This file will generate our CSV table. There is nothing to display on this page, it is simply used
 to generate our CSV file and then exit. 
*/

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
//$write_single_line_per_participant = true;
//$myheader = null;
//$myflags = null;
//$data = null;
//
//if ($write_single_line_per_participant){
//	// convert the sent data into a flat array
//	$data = json_decode(file_get_contents('php://input'), true);
//
//	if ($data){
//		// write individual file
//		$indiv_file = "../../results/individual/" . $data["participant_id"] . '.csv';
//		// $exists = file_exists($indiv_file);
//		// $indiv_handle = fopen($indiv_file, "a+");
//
//		// write a column header
//		// if (!$exists) {
//		// 	fwrite($indiv_handle, $LOG_HEADER . PHP_EOL);
//		// }
//
//		// add the received data to the file
//		// fputcsv($indiv_handle, $data);
//		// // close the file
//		// fclose($indiv_handle);
//
//
//		$myflags = LOCK_EX | FILE_APPEND;
//	}
//
//} else {
//
//	// convert the sent data into an array
//	$data = json_decode(file_get_contents('php://input'), $flags = JSON_OBJECT_AS_ARRAY);
//	if ($data){
//		$myheader = ["participant_id", "trial", "filter", "image", "recognize", "difficult"];
//		// write individual file
//		$indiv_file = "../../results/individual/" . $data[0][0] . '.csv';
//		// $exists = file_exists($indiv_file);
//		$myflags = LOCK_EX;
//	}
//}
//if($data){
//	$handle = fopen("php://output", "w");
//	ob_start();
//	// write a column header
//	if ($myheader && count($myheader) > 0){
//		fputcsv($handle, $myheader);
//	}
//	// check if we have multiple lines
//	if (count($data) != count($data, COUNT_RECURSIVE)){
//	// write all lines
//		foreach ($data as $dat) {
//		    fputcsv($handle, $dat);
//		}
//	} else {
//		fputcsv($handle, $data);
//
//	}
//	$csvContent = ob_get_clean();
//
//	echo file_put_contents($indiv_file, $csvContent, $flags = $myflags);
//}
//
//
//exit;

?>
