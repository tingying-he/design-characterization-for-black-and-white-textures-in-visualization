<?php
$data = json_decode(file_get_contents('php://input'), TRUE);
$jsonData = json_encode($data['parameters']);
$filename = $data['filename'];
file_put_contents('../../results/parameters/'.$filename.'.json', $jsonData);