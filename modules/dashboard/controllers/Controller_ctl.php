<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller_ctl extends MY_Admin
{
    var $id_role = '';
    var $id_user = '';
    var $access = [];
    var $acc = 0;
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_role = $this->session->userdata(PREFIX_SESSION.'_id_role');
        // $this->id_role = 4;
        $this->id_user = $this->session->userdata(PREFIX_SESSION.'_id_user');
        // $this->id_user = 27;
        $this->access = $this->access();

    }

    public function index()
    {
       $this->dashboard();
    }
    
    public function dashboard()
    {
        // GLBL
        $this->data['title'] = 'Dashboard';

        $mydata = [];

         // LOAD JS
        $this->data['js_add'][] = '<script>var page = "dashboard"</script>';
        
        $limit = 10;
        $offset = $this->uri->segment(2);
        $params = [];
        $where['user.status'] = 'Y';
        $where['user.approve'] = 'N';
        $where['user.role'] = 2;
        $where['user.delete'] = 'N';
        $jumlah = $this->action_m->cnt_where_params('user', $where, 'user.*', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('user', $where, 'user.*', $params);
        
        $mydata['result'] = $result;
        $mydata['search'] = $search;
        $mydata['offset'] = $offset;

        load_pagination('dashboard', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('index', $mydata, TRUE);
        $this->display();
    }


    public function report()
    {
        $tanggal_mulai = $this->input->get('date_start');
        $tanggal_selesai = $this->input->get('date_end');

        if (!$tanggal_mulai) {
            $tanggal_mulai = date('Y-m-d', strtotime(date('Y-m-d') . ' -4 days'));
        }

        if (!$tanggal_selesai) {
            $tanggal_selesai = date('Y-m-d');
        }else{
            if (strtotime($tanggal_selesai) <= strtotime($tanggal_mulai)) {
                $tanggal_selesai = date('Y-m-d');
            }
        }
        // var_dump($this->setting);die;
        // GLBL
        $this->data['title'] = 'Laporan';

        $mydata = [];

         // LOAD JS
        $this->data['js_add'][] = '<script>var page = "report"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/dashboard/report.js"></script>';

        // SET DATA
        $params = [];
        $limit = 5;
        $offset = $this->uri->segment(2);

        $where['DATE(donasi.create_date) <= '] = $tanggal_selesai;
        $where['DATE(donasi.create_date) >='] = $tanggal_mulai;
        $params['arrorderby']['kolom'] = 'donasi.create_date';
        $params['arrorderby']['order'] = 'ASC';
        $jumlah = $this->action_m->cnt_where_params('donasi',$where,'donasi.*',$params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }

        $result = $this->action_m->get_where_params('donasi',$where,'donasi.*',$params);

        $status = [];
        $keuangan = [];

        // Mengubah tanggal ke timestamp
        $startTimestamp = strtotime($tanggal_mulai);
        $endTimestamp = strtotime($tanggal_selesai);

        // Menghitung selisih dalam detik, lalu diubah ke hari
        $diffInSeconds = $endTimestamp - $startTimestamp;
        $selisih = $diffInSeconds / (60 * 60 * 24);
        $tgl_bro = $tanggal_mulai;
        for ($i=0; $i < $selisih; $i++) { 
            $key = date('Ymd',strtotime($tgl_bro.' +1 days'));
            $keuangan[$key] = 0;
            $tgl_bro = $key;
        }
        if ($result) {

            foreach ($result as $key) {
                $keuangan[date('Ymd',strtotime($key->create_date))] += $key->nominal;
            }
        }
        // DISPLAY DATA
        $mydata['result'] = $result;
        $mydata['offset']= $offset;
        $mydata['tanggal_mulai']= $tanggal_mulai;
        $mydata['tanggal_selesai']= $tanggal_selesai;
        $mydata['keuangan'] = $keuangan;
        // LOAD VIEW
        load_pagination('report', $limit, $jumlah);
        $this->data['content'] = $this->load->view('report', $mydata, TRUE);
        $this->display();
    }

}
