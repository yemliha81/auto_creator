<?php
date_default_timezone_set('Europe/Istanbul');
$data = $_POST['imgdata'];

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

$imgname = $_POST['file_name'];

if(!file_exists('tmpimg/'.$imgname)){
	$save = file_put_contents('tmpimg/'.$imgname, $data);
	if($save != FALSE){
		echo trim($imgname);
	}else{
		echo 'error';
	}
}else{
	echo trim($imgname);
}





?>

