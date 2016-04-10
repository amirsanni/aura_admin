<?php

defined('BASEPATH') OR exit('');

/**
 * Description of Blog
 *
 * @author Ameer <amirsanni@gmail.com>
 * @date 30th RabAwwal, 1437AH
 * @date 11th Jan., 2016
 */
class Blogs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->genlib->checkLogin();

        $this->load->model('blogmodel');
        $this->load->helper('text');
    }



    public function index() {

        $data['pageContent'] = $this->load->view('blogs/blogs', '', TRUE);
        $data['pageTitle'] = "Blogs";

        $this->load->view('main', $data);
    }



    /**
     * lau_ = "Load all blogs"
     */
    public function lab_() {
        //set the sort order
        $order_by = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "title";
        $order_format = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";

        //count the total blogs in db
        $total_blogs = $this->db->count_all('blogs');

        $this->load->library('pagination');

        $page_number = $this->uri->segment(3, 0); //set page number to zero if the page number is not set in the third segment of uri

        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10; //show $limit per page
        $start = $page_number == 0 ? 0 : ($page_number - 1) * $limit; //start from 0 if $page_number is 0, else start from the next iteration
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes, $uri_segment=3) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($total_blogs, "blogs/lab_", $limit, ['class' => 'lnp'], "");

        $this->pagination->initialize($config); //initialize the library class
        //get all blogs from db
        $data['all_blogs'] = $this->blogmodel->get_all($order_by, $order_format, $start, $limit);
        $data['range'] = $total_blogs > 0 ? ($start + 1) . "-" . ($start + count($data['all_blogs'])) . " of " . $total_blogs : "";
        $data['links'] = $this->pagination->create_links(); //page links
        $data['sn'] = $start + 1;

        $json['blogsTable'] = $this->load->view('blogs/all_blogs', $data, TRUE); //get view with populated customers table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }





    public function add() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a blog item';

        $this->form_validation->set_rules('title', 'Title', ['strtolower', 'ucfirst', 'required'], ['required' => "required"]);
        $this->form_validation->set_rules('body', 'Text', 'required', ['required' => "required"]);
        $this->form_validation->set_rules('author', 'Author', ['max_length[30]', 'strtolower', 'ucfirst', 'required'], ['required' => "required"]);

        if ($this->form_validation->run() !== FALSE) {

            //move logo to disk and get url if logo was uploaded
            if (!empty($_FILES['logo']['tmp_name'])) {
                /*
                 * upload_logo method will try to upload file and return status based on the success or failure of the upload
                 * The status and msg will be returned to the client.
                 */
                $logo_info = $this->upload_logo($_FILES['logo']);

                //insert details if logo was uploaded successfully
                $inserted_id = $logo_info['status'] === 1 ?
                        $this->blogmodel->addblog(set_value('title'), set_value('body'), set_value('author'), $logo_info['logo_url']) : "";

                $json['status'] = $inserted_id ? 1 : 0;
                $json['logo_error'] = $logo_info['logo_error_msg'];
            } 


            else {

                /**
                 * insert info into db
                 * function header: add($username, $first_name, $last_name, $email, $profession, $mobile_1, $mobile_2, $password, $logo
                 * $street, $city, $state, $country)
                 */
                $inserted_id = $this->blogmodel->addblog(set_value('title'), set_value('body'), set_value('author'), '');

                //send welcome email to user
                //$inserted_id ? $this->genlib->sendWelcomeMessage($membershipId, $memberName, set_value('email')) : "";

                $json['status'] = $inserted_id ? 1 : 0;
            }
        } 


        else {
            //return all error messages
            $json = $this->form_validation->error_array(); //get an array of all errors

            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    private function upload_logo($file) {
        $json = [];

        if (!empty($file)) {

            /*
             * We replace the '.' and '@' chars from the email to prevent folder naming error as it
             * will be used as the name of the user's folder
             */

            //make dir to upload logo
            if (!file_exists("../blog_images")) {
                mkdir("../blog_images");
            }

            $config['file_name'] = "my_logo"; //use this as the name of all user's logos
            $config['upload_path'] = "../blog_images/"; //files are stored outside the app root
            $config['allowed_types'] = 'jpg|png|jpeg|jpe';
            $config['file_ext_tolower'] = FALSE;
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 500; //in kb

            $this->load->library('upload', $config); //load CI's 'upload' library

            if ($this->upload->do_upload('logo') == FALSE) {
                $msg = $this->upload->display_errors();

                $json = ['logo_error_msg' => $msg, 'status' => 0];
            } 


            else {
                //get array of file info on success
                $data = $this->upload->data();

                //set values to insert into db
                $file_name = $data['file_name']; //new file name with the extension
                $logo_url = "download/blog/{$file_name}"; //link that will be visible to users

                $json = ['status' => 1, 'logo_url' => $logo_url, 'logo_error_msg' => ''];
            }
        } 


        else {
            $json = ['status' => 0, 'logo_error_msg' => "No image was selected"];
        }


        return $json;
    }




    public function update() {
        $this->genlib->ajaxOnly();

        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules('title', 'Title', ['strtolower', 'ucfirst', 'required'], ['required' => "required"]);
        $this->form_validation->set_rules('body', 'Text', 'required', ['required' => "required"]);
        $this->form_validation->set_rules('author', 'Author', ['max_length[30]', 'strtolower', 'ucfirst', 'required'], ['required' => "required"]);
        $blog_id = $this->input->post('id', TRUE);

        if ($this->form_validation->run() !== FALSE) {
            $this->db->trans_start();
            //move logo to disk and get url if logo was uploaded
            if (!empty($_FILES['logo']['tmp_name'])) {
                /*
                 * upload_logo method will try to upload file and return status based on the success or failure of the upload
                 * The status and msg will be returned to the client.
                 */
                $logo_info = $this->upload_logo($_FILES['logo']);

                /**
                 * update info in db
                 * function header: update($id, $title, $body, $author, $logo url)
                 */
                $updated = $logo_info['status'] === 1 ?
                        $this->blogmodel->update($blog_id, set_value('title'), set_value('body'), set_value('author'), $logo_info['logo_url']) : "";

                $this->db->trans_complete();

                $json = $updated ?
                        ['status' => 1, 'msg' => "Blog successfully updated"] :
                        ['status' => 0, 'msg' => "Oops! Unexpected server error! Pls contact your administrator for help. Sorry for the embarrassment"];
            } 



            else {

                /**
                 * insert info into db
                 * function header: add($username, $first_name, $last_name, $email, $profession, $mobile_1, $mobile_2, $password, $logo
                 * $street, $city, $state, $country)
                 */
                $updated = $this->blogmodel->update($blog_id, set_value('title'), set_value('body'), set_value('author'), '');
                
                $this->db->trans_complete();
                //send welcome email to user
                //$inserted_id ? $this->genlib->sendWelcomeMessage($membershipId, $memberName, set_value('email')) : "";
                $json = $updated ? ['status' => 1, 'msg' => "Blog successfully updated"] : ['status' => 0, 'msg' => "Oops! Unexpected server error! Pls contact your administrator for help. Sorry for the embarrassment"];
            }
        } 



        else {
            //return all error messages
            $json = $this->form_validation->error_array(); //get an array of all errors

            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json['status'] = 0;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Used as a callback while updating user's info to ensure 'mobile_1' field does not contain a number already used by another user
     * @param type $title
     * @param type $id
     */
    public function crosscheckMobile($title, $id) {
        //check db to ensure the title was previously used for user with $user_id i.e. the same user we're updating
        $blog_with_title = $this->genmod->getTableCol('blogs', 'id', 'title', $title);

        //if title does not exist or it exist but was used by current user
        if (!$blog_with_title || ($blog_with_title == $id)) {
            return TRUE;
        } 


        else {//if it exist and was used in another blog
            $this->form_validation->set_message('crosscheckMobile', 'This number is already used by another user');

            return FALSE;
        }
    }




    /**
     * To get blog's details for edit/update
     */
    public function get_blog_det() {
        $this->genlib->ajaxOnly();

        $id = $this->input->post('id', TRUE);

        //call model to get info
        $blog_info = $this->blogmodel->getblogdet($id);

        if ($blog_info) {

            foreach ($blog_info as $get) {
                $json['title'] = $get->title;
                $json['body'] = $get->body;
                $json['author'] = $get->author;
                $json['logo'] = $get->default_image;
            }
            $json['id'] = $id; 
            $json['status'] = 1;
        } 


        else {
            $json = ['status' => 0];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /**
     * cbps = "Change blog published status"
     */
    public function cbps() {
        $blog_id = $this->input->get('id', TRUE);
        $new_status = $this->input->get('ns', TRUE);

        //updateTableCol($tableName, $colName, $colVal, $whereCol, $whereColVal)
        $updated = $this->genmod->updatetablecol('blogs', 'published', $new_status, 'id', $blog_id);

        $json['status'] = $updated ? 1 : 0;

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

}