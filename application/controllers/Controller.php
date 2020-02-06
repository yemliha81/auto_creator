<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Controller extends CI_Controller {

	public function list_items($table){
		
		$table_name = $table.'_table';
		$fields = $this->db->field_data($table_name);
		//debug($fields);
		$data['table_name'] = $table;
		$data['fields'] = $fields;
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
		$post = $this->input->post();
		
		$table_name = $table.'_table';
		
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



	
}