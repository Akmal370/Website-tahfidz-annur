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

        $this->acc = cek_access($this->access);

    }

    public function index()
    {
        redirect($this->access['landing']);
    }

    public function banner()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Banner';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "basedata/banner"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/basedata/banner.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['banner.status'] = $status;
            }
        }
        
        $where['banner.delete'] = 'N';
        if ($search) {
            $params['columnsearch'][] = 'title';
            $params['search'] = $search;
        }
        $jumlah = $this->action_m->cnt_where_params('banner', $where, 'banner.*', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('banner', $where, 'banner.*', $params);
        // CETAK DATA

        $mydata['result'] = $result;
        $mydata['search'] = $search;
        $mydata['action'] = $this->access['action'];
        $mydata['prefix_page'] = 'page_'.$this->acc;

        load_pagination('basedata/banner', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('banner', $mydata, TRUE);
        $this->display();
    }
    

    public function quotes()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Quotes';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "basedata/quotes"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/basedata/quotes.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['quotes.status'] = $status;
            }
        }
        
        $where['quotes.delete'] = 'N';
        if ($search) {
            $params['columnsearch'][] = 'text';
            $params['search'] = $search;
        }
        $jumlah = $this->action_m->cnt_where_params('quotes', $where, 'quotes.*', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('quotes', $where, 'quotes.*', $params);
        // CETAK DATA

        $mydata['result'] = $result;
        $mydata['search'] = $search;
        $mydata['action'] = $this->access['action'];
        $mydata['prefix_page'] = 'page_'.$this->acc;

        load_pagination('basedata/quotes', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('quotes', $mydata, TRUE);
        $this->display();
    }



    public function news()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');
        $id_news_category = $this->input->get('id_news_category');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Berita';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "basedata/news"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/basedata/news.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['news.status'] = $status;
            }
        }
        
        $where['news.delete'] = 'N';
        if ($search) {
            $params['columnsearch'][] = 'title';
            $params['columnsearch'][] = 'short_description';
            $params['columnsearch'][] = 'long_description';
            $params['search'] = $search;
        }

        if ($id_news_category && $id_news_category != 'all') {
            $where['news.id_news_category'] = $id_news_category;
        }
        $params['arrorderby']['kolom'] = 'news.create_date';
        $params['arrorderby']['order'] = 'DESC';
        $params['arrjoin']['news_category']['statement'] = 'news_category.id_news_category = news.id_news_category';
        $params['arrjoin']['news_category']['type'] = 'LEFT';

        $jumlah = $this->action_m->cnt_where_params('news', $where, 'news.*,news_category.name AS category', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('news', $where, 'news.*,news_category.name AS category', $params);
        $category = $this->action_m->get_all('news_category',['status' => 'Y','delete' => 'N']);
        // CETAK DATA

        $mydata['result'] = $result;
        $mydata['category'] = $category;
        $mydata['search'] = $search;
        $mydata['action'] = $this->access['action'];
        $mydata['prefix_page'] = 'page_'.$this->acc;

        load_pagination('basedata/news', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('news', $mydata, TRUE);
        $this->display();
    }


    public function struktur()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');
        $id_struktur_jabatan = $this->input->get('id_struktur_jabatan');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Berita';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "basedata/struktur"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/basedata/struktur.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['struktur.status'] = $status;
            }
        }
        
        $where['struktur.delete'] = 'N';
        if ($search) {
            $params['columnsearch'][] = 'name';
            $params['search'] = $search;
        }

        if ($id_struktur_jabatan && $id_struktur_jabatan != 'all') {
            $where['struktur.id_struktur_jabatan'] = $id_struktur_jabatan;
        }
        $params['arrjoin']['struktur_jabatan']['statement'] = 'struktur_jabatan.id_struktur_jabatan = struktur.id_struktur_jabatan';
        $params['arrjoin']['struktur_jabatan']['type'] = 'LEFT';

        $jumlah = $this->action_m->cnt_where_params('struktur', $where, 'struktur.*,struktur_jabatan.name AS jabatan', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('struktur', $where, 'struktur.*,struktur_jabatan.name AS jabatan', $params);
        $jabatan = $this->action_m->get_all('struktur_jabatan',['status' => 'Y','delete' => 'N']);
        // CETAK DATA

        $mydata['result'] = $result;
        $mydata['jabatan'] = $jabatan;
        $mydata['search'] = $search;
        $mydata['action'] = $this->access['action'];
        $mydata['prefix_page'] = 'page_'.$this->acc;

        load_pagination('basedata/struktur', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('struktur', $mydata, TRUE);
        $this->display();
    }


    public function tokoh()
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Tokoh';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "basedata/tokoh"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/basedata/tokoh.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['tokoh.status'] = $status;
            }
        }
        
        $where['tokoh.delete'] = 'N';
        if ($search) {
            $params['columnsearch'][] = 'name';
            $params['columnsearch'][] = 'address';
            $params['search'] = $search;
        }
        $jumlah = $this->action_m->cnt_where_params('tokoh', $where, 'tokoh.*', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('tokoh', $where, 'tokoh.*', $params);
        $sosmed = $this->action_m->get_all('sosmed');
        // CETAK DATA

        $mydata['result'] = $result;
        $mydata['search'] = $search;
        $mydata['action'] = $this->access['action'];
        $mydata['prefix_page'] = 'page_'.$this->acc;
        $mydata['sosmed'] = $sosmed;
        
        load_pagination('basedata/tokoh', $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('tokoh', $mydata, TRUE);
        $this->display();
    }
}
