<?php
$data = json_decode(file_get_contents('php://input'), TRUE);
$jsonData = json_encode($data['jsonData']);
$filename = $data['filename'];
file_put_contents('generated_json/'.$filename.'.json', $jsonData);