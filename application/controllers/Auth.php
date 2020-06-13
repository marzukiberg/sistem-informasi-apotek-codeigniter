<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
  
  public function __construct(){
    parent::__construct();
    
  }
  
	public function index()
	{
	  if($this->session->login===true){
      redirect("admin");
    } 
    
	  $data['title'] = 'Apotek | Login';
	  $this->load->view('module/header', $data);
	  $this->load->view('login');
		$this->load->view('module/footer');
	}
	
	public function login(){
	  $username = $this->input->post("username");
	  $password = $this->input->post("password");
	  
	  $cek = $this->db->get_where("users", ["username" => $username])->result();
	  if(count($cek) > 0){
	    if($cek[0]->password === sha1($password)){
	      
	      $this->session->set_userdata([
	        "login" => true, 
	        "name" => $cek[0]->name
	        ]);
	      
	      redirect("admin");
	    }else{
	      $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Password salah!</div>");
        redirect("auth");
	    }
	  }else{
	    $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Username tidak terdaftar!</div>");
      redirect("auth");
	  }
	}
	
	public function logout(){
	  session_destroy();
	  
	  redirect("auth", "refresh");
	}
}
