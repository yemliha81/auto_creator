<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
		
		class Category extends CI_Controller {

			public function Category_list()
			{
				$this->load->view('Category_list_view', $data);
			}

			public function Category_add()
			{
				$this->load->view('Category_add_view', $data);
			}

			public function Category_add_post()
			{
				//INSERT process will be here
			}

			public function Category_update()
			{
				$this->load->view('Category_update_view', $data);
			}

			public function Category_update_post()
			{
				//UPDATE process will be here
			}

			public function Category_delete()
			{
				//DELETE process will be here
			}
			
		}

		?>