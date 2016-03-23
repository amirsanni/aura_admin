<?php
defined('BASEPATH') OR exit("Access Denied");

/**
 * Description of Misc
 *
 * @author Amir <amirsanni@gmail.com>
 * @date 06-Mar-2016
 */
class Misc extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    
    
    /**
     * check if admin's session is still on
     */
    public function check_session_status(){
        if(isset($_SESSION['admin_id']) && ($_SESSION['admin_id'] != FALSE) && ($_SESSION['admin_id'] != "")){
            $json['status'] = 1;
            
            //update user's last seen time
            //update_last_seen_time($id, $table_name)
            //$this->genmod->update_last_seen_time($_SESSION['admin_id'], 'admin');
        }
        
        else{
            $json['status'] = 0;
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
