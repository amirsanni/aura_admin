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
    
    
    
    public function get_user_projects($user_id, $order_by, $order_format, $start='', $limit=''){
        //$this->db->select("projects.id, title, description, ");
        
        $q = "SELECT projects.*, pr_categories.name as 'category_name'
            FROM projects 
            INNER JOIN pr_categories 
            ON projects.category_id=pr_categories.id
            WHERE projects.user_id = ? ORDER BY $order_by $order_format";
        
        $run_q = $this->db->query($q, [$user_id]);
        
        if($run_q->num_rows()){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
}
