<?php

	$data = json_decode(file_get_contents('php://input'), true);

	$agree_filename = "../../results/consent.csv";
  $exists = file_exists($agree_filename);
  $agree_file = fopen($agree_filename, "a+");

  if (!$exists){
    fwrite($agree_file, "timestamp,participant_id,condition,study_id,session_id");
  }

  fwrite($agree_file,
    PHP_EOL .
    date(DateTime::ISO8601) . ',' .
    $data["participant_id"] . ',' .
    $data["condition"] . ',' .
    $data["study_id"] . ',' .
    $data["session_id"]
  );

  fclose($agree_file);
	exit;

?>
