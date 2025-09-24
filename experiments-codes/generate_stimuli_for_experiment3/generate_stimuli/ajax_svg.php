<?php
$data = json_decode(file_get_contents('php://input'), TRUE);
$svgData = $data['svgData'];
$filename = $data['filename'];
file_put_contents('generated_svg/'.$filename.'.svg', $svgData);