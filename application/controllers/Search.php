<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Search
 *
 * @author Amir <amirsanni@gmail.com>
 * @date 26th Rab.Awwal, 1437A.H (Jan. 7th, 2016)
 */

class Search extends CI_Controller{
    protected $value;
    
    public function __construct() {
        parent::__construct();
        
        //$this->gen->checklogin();
        
        $this->genlib->ajaxOnly();
        
        $this->load->model(['admin', 'project', 'blogmodel']);
        
        $this->load->helper('text');
        
        $this->value = $this->input->get('v', TRUE);
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /**
     * ps = "Project Search"
     */
    public function ps(){
    	$data['project_list'] = $this->project->all_proj_search($this->value);
    	$data['sn'] = 1;
    	
    	$this->load->view('projects/project_list', $data);
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    public function adminSearch(){
        $data['allAdministrators'] = $this->admin->adminSearch($this->value);
        $data['sn'] = 1;
        
        $json['adminTable'] = $data['allAdministrators'] ? $this->load->view('adminlist', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
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
