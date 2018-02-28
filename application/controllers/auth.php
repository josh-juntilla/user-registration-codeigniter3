<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
        
        public $status; 
        public $roles;
    
        function __construct(){
            parent::__construct();
            $this->load->model('User_model', 'user_model', TRUE);
            $this->load->library(['form_validation', 'user']);    
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            $this->config->load('roles', true);
            $this->status = $this->config->item('status','roles'); 
            $this->roles  = $this->config->item('roles','roles');
        }      
    
	public function index()
	{
        // redirect to login page
        $this->login();
	}
        
        
        public function register()
        {
            // if ($this->user->isLoggedIn()) {
            //     redirect();
            // }
             
            $this->form_validation->set_rules('firstname', 'First Name', 'required');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required');    
            $this->form_validation->set_rules('gender', 'Gender', 'required');    
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');    
                       
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('register', [
                    'page_title' => 'User Registration',
                    'islogin' => $this->user->isLoggedIn()
                ]);
            }else{                
                if($this->user_model->isDuplicate($this->input->post('email'))){
                    $this->session->set_flashdata('flash_message', 'User email already exists');
                    redirect(base_url().'auth/login');
                }else{
                    
                    $clean = $this->security->xss_clean($this->input->post(NULL,TRUE));
                    $id = $this->user_model->insertUser($clean);
                    $token = $this->user_model->insertToken($id);
                    
                    $qstring = $this->base64url_encode($token);
                    $url = base_url() . 'auth/complete/token/' . $qstring;
                    $link = '<a href="' . $url . '">' . $url . '</a>'; 

                    // send mail
                    try {
                        $this->load->library('mailer');
                        $this->mailer->addAddress($this->input->post('email'), $this->input->post('firstname') . ' ' . $this->input->post('lastname'));

                        $this->mailer->Subject = 'Welcome!';
                        $this->mailer->Body    = $this->load->view('newsletter/register', array(
                            'confirmation_url' => $url,
                        ), true);

                        $this->mailer->send();
                    } catch (Exception $e) {
                        echo 'Message could not be sent. Mailer Error: ', $this->mailer->ErrorInfo;
                        exit();
                    }

                    $this->load->view('register_success', [
                        'islogin' => $this->user->isLoggedIn()
                    ]);
                }  
            }
        }
        
        
        protected function _islocal(){
            return strpos($_SERVER['HTTP_HOST'], 'local');
        }
        
        public function complete()
        {                                   
            $token = base64_decode($this->uri->segment(4));       
            $cleanToken = $this->security->xss_clean($token);
            
            $user_info = $this->user_model->isTokenValid($cleanToken); //either false or array();           
            
            if(!$user_info){
                $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
                redirect(base_url().'auth/login');
            }            
            $data = array(
                'firstName'=> $user_info->first_name, 
                'email'=>$user_info->email, 
                'user_id'=>$user_info->id, 
                'token'=>$this->base64url_encode($token),
                'islogin' => $this->user->isLoggedIn(),
            );
           
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');              
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('complete', $data);
            }else{
                $this->load->library('password');                 
                $post = $this->input->post(NULL, TRUE);
                
                $cleanPost = $this->security->xss_clean($post);
                
                $hashed = $this->password->create_hash($cleanPost['password']);                
                $cleanPost['password'] = $hashed;
                unset($cleanPost['passconf']);
                $userInfo = $this->user_model->updateUserInfo($cleanPost);
                
                if(!$userInfo){
                    $this->session->set_flashdata('flash_message', 'There was a problem updating your record');
                    redirect(base_url().'auth/login');
                }

                $this->user_model->updateToken($cleanToken);
                
                unset($userInfo->password);
                
                foreach($userInfo as $key=>$val){
                    $this->session->set_userdata($key, $val);
                }
                redirect(base_url().'auth/success');
            }
        }
        
        public function login()
        {
            // added IF statement to check the session if someone already logged-in
            // if not logged-in, usual login form will show otherwise, user will be redirect to homepage 
            // if ($this->user->isLoggedIn()) {
            //     redirect();
            // }

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');    
            $this->form_validation->set_rules('password', 'Password', 'required'); 
            
            if($this->form_validation->run() == FALSE) {
                $this->load->view('login', [
                    'page_title' => 'User Login',
                    'islogin' => $this->user->isLoggedIn()
                ]);
            }else{
                
                $post = $this->input->post();  
                $clean = $this->security->xss_clean($post);
                
                $userInfo = $this->user_model->checkLogin($clean);
                
                if(!$userInfo){
                    $this->session->set_flashdata('flash_message', 'The login was unsucessful');
                    redirect(base_url().'auth/login');
                }                
                foreach($userInfo as $key=>$val){
                    $this->session->set_userdata($key, $val);
                }

                redirect(base_url().'auth/success');
            }
        }
        
        public function logout()
        {
            $this->session->sess_destroy();
            redirect(base_url().'auth/login/');
        }
        
        public function forgot()
        {
            if ($this->user->isLoggedIn()) {
                redirect();
            }

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
            
            if($this->form_validation->run() == FALSE) {
                $this->load->view('forgot', [
                    'islogin' => $this->user->isLoggedIn()
                ]);
            }else{
                $email = $this->input->post('email');  
                $clean = $this->security->xss_clean($email);
                $userInfo = $this->user_model->getUserInfoByEmail($clean);
                
                if(!$userInfo){
                    $this->session->set_flashdata('flash_message', 'We cant find your email address');
                    redirect(base_url().'auth/login');
                }   
                
                if($userInfo->status != $this->status[1]){ //if status is not approved
                    $this->session->set_flashdata('flash_message', 'Your account is not in approved status');
                    redirect(base_url().'auth/login');
                }
                
                //build token 
                $token = $this->user_model->insertToken($userInfo->id);                        
                $qstring = $this->base64url_encode($token);                  
                $url = base_url() . 'auth/reset_password/token/' . $qstring;

                // send mail
                try {
                    $this->load->library('mailer');
                    $this->mailer->addAddress($this->input->post('email'));

                    $this->mailer->Subject = 'Forgot Password';
                    $this->mailer->Body    = $this->load->view('newsletter/forgot_password', array(
                        'forgot_url' => $url,
                    ), true);

                    $this->mailer->send();
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $this->mailer->ErrorInfo;
                    exit();
                }

                $this->load->view('forgot_success', [
                    'islogin' => $this->user->isLoggedIn()
                ]);
            }
            
        }
        
        public function reset_password()
        {
            // if ($this->user->isLoggedIn()) {
            //     redirect();
            // }

            $token = $this->base64url_decode($this->uri->segment(4));                  
            $cleanToken = $this->security->xss_clean($token);
            
            $user_info = $this->user_model->isTokenValid($cleanToken); //either false or array();               
            
            if(!$user_info){
                $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
                redirect(base_url().'auth/login');
            }            
            $data = array(
                'firstName'=> $user_info->first_name, 
                'email'=>$user_info->email, 
//                'user_id'=>$user_info->id, 
                'token'=>$this->base64url_encode($token),
                'islogin' => $this->user->isLoggedIn()
            );
           
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');              
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('reset_password', $data);
            }else{
                                
                $this->load->library('password');                 
                $post = $this->input->post(NULL, TRUE);                
                $cleanPost = $this->security->xss_clean($post);                
                $hashed = $this->password->create_hash($cleanPost['password']);                
                $cleanPost['password'] = $hashed;
                $cleanPost['user_id'] = $user_info->id;
                unset($cleanPost['passconf']);                
                if(!$this->user_model->updatePassword($cleanPost)){
                    $this->session->set_flashdata('flash_message', 'There was a problem updating your password');
                }else{
                    
                    $this->session->set_flashdata('flash_message', 'Your password has been updated. You may now login');
                }
                redirect(base_url().'auth/success');                
            }
        }

    public function success(){

       // if ($this->user->isLoggedIn()) {
       //      redirect();
       //  }
    
        $this->load->view('success',['islogin' => $this->user->isLoggedIn(),]);
    }    
        
    private function base64url_encode($data) { 
      return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    } 

    private function base64url_decode($data) { 
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    }       
}
