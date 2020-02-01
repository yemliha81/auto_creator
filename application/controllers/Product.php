<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
		
			class Product extends CI_Controller {

				public function product_list()
				{
					$data['item_list'] = $this->db->select('*')
						->get('product_table')->result_array();
					
					$this->load->view('product_list_view', $data);
				}

				public function product_add()
				{
					$this->load->view('product_add_view', $data);
				}

				public function product_add_post()
				{
					//INSERT process will be here
				}

				public function product_update()
				{
					$this->load->view('product_update_view', $data);
				}

				public function product_update_post()
				{
					//UPDATE process will be here
				}

				public function product_delete()
				{
					//DELETE process will be here
				}
				
			}

		?>