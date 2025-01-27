<?php defined('BASEPATH') or exit('No direct script access allowed');

class Function_ctl extends MY_Admin
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

    // BANNER
    public function detail_banner( )
    {
        $id = $this->input->post('id');
        if (!$id) {
            $data['status'] = false;
            $data['message'] = 'ID Tidak valid';
            echo json_encode($data);
            exit;
        }

        $get =$this->action_m->get_single('banner',['id_banner' => $id,'status' => 'Y','delete' => 'N']);
        if (!$get) {
            $data['status'] = false;
            $data['message'] = 'ID Tidak valid';
            echo json_encode($data);
            exit;
        }
        $res['result'] = $get;
        $res['wave'] = ($this->input->get('wave') && $this->input->get('wave') != '') ? $this->input->get('wave') : null;

        $data['status'] = true;
        $data['html'] = $this->load->view('modal/detail_banner',$res,TRUE);
        echo json_encode($data);
        exit;
    }


    public function tambah_banner()
    {
        $arrAccess = [];
        // VARIABEL
        $arrVar['title']             = 'Judul';
        $arrVar['description']          = 'Deskripsi';
        
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            $post[$var] = trim($$var);
            $arrAccess[] = true;
        }

        $button = $this->input->post('button') ?? 'N';

        $post['button'] = $button;
        if ($button == 'Y') {
            // VARIABEL
            $arrVar2 = [];
            $arrVar2['button_name']             = 'Nama button';
            $arrVar2['button_link']          = 'Url button';

            // INFORMASI UMUM
            foreach ($arrVar2 as $var => $value) {
                $$var = $this->input->post($var);
                if (!$$var) {
                    $data['required'][] = ['req_'. $var, $value.' tidak boleh kosong!'];
                    $arrAccess[] = false;
                } else {
                    $post[$var] = trim($$var);
                    $arrAccess[] = true;
                }
            }
        }else{
            $post['button_name'] = null;
            $post['button_link'] = null;
        }
        
        if (empty($_FILES['file']['tmp_name'])) {
            $data['required'][] = ['req_file', 'File tidak boleh kosong!'];
            $arrAccess[] = false;
        }else{
            $arrAccess[] = true;
        }
        // FOR CMS
        $cms = $this->input->post('cms') ?? null;
        $id_cms_section = $this->input->post('id_cms_section') ?? null;

        if (!in_array(false, $arrAccess)) {
            $setting = $this->action_m->get_single('setting',['id_setting' => 1]);
            if (!empty($_FILES['file']['tmp_name'])) {
                $file = $_FILES['file'];
                // UKURAN FILE
                $ukuran = $_FILES['file']['size'];

                // PEMAKAIAN
                $storage = getFolderSize('./data/');
                $storage += getFolderSize('./assets/');

                $total = $ukuran + $storage;
                if ($total > $setting->storage) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Penyimpanan tidak memadai!</br><b>Penyimpanan tersedia : '.($setting->storage - $storage).'</b>';
                    echo json_encode($data);
                    exit;
                }

                
                $tujuan = './data/banner/';
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg|mp4';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_upload = [];

                if (!$this->upload->do_upload('file')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $post['file'] = $data_upload['upload_data']['file_name'];
                }
            }
            $post['banner.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('banner', $post);
            if ($insert) {
                if ($cms && $id_cms_section) {
                    $in['id_cms_section'] = $id_cms_section;
                    $in['id_banner'] = $insert;

                    $this->action_m->insert('cms_banner',$in);

                    $data['status'] = true;
                    $data['alert']['message'] = 'Berhasil menambahkan banner!';
                    $data['reload'] = true;
                }else{
                    $data['status'] = true;
                    $data['alert']['message'] = 'Berhasil menambahkan banner!';
                    $data['load'][0]['parent'] = '#base_table';
                    $data['load'][0]['reload'] = base_url('basedata/banner #reload_table');
                    $data['modal']['id'] = '#kt_modal_banner';
                    $data['modal']['action'] = 'hide';
                    $data['input']['all'] = true;
                }
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal menambahkan banner!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    public function ubah_banner()
    {
        $arrAccess = [];
        $id_banner = $this->input->post('id_banner');
        if (!$id_banner) {
            $data['status'] = false;
            $data['alert']['message'] = 'ID Tidak valid';
            echo json_encode($data);
            exit;
        }
        // VARIABEL
        $arrVar['title']             = 'Judul';
        $arrVar['description']          = 'Deskripsi';
        $arrVar['name_file']          = 'Nama file';
        
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!in_array($var,['name_file'])) {
                $post[$var] = trim($$var);
            }
            $arrAccess[] = true;
        }

        $button = $this->input->post('button') ?? 'N';

        // FOR CMS
        $cms = $this->input->post('cms') ?? null;
        $id_cms_section = $this->input->post('id_cms_section') ?? null;
        if ($cms) {
            $prefix = "req_edit_";
        }else{
            $prefix = "req_";
        }
        $post['button'] = $button;
        if ($button == 'Y') {
            // VARIABEL
            $arrVar2 = [];
            $arrVar2['button_name']             = 'Nama button';
            $arrVar2['button_link']          = 'Url button';

            // INFORMASI UMUM
            foreach ($arrVar2 as $var => $value) {
                $$var = $this->input->post($var);
                if (!$$var) {
                    $data['required'][] = [$prefix . $var, $value.' tidak boleh kosong!'];
                    $arrAccess[] = false;
                } else {
                    $post[$var] = trim($$var);
                    $arrAccess[] = true;
                }
            }
        }else{
            $post['button_name'] = null;
            $post['button_link'] = null;
        }

        if (empty($_FILES['file']['tmp_name']) && !$name_file) {
            $data['required'][] = [$prefix.'file', 'File tidak boleh kosong!'];
            $arrAccess[] = false;
        }else{
            $arrAccess[] = true;
        }
        

        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('banner',['id_banner' => $id_banner]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data banner tidak ditemukan!';
                echo json_encode($data);
                exit;
            }
            $setting = $this->action_m->get_single('setting',['id_setting' => 1]);
            $tujuan = './data/banner/';
            if (!empty($_FILES['file']['tmp_name'])) {
                $file = $_FILES['file'];
                // UKURAN FILE
                $ukuran = $_FILES['file']['size'];

                // PEMAKAIAN
                $storage = getFolderSize('./data/');
                $storage += getFolderSize('./assets/');

                $total = $ukuran + $storage;
                if ($total > $setting->storage) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Penyimpanan tidak memadai!</br><b>Penyimpanan tersedia : '.($setting->storage - $storage).'</b>';
                    echo json_encode($data);
                    exit;
                }

                
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg|mp4';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_upload = [];

                if (!$this->upload->do_upload('file')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $post['file'] = $data_upload['upload_data']['file_name'];
                    if ($result->file) {
                        if (file_exists($tujuan.$result->file)) {
                            unlink($tujuan.$result->file);
                        }
                    }
                }
            }
            $update = $this->action_m->update('banner', $post,['id_banner' => $id_banner]);
            if ($update) {
                if ($cms && $id_cms_section) {
                    $data['status'] = true;
                    $data['alert']['message'] = 'Berhasil merubah banner!';
                    $data['reload'] = true;
                }else{
                    $data['status'] = true;
                    $data['alert']['message'] = 'Berhasil merubah banner!';
                    $data['load'][0]['parent'] = '#base_table';
                    $data['load'][0]['reload'] = base_url('basedata/banner #reload_table');
                    $data['modal']['id'] = '#kt_modal_banner';
                    $data['modal']['action'] = 'hide';
                    $data['input']['all'] = true;
                }
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal menambahkan banner!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    public function get_modal_banner( )
    {
        $insert = $this->input->get('insert') ?? false;
        $id = $this->input->post('id');
        $cms = $this->input->get('cms') ?? false;
        if (!$insert && !$id) {
            $data['status'] = false;
            $data['message'] = 'ID Tidak valid';
            echo json_encode($data);
            exit;
        }

        if ($id) {
            $get =$this->action_m->get_single('banner',['id_banner' => $id,'status' => 'Y','delete' => 'N']);
            if (!$get) {
                $data['status'] = false;
                $data['message'] = 'ID Tidak valid';
                echo json_encode($data);
                exit;
            }
            $res['result'] = $get;
        }
        $res['cms'] = $cms;
        $data['status'] = true;
        $data['html'] = $this->load->view('modal/tambah_edit_banner',$res,TRUE);
        echo json_encode($data);
        exit;
    }
    
    public function hapus_banner()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('banner',['id_banner' => $id,'delete' => 'N']);
        if ($res) {
            $hapus = $this->action_m->delete('banner',['id_banner' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/banner #reload_table');
                if (file_exists('./data/banner/'.$res->file)) {
                    unlink('./data/banner/'.$res->file);
                }
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Gagal menghapus data!';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan!';
        }
        

        echo json_encode($data);
        exit;
    }









    // quotes

    public function tambah_quotes()
    {
        $arrAccess = [];
        // VARIABEL
        $arrVar['text']             = 'Quotes';
        
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        // FOR CMS
        $cms = $this->input->post('cms') ?? null;
        $id_cms_section = $this->input->post('id_cms_section') ?? null;

        if (!in_array(false, $arrAccess)) {
            $post['quotes.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('quotes', $post);
            if ($insert) {
                if ($cms && $id_cms_section) {
                    $in['id_cms_section'] = $id_cms_section;
                    $in['id_quotes'] = $insert;

                    $this->action_m->insert('cms_quotes',$in);

                    $data['status'] = true;
                    $data['alert']['message'] = 'Berhasil menambahkan quotes!';
                    $data['reload'] = true;
                }else{
                    $data['status'] = true;
                    $data['alert']['message'] = 'Berhasil menambahkan quotes!';
                    $data['load'][0]['parent'] = '#base_table';
                    $data['load'][0]['reload'] = base_url('basedata/quotes #reload_table');
                    $data['modal']['id'] = '#kt_modal_quotes';
                    $data['modal']['action'] = 'hide';
                    $data['input']['all'] = true;
                }
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal menambahkan quotes!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    public function ubah_quotes()
    {
        $arrAccess = [];
        // FOR CMS
        $cms = $this->input->post('cms') ?? null;
        $id_cms_section = $this->input->post('id_cms_section') ?? null;
        if ($cms) {
            $prefix = "req_edit_";
        }else{
            $prefix = "req_";
        }

        $arrAccess = [];
        // VARIABEL
         $arrVar['id_quotes']             = 'ID';
        $arrVar['text']             = 'Quotes';
        
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = [$prefix . $var, $value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('quotes',['id_quotes' => $id_quotes]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data quotes tidak ditemukan!';
                echo json_encode($data);
                exit;
            }

            $update = $this->action_m->update('quotes', $post,['id_quotes' => $id_quotes]);
            if ($update) {
                if ($cms && $id_cms_section) {
                    $data['status'] = true;
                    $data['alert']['message'] = 'Berhasil merubah quotes!';
                    $data['reload'] = true;
                }else{
                    $data['status'] = true;
                    $data['alert']['message'] = 'Berhasil merubah quotes!';
                    $data['load'][0]['parent'] = '#base_table';
                    $data['load'][0]['reload'] = base_url('basedata/quotes #reload_table');
                    $data['modal']['id'] = '#kt_modal_quotes';
                    $data['modal']['action'] = 'hide';
                    $data['input']['all'] = true;
                }
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal menambahkan quotes!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function get_modal_quotes()
    {
        $insert = $this->input->get('insert') ?? false;
        $id = $this->input->post('id');
        $cms = $this->input->get('cms') ?? false;
        if (!$insert && !$id) {
            $data['status'] = false;
            $data['message'] = 'ID Tidak valid';
            echo json_encode($data);
            exit;
        }

        if ($id) {
            $get =$this->action_m->get_single('quotes',['id_quotes' => $id,'status' => 'Y','delete' => 'N']);
            if (!$get) {
                $data['status'] = false;
                $data['message'] = 'ID Tidak valid';
                echo json_encode($data);
                exit;
            }
            $res['result'] = $get;
        }
        $res['cms'] = $cms;
        $data['status'] = true;
        $data['html'] = $this->load->view('modal/tambah_edit_quotes',$res,TRUE);
        echo json_encode($data);
        exit;
    }
    
    public function hapus_quotes()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('quotes',['id_quotes' => $id,'delete' => 'N']);
        if ($res) {
            $hapus = $this->action_m->delete('quotes',['id_quotes' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/quotes #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Gagal menghapus data!';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan!';
        }
        

        echo json_encode($data);
        exit;
    }




    // NEWS CATEGORY
    public function tambah_news_category()
    {
        $arrAccess = [];
        // VARIABEL
        $arrVar['name']             = 'Kategori';
        
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_category_' . $var, $value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (!in_array(false, $arrAccess)) {
            $post['news_category.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('news_category', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil menambahkan kategori berita!';
                $data['select_manipulator'][0]['id'] = '#id_news_category';
                $data['select_manipulator'][0]['value'] = $insert;
                $data['select_manipulator'][0]['text'] = $name;
                $data['select_manipulator'][0]['action'] = 'add';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/news #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('basedata/news #form_news_category');
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal menambahkan kategori berita!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    public function ubah_news_category()
    {
        $arrAccess = [];

        $arrAccess = [];
        // VARIABEL
        $arrVar['id_news_category']             = 'ID';
        $arrVar['name_edit']             = 'kategori';
        
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                if ($var == 'name_edit') {
                    $data['required'][] = ['req_category_name', $value.' tidak boleh kosong!'];
                }else{
                    $data['required'][] = ['req_category_'.$var, $value.' tidak boleh kosong!'];
                }
                
                $arrAccess[] = false;
            } else {
                $arrAccess[] = true;
            }
        }

        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('news_category',['id_news_category' => $id_news_category]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data news_category tidak ditemukan!';
                echo json_encode($data);
                exit;
            }
            $post['name'] = $name_edit;
            $update = $this->action_m->update('news_category', $post,['id_news_category' => $id_news_category]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil merubah kategori berita!';
                $data['select_manipulator'][0]['id'] = '#id_news_category';
                $data['select_manipulator'][0]['value'] = $id_news_category;
                $data['select_manipulator'][0]['text'] = $name_edit;
                $data['select_manipulator'][0]['action'] = 'edit';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/news #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('basedata/news #form_news_category');

                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal merubah kategori berita!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function hapus_news_category()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('news_category',['id_news_category' => $id,'delete' => 'N']);
        if ($res) {
            $hapus = $this->action_m->delete('news_category',['id_news_category' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['select_manipulator'][0]['id'] = '#id_news_category';
                $data['select_manipulator'][0]['value'] = $id;
                $data['select_manipulator'][0]['action'] = 'remove';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/news #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('basedata/news #form_news_category');
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Gagal menghapus data!';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan!';
        }
        

        echo json_encode($data);
        exit;
    }



    // NEWS

    public function tambah_news()
    {
        // var_dump($_POST);die;
        // VARIABEL
        $arrVar['title']                       = 'judul';
        $arrVar['id_news_category']            = 'kategori';
        $arrVar['short_description']           = 'deskripsi singkat';
        $arrVar['long_description']            = 'isi berita';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var) ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                if ($var == 'long_description') {
                    $cc = ckeditor_check($$var);
                    if (empty($cc)) {
                        $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                        $arrAccess[] = false;
                    }else{
                        $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }else{
                    if ($$var == '') {
                        $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                        $arrAccess[] = false;
                    }else{
                         $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }
            }
        }
        $tujuan = './data/news/';
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image'];
                
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_upload = [];

                if (!$this->upload->do_upload('image')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $post['image'] = $data_upload['upload_data']['file_name'];
                }
            }else{
                $data['status'] = false;
                $data['alert']['message'] = 'Gambar tidak boleh kosong!';
                echo json_encode($data);
                exit;
            }
            $post['news.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('news', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = ucfirst('data berhasil ditambahkan!');
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/news #reload_table');
                $data['modal']['id'] = '#kt_modal_news';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = ucfirst('data gagal ditambahkan!');
            }
        }else{
            $data['status'] = false;
        }
       
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function ubah_news()
    {
        // VARIABEL
        $arrVar['id_news']              = 'ID';
        $arrVar['title']                       = 'judul';
        $arrVar['id_news_category']            = 'kategori';
        $arrVar['short_description']           = 'deskripsi singkat';
        $arrVar['long_description']            = 'isi berita';

        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var) ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                if ($var == 'long_description') {
                    $cc = ckeditor_check($$var);
                    if (empty($cc)) {
                        $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                        $arrAccess[] = false;
                    }else{
                        $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }else{
                    if ($$var == '') {
                        $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                        $arrAccess[] = false;
                    }else{
                         $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }
            }
        }
        $tujuan = './data/news/';

        $name_image = $this->input->post('name_image');
        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('news',['id_news' => $id_news]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data berita tidak ditemukan!';
                echo json_encode($data);
                exit;
            }
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image'];
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_upload = [];

                if (!$this->upload->do_upload('image')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $post['image'] = $data_upload['upload_data']['file_name'];
                    if (file_exists($tujuan.$result->image)) {
                        unlink($tujuan.$result->image);
                    }
                }
            }else{
                if (!$name_image) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Gambar berita tidak boleh kosong!';
                    echo json_encode($data);
                    exit;
                }
                
                
            }
            $update = $this->action_m->update('news', $post,['id_news' => $id_news]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berita berhasil di ubah';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/news #reload_table');
                $data['modal']['id'] = '#kt_modal_news';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal merubah berita';
            }
        }else{
            $data['status'] = false;
        }
       
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function hapus_news()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('news',['id_news' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('news',['id_news' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berita berhasil dihapus';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/news #reload_table');
                if (file_exists('./data/news/'.$res->image)) {
                    unlink('./data/news/'.$res->image);
                 }
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Berita gagal dihapus';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan';
        }
        

        echo json_encode($data);
        exit;
    }




    // STRUKTUR JABATAN
    public function tambah_struktur_jabatan()
    {
        $arrAccess = [];
        // VARIABEL
        $arrVar['name']             = 'Kategori';
        
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_jabatan_' . $var, $value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (!in_array(false, $arrAccess)) {
            $post['struktur_jabatan.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('struktur_jabatan', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil menambahkan kategori berita!';
                $data['select_manipulator'][0]['id'] = '#id_struktur_jabatan';
                $data['select_manipulator'][0]['value'] = $insert;
                $data['select_manipulator'][0]['text'] = $name;
                $data['select_manipulator'][0]['action'] = 'add';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/struktur #reload_table');
                $data['load'][1]['parent'] = '#parent_jabatan';
                $data['load'][1]['reload'] = base_url('basedata/struktur #form_struktur_jabatan');
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal menambahkan kategori berita!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    public function ubah_struktur_jabatan()
    {
        $arrAccess = [];

        $arrAccess = [];
        // VARIABEL
        $arrVar['id_struktur_jabatan']             = 'ID';
        $arrVar['name_edit']             = 'kategori';
        
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                if ($var == 'name_edit') {
                    $data['required'][] = ['req_jabatan_name', $value.' tidak boleh kosong!'];
                }else{
                    $data['required'][] = ['req_jabatan_'.$var, $value.' tidak boleh kosong!'];
                }
                
                $arrAccess[] = false;
            } else {
                $arrAccess[] = true;
            }
        }

        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('struktur_jabatan',['id_struktur_jabatan' => $id_struktur_jabatan]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data struktur_jabatan tidak ditemukan!';
                echo json_encode($data);
                exit;
            }
            $post['name'] = $name_edit;
            $update = $this->action_m->update('struktur_jabatan', $post,['id_struktur_jabatan' => $id_struktur_jabatan]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil merubah kategori berita!';
                $data['select_manipulator'][0]['id'] = '#id_struktur_jabatan';
                $data['select_manipulator'][0]['value'] = $id_struktur_jabatan;
                $data['select_manipulator'][0]['text'] = $name_edit;
                $data['select_manipulator'][0]['action'] = 'edit';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/struktur #reload_table');
                $data['load'][1]['parent'] = '#parent_jabatan';
                $data['load'][1]['reload'] = base_url('basedata/struktur #form_struktur_jabatan');

                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal merubah kategori berita!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function hapus_struktur_jabatan()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('struktur_jabatan',['id_struktur_jabatan' => $id,'delete' => 'N']);
        if ($res) {
            $hapus = $this->action_m->delete('struktur_jabatan',['id_struktur_jabatan' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['select_manipulator'][0]['id'] = '#id_struktur_jabatan';
                $data['select_manipulator'][0]['value'] = $id;
                $data['select_manipulator'][0]['action'] = 'remove';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/struktur #reload_table');
                $data['load'][1]['parent'] = '#parent_jabatan';
                $data['load'][1]['reload'] = base_url('basedata/struktur #form_struktur_jabatan');
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Gagal menghapus data!';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan!';
        }
        

        echo json_encode($data);
        exit;
    }



    // STRUKTUR

    public function tambah_struktur()
    {
        // var_dump($_POST);die;
        // VARIABEL
        $arrVar['name']                       = 'nama';
        $arrVar['id_struktur_jabatan']            = 'jabatan';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var) ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                if ($$var == '') {
                    $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                    $arrAccess[] = false;
                }else{
                        $post[$var] = $$var;
                    $arrAccess[] = true;
                }
            }
        }
        $tujuan = './data/struktur/';
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image'];
                
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_upload = [];

                if (!$this->upload->do_upload('image')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $post['image'] = $data_upload['upload_data']['file_name'];
                }
            }else{
                $data['status'] = false;
                $data['alert']['message'] = 'Gambar tidak boleh kosong!';
                echo json_encode($data);
                exit;
            }
            $post['struktur.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('struktur', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = ucfirst('data berhasil ditambahkan!');
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/struktur #reload_table');
                $data['modal']['id'] = '#kt_modal_struktur';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = ucfirst('data gagal ditambahkan!');
            }
        }else{
            $data['status'] = false;
        }
       
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function ubah_struktur()
    {
        // VARIABEL
        $arrVar['id_struktur']              = 'ID';
        $arrVar['name']                       = 'nama';
        $arrVar['id_struktur_jabatan']            = 'jabatan';

        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var) ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                if ($$var == '') {
                    $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                    $arrAccess[] = false;
                }else{
                        $post[$var] = $$var;
                    $arrAccess[] = true;
                }
            }
        }
        $tujuan = './data/struktur/';

        $name_image = $this->input->post('name_image');
        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('struktur',['id_struktur' => $id_struktur]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data berita tidak ditemukan!';
                echo json_encode($data);
                exit;
            }
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image'];
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_upload = [];

                if (!$this->upload->do_upload('image')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $post['image'] = $data_upload['upload_data']['file_name'];
                    if (file_exists($tujuan.$result->image)) {
                        unlink($tujuan.$result->image);
                    }
                }
            }else{
                if (!$name_image) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Gambar berita tidak boleh kosong!';
                    echo json_encode($data);
                    exit;
                }
                
                
            }
            $update = $this->action_m->update('struktur', $post,['id_struktur' => $id_struktur]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berita berhasil di ubah';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/struktur #reload_table');
                $data['modal']['id'] = '#kt_modal_struktur';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal merubah berita';
            }
        }else{
            $data['status'] = false;
        }
       
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function hapus_struktur()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('struktur',['id_struktur' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('struktur',['id_struktur' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berita berhasil dihapus';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/struktur #reload_table');
                if (file_exists('./data/struktur/'.$res->image)) {
                    unlink('./data/struktur/'.$res->image);
                 }
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Berita gagal dihapus';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan';
        }
        

        echo json_encode($data);
        exit;
    }





    // TOKOH

    public function tambah_tokoh()
    {
        // var_dump($_POST);die;
        // VARIABEL
        $arrVar['name']                       = 'nama';
        $arrVar['address']                       = 'alamat';
        $arrVar['description']                       = 'deskripsi';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var) ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                if ($var == 'description') {
                    $cc = ckeditor_check($$var);
                    if (empty($cc)) {
                        $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                        $arrAccess[] = false;
                    }else{
                        $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }else{
                    if ($$var == '') {
                        $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                        $arrAccess[] = false;
                    }else{
                         $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }
            }
        }
        $tujuan = './data/tokoh/';

        $sosmed = $this->input->post('sosmed');
        $arr_sos = [];
        if ($sosmed) {
            foreach ($sosmed as $id => $url) {
                if ($url != '') {
                    $arr_sos[$id] = $url;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image'];
                
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_upload = [];

                if (!$this->upload->do_upload('image')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $post['image'] = $data_upload['upload_data']['file_name'];
                }
            }else{
                $data['status'] = false;
                $data['alert']['message'] = 'Gambar tidak boleh kosong!';
                echo json_encode($data);
                exit;
            }
            $post['sosmed'] = json_encode($arr_sos);
            $post['tokoh.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('tokoh', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = ucfirst('data berhasil ditambahkan!');
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/tokoh #reload_table');
                $data['modal']['id'] = '#kt_modal_tokoh';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = ucfirst('data gagal ditambahkan!');
            }
        }else{
            $data['status'] = false;
        }
       
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function ubah_tokoh()
    {
        // VARIABEL
        $arrVar['id_tokoh']              = 'ID';
        $arrVar['name']                       = 'nama';
        $arrVar['address']                       = 'alamat';
        $arrVar['description']                       = 'deskripsi';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var) ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                if ($var == 'description') {
                    $cc = ckeditor_check($$var);
                    if (empty($cc)) {
                        $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                        $arrAccess[] = false;
                    }else{
                        $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }else{
                    if ($$var == '') {
                        $data['required'][] = ['req_' . $var, ucfirst($value).' tidak boleh kosong!'];
                        $arrAccess[] = false;
                    }else{
                         $post[$var] = $$var;
                        $arrAccess[] = true;
                    }
                }
            }
        }
        $sosmed = $this->input->post('sosmed');
        $arr_sos = [];
        if ($sosmed) {
            foreach ($sosmed as $id => $url) {
                if ($url != '') {
                    $arr_sos[$id] = $url;
                }
            }
        }

        $tujuan = './data/tokoh/';

        $name_image = $this->input->post('name_image');
        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('tokoh',['id_tokoh' => $id_tokoh]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data berita tidak ditemukan!';
                echo json_encode($data);
                exit;
            }
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image'];
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_upload = [];

                if (!$this->upload->do_upload('image')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_upload = array('upload_data' => $this->upload->data());
                    $post['image'] = $data_upload['upload_data']['file_name'];
                    if (file_exists($tujuan.$result->image)) {
                        unlink($tujuan.$result->image);
                    }
                }
            }else{
                if (!$name_image) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Gambar berita tidak boleh kosong!';
                    echo json_encode($data);
                    exit;
                }
                
                
            }
            $post['sosmed'] = json_encode($arr_sos);
            $update = $this->action_m->update('tokoh', $post,['id_tokoh' => $id_tokoh]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berita berhasil di ubah';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/tokoh #reload_table');
                $data['modal']['id'] = '#kt_modal_tokoh';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal merubah berita';
            }
        }else{
            $data['status'] = false;
        }
       
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function hapus_tokoh()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('tokoh',['id_tokoh' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('tokoh',['id_tokoh' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berita berhasil dihapus';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('basedata/tokoh #reload_table');
                if (file_exists('./data/tokoh/'.$res->image)) {
                    unlink('./data/tokoh/'.$res->image);
                 }
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Berita gagal dihapus';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan';
        }
        

        echo json_encode($data);
        exit;
    }
}