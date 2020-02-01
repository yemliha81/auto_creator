<?php

include('functions.php');

$name = '594839e255a6c.jpg';
$source_path = $_SERVER['DOCUMENT_ROOT'].'/img/img/small/';
$big_path = $_SERVER['DOCUMENT_ROOT'].'/img/img/big/';
$big_size = 800;

quick_img_upload_resize( $name, $source_path.$name, $big_path, $big_size );


//echo quick_img_upload_resize( $name, $source_path, $big_path, $big_size );

die("done");