<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Welcome extends CI_Controller {

	public function index()
	{
		$fields = $this->db->field_data('product_table');
		debug($fields);
		$this->load->view('welcome_view', $data);
	}
	
}
