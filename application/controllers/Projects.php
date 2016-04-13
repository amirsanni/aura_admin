<?php
defined('BASEPATH') OR exit("");

/**
 * Description of Projects
 *
 * @author Amir <amirsanni@gmail.com>
 * @date 09-Apr-2016
 */
class Projects extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('project');
    }
    
    
    
    public function index(){
        $data['pageContent'] = $this->load->view('projects/index', '', TRUE);
        $data['pageTitle'] = "Projects";
        
        $this->load->view('main', $data);
    }
    
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    
    public function lap_(){
        $this->genlib->ajaxOnly();
        
        $this->load->helper('text');
        
        //set the sort order
        $order_by = $this->input->post('orderBy', TRUE) ? $this->input->post('orderBy', TRUE) : "date_created";
        $order_format = $this->input->post('orderFormat', TRUE) ? $this->input->post('orderFormat', TRUE) : "DESC";
        
        //count the total projects in db
        $total_projects = $this->db->count_all('projects');
        
        $this->load->library('pagination');
        
        $page_number = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
	
        $limit = $this->input->post('limit', TRUE) ? $this->input->post('limit', TRUE) : 10;//show $limit per page
        $start = $page_number == 0 ? 0 : ($page_number - 1) * $limit;//start from 0 if $page_number is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes, $uri_segment=3) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($total_projects, "projects/lap_", $limit, ['class'=>'nxtProj'], 3);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all projects from db
        $data['project_list'] = $this->project->get_all($order_by, $order_format, $start, $limit);
        $data['range'] = $total_projects > 0 ? ($start+1) . "-" . ($start + count($data['project_list'])) . " of " . $total_projects : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        
        //load view
        $this->load->view('projects/project_list', $data);
    }
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    
    
    /**
     * paup = "Publish and Unpublish Project"
     */
    public function paup(){
    	$proj_id = $this->input->get('pId', TRUE);
    	$new_status = $this->input->get('ns', TRUE);
    	
    	//$new_status must be either 0 or 1
    	if(in_array($new_status, [0, 1]) == false){
    		$json['status'] = 0;
    	}
    	
    	else{
    		//updateTableCol($tableName, $colName, $colVal, $whereCol, $whereColVal)
    		$updated = $this->genmod->updatetablecol('projects', 'published', $new_status, 'id', $proj_id);
    		 
    		$json['status'] = $updated ? 1 : 0;
    		
    		$updated ? $this->notify_user_of_update($proj_id, $new_status) : "";
    		 
    		$this->output->set_content_type('application/json')->set_output(json_encode($json));
    	}
    }
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    
    /**
     * Send message to project owner in regard to the status of his project
     * @param int $proj_id
     * @param int $new_status
     */
    private function notify_user_of_update($proj_id, $new_status){
    	$project_owner_details = $this->project->get_project_owner_details($proj_id);
    	
    	foreach($project_owner_details as $get){
    		$email = $get->email;
    		$username = $get->username;
    		$project_title = $get->title;
    		$name = $get->first_name . " " . $get->last_name;
    	}
    	
    	//set message details
    	if($new_status == 1){
    		$subject = "Project Published";
    		$msg = "<p>Hi {$username}, your project titled '{$project_title}' has been published.</p>Thank you and Welcome.";
    	}
    	
    	else{
    		$subject = "Project Unpublished";
    		$msg = "<p>Hi {$username}, your project titled '{$project_title}' has been unpublished for not complying to our terms.</p>
    				Do not hesitate to contact us via this email if you need more info.<br>Thank you.";
    	}
    	
    	
    	//send email to user
    	//send_email($sname, $semail, $rname, $remail, $subject, $message, $replyToEmail="", $files="")
    	$this->genlib->send_email("Aura Admin", $this->genlib->get_default_email(), $name, $email, 
    			$subject, $msg, $replyToEmail=$this->genlib->get_default_email(), "");
    }
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    /**
     * 
     */
    public function del_proj(){
    	$proj_id = $this->input->get('id', TRUE);
    	
    	if($proj_id){
    		$this->db->where('id', $proj_id);
    		$this->db->delete('projects');
    		
    		$json['status'] = $this->db->affected_rows() ? 1 : 0;
    		
    		
    		$this->output->set_content_type('application/json')->set_output(json_encode($json));
    	}
    	
    	else{
    		$json['status'] = 0;
    		$json['msg'] = "Unrecognised project. Project might have been deleted.";
    		
    		$this->output->set_content_type('application/json')->set_output(json_encode($json));
    	}
    }
    
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    
    
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
}
