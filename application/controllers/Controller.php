<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Controller extends CI_Controller {

	public function list_items($table){
		
		$table_name = $table.'_table';
		$fields = $this->db->field_data($table_name);
		//debug($fields);
		$data['table_name'] = $table;
		$data['fields'] = json_decode(json_encode($fields),true);
		$data['item_list'] = $this->db->select('*')
			->get($table_name)->result_array();
		//debug($data);
		$this->load->view('item_list_view', $data);
	}
	
	public function insert_item($table){
		
		$table_name = $table.'_table';
		
		$fields = $this->db->field_data($table_name);
		//debug($fields);
		$data['fields'] = $fields;
		$data['post_link'] = FATHER_BASE."controller/insert_item_post/".$table;
		
		$this->load->view('item_insert_view', $data);
	}
	
	public function insert_item_post($table){
		require DOC_ROOT . 'resize/SimpleImage.php';
		$post = $this->input->post();
		
		$table_name = $table.'_table';
		
		$fields = $this->db->field_data($table_name);
		$fields = json_decode(json_encode($fields), true);
		//debug(json_decode(json_encode($fields), true));
		foreach($fields as $key => $val){
			if($val['default'] == 'img'){
				$file = $_FILES[$val['name']];
				$img_name[$key] = img_seo_name(time().'-'.$file[name]);
				if( ( $file[type] == 'image/jpeg' ) OR ( $file[type] == 'image/png' ) ){
					
					if( ( $file[size] > 0 ) AND ( $file[size] < 3000000 ) )
						//File Upload
						$from_file = $file['tmp_name'];
						$to_file = DOC_ROOT . 'img/' .$img_name[$key];
						
						$save_image = $this->save_image($from_file,$to_file, 400, 400);
						if($save_image == true){
							$post[$val['name']] = $img_name[$key];
						}
						
				}
			}else{
				continue ;
			}
		}
		
		//die();
		
		$insert = $this->db->insert($table_name, $post);
			
		
		redirect(CREATOR);
	}
	
	public function update_item($table, $id){
		
		$table_name = $table.'_table';
		
		$fields = $this->db->field_data($table_name);
		//debug($fields);
		$data['fields'] = $fields;
		$data['post_link'] = FATHER_BASE."controller/update_item_post/".$table;
		$data['item_details'] = $this->db->select('*')
			->where('id', $id)
			->get($table_name)->row_array();
		
		$this->load->view('item_update_view', $data);
	}
	
	public function update_item_post($table){
		$post = $this->input->post();
		//debug($post);
		$table_name = $table.'_table';
		$fields = $this->db->field_data($table_name);
		//debug($fields);
		$data['fields'] = $fields;
		$update = $this->db->update($table_name, $post, array('id' => $post['id']));
			
		
		redirect(CREATOR);
	}
	
	public function save_image($from_file, $to_file, $width, $height){
		try {
		  // Create a new SimpleImage object
		  $image = new \claviska\SimpleImage();

		  // Magic! ✨
		  $image
			->fromFile($from_file)                     // load image.jpg
			->autoOrient()                              // adjust orientation based on exif data
			//->resize($width, $height)                          // resize to 320x200 pixels
			->thumbnail($width, $height, 'center')        // resize to 320x200 pixels
			//->flip('x')                                 // flip horizontally
			//->colorize('DarkBlue')                      // tint dark blue
			//->border('black', 10)                       // add a 10 pixel black border
			//->overlay('watermark.png', 'bottom right')  // add a watermark image
			->toFile($to_file, 'image/jpeg') ;     // convert to PNG and save a copy to new-image.png
			//->toScreen();                               // output to the screen
			return true;
		  // And much more! 💪
		} catch(Exception $err) {
		  // Handle errors
		  //echo $err->getMessage();
		  return false;
		}
	}



	
}