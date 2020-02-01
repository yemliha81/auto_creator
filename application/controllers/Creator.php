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
		$controller_name = $post['table_name'];


		$query .= "CREATE TABLE IF NOT EXISTS ".$post['table_name']."_table (
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
			$this->create_controller($controller_name, $fileName);
			
			
			die("Successful!!!");
		}else{
			die("ERROR!!!");
		}

	}

	public function create_controller($controller_name, $fileName){
		if(!file_exists($fileName)){
			
			touch($fileName);
			$fp = fopen( $fileName, 'w');
			fwrite($fp, $this->file_content_creator($controller_name));
			fclose($fp);
			
		}
	}

	public function file_content_creator($table_name){

		$db_table_name = strtolower($table_name.'_table');
		$table_name_list = strtolower($table_name.'_list');
		$table_name_list_view = strtolower($table_name.'_list_view');
		$table_name_add = strtolower($table_name.'_add');
		$table_name_add_view = strtolower($table_name.'_add_view');
		$table_name_add_post = strtolower($table_name.'_add_post');
		$table_name_update = strtolower($table_name.'_update');
		$table_name_update_view = strtolower($table_name.'_update_view');
		$table_name_update_post = strtolower($table_name.'_update_post');
		$table_name_delete = strtolower($table_name.'_delete');

		$content = "<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
		
		class $table_name extends CI_Controller {

			public function $table_name_list()
			{
				\$data['item_list'] = \$this->db->select('*')->get('$db_table_name')->result_array();
				debug(\$data['item_list']);
				\$this->load->view('$table_name_list_view', \$data);
			}

			public function $table_name_add()
			{
				\$this->load->view('$table_name_add_view', \$data);
			}

			public function $table_name_add_post()
			{
				//INSERT process will be here
			}

			public function $table_name_update()
			{
				\$this->load->view('$table_name_update_view', \$data);
			}

			public function $table_name_update_post()
			{
				//UPDATE process will be here
			}

			public function $table_name_delete()
			{
				//DELETE process will be here
			}
			
		}

		?>";

		return strval($content);

	}





	
}