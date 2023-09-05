<?php 

class User extends CI_Controller{

    // function construct
    public function __construct()
    {
        parent::__construct();

        // load model user
        $this->load->model('Guru_model', 'users');
    }

    public function index(){
        $this->load->view('user/index');
    }
}




?>