<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "functions.php";

/**
 * Description of Test
 *
 * @author Amir <amirsanni@gmail.com>
 * Date: Dec 31st, 2015
 */

class Test extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
    }
    
    
    public function index(){
        echo password_hash("mm3v6ki3fr", PASSWORD_BCRYPT);
    }
    
    
    
    public function newhex(){
        echo md5(time());
    }
   
}