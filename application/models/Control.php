<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class control extends CI_Model {  
    
    
    public function __construct() {    
        parent::__construct();
        
        $logged_in = $this->session->userdata('logged_in');

        $session_type = $this->session->userdata('session_type');
        if( $logged_in != 1 ) {
            redirect( LOGOUT ); 
        }
             
    }
    
    
    


}