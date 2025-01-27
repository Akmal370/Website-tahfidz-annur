<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller_ctl extends MY_Admin
{
    var $id_role = '';
    var $id_user = '';
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_role = $this->session->userdata(PREFIX_SESSION.'_id_role');
        // $this->id_role = 4;
        $this->id_user = $this->session->userdata(PREFIX_SESSION.'_id_user');

    }

    public function index()
    {
        redirect('dashboard');
    }


    public function base($id = NULL)
    {
        if ($id == base64url_encode(99)) {
            $this->news($id);
            return;
        }
         if ($id == base64url_encode(101)) {
            $this->gallery($id);
            return;
        }
        if ($id == base64url_encode(102)) {
            $this->donasi($id);
            return;
        }
        $mydata = [];
        $id = base64url_decode($id);
        if ($id == NULL) {
            redirect('cms');
        }
        

        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/cms/base.js"></script>';

        // DATA

        $params['arrorderby']['kolom'] = 'cms_section.urutan';
        $params['arrorderby']['order'] = 'ASC';

        $where['id_page'] = $id;

        $layout = $this->action_m->get_where_params('layout',['status' => 'Y']);

        $params['arrjoin']['layout']['statement'] = 'layout.id_layout = cms_section.id_layout';
        $params['arrjoin']['layout']['type'] = 'LEFT';
        $section = $this->action_m->get_where_params('cms_section',['cms_section.id_page' => $id],'cms_section.*,layout.file,layout.name AS layout',$params);
        
        $banner = [];
        $jabatan = [];
        
        if ($section) {
            $idl = [];
            $ids = [];
            foreach ($section as $key) {
                $idl[] = $key->id_layout;
                $ids[$key->id_layout][] = $key->id_cms_section;
            }

            if (count($idl) > 0) {
                $idl = array_unique($idl);
                $idl = array_values($idl);

                // BANNER
                if (in_array(1,$idl)) {
                    $dt = (isset($ids[1])) ? $ids[1] : null;
                    if ($dt) {
                        $banner = $this->get_banner($dt);
                    }
                    
                }

            }
            
        }
        $page = $this->action_m->get_single('page',$where);

        $par_banner['arrorderby']['kolom'] = 'banner.create_date';
        $par_banner['arrorderby']['order'] = 'ASC';
        
        $all_banner = $this->action_m->get_where_params('banner',['status' => 'Y','delete' => 'N'],'banner.*',$par_banner);

        $mydata['section'] = $section;
        $mydata['page'] = $page;
        $mydata['layout'] = $layout;
        $mydata['id_page'] = $id;
        $mydata['banner'] = $all_banner;

        // DATA KETERGANTUNGAN
        $mydata['attribut']['banner'] = $banner;
        // LOAD VIEW
        $this->data['content'] = $this->load->view('base', $mydata, TRUE);
        $this->display();

    }


    public function get_banner($id_section)
    {
        if ($id_section == null || empty($id_section)) {
            return false;
        }

        $params['arrjoin']['banner']['statement'] = 'banner.id_banner = cms_banner.id_banner';
        $params['arrjoin']['banner']['type'] = 'LEFT';

        $params['where_in']['kolom'] = 'cms_banner.id_cms_section';
        $params['where_in']['value'] = $id_section;

        $params['arrorderby']['kolom'] = 'cms_banner.id_cms_section';
        $params['arrorderby']['order'] = 'ASC';

        $result = $this->action_m->get_where_params('cms_banner',['banner.status' => 'Y'],'cms_banner.id_cms_banner,cms_banner.id_cms_section,cms_banner.urutan,banner.*',$params);

        $data = [];
        $idp = 0;
        $no = 0;
        if ($result) {
            foreach ($result as $key) {
                if ($key->id_cms_section != $idp) {
                    $idp = $key->id_cms_section;
                    $no = 0;
                }
                $num = $no++;
                $data[$key->id_cms_section][$num]['id_cms_banner'] = $key->id_cms_banner;
                $data[$key->id_cms_section][$num]['id_banner'] = $key->id_banner;
                $data[$key->id_cms_section][$num]['file'] = $key->file;
                $data[$key->id_cms_section][$num]['title'] = $key->title;
                $data[$key->id_cms_section][$num]['description'] = $key->description;
                $data[$key->id_cms_section][$num]['status'] = $key->status;
                $data[$key->id_cms_section][$num]['button'] = $key->button;
                $data[$key->id_cms_section][$num]['button_name'] = $key->button_name;
                $data[$key->id_cms_section][$num]['button_link'] = $key->button_link;
                $data[$key->id_cms_section][$num]['urutan'] = $key->urutan;
            }
        }

        return $data;
    }

    public function news($id_page = null)
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');
        $id_news_category = $this->input->get('id_news_category');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Berita';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "cms/'.$id_page.'"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/cms/news.js"></script>';

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
        $mydata['id_page'] = $id_page;

        load_pagination('cms/'.$id_page, $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('news', $mydata, TRUE);
        $this->display();
    }

    public function gallery($id_page = null)
    {
        // GET FILTER DATA
        $search = $this->input->get('search');
        $search = search_encode($search);
        $status = $this->input->get('status');
        $id_gallery_category = $this->input->get('id_gallery_category');

        // LOAD MAIN DATA
        $this->data['title'] = 'Data Berita';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "cms/'.$id_page.'"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/cms/gallery.js"></script>';

        // LOAD DATA
        $limit = 5;
        $offset = $this->uri->segment(3);
        $params = [];
        if ($status != 'all') {
            if (in_array($status, ['Y', 'N'])) {
                $where['gallery.status'] = $status;
            }
        }
        
        $where['gallery.delete'] = 'N';
        if ($search) {
            $params['columnsearch'][] = 'title';
            $params['columnsearch'][] = 'short_description';
            $params['columnsearch'][] = 'long_description';
            $params['search'] = $search;
        }

        if ($id_gallery_category && $id_gallery_category != 'all') {
            $where['gallery.id_gallery_category'] = $id_gallery_category;
        }
        $params['arrorderby']['kolom'] = 'gallery.create_date';
        $params['arrorderby']['order'] = 'DESC';
        $params['arrjoin']['gallery_category']['statement'] = 'gallery_category.id_gallery_category = gallery.id_gallery_category';
        $params['arrjoin']['gallery_category']['type'] = 'LEFT';

        $jumlah = $this->action_m->cnt_where_params('gallery', $where, 'gallery.*,gallery_category.name AS category', $params);
        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $result = $this->action_m->get_where_params('gallery', $where, 'gallery.*,gallery_category.name AS category', $params);
        $category = $this->action_m->get_all('gallery_category',['status' => 'Y','delete' => 'N']);
        // CETAK DATA

        $mydata['result'] = $result;
        $mydata['category'] = $category;
        $mydata['search'] = $search;
        $mydata['id_page'] = $id_page;

        load_pagination('cms/'.$id_page, $limit, $jumlah);

        // LOAD VIEW
        $this->data['content'] = $this->load->view('gallery', $mydata, TRUE);
        $this->display();
    }

    public function donasi($id_page = null)
    {
        // LOAD MAIN DATA
        $this->data['title'] = 'Data Donasi';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "cms/'.$id_page.'"</script>';

         // BUTTON 
        $this->data['button']['id'] = 'btn_update_umum_donasi';
        $this->data['button']['form_id'] = '#form_ubah_donasi';
        


        $result = $this->action_m->get_single('setting',['id_setting' => 1]);

        $mydata['result'] = $result;
        
        // LOAD VIEW
        $this->data['content'] = $this->load->view('donasi', $mydata, TRUE);
        $this->display();
    }
}