<?php //header("Cache-Control: no-cache, must-revalidate");
// session_start();

/*
 This file will generate our CSV table. There is nothing to display on this page, it is simply used
 to generate our CSV file and then exit. That way we won't be re-directed after pressing the export
 to CSV button on the previous page.
*/
$configFileContents = file_get_contents("../setup/config/config.json");
$config = json_decode($configFileContents, true);


$data = json_decode(file_get_contents('php://input'), $flags = JSON_OBJECT_AS_ARRAY);

$header = ["participant_id", "condition", "trial", "filter", "image", "recognize", "difficult"];
// write individual file
$indiv_file = "../../results/trial-log.csv";
$exists = file_exists($indiv_file);

$handle = fopen("php://output", "w");
ob_start();
// write a column header
if (!$exists) {
	fputcsv($handle, $header);
}
foreach ($data as $dat) {
    fputcsv($handle, $dat);
}
$csvContent = ob_get_clean();

echo file_put_contents($indiv_file, $csvContent, $flags = FILE_APPEND | LOCK_EX);

// if we used a file to assign the participant and if the name of that file was written into the condition field, move the file assigned to the participant from the 'in_use' to the 'used' folder
if (file_exists('../setup/' . $config["stimuli_order_files"]["directory_name"] . '/in_use/' . $data[1][1])){
	$cwd = getcwd();
	chdir('../setup/' . $config["stimuli_order_files"]["directory_name"]);
	$pid_file = $data[1][1];
	// move the file and return a message if it worked or not.
	echo rename('in_use/' . $pid_file , 'used/' . $pid_file) ? 'Server moved order file on used pile' : 'Error moving order file ' . $pid_file;
	
	// check if there are abandoned files from participants who timed out
	if (isset($config["stimuli_order_files"]["time_out"])){
		$time_out = $config["stimuli_order_files"]["time_out"] * 60 * 60;
		$now = time();
		// go through all files in the in_use folder and check when they were last modified.
		chdir('in_use/');
		$files = glob('*.csv');
		// make sure there is at least 1
		if (count($files) > 0){
		  for ($i=0; $i < count($files); $i++) { 
		  	$ts = filemtime($files[$i]);
		  	if ($now - $ts > $time_out){
		  		echo rename($files[$i] , '../unused/'.  $files[$i]) ? 'Moved back file ' . $files[$i] : 'Failed to move file ' . $files[$i];
		  	}
		  }
		}
	}


	// set the old working directory back
	chdir($cwd);
}


exit;
?>
