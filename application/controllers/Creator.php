<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Creator extends CI_Controller {

	public function index()
	{
		$this->load->view('table_creator_view', $data);
	}

	public function utf_8($type){
		if( ($type == "varchar") OR ($type == "text") ){
			return " COLLATE utf8_unicode_ci";
		}else{
			return "";
		}
	}


	public function table_creator_post()
	{
		
		$post = $this->input->post();

		$query .= "CREATE TABLE IF NOT EXISTS ".$post['table_name']." (
					id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
			foreach($post['field_name'] as $key => $val){
			
				$type = $post['field_type'][$key];

			if( ($type == "boolean") OR ( $type == "float" ) ){
				$query .= "".$val." ".$post['field_type'][$key]." ".$post['null'][$key]." ,";
			}elseif($type == "text"){
				$query .= "".$val." ".$post['field_type'][$key]."  ".$this->utf_8($post['field_type'][$key])."  ".$post['null'][$key]." ,";
			}else{
				$query .= "".$val." ".$post['field_type'][$key]."   (".$post['char_length'][$key].")  ".$this->utf_8($post['field_type'][$key])."  ".$post['null'][$key]." ,";
			}
			
		}
		$query = substr($query, 0, -1);
		$query .= " ) ;";
		



		$run = $this->db->query($query);

		if($run){
			
			$fileName = "application/controllers/".$post['table_name'].".php";

			if(!file_exists($fileName)){
				touch($fileName);
			}
			
			die("Successful!!!");
		}else{
			die("ERROR!!!");
		}


		/*
		test
		CREATE TABLE IF NOT EXISTS 'products_table' (
		  'pro_id' int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  'pro_name' varchar(50) COLLATE utf8_unicode_ci NOT NULL,
		  'pro_img' varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  'pro_barcode' varchar(50) COLLATE utf8_unicode_ci NOT NULL,
		  'pro_price' decimal(7,2) NOT NULL,
		  'pro_type' int(11) NOT NULL,
		  'pro_stock' int(11) NOT NULL,
		  'cat_id' int(11) NOT NULL,
		  'unit' varchar(20) COLLATE utf8_unicode_ci NOT NULL,
		  'gr' decimal(7,2) NOT NULL,
		  'pro_insert_time' bigint(20) NOT NULL,
		  'pro_status' int(11) NOT NULL,
		  'pro_status2' int(11) NOT NULL
		);*/



	}
	
}