<?php
defined('BASEPATH') OR exit('Access Denied');

/**
 * Description of Genlib
 * Class deals with functions needed in multiple controllers to avoid repetition in each of the controllers
 *
 * @author Amir <amirsanni@gmail.com>
 */
class Genlib {
    protected $CI;
    
    public function __construct() {
        $this->CI = &get_instance();
    }
    
    
    /**
     * 
     * @param type $sname
     * @param type $semail
     * @param type $rname
     * @param type $remail
     * @param type $subject
     * @param type $message
     * @param type $replyToEmail
     * @param type $files
     * @return type
     */
    public function send_email($sname, $semail, $rname, $remail, $subject, $message, $replyToEmail="", $files=""){
        $this->CI->email->from($semail, $sname);
        $this->CI->email->to($remail, $rname);
        $replyToEmail ? $this->CI->email->reply_to($replyToEmail, $sname) : "";
        $this->CI->email->subject($subject);
        $this->CI->email->message($message);
        
        //include attachment if $files is set
        if($files){
            foreach($files as $fileLink){
                $this->CI->email->attach($fileLink, 'inline');
            }
        }

        $send_email = $this->CI->email->send();
        
        
        return $send_email ? TRUE : FALSE;
    }
	
    
    


    public function checkLogin() {
        if (!($_SESSION['admin_id'])) {
            //redirect to log in page
            $currentUrl = $_SERVER['QUERY_STRING'] ? current_url() . "?" . $_SERVER['QUERY_STRING'] : current_url();

            redirect(base_url() . '?red_uri=' . urlencode($currentUrl)); //redirects to login page
        } 
        
        else {
            return "";
        }
    }
    
    
    
    
    /**
     * Ensure request is an AJAX request
     * @return string
     */
    public function ajaxOnly(){
        //display uri error if request is not from AJAX
        if(!$this->CI->input->is_ajax_request()){
            redirect(base_url());
        }
        
        else{
            return "";
        }
    }
    
    
    
    
    
    /**
     * Calculate the size of a file or diskSpace and format it based on the size
     * @param type $size size in bytes
     * @return type
     */
    public function formatFileSize($size){
        if($size < 1000){
            $newSize = $size."B";
        }
        
        else if($size > 1000 && $size < 1000000){
            $newSize = round($size/1000, 2)."KB";
        }
        
        else{
            $newSize = round($size/1000000, 2)."MB";
        }
        
        return $newSize;
    }
    
    
    
    
    
    /**
     * Set and return pagination configuration
     * @param type $totalRows
     * @param type $urlToCall
     * @param type $limit
     * @param type $attributes
     * @return boolean
     */
    public function setPaginationConfig($totalRows, $urlToCall, $limit, $attributes, $uri_segment=3){
        $config = ['total_rows'=>$totalRows, 'base_url'=>base_url().$urlToCall, 'per_page'=>$limit, 'uri_segment'=>$uri_segment,
            'num_links'=>$totalRows/$limit, 'use_page_numbers'=>TRUE, 'first_link'=>FALSE, 'last_link'=>FALSE,
            'prev_link'=>'&lt;&lt;', 'next_link'=>'&gt;&gt;', 'full_tag_open'=>"<ul class='pagination'>", 'full_tag_close'=>'</ul>', 
            'num_tag_open'=>'<li>', 'num_tag_close'=>'</li>', 'next_tag_open'=>'<li>', 'next_tag_close'=>'</li>',
            'prev_tag_open'=>'<li>', 'prev_tag_close'=>'</li>', 'cur_tag_open'=>'<li><a><b style="color:black">', 
            'cur_tag_close'=>'</b></a></li>', 'attributes'=>$attributes];
        
        
        return $config;
    }
    
    
    
    /**
     * 
     */
    public function get_default_email(){
    	return "info@designaura.net";
    }
}