<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Category extends CI_Controller {

    public function category_list()
	{
		$this->load->view('category_list_view', $data);
    }

    public function category_add()
	{
		$this->load->view('category_add_view', $data);
    }

    public function category_add_post()
	{
		//INSERT process will be here
    }

    public function category_update()
	{
		$this->load->view('category_update_view', $data);
    }

    public function category_update_post()
	{
		//UPDATE process will be here
    }

    public function category_delete()
	{
		//DELETE process will be here
    }
    
}