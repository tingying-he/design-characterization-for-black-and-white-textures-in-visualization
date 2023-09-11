<?php
phpinfo();

$data = json_decode(file_get_contents('php://input'));

$filename = "../../results/results.json";//result file

if(file_exists($filename))
{
    $final_data=fileWriteAppend($filename, $data);
    if(file_put_contents($filename, $final_data))
    {
        $message = "<label class='text-success'>Data added Success fully</p>";
    }
}
else
{
    $final_data=fileCreateWrite();
    if(file_put_contents('file.json', $final_data))
    {
        $message = "<label class='text-success'>File created and data added Success fully</p>";
    }

}
function fileWriteAppend($filename, $data){
    $current_data = file_get_contents($filename);
    $array_data = json_decode($current_data, true);
    $extra = $data;
    $array_data[] = $extra;
    $final_data = json_encode($array_data);
    return $final_data;
}
function fileCreateWrite(){
    $file=fopen("file.json","w");
    $array_data=array();
    $extra = array(
        'name'               =>     $_POST['name'],
        'gender'          =>     $_POST["gender"],
        'age'          =>     $_POST["age"],
        'education'     =>     $_POST["education"],
        'designation'     =>     $_POST["designation"],
        'dob'     =>     $_POST["dob"]

    );
    $array_data[] = $extra;
    $final_data = json_encode($array_data);
    fclose($file);
    return $final_data;
}

?>



