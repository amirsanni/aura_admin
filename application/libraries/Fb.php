<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Facebook/autoload.php';

Class Fb{
    
    protected $CI;
    protected $appId = "811998922250501";//"620130591462911";
    protected $appSecret = "d0cebc61ee5593129adb9358812283c5";//"438d1a6990c7433397363acc0d1155d1";
    protected $version = "v2.4";
    protected $userInfo = "";
    protected $loginUrl = "";
    protected $permissions = "";
    protected $accessToken = "";
    protected $fb = "";
    protected $helper = "";

    public function __construct() {
        $this->CI = &get_instance();
        
        //session_start();

        $this->fb = new Facebook\Facebook([
            'app_id' => $this->appId,
            'app_secret' => $this->appSecret,
            'default_graph_version' => $this->version,
        ]);

        $this->helper = $this->fb->getRedirectLoginHelper();

        $this->permissions = ['email']; // optional

        try {
            if (isset($_SESSION['facebook_access_token'])) {
                $this->accessToken = $_SESSION['facebook_access_token'];
            } 

            else {
                $this->accessToken = $this->helper->getAccessToken();
            }
        } 

        catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            //echo 'Graph returned an error: ' . $e->getMessage();
            $this->session->sess_destroy();
            unset($_SESSION['facebook_access_token']);
            redirect(base_url());
            //exit;
        } 

        catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            //exit;
            
            $this->session->sess_destroy();
            unset($_SESSION['facebook_access_token']);
            redirect(base_url());
        }
    }

    public function getFbAccess() {
        if (isset($this->accessToken)) {
            if (isset($_SESSION['facebook_access_token'])) {
                $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } 

            else {
                // getting short-lived access token
                $_SESSION['facebook_access_token'] = (string) $this->accessToken;

                // OAuth 2.0 client handler
                $oAuth2Client = $this->fb->getOAuth2Client();

                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

                // setting default access token to be used in script
                $this->fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }

            // getting basic info about user
            try {
                $profile_request = $this->fb->get('/me?fields=name,first_name,last_name,email,gender');

                //$profile = $profile_request->getGraphNode()->asArray();
                $this->userInfo = $profile_request->getGraphUser();
            } 

            catch (Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                //echo 'Graph returned an error: ' . $e->getMessage();
                //exit;
                
                $this->session->sess_destroy();
                unset($_SESSION['facebook_access_token']);
                redirect(base_url());
            } 

            catch (Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                //echo 'Facebook SDK returned an error: ' . $e->getMessage();
                //exit;
                
                $this->session->sess_destroy();
                unset($_SESSION['facebook_access_token']);
                redirect(base_url());
            }
        }
        
        return $this->userInfo ? $this->userInfo : "";
    }
    
    
    
    public function getFbUrl(){
        // replace your website URL same as added in the developers.facebook.com/apps 
        // e.g. if you used http instead of https and you used non-www version or 
        // www version of your website then you must add the same here
        $this->loginUrl = $this->helper->getLoginUrl(base_url(), $this->permissions);
        
        return $this->loginUrl;
    }
    
}
