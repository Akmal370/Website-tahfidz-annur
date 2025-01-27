<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller_ctl extends MY_Auth
{
    var $id_role = '';
    var $id_user = '';
    var $name = '';
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_role = $this->session->userdata(PREFIX_SESSION.'_id_role');
        $this->id_user = $this->session->userdata(PREFIX_SESSION.'_id_user');
        $this->name = $this->session->userdata(PREFIX_SESSION.'_name');
    }

    public function index()
    {
        redirect('login');
    }
    
    public function login()
    {
        if ($this->session->userdata(PREFIX_SESSION.'_id_user')) {
            redirect('dashboard');
        }
        // GLOBAL VARIABEL
        $this->data['title'] = 'Masuk untuk melanjutkan akses';

        // LOAD JS
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/auth/login.js"></script>';

        $mydata['setting'] = $this->action_m->get_single('setting',['id_setting' => 1]);
        // LOAD VIEW
        $this->data['content'] = $this->load->view('login', $mydata, TRUE);
        $this->display();
    }

    public function register()
    {
        // GLOBAL VARIABEL
        $this->data['title'] = 'Daftar menjadi member';

        // LOAD JS
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/auth/register.js"></script>';

        $mydata['setting'] = $this->action_m->get_single('setting',['id_setting' => 1]);
        // LOAD VIEW
        $this->data['content'] = $this->load->view('register', $mydata, TRUE);
        $this->display();
    }
}
