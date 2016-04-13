<?php
defined('BASEPATH') OR exit("LOL!");

/**
 * Description of Project
 *
 * @author Amir <amirsanni@gmail.com>
 * @date 20-Mar-2016
 */
class Project extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
    
    
    public function get_user_projects($user_id, $order_by, $order_format, $start, $limit){
        //$this->db->select("projects.id, title, description, ");
        $limit_text = $start ? " LIMIT $start , $limit" : '';
        $q = "SELECT projects.*, pr_categories.name as 'category_name'
            FROM projects 
            INNER JOIN pr_categories 
            ON projects.category_id=pr_categories.id
            WHERE projects.user_id = ? 
            ORDER BY {$order_by} {$order_format} {$limit_text}";
        
        $run_q = $this->db->query($q, [$user_id]);
        
        if($run_q->num_rows()){
            return $run_q->result();
        }
        
        else{
            return FALSE;
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
     * 
     * @param type $order_by
     * @param type $order_format
     * @param type $start
     * @param type $limit
     * @return boolean
     */
    public function get_all($order_by, $order_format, $start, $limit){
        $q = "SELECT projects.id, projects.title, projects.description, projects.date_created, projects.published,
                pr_categories.name as 'category', 
                users.username, users.email as 'creator_email'
                FROM projects
                INNER JOIN pr_categories ON projects.category_id = pr_categories.id
                INNER JOIN users ON projects.user_id = users.id
                ORDER BY {$order_by} {$order_format} LIMIT {$start}, {$limit}";
        
        $run_q = $this->db->query($q);
        
        if($run_q->num_rows()){
            return $run_q->result();
        }
        
        else{
            return FALSE;
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
     * 
     * @param string $v
     */
    public function all_proj_search($v){
    	$q = "SELECT projects.id, projects.title, projects.description, projects.date_created, projects.published,
                pr_categories.name as 'category', 
                users.username, users.email as 'creator_email'
                FROM projects
                INNER JOIN pr_categories ON projects.category_id = pr_categories.id
                INNER JOIN users ON projects.user_id = users.id
                WHERE projects.id LIKE '%{$v}%' || projects.title LIKE '%{$v}%' || users.email LIKE '%{$v}%' || pr_categories.name LIKE '%{$v}%'";
    	
    	$run_q = $this->db->query($q);
    	
    	if($run_q->num_rows()){
    		return $run_q->result();
    	}
    	
    	else{
    		return FALSE;
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
     * 
     * @param int $proj_id
     * @return boolean
     */
    public function get_project_owner_details($proj_id){
    	$q = "SELECT username, first_name, last_name, email, projects.title 
    			FROM users 
    			INNER JOIN projects 
    			ON projects.user_id = users.id 
    			WHERE projects.id = ?";
    	
    	$run_q = $this->db->query($q, [$proj_id]);
    	
    	if($run_q->num_rows()){
    		return $run_q->result();
    	}
    	
    	else{
    		return FALSE;
    	}
    }
    
    
    /*
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     ********************************************************************************************************************************
     */
}
