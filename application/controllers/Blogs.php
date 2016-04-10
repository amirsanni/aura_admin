<?php
defined('BASEPATH') OR exit('');


/**
 * Description of Blog
 *
 * @author Ameer <amirsanni@gmail.com>
 * @date 30th RabAwwal, 1437AH
 * @date 11th Jan., 2016
 */
class Blogs extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
            $this->genlib->checkLogin();

            $this->load->model('blogmodel');
    }
    
    public function index(){
        
        $data['pageContent'] = $this->load->view('blogs/blogs', '', TRUE);
        $data['pageTitle'] = "Blog";
        
        $this->load->view('main', $data);
    }

        
    /**
     * lau_ = "Load all blogs"
     */
    public function lab_(){
        //set the sort order
        $order_by = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "title";
        $order_format = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        //count the total users in db
        $total_blogs = $this->db->count_all('blogs');
        
        $this->load->library('pagination');
        
        $page_number = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
	
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $page_number == 0 ? 0 : ($page_number - 1) * $limit;//start from 0 if $page_number is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes, $uri_segment=3) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($total_blogs, "users/lab_", $limit, ['class'=>'lnp'], "");
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all blogs from db
        $data['all_blogs'] = $this->blogmodel->get_all($order_by, $order_format, $start, $limit);
        $data['range'] = $total_blogs > 0 ? ($start+1) . "-" . ($start + count($data['all_blogs'])) . " of " . $total_blogs : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        
        $json['blogsTable'] = $this->load->view('blogs/all_blogs', $data, TRUE);//get view with populated customers table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
        
        public function add()
            {
                $this->load->helper('form');
                $this->load->library('form_validation');

                $data['title'] = 'Create a blog item';

                $this->form_validation->set_rules('title', 'Title', ['strtolower', 'ucfirst', 'required'], ['required'=>"required"]);
                $this->form_validation->set_rules('body', 'Text', 'required', ['required'=>"required"]);
                $this->form_validation->set_rules('author', 'Title', ['strtolower', 'ucfirst', 'required'], ['required'=>"required"]);

                if($this->form_validation->run() !== FALSE){
            
                //move logo to disk and get url if logo was uploaded
                if(!empty($_FILES['logo']['tmp_name'])){
                    /*
                     * upload_logo method will try to upload file and return status based on the success or failure of the upload
                     * The status and msg will be returned to the client.
                     */
                    $logo_info = $this->upload_logo($_FILES['logo']);

                    //insert details if logo was uploaded successfully
                    $inserted_id = $logo_info['status'] === 1 
                        ? 
                        $this->blogmodel->addblog(set_value('title'), set_value('body'), set_value('author'),$logo_info['logo_url']) : "";

                    $json['status'] = $inserted_id ? 1 : 0;
                    $json['logo_error'] = $logo_info['logo_error_msg'];
                }


                else{

                    /**
                     * insert info into db
                     * function header: add($username, $first_name, $last_name, $email, $profession, $mobile_1, $mobile_2, $password, $logo
                     * $street, $city, $state, $country)
                     */
                    $inserted_id = $this->blogmodel->addblog(set_value('title'), set_value('body'), set_value('author'));

                    //send welcome email to user
                    //$inserted_id ? $this->genlib->sendWelcomeMessage($membershipId, $memberName, set_value('email')) : "";

                    $json['status'] = $inserted_id ? 1 : 0;

                }
            }

            else{
                //return all error messages
                $json = $this->form_validation->error_array();//get an array of all errors

                $json['msg'] = "One or more required fields are empty or not correctly filled";
                $json['status'] = 0;
            }

            $this->output->set_content_type('application/json')->set_output(json_encode($json));
        } 
        
        
        private function upload_logo($file){
        $json = [];
        
        if(!empty($file)){
            
            /*
             * We replace the '.' and '@' chars from the email to prevent folder naming error as it
             * will be used as the name of the user's folder
             */
            $stringified_email = "aura_blogs";
            
            //make dir to upload logo
            file_exists("../aura_users") ?  : mkdir("../aura_users");
            if(!file_exists("../aura_users/{$stringified_email}")){
                mkdir("../aura_users/{$stringified_email}");
            }
            
            $config['file_name'] = "my_logo";//use this as the name of all user's logos
            $config['upload_path'] = "../aura_users/{$stringified_email}/";//files are stored outside the app root
            $config['allowed_types'] = 'jpg|png|jpeg|jpe';
            $config['file_ext_tolower'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 500;//in kb

            $this->load->library('upload', $config);//load CI's 'upload' library

            if($this->upload->do_upload('logo') == FALSE){
                $msg = $this->upload->display_errors();
                
                $json = ['logo_error_msg'=>$msg, 'status'=>0];
            }

            else{
                //get array of file info on success
                $data = $this->upload->data();

                //set values to insert into db
                $file_name = $data['file_name'];//new file name with the extension
                $logo_url = "download/logo/{$stringified_email}/{$file_name}";//link that will be visible to users
                
                $json = ['status'=>1, 'logo_url'=>$logo_url, 'logo_error_msg'=>''];
            }
        }
        
        
        else{
            $json = ['status'=>0, 'logo_error_msg'=>"No image was selected"];
        }
        
        
        return $json;
    }
}
