<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
		
		class Product extends CI_Controller {

			public function Product_list()
			{
				$this->load->view('Product_list_view', $data);
			}

			public function Product_add()
			{
				$this->load->view('Product_add_view', $data);
			}

			public function Product_add_post()
			{
				//INSERT process will be here
			}

			public function Product_update()
			{
				$this->load->view('Product_update_view', $data);
			}

			public function Product_update_post()
			{
				//UPDATE process will be here
			}

			public function Product_delete()
			{
				//DELETE process will be here
			}
			
		}

?>