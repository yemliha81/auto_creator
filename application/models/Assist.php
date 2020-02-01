<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class assist extends CI_Model {

    public $lang = NULL;
    public $lang_prefix = NULL;
    public $data = NULL;
    //public $inits = NULL;
    
    public function __construct() {    
        parent::__construct();
        $this->data['inits'] = $this->config->item('inits');
        
        //$all_session_data = $this->session->all_userdata();
        //$all_session_data['default_lang'] = 'TR';
        
        $this->session->set_userdata(array('default_lang' => 'TR'));
        $this::set_data(); 
        
        //$this::lang_control();
        //$this::set_lang_prefix();
        
        $this->output->enable_profiler(FALSE);   
	
    }
    private function get_canonical_url(){
		
		$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		$url_segments = (explode("/",$url));
		
		foreach($url_segments as $key => $val){
			$new_val[] = filter_var($val, FILTER_SANITIZE_STRING);
		}

		foreach($new_val as $key => $val){
			if($val == ''){
				unset($new_val[$key]);
			}
		}

		$last_key = key( array_slice( $new_val, -1, 1, TRUE ) );
		$last_uri_controle = $new_val[$last_key];
		
		if( is_numeric($last_uri_controle) ){
			$url = str_replace("/".$last_uri_controle, "", $url);
		}
		
		$this->data['canonical_url'] =  $url;

	}
    
    private function set_data() {
        $this->data['success'] = $this->session->flashdata('success');
        $this->data['error'] = $this->session->flashdata('error');
        $this->data['warning'] = $this->session->flashdata('warning');
        $this->data['info'] = $this->session->flashdata('info');
        $this->data['SES'] = $this->session->all_userdata();
    }
    
    
    /* private function lang_control() {
		
         if( $this->data['SES']['desired_lang'] != NULL ) {
            $this->lang = $this->data['SES']['desired_lang'];
        }else {
            $this->lang = $this->data['SES']['default_lang'];
        }
        $this::set_lang_prefix();
    } */
       
    private function set_lang_prefix() {
        
        switch( $this->lang ) {
            case 'TR' : $this->lang_prefix = 'tr/'; break;
            case 'EN' : $this->lang_prefix = 'en/'; break;
        }
        
    }
    
    public function warnings( $num ) {
        
        $warning_lang_file = DOC_ROOT.'application/views/'.$this->lang_prefix.'components/warnings.php';
        include($warning_lang_file);

        return $data[$num];
    }
       
    
    public function x_view( $view_name = FALSE, $data = NULL ) {
        //$data = $this->data;
        $this->load->view( $this->lang_prefix . $view_name, $data);
    }
    

    public function class_access( $class_prefix ) {
        $allowed_degrees = NULL;
        $access_allow = FALSE;
        if( $class_prefix == 'main' ) {
            $allowed_degrees = '-1,0,1,2,3,4,5';
        }
        if( $class_prefix == 'cc_admin' ) {
            $allowed_degrees = '-1,0,1';
        }

        $degree_arr = explode(',', $allowed_degrees);
        //debug($this->data);
        foreach( $degree_arr AS $key => $val ) {
            if( $this->data['SES']['admin_degree'] == $val ) {
                $access_allow = TRUE;
            }
        }
        
        if( $this->data['SES']['logged_in'] != TRUE ) {
            $this->session->sess_destroy();
            redirect(LOGOUT);
        }
        
        if( $access_allow != TRUE ) {
            $this->flash_redirect( MAIN_PAGE, 'warning', $this->warnings(3) );
        }
        
    }



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //---------------------------------------HELPER MODULES----------------------------------------------------//
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

 
    public function flash_redirect( $location = FALSE, $warn_type = FALSE, $warn_val = FALSE, $bunch_data = FALSE ) {
    
        if( $bunch_data != FALSE ) {
            $this->session->set_userdata('bunch_data', $bunch_data);
        }
        if( $warn_type != FALSE ) {
            $this->session->set_flashdata($warn_type, $warn_val);
        }
        if( $location != FALSE ) {
           redirect( $location ); 
        }
        redirect( FATHER_BASE );     
    }
	

	
	public function categories(){
		
		$cats = $this->db->select('*')
			->order_by('sort', 'ASC')
			->where('up_cat', '1')
			->get('cats_table')->result_array();
				
				
			return $cats;
	}
	
	public function pages(){
		
		$pages = $this->db->select('*')
			->order_by('sort', 'ASC')
			->get('pages_table')->result_array();

			return $pages;
	}
	
	public function notifications(){
		$member_id = $this->data['SES']['member_id'];
		$new_notf = $this->db->select('*')
			->where('member_id', $member_id)
			->where('new', '1')
			->order_by('insert_time', 'DESC')
			->get(NOTIFICATIONS_TABLE)->num_rows();
		return $new_notf;
	}
	

	public function categories_welcome(){
		
			$main_cats_welcome = $this->db->select('*')
				->where(CATEGORY_TABLE.'.level', '1')
				->join(CATEGORY_LANG_TABLE, CATEGORY_TABLE.'.cat_id ='.CATEGORY_LANG_TABLE.'.cat_id', 'left')
				->where(CATEGORY_LANG_TABLE.'.lang', tr_seo_converter($this->lang_prefix))
				->get(CATEGORY_TABLE)->result_array();
				
			foreach($main_cats_welcome as $key => $val){
				$main_cats_welcome[$key]['sub_cats'] = $this->db->select('*')
					->join(CATEGORY_LANG_TABLE, SUB_CATEGORY_TABLE.'.sub_cat_id ='.CATEGORY_LANG_TABLE.'.cat_id', 'left')
					->where(CATEGORY_LANG_TABLE.'.lang', tr_seo_converter($this->lang_prefix))
					->where(SUB_CATEGORY_TABLE.'.cat_id', $val['cat_id'])
					->limit(1)
					->get(SUB_CATEGORY_TABLE)->result_array();
			}
				
				
			return $main_cats_welcome;
	}
	
	
	public function packs(){
		
			$packs = $this->db->select('*')
				->order_by('sort', 'ASC')
				->get(CREDIT_PACKAGES_TABLE)->result_array();
				
				
			return $packs;
	}

	
	public function designers(){
		$data['designers'] = $this->db->select('*')
			->join(DESIGNER_LANG_TABLE, DESIGNER_TABLE.'.designer_id ='.DESIGNER_LANG_TABLE.'.designer_id', 'left')
			->where(DESIGNER_TABLE.'.designer_status', '1')
			//->limit(20)
			->order_by(DESIGNER_TABLE.'.designer_id', 'RANDOM')
			->get(DESIGNER_TABLE)->result_array();
		return $data['designers'];
		}
	
	public function all_categories(){
		
			// CATEGORÝES //
			$data['all_categories']	= $this->db->select('*')
				->join(CATEGORY_LANG_TABLE, CATEGORY_TABLE.'.cat_id = '.CATEGORY_LANG_TABLE.'.cat_id', 'left')
				->where(CATEGORY_TABLE.'.cat_type','UP')
				->where('cat_status', '1')
				->where('is_header !=', '1')
				->order_by(CATEGORY_TABLE.'.cat_id', 'DESC')
				->get(CATEGORY_TABLE)->result_array();
			// CATEGORÝES //
			$all_c = $data['all_categories'] ;
		return $all_c;
		}
	
	public function static_pages(){
		$data = $this->assist->data;
		$data['page'] = $this->db->select('*')
			->join(STATIC_PAGE_LANG_TABLE, STATIC_PAGE_TABLE.'.static_page_id ='.STATIC_PAGE_LANG_TABLE.'.static_page_id', 'left')
			->where(STATIC_PAGE_TABLE.'.static_page_status', 1)
			->get(STATIC_PAGE_TABLE)->result_array();
		$pages = $data['page'] ;
		return $pages;
	}
	
	public function recursive_pagination( $pagination_arr ) {
        
		//echo '<pre/>'; print_r($pagination_arr);
		
        //--DECLARATIONS FOR PAGINATION----
        $total_row = $pagination_arr['total_row'];
        $now_page = $pagination_arr['now_page'];
        $per_page_limit = $pagination_arr['per_page_limit'];
        $link = $pagination_arr['link'];
        $num_of_links = $pagination_arr['num_of_links'];
        $uri_segment = $pagination_arr['uri_segment'];       
        //--DECLARATIONS FOR PAGINATION----
        
        
        $config['base_url'] = $link; //BASE URL FOR PAGINATION.......
        $config['total_rows'] = $total_row;
        $config['per_page'] = $per_page_limit; 
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = $uri_segment;
        $config['num_links'] = $num_of_links;
        $config['page_query_string'] = FALSE;
        $config['now_page'] = $now_page;
   
        //----PAGINATION CSS----     
  
		$config['full_tag_open'] = '<div class="dataTables_paginate paging_bootstrap"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></div>';
        
        $config['prev_tag_open'] = '<li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_tag_open'] = '<li>';
        $config['first_link'] = 'Ýlk';
        $config['first_tag_close'] = '</li>';
        
        $config['next_tag_open'] = '<li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_close'] = '</li>';
        
        $config['last_tag_open'] = '<li>';
        $config['last_link'] = 'Son';
        $config['last_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        //----PAGINATION CSS---- 

        $this->pagination->initialize($config); 
        
        $pagination =  $this->pagination->create_links(); // DECLARATION OF PAGINATION.......
        
        return $pagination;
    }
	
	
	  /**
     * 
     * PAGINATION FOR MAKING JOBS EASIER
     * @params are inside an array defined in insite of method...
     * @return full pagination...
     * 
     * 
     ***/
    public function recursive_pagination_2( $pagination_arr ) {
        
        //--DECLARATIONS FOR PAGINATION----
        $total_row = $pagination_arr['total_row'];
        $now_page = $pagination_arr['now_page'];
        $per_page_limit = $pagination_arr['per_page_limit'];
        $link = $pagination_arr['link'];
        $num_of_links = $pagination_arr['num_of_links'];
        $uri_segment = $pagination_arr['uri_segment'];       
        //--DECLARATIONS FOR PAGINATION----
        
        
        $config['base_url'] = $link; //BASE URL FOR PAGINATION.......
        $config['total_rows'] = $total_row;
        $config['per_page'] = $per_page_limit; 
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = $uri_segment;
        $config['num_links'] = $num_of_links;
        $config['page_query_string'] = FALSE;
        $config['now_page'] = $now_page;
   
   
        //----PAGINATION CSS----     
        $config['full_tag_open'] = '<nav><ul class="pagination" >';
        $config['full_tag_close'] = '</ul></nav>';
        
        $config['prev_tag_open'] = '<li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_close'] = '</li>';
        
        $config['first_tag_open'] = '<li>';
        $config['first_link'] = 'Ýlk';
        $config['first_tag_close'] = '</li>';
        
        $config['next_tag_open'] = '<li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_close'] = '</li>';
        
        $config['last_tag_open'] = '<li>';
        $config['last_link'] = 'Son';
        $config['last_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li class="active" style="background:#969696;"><a href="#" style="background:#969696;border-color:#969696;sssss">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //----PAGINATION CSS---- 

        $this->pagination->initialize($config); 
        
        $pagination =  $this->pagination->create_links(); // DECLARATION OF PAGINATION.......
        
        return $pagination;
    }


}