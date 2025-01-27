<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller_ctl extends MY_Frontend
{
    var $id_user = '';
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_user = $this->session->userdata(PREFIX_SESSION.'_id_user');
    }

    public function index()
    {
        $order['order_by'] = 'urutan';
        $order['ascdesc'] = 'ASC';
        $cek = $this->action_m->get_single('page',['status' => 'Y','delete' =>'N','type' => 2],$order);
        if (!$cek) {
            redirect('login');
        }else{
            redirect($cek->url);
        }
    }

    public function beranda()
    {
        $mydata = [];
         $this->data['content'] = $this->load->view('sementara/home', $mydata, TRUE);
        $this->display();
    }
    public function base($id_page = NULL)
    {
        if ($id_page == NULL) {
            redirect('login');
        }
        if ($id_page == 99) {
            $this->news();
            return;
        }
        if ($id_page == 101) {
            $this->gallery();
            return;
        }
        if ($id_page == 102) {
            $this->donasi();
            return;
        }
        $result = $this->action_m->get_single('page',['id_page' => $id_page,'status' => 'Y']);
        if (!$result) {
            redirect('login');
        }
        // GLOBAL VARIABEL
        $this->data['title'] = ucfirst($result->name);

        $params['arrjoin']['layout']['statement'] = 'layout.id_layout = cms_section.id_layout';
        $params['arrjoin']['layout']['type'] = 'LEFT';
        $params['arrorderby']['kolom'] = 'urutan';
        $params['arrorderby']['order'] = 'ASC';
        $section = $this->action_m->get_where_params('cms_section',['cms_section.id_page' => $id_page,'cms_section.status' => 'Y'],'cms_section.*,layout.file,layout.name AS layout',$params);
        

        $banner = [];
        $quotes = [];
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
        // CETAK VARIABEL
        $mydata['section'] = $section;

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


    public function detail($id) {
        if (!$id) {
            redirect('user');
        }
        $params['arrjoin']['news_category']['statement'] = 'news_category.id_news_category = news.id_news_category';
        $params['arrjoin']['news_category']['type'] = 'LEFT';
        $cek = $this->action_m->get_where_params('news',['id_news' => $id,'news.status' => 'Y','news.delete' => 'N'],'news.*,news_category.name AS category',$params);
        if (!$cek) {
            redirect('user');
        }
        $cek = $cek[0];

        $rand = $this->action_m->get_query('news','SELECT news.*, news_category.name AS category, user.name AS created FROM news LEFT JOIN news_category ON news.id_news_category = news_category.id_news_category LEFT JOIN user ON news.create_by = user.id_user WHERE id_news != '.$id.' AND news.status = "Y" AND news.delete = "N" ORDER BY RAND() LIMIT 2
        ');

        $mydata['result'] = $cek;
        $mydata['rand'] = $rand;
        // LOAD VIEW
        $this->data['content'] = $this->load->view('detail', $mydata, TRUE);
        $this->display();

    }

    public function news()
    {
        // LOAD VIEW
        $mydata = [];
        $this->data['title'] = 'Berita terkini';
        
        $params['arrjoin']['news_category']['statement'] = 'news_category.id_news_category = news.id_news_category';
        $params['arrjoin']['news_category']['type'] = 'LEFT';
        $params['arrorderby']['kolom'] = 'news.create_date';
        $params['arrorderby']['order'] = 'DESC';
        $result = $this->action_m->get_where_params('news',['news.status' => 'Y','news.delete' => 'N'],'news.*,news_category.name AS category',$params);
        $category = [];
        if ($result) {
            $id = [];
            foreach ($result as $row) {
                $id[] = $row->id_news_category;
            }
            $id = array_unique($id);
            if (count($id) > 0) {
                $par['where_in']['kolom'] = 'id_news_category';
                $par['where_in']['value'] = $id;
                $category = $this->action_m->get_where_params('news_category',['status' => 'Y','delete' => 'N'],'*',$par);
            }
        }

        $mydata['result'] = $result;
        $mydata['category'] = $category;
        $this->data['content'] = $this->load->view('section/sec_news', $mydata, TRUE);
        $this->display();
    }

    public function gallery()
    {
        // LOAD VIEW
        $mydata = [];
        $this->data['title'] = 'Galleri kita';
        
        $params['arrjoin']['gallery_category']['statement'] = 'gallery_category.id_gallery_category = gallery.id_gallery_category';
        $params['arrjoin']['gallery_category']['type'] = 'LEFT';
        $params['arrorderby']['kolom'] = 'gallery.create_date';
        $params['arrorderby']['order'] = 'DESC';
        $result = $this->action_m->get_where_params('gallery',['gallery.status' => 'Y','gallery.delete' => 'N'],'gallery.*,gallery_category.name AS category',$params);
        $category = [];
        if ($result) {
            $id = [];
            foreach ($result as $row) {
                $id[] = $row->id_gallery_category;
            }
            $id = array_unique($id);
            if (count($id) > 0) {
                $par['where_in']['kolom'] = 'id_gallery_category';
                $par['where_in']['value'] = $id;
                $category = $this->action_m->get_where_params('gallery_category',['status' => 'Y','delete' => 'N'],'*',$par);
            }
        }

        $mydata['result'] = $result;
        $mydata['category'] = $category;
        $this->data['content'] = $this->load->view('section/sec_gallery', $mydata, TRUE);
        $this->display();
    }


    public function donasi()
    {
        // LOAD VIEW
        $mydata = [];
        $this->data['title'] = 'Donasi bersama kita';

        $result = $this->action_m->get_single('setting',['id_setting' => 1]);

        $mydata['result'] = $result;
        $this->data['content'] = $this->load->view('section/sec_donasi', $mydata, TRUE);
        $this->display();
    }

}