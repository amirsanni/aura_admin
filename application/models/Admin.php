<?php
defined('BASEPATH') OR exit('');

/**
 * Description of Admin
 *
 * @author Amir <amirsanni@gmail.com>
 * @date 31st Jan, 2016
 */
class Admin extends CI_Model{
    public function __construct(){
        parent::__construct();
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
     * @param type $f_name
     * @param type $l_name
     * @param type $email
     * @param type $password
     * @param type $role
     * @param type $mobile1
     * @param type $mobile2
     * @return boolean
     */
    public function add($f_name, $l_name, $email, $password, $role, $mobile1, $mobile2){
        $data = ['first_name'=>$f_name, 'last_name'=>$l_name, 'email'=>$email, 'password'=>$password, 'role'=>$role,
            'mobile1'=>$mobile1, 'mobile2'=>$mobile2];
        
        $this->db->set('created_on', 'NOW()', FALSE);
        
        $this->db->insert('admin', $data);
        
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
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
     * @param type $admin_id
     * @return boolean
     */
    public function update_last_login($admin_id){
        $q = "UPDATE admin SET last_login = NOW() WHERE id = ?";
        
        $this->db->query($q, [$admin_id]);
        
        if(!$this->db->error()){
            return TRUE;
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
     * Get some details about an admin (stored in session)
     * @param type $email
     * @return boolean
     */
    public function get_admin_info($email){
        $this->db->select('id, first_name, last_name, role');
        $this->db->where('email', $email);

        $run_q = $this->db->get('admin');

        if($run_q->num_rows() > 0){
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
     * @param type $orderBy
     * @param type $orderFormat
     * @param type $start
     * @param type $limit
     * @return boolean
     */
    public function getAll($orderBy = "first_name", $orderFormat = "ASC", $start = 0, $limit = ""){
        $this->db->select('id, first_name, last_name, email, role, mobile1, mobile2, created_on, last_login, account_status, deleted');
        $this->db->where("id != ", $_SESSION['admin_id']);
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        
        $run_q = $this->db->get('admin');
        
        if($run_q->num_rows() > 0){
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
    * @param type $admin_id
    * @param type $new_status New account status
    * @return boolean
    */ 
   	public function suspend($admin_id, $new_status){
       	$q = "UPDATE admin SET account_status = ? WHERE id = ?";
       
       	$this->db->query($q, [$new_status, $admin_id]);
       
   		if(!$this->db->error()['message']){
        	return TRUE;
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
    * @param type $admin_id
    * @param type $new_value
    * @return boolean
    */
    public function delete($admin_id, $new_value){
       	$q = "UPDATE admin SET deleted = ? WHERE id = ?";
       
		$this->db->query($q, [$new_value, $admin_id]);
       
    	if(!$this->db->error()['message']){
        	return TRUE;
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
     * @param type $value
     * @return boolean
     */
    public function adminSearch($value){
        $q = "SELECT * FROM admin WHERE 
                id != {$_SESSION['admin_id']}
                    AND
                (
                MATCH(first_name) AGAINST(?)
                || MATCH(last_name) AGAINST(?)
                || MATCH(first_name, last_name) AGAINST(?)
                || MATCH(email) AGAINST(?)
                || MATCH(mobile1) AGAINST(?)
                || MATCH(mobile2) AGAINST(?)
                || first_name LIKE '%".$this->db->escape_like_str($value)."%'
                || last_name LIKE '%".$this->db->escape_like_str($value)."%' 
                || email LIKE '%".$this->db->escape_like_str($value)."%'
                || mobile1 LIKE '%".$this->db->escape_like_str($value)."%'
                || mobile2 LIKE '%".$this->db->escape_like_str($value)."%'
                )";

        $run_q = $this->db->query($q, [$value, $value, $value, $value, $value, $value]);

        if($run_q->num_rows() > 0){
            return $run_q->result();
        }

        else{
            return FALSE;
        }
    }
    
    
    
    
    /**
     * 
     * @param int $admin_id
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $mobile1
     * @param string $mobile2
     * @param string $role
     * @return boolean
     */
    public function update($admin_id, $first_name, $last_name, $email, $mobile1, $mobile2, $role){
        $data = ['first_name'=>$first_name, 'last_name'=>$last_name, 'mobile1'=>$mobile1, 'mobile2'=>$mobile2, 'email'=>$email, 
            'role'=>$role];
        
        $this->db->where('id', $admin_id);
        
        $this->db->update('admin', $data);
        
        if(!$this->db->error()['message']){
        	return TRUE;
        }
        
        else{
        	return FALSE;
        }
    }
}
