<?php

    $data = json_decode(file_get_contents('php://input'), true);

    $excluded_filename = "../../results/excluded.csv";
    $exists = file_exists($excluded_filename);
    $excluded_file = fopen($excluded_filename, "a+");

    if (!$exists) {
        fwrite($excluded_file, "timestamp,participant_id,condition,study_id,session_id,browser_name,browser_version,os,failed_attention_check,reloaded");
    }

    $reloaded = $data["reloaded"] ? ",0,1" : ",1,0"; // tests whether the user reloaded or didnt pass the att. check
    fwrite(
        $excluded_file,
        PHP_EOL .
        date(DateTime::ISO8601) . ',' .
        $data['participant_id'] . ',' .
        $data['condition']      . ',' .
        $data['study_id']       . ',' .
        $data['session_id']     . ',' .
        $data['browser_name']   . ',' .
        $data["browser_version"]. ',' .
        $data["os"] . $reloaded
    );

    fclose($excluded_file);
    exit;

?>
