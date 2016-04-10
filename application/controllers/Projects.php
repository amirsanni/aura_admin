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
    
    
    
    
    public function lap_(){
        //set the sort order
        $order_by = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "date_created";
        $order_format = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "DESC";
        
        //count the total projects in db
        $total_projects = $this->db->count_all('projects');
        
        $this->load->library('pagination');
        
        $page_number = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
	
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $page_number == 0 ? 0 : ($page_number - 1) * $limit;//start from 0 if $page_number is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes, $uri_segment=3) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($total_projects, "users/lap_", $limit, ['class'=>'nxtProj'], 3);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all projects from db
        $data['project_list'] = $this->project->get_all($order_by, $order_format, $start, $limit);
        $data['range'] = $total_projects > 0 ? ($start+1) . "-" . ($start + count($data['project_list'])) . " of " . $total_projects : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        
        print_r($data['project_list']);
        $this->load->view('projects/project_list', $data);//load view
    }
}
