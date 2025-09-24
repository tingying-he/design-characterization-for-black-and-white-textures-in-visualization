<?php
$data = json_decode(file_get_contents('php://input'), TRUE);
$pngData = $data['pngData'];
$filename = $data['filename'];
//file_put_contents('generated_svg/'.$filename.'.svg', $svgData);

//$encodeData = $_POST['dataURL'];
$encodeData = substr($pngData, strpos($pngData, ',') + 1); //strip the URL of its headers
$decodeData = base64_decode($encodeData);
$handle = fopen('generated_png/'.$filename.'.png', 'x+');
fwrite($handle, $decodeData);
fclose($handle);