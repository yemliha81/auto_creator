<?php

function debug( $var ) {
    echo '<pre>'; print_r($var); die();
}


function suit_img( $val, $img_name ) {
    echo IMG.$val.'/'.$img_name;
}

function suit_img_2( $val, $img_name ) {
    echo IMG_PROFILE.$val.'/'.$img_name;
}

function img_dir_maker( $vir_path_name ) {
    
}

function img_name_generator( $desired_name ) {
    return $desired_name.'_'.time().rand(0,1000);
}


function quick_path_maker( $full_path ) {
    if (!file_exists($full_path)) {
        mkdir($full_path, 0777, true);
    }
}

function img_giver_2( $dimention, $unix_time, $img_name ) {

    
    $year = date('Y', $unix_time);
    $month = date('m', $unix_time);
    $day = date('d', $unix_time);

    
    $full_img_path = PRO_IMG_2.'/'.$dimention.'/'.$img_name;
    $check_path = PRO_IMG_CHECK_PATH.$dimention.'/'.$img_name;
    //debug($full_img_path);
    if(getimagesize($check_path))
    {
        //echo 'TTT';
      return $full_img_path;
    }
    return NO_IMAGE;
    

}

function img_giver_3( $dimention, $unix_time, $img_name ) {

    
    $year = date('Y', $unix_time);
    $month = date('m', $unix_time);
    $day = date('d', $unix_time);

    
    $full_img_path = SLIDER_IMG.'/'.$dimention.'/'.$img_name;
    $check_path = SLIDER_IMG_CHECK_PATH.$dimention.'/'.$img_name;
    
    
    return $full_img_path;
    
    

}


function img_path_creator( $path, $unix_time ) {
    
    if( $unix_time == FALSE ) {
        $unix_time = time();
    }
    
    $year = date('Y', $unix_time);
    $month = date('m', $unix_time);
    $day = date('d', $unix_time);
    $hour = date('H', $unix_time);
    $minute = date('i', $unix_time);
    $second = date('s', $unix_time);
    
    $data['desired_path'] = $path.'/'.$year.'/'.$month.'/'.$day.'/'.$hour.'/';
    //$data['virtual_path'] = '/'.$year.'/'.$month.'/'.$day.'/'.$hour.'/';
    if (!file_exists($data['desired_path'])) {
        mkdir($data['desired_path'], 0777, true); 
    }
    
    return $data['desired_path'];
}

function img_path_creator2( $unix_time ) {
    
    if( $unix_time == FALSE ) {
        $unix_time = time();
    }
	
	//die($unix_time);
    
    $year = date('Y', $unix_time);
    $month = date('m', $unix_time);
    $day = date('d', $unix_time);
    $hour = date('H', $unix_time);
    $minute = date('i', $unix_time);
    $second = date('s', $unix_time);
    $data['virtual_path'] = $year.'/'.$month.'/'.$day.'/'.$hour.'/';

    
    return $data['virtual_path'];
}


function img_loader( $link, $path, $desired_name, $unix_time ) {
    $link_arr = explode('.', $link);
    if( sizeof($link_arr) <= 1 ) {
        return FALSE;
    }
    $img_name = img_name_generator($desired_name);
    $path_arr = img_path_creator($path, $unix_time);
    $full_path = $path_arr['desired_path'].$img_name.'.'.$link_arr[count($link_arr)-1];
    
    $result = file_put_contents($full_path, file_get_contents($link));
    //$result = file_put_contents($full_path, $link);
    if( $result == FALSE ) {
        return FALSE;
    }
    $data['full_path'] = $full_path;
    $data['img_name'] = $img_name.'.'.$link_arr[count($link_arr)-1];
    $data['desired_path'] = $path_arr['desired_path'];
    $data['virtual_path'] = $path_arr['virtual_path'];
    return $data;
}




function by_hours_graph( $str_time ) {
    $data = array(
                                1 => array( 'time_name' => '00:00', 'unix_time' => strtotime( $str_time . " 00:00:00" ) ), 
                                2 => array( 'time_name' => '12:00', 'unix_time' => strtotime( $str_time . " 12:00:00" ) ), 
                                3 => array( 'time_name' => '13:00', 'unix_time' => strtotime( $str_time . " 13:00:00" ) ), 
                                4 => array( 'time_name' => '15:00', 'unix_time' => strtotime( $str_time . " 15:00:00" ) ), 
                                5 => array( 'time_name' => '16:00', 'unix_time' => strtotime( $str_time . " 16:00:00" ) ), 
                                6 => array( 'time_name' => '18:00', 'unix_time' => strtotime( $str_time . " 18:00:00" ) ), 
                                7 => array( 'time_name' => '19:00', 'unix_time' => strtotime( $str_time . " 19:00:00" ) ), 
                                8 => array( 'time_name' => '20:00', 'unix_time' => strtotime( $str_time . " 20:00:00" ) ), 
                                9 => array( 'time_name' => '21:00', 'unix_time' => strtotime( $str_time . " 21:00:00" ) ), 
                                10 => array( 'time_name' => '24:00', 'unix_time' => strtotime( $str_time . " 24:00:00" ) ) 
                                );
    return $data;
}



function aasort ( $array, $key) {
            $sorter=array();
            $ret=array();
            reset($array);
            foreach ($array as $ii => $va) {
                $sorter[$ii]=$va[$key];
            }
            asort($sorter);
            foreach ($sorter as $ii => $va) {
                $ret[$ii]=$array[$ii];
            }
            $array=$ret;
            $array = array_reverse($array);
            return $array;
}

/*function proper_logo_src( $base_url = IMG, $img_dir, $dimention ) {
    return $base_url . $dimention . $img_dir;
}


function make_news_url( $host_name, $text ) {
    return 'http://' . $host_name . '/haberler/' . $text;
}*/

function months() {
    $data = array(  
                    1 => array( 'Ocak', 'OCA' ),
                    2 => array( 'Şubat', 'ŞUB' ),
                    3 => array( 'Mart', 'MAR' ),
                    4 => array( 'Nisan', 'NİS' ),
                    5 => array( 'Mayıs', 'MAY' ),
                    6 => array( 'Haziran', 'HAZ' ),
                    7 => array( 'Temmuz', 'TEM' ),
                    8 => array( 'Ağustos', 'AĞU' ),
                    9 => array( 'Eylül', 'EYL' ),
                    10 => array( 'Ekim', 'EKİ' ),
                    11 => array( 'Kasım', 'KAS' ),
                    12 => array( 'Aralık', 'ARA' )
                    );
    return $data;
}


function months_2() {
    $data = array(
                    'Ocak' => '01',
                    'Şubat' => '02',
                    'Mart' => '03',
                    'Nisan' => '04',
                    'Mayıs' => '05',
                    'Haziran' => '06',
                    'Temmuz' => '07',
                    'Ağustos' => '08',
                    'Eylül' => '09',
                    'Ekim' => '10',
                    'Kasım' => '11',
                    'Aralık' => '12'
                    );
    return $data;
}




function shorten($link) {
  
    $access_token = '3443c6ac7ce9f835ea112895273fdb71be701544';
    $json = file_get_contents('https://api-ssl.bitly.com/v3/shorten?access_token=' . $access_token . '&longUrl=' . urlencode($link));
    //echo 'https://api-ssl.bitly.com/v3/shorten?access_token=' . $access_token . '&longUrl=' . urlencode($link); 
    $obj = json_decode($json);
    
    if( $obj->data->url != NULL ) {
        return $obj->data->url;
    }
    return $link;
}

function img_seo_name($s) {
    $tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç');
    $eng = array('s','s','i','i','g','g','u','u','o','o','c','c');
    $s = str_replace($tr,$eng,$s);
    $s = strtolower($s);
	$s = preg_replace('/[^.%a-z0-9 _-]/', '', $s);
	$s = preg_replace('/&+?;/', '', $s);
    $s = preg_replace('/\s+/', '-', $s);
    $s = preg_replace('|-+|', '-', $s);
    $s = trim($s, '-');
 
    return $s;
}


function cevir($s) {
    $tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç');
    $eng = array('s','s','i','i','g','g','u','u','o','o','c','c');
    $s = str_replace($tr,$eng,$s);
    $s = strtolower($s);
    $s = preg_replace('/&.+?;/', '', $s);
    $s = preg_replace('/[^%a-z0-9 _-]/', '', $s);
    $s = preg_replace('/\s+/', '-', $s);
    $s = preg_replace('|-+|', '-', $s);
    $s = trim($s, '-');
 
    return $s;
}


function sanitize($url) {
	 
	$url = trim($url);
	$find = array('<b>', '</b>');
	$url = str_replace ($find, '', $url);
	$url = preg_replace('/<(\/{0,1})img(.*?)(\/{0,1})\>/', 'image', $url);
	$find = array(' ', '&amp;amp;amp;quot;', '&amp;amp;amp;amp;', '&amp;amp;amp;', '\r\n', '\n', '/', '\\', '+', '<', '>');
	$url = str_replace ($find, '-', $url);
	$find = array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ë', 'Ê');
	$url = str_replace ($find, 'e', $url);
	$find = array('í', 'ý', 'ì', 'î', 'ï', 'I', 'Ý', 'Í', 'Ì', 'Î', 'Ï','İ','ı');
	$url = str_replace ($find, 'i', $url);
	$find = array('ó', 'ö', 'Ö', 'ò', 'ô', 'Ó', 'Ò', 'Ô');
	$url = str_replace ($find, 'o', $url);
	$find = array('á', 'ä', 'â', 'à', 'â', 'Ä', 'Â', 'Á', 'À', 'Â');
	$url = str_replace ($find, 'a', $url);
	$find = array('ú', 'ü', 'Ü', 'ù', 'û', 'Ú', 'Ù', 'Û');
	$url = str_replace ($find, 'u', $url);
	$find = array('ç', 'Ç');
	$url = str_replace ($find, 'c', $url);
	$find = array('þ', 'Þ','ş','Ş');
	$url = str_replace ($find, 's', $url);
	$find = array('ð', 'Ð','ğ','Ğ');
	$url = str_replace ($find, 'g', $url);
	$find = array('/[^A-Za-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	$url = str_replace ('--', '-', $url);
	$url = strtolower($url);
	return $url;
    
}

function tr_seo_converter( $input ) {
    $res = cevir($input);
    $result = sanitize($res);
    return $result;
}



function quick_document_upload($tag, $source_path){
	
	if($_FILES[$tag]['error'] == 0 AND $_FILES[$tag]['size'] > 0){
		
		$type_x = pathinfo($_FILES[$tag]['name'], PATHINFO_EXTENSION); 			
		
		$type = strtolower($type_x);
		
		//Get the temp file path
			$tmpFilePath = $_FILES[$tag]['tmp_name'];
			$new_name = md5(uniqid()).'.'.$type;
			$newFilePath = $source_path . $new_name;
		  //Make sure we have a filepath
		   if ($tmpFilePath != ""){	
		   
				$move =  move_uploaded_file($tmpFilePath, $newFilePath);
				
				if($move){
					return $new_name;
				}

		   }

	}			
	
}



function quick_img_upload_resize( $tag, $i, $source_path, $medium_path, $medium_size, $small_path, $small_size ){
	
	
	
	if($_FILES[$tag]['error'][$i] == 0 AND $_FILES[$tag]['size'][$i] > 0){
			//die('1111');
			$type_x = pathinfo($_FILES[$tag]['name'][$i], PATHINFO_EXTENSION); 			
			
			$type = strtolower($type_x);
			
			if($type == 'jpg' || $type == 'png' || $type == 'jpeg'){
			
				//Get the temp file path
					$tmpFilePath = $_FILES[$tag]['tmp_name'][$i];
					$new_name[$i] = md5(uniqid()).'.'.$type;
					$newFilePath = $source_path . $new_name[$i];
					$mediumFilePath = $medium_path . $new_name[$i];
					$smallFilePath = $small_path . $new_name[$i];
				  //Make sure we have a filepath
				   if ($tmpFilePath != ""){	
				   
						$move =  move_uploaded_file($tmpFilePath, $newFilePath);
						
						if($move){						
							
							//----------RESIZE -------------//
							$filename = $newFilePath;
							//die($filename);
							if($type == 'jpeg'){ $img = ImageCreateFromJpeg($filename); }
							if($type == 'jpg'){ $img = ImageCreateFromJpeg($filename); }
							if($type == 'png'){ $img = ImageCreateFromPng($filename); }
							
							
							
							$width = imagesx($img); 
							$height = imagesy($img); 
							
							$ratio = $width / $height;

							// Content type
							
							list($width, $height) = getimagesize($filename);
							
							// Get new dimensions for medium
							$new_width_m = $medium_size;
							$new_height_m = $medium_size / $ratio;

							// Get new dimensions for thumbs
							$new_width = $small_size;
							$new_height = $small_size / $ratio;

							// Resize medium
							$image_p_m = imagecreatetruecolor($new_width_m, $new_height_m);
							if($type == 'jpeg'){ $image = imagecreatefromjpeg($filename); }
							if($type == 'jpg'){ $image = imagecreatefromjpeg($filename); }
							if($type == 'png'){ $image = imagecreatefromPng($filename); }
							
							// Resize thumb
							$image_p = imagecreatetruecolor($new_width, $new_height);
							if($type == 'jpeg'){ $image = imagecreatefromjpeg($filename); }
							if($type == 'jpg'){ $image = imagecreatefromjpeg($filename); }
							if($type == 'png'){ $image = imagecreatefromPng($filename); }
							
							imagecopyresized($image_p_m, $image, 0, 0, 0, 0, $new_width_m, $new_height_m, $width, $height);
							imagecopyresized($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

							if($type == 'jpeg'){ imagejpeg($image_p_m, $mediumFilePath); }
							if($type == 'jpg'){ imagejpeg($image_p_m, $mediumFilePath); }
							if($type == 'png'){ imagepng($image_p_m, $mediumFilePath); }
							
							// Output
							if($type == 'jpeg'){ imagejpeg($image_p, $smallFilePath); }
							if($type == 'jpg'){ imagejpeg($image_p, $smallFilePath); }
							if($type == 'png'){ imagepng($image_p, $smallFilePath); }
							
							
							return $new_name[$i];
							
							
							//----------RESIZE -------------//
							
							
						}else{
							return false;
						}
						
					  }
				
			}else{				
				return 'wrong_file_type';
			}
			
		}else{
			die('55555');
		}
		
	
}

function quick_profile_img_upload_resize( $tag, $source_path, $medium_path, $medium_size, $small_path, $small_size ){
	
	
	
	if($_FILES[$tag]['error'] == 0 AND $_FILES[$tag]['size'] > 0){
			//die('1111');
			$type_x = pathinfo($_FILES[$tag]['name'], PATHINFO_EXTENSION); 			
			
			$type = strtolower($type_x);
			
			if($type == 'jpg' || $type == 'png' || $type == 'jpeg'){
			
				//Get the temp file path
					$tmpFilePath = $_FILES[$tag]['tmp_name'];
					$new_name = md5(uniqid()).'.'.$type;
					$newFilePath = $source_path . $new_name;
					$mediumFilePath = $medium_path . $new_name;
					$smallFilePath = $small_path . $new_name;
				  //Make sure we have a filepath
				   if ($tmpFilePath != ""){	
				   
						$move =  move_uploaded_file($tmpFilePath, $newFilePath);
						
						if($move){						
							
							//----------RESIZE -------------//
							$filename = $newFilePath;
							//die($filename);
							if($type == 'jpeg'){ $img = ImageCreateFromJpeg($filename); }
							if($type == 'jpg'){ $img = ImageCreateFromJpeg($filename); }
							if($type == 'png'){ $img = ImageCreateFromPng($filename); }
							
							
							
							$width = imagesx($img); 
							$height = imagesy($img); 
							
							$ratio = $width / $height;

							// Content type
							
							list($width, $height) = getimagesize($filename);
							
							// Get new dimensions for medium
							$new_width_m = $medium_size;
							$new_height_m = $medium_size / $ratio;

							// Get new dimensions for thumbs
							$new_width = $small_size;
							$new_height = $small_size / $ratio;

							// Resize medium
							$image_p_m = imagecreatetruecolor($new_width_m, $new_height_m);
							if($type == 'jpeg'){ $image = imagecreatefromjpeg($filename); }
							if($type == 'jpg'){ $image = imagecreatefromjpeg($filename); }
							if($type == 'png'){ $image = imagecreatefromPng($filename); }
							
							// Resize thumb
							$image_p = imagecreatetruecolor($new_width, $new_height);
							
							imagecopyresized($image_p_m, $image, 0, 0, 0, 0, $new_width_m, $new_height_m, $width, $height);
							imagecopyresized($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

							if($type == 'jpeg'){ imagejpeg($image_p_m, $mediumFilePath); }
							if($type == 'jpg'){ imagejpeg($image_p_m, $mediumFilePath); }
							if($type == 'png'){ imagepng($image_p_m, $mediumFilePath); }
							
							// Output
							if($type == 'jpeg'){ imagejpeg($image_p, $smallFilePath); }
							if($type == 'jpg'){ imagejpeg($image_p, $smallFilePath); }
							if($type == 'png'){ imagepng($image_p, $smallFilePath); }
							
							
							return $new_name;
							
							
							//----------RESIZE -------------//
							
							
						}else{
							return 'error';
						}
						
					  }
				
			}
			
		}else{
			return 'error';
		}
		
	
}

?>