<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller_ctl extends MY_Admin
{
    var $id_user = '';
    var $id_role = '';
    var $access = [];
    var $acc = 0;
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_user = $this->session->userdata(PREFIX_SESSION.'_id_user');
        $this->id_role = $this->session->userdata(PREFIX_SESSION.'_id_role');
        // $this->id_role = 4
        // $this->id_user = 27;
        $this->access = $this->access();

    }

    public function index()
    {
        redirect('master/user');
    }


    public function user()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data User';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "master/user"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/master/user.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['user.status'] = $status;
            }
        }
        $where['user.role'] = 1;
        $where['user.delete'] = 'N';
        $where['user.id_user !='] = $this->id_user;
        if ($search) {
            $params['columnsearch'][] = 'user.name';
            $params['columnsearch'][] = 'user.email';
            $params['columnsearch'][] = 'user.phone';
            $params['search'] = $search;
        }
        $jumlah = $this->action_m->cnt_where_params('user', $where, 'user.*', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('user', $where, 'user.*', $params);
        
        $mydata['result'] = $result;
        $mydata['search'] = $search;

        load_pagination('master/user', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('user', $mydata, TRUE);
        $this->display();
    }


    public function member()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Member';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "master/member"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/master/user.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['user.status'] = $status;
            }
        }
        $where['approve'] = 'Y';
        $where['user.role'] = 2;
        $where['user.delete'] = 'N';
        $where['user.id_user !='] = $this->id_user;
        if ($search) {
            $params['columnsearch'][] = 'user.name';
            $params['columnsearch'][] = 'user.email';
            $params['columnsearch'][] = 'user.phone';
            $params['search'] = $search;
        }
        $jumlah = $this->action_m->cnt_where_params('user', $where, 'user.*', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('user', $where, 'user.*', $params);
        
        $mydata['result'] = $result;
        $mydata['search'] = $search;

        load_pagination('master/member', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('member', $mydata, TRUE);
        $this->display();
    }

}
