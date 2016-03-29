<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Genmod
 *
 * @author Amir <amirsanni@gmail.com>
 */
class Genmod extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }


    /**
     * Update any single column in any table using a single column in the where clause
     * @param string $tableName the name of the table to update
     * @param string $colName name of column to update
     * @param mixed $colVal value to insert into $colName
     * @param string $whereCol column to use in the where clause
     * @param mixed $whereColVal value of column $whereCol
     * @return boolean
     */
    public function updateTableCol($tableName, $colName, $colVal, $whereCol, $whereColVal){
        $q = "UPDATE $tableName SET $colName = ? WHERE $whereCol = ?";
        
        $this->db->query($q, [$colVal, $whereColVal]);
        
        if(!$this->db->error()['message']){
            return TRUE;
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    /**
     * get a single column from any table using a single column in the where clause
     * @param string $tableName
     * @param string $selColName
     * @param string $whereColName
     * @param mixed $colValue
     * @return boolean
     */
    public function getTableCol($tableName, $selColName, $whereColName, $colValue){
        $q = "SELECT $selColName FROM $tableName WHERE $whereColName = ?";
        
        $run_q = $this->db->query($q, [$colValue]);
        
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->$selColName;
            }
        }
        
        else{
            return FALSE;
        }
    }
    
    
    /**
     * 
     * @param type $userId
     * @param type $socialId
     * @param type $socialName
     */
    public function insertSocialDetails($userId, $socialId, $socialName){
        $q = "INSERT INTO socialids (userId, userIdOnSocial, socialName) VALUES (?, ?, ?)";
        
        $this->db->query($q, [$userId, $socialId, $socialName]);
        
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    /**
     * Update user's social id in social with $socialName
     * @param type $userId
     * @param type $socialId
     * @param type $socialName
     */
    public function updateSocialDetails($userId, $socialId, $socialName){
        $q = "UPDATE socialids SET userIdOnSocial = ? WHERE userId = ? AND socialName = ?";
        
        $this->db->query($q, [$socialId, $userId, $socialName]);
        
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
        
        else{
            return FALSE;
        }
    }
    
    
    
    public function socialDetailsExist($userId, $socialName){
        $q = "SELECT id FROM socialids WHERE userId = ? AND socialName = ?";
        
        $run_q = $this->db->query($q, [$userId, $socialName]);
        
        if($run_q->num_rows() > 0){
            foreach($run_q->result() as $get){
                return $get->id;
            }
        }
        
        else{
            return FALSE;
        }
    }
}
