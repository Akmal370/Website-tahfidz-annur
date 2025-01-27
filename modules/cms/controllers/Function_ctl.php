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

    public function sorting_section()
    {
        // var_dump($_POST);die;
        $id = $this->input->post('id');

        $no = 0;
        $place = 1;
        $set = [];
        if (count($id) > 0) {
            foreach ($id as $value) {
                $num = $no++;
                $place = $place+1;
                $set[$num]['id_cms_section'] = $value;
                $set[$num]['urutan'] = $place;
            }
            $update = $this->action_m->update_batch('cms_section',$set,'id_cms_section');
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data berhasil di sorting!';
                $data['reload'] = true;
                echo json_encode($data);
                exit;
            }else { 
                $data['status'] = false;
                $data['alert']['message'] = 'Tidak ada data urutan yang berubah!';
                $data['reload'] = true;
                echo json_encode($data);
                exit;
            }
        }else{
            $data['status'] = false;
            $data['alert']['message'] = 'Data gagal di sorting!';
            $data['reload'] = true;
            echo json_encode($data);
            exit;
        }
        
    }


    public function save_attr()
    {
        $id = $this->input->post('id');
        $attr = $this->input->post('attr');

        $get = $this->action_m->get_single('cms_section',['id_cms_section' => $id]);
        if (!$get) {
            $data['status'] = false;
            $data['message'] = 'Data section tidak valid!';
            echo json_encode($data);
            exit;
        }
        $real = ($get->data) ? json_decode($get->data) : [];

        $arr3 = [];
        $arr1 = [];
        if ($real) {
            foreach ($real as $field => $val) {
                if (!isset($arr2[$field])) {
                    $arr1[$field] = $val; 
                }
                
            }
        }
        $arr2 = [];
        if ($attr) {
            foreach ($attr as $field => $val) {
                $arr2[$field] = $val; 
            }
        }
        $arr3 = array_merge($arr1,$arr2);
        $set['data'] = json_encode($arr3);
        $update = $this->action_m->update('cms_section',$set,['id_cms_section' => $id]);
        if ($update) {
           $data['status'] = true;
           $data['message'] = '{{data}} berhasil dirubah';
        }else{
            $data['status'] = false;
            $data['message'] = '{{data}} gagal dirubah';
        }
        echo json_encode($data);
        exit;
    }


     public function hapus_banner()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('cms_banner',['id_cms_banner' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('cms_banner',['id_cms_banner' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['checkbox']['pane'] = '#tambah-button-'.$res->id_cms_section;
                $data['checkbox']['id'] = $res->id_banner;
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
    

    public function tambah_cms_banner()
    {
        
        $id_banner = $this->input->post('id_banner');
        
        // var_dump($id_banner);die;
        $id_cms_section = $this->input->post('id_cms_section');
        if (!$id_banner || !$id_cms_section || count($id_banner) <= 0) {
            $data['status'] = false;
            $data['alert']['message'] = 'Data tidak boleh kosong!';
            echo json_encode($data);
            exit;
        }

        $params['where_in']['kolom'] = 'id_banner';
        $params['where_in']['value'] = $id_banner;
        $cek = $this->action_m->get_where_params('banner',['status' => 'Y','delete'=>'N'],'banner.*',$params);
        if ($cek) {
            $id = [];
            $no = 0;
            foreach ($cek as $row) {
                $num = $no++;
                $post[$num]['id_cms_section'] = $id_cms_section;
                $post[$num]['id_banner']    = $row->id_banner;
                $post[$num]['urutan'] = 100;
            }
            $insert = $this->action_m->insert_batch('cms_banner',$post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data banner berhasil disimpan';
                $data['reload'] = true;
                echo json_encode($data);
                exit;
            }else{
                $data['status'] = false;
                $data['alert']['message'] = 'Data banner gagal disimpan';
                echo json_encode($data);
                exit;
            }
        }else{
            $data['status'] = false;
            $data['alert']['message'] = 'Data banner tidak valid!';
            echo json_encode($data);
            exit;
        }
    }

    public function save_image()
    {
        $name_file = $this->input->post('name_file') ?? '';
        if (!empty($_FILES['file']['tmp_name'])) {
            $file = $_FILES['file'];
            // UKURAN FILE
            $tujuan = './data/hero/';
            $config['upload_path'] = $tujuan;
            $config['allowed_types'] = 'png|jpg|jpeg';
            $config['file_name'] = uniqid();
            $config['file_ext_tolower'] = true;

            $this->load->library('upload', $config);

            $data_upload = [];

            if (!$this->upload->do_upload('file')) {

                if ($name_file) {
                    if (file_exists($tujuan.$name_file)) {
                        unlink($tujuan.$name_file);
                    }
                    
                }
                $error = $this->upload->display_errors();
                $data['status'] = 'warning';
                $data['message'] = $error;
                echo json_encode($data);
                exit;
            } else {
                $data_upload = array('upload_data' => $this->upload->data());
                $data['status'] = 'success';
                $data['name'] = $data_upload['upload_data']['file_name'];
                $data['message'] = 'Gambar hero berhasil di update';
                echo json_encode($data);
                exit;
            }
        }else{
            $data['status'] = 'warning';
            $data['message'] = 'Tidak ada file yang diupload.';
            echo json_encode($data);
            exit;
        }
    }

    public function delete_image()
    {
         $tujuan = './data/hero/';
        $name_file = $this->input->post('name_file') ?? '';
        if ($name_file) {
            if (file_exists($tujuan.$name_file)) {
                unlink($tujuan.$name_file);
                $data['status'] = 'success';
                $data['message'] = 'Gambar hero berhasil dihapus!';
                echo json_encode($data);
                exit;
            }else{
                $data['status'] = 'warning';
                $data['message'] = 'File tidak ditemukan!</br> (Refresh jika terjadi kesalahan)';
                echo json_encode($data);
                exit;
            }
        }else{
            $data['status'] = 'warning';
            $data['message'] = 'File tidak terdeteksi!';
            echo json_encode($data);
            exit;
        }
    }



    // SORTING

    public function sorting_banner()
    {
        $data = $this->input->post('data');
        $data = json_decode($data);
        $data = $data->order;

        $no = 0;
        if (count($data) > 0) {
            foreach ($data as $row) {
                $num = $no++;
                $set[$num]['id_cms_banner'] = $row->id;
                $set[$num]['urutan'] = $row->position;
            }
            $update = $this->action_m->update_batch('cms_banner',$set,'id_cms_banner');
            if ($update) {
                echo json_encode(true);
                exit;
            }else { 
                echo json_encode(false);
                exit;
            }
        }else{
            echo json_encode(false);
            exit;
        }
        
    }

    // NEWS CATEGORY
    public function tambah_news_category($id_page)
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
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('cms/'.$id_page.' #form_news_category');
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


    public function ubah_news_category($id_page)
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
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('cms/'.$id_page.' #form_news_category');

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

    public function hapus_news_category($id_page)
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
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('cms/'.$id_page.' #form_news_category');
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


    // gallery CATEGORY
    public function tambah_gallery_category($id_page)
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
            $post['gallery_category.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('gallery_category', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil menambahkan kategori berita!';
                $data['select_manipulator'][0]['id'] = '#id_gallery_category';
                $data['select_manipulator'][0]['value'] = $insert;
                $data['select_manipulator'][0]['text'] = $name;
                $data['select_manipulator'][0]['action'] = 'add';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('cms/'.$id_page.' #form_gallery_category');
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


    public function ubah_gallery_category($id_page)
    {
        $arrAccess = [];

        $arrAccess = [];
        // VARIABEL
        $arrVar['id_gallery_category']             = 'ID';
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
            $result = $this->action_m->get_single('gallery_category',['id_gallery_category' => $id_gallery_category]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data gallery_category tidak ditemukan!';
                echo json_encode($data);
                exit;
            }
            $post['name'] = $name_edit;
            $update = $this->action_m->update('gallery_category', $post,['id_gallery_category' => $id_gallery_category]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil merubah kategori berita!';
                $data['select_manipulator'][0]['id'] = '#id_gallery_category';
                $data['select_manipulator'][0]['value'] = $id_gallery_category;
                $data['select_manipulator'][0]['text'] = $name_edit;
                $data['select_manipulator'][0]['action'] = 'edit';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('cms/'.$id_page.' #form_gallery_category');

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

    public function hapus_gallery_category($id_page)
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('gallery_category',['id_gallery_category' => $id,'delete' => 'N']);
        if ($res) {
            $hapus = $this->action_m->delete('gallery_category',['id_gallery_category' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['select_manipulator'][0]['id'] = '#id_gallery_category';
                $data['select_manipulator'][0]['value'] = $id;
                $data['select_manipulator'][0]['action'] = 'remove';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                $data['load'][1]['parent'] = '#parent_category';
                $data['load'][1]['reload'] = base_url('cms/'.$id_page.' #form_gallery_category');
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

    public function tambah_news($id_page)
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

                if (!file_exists($tujuan)) {
                    mkdir($tujuan);
                }
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
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
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

    public function ubah_news($id_page)
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
                if (!file_exists($tujuan)) {
                    mkdir($tujuan);
                }
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
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
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

    public function hapus_news($id_page)
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
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
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

    // gallery

     public function tambah_gallery($id_page)
    {
        // var_dump($_POST);die;
        // VARIABEL
        $arrVar['title']                       = 'judul';
        $arrVar['id_gallery_category']            = 'kategori';
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
        $tujuan = './data/gallery/';
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {

                if (!file_exists($tujuan)) {
                    mkdir($tujuan);
                }
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
            $post['gallery.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('gallery', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = ucfirst('data berhasil ditambahkan!');
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                $data['modal']['id'] = '#kt_modal_gallery';
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

    public function ubah_gallery($id_page)
    {
        // VARIABEL
        $arrVar['id_gallery']              = 'ID';
        $arrVar['title']                       = 'judul';
        $arrVar['id_gallery_category']            = 'kategori';

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
        $tujuan = './data/gallery/';

        $name_image = $this->input->post('name_image');
        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('gallery',['id_gallery' => $id_gallery]);
            if (!$result) {
                $data['status'] = false;
                $data['alert']['message'] = 'Data berita tidak ditemukan!';
                echo json_encode($data);
                exit;
            }
            if (!empty($_FILES['image']['tmp_name'])) {
                if (!file_exists($tujuan)) {
                    mkdir($tujuan);
                }
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
            $update = $this->action_m->update('gallery', $post,['id_gallery' => $id_gallery]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berita berhasil di ubah';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                $data['modal']['id'] = '#kt_modal_gallery';
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

    public function hapus_gallery($id_page)
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('gallery',['id_gallery' => $id]);
        if ($res) {
            $hapus = $this->action_m->delete('gallery',['id_gallery' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berita berhasil dihapus';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('cms/'.$id_page.' #reload_table');
                if (file_exists('./data/gallery/'.$res->image)) {
                    unlink('./data/gallery/'.$res->image);
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


                
                $tujuan = './data/banner/';
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
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
                    $data['load'][0]['reload'] = base_url('cms/banner #reload_table');
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

                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
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
                    $data['load'][0]['reload'] = base_url('cms/banner #reload_table');
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


    public function update_donasi()
    {
        // VARIABEL
        $arrVar['title_donasi']            = 'Judul';
        $arrVar['text_donasi']            = 'Deskripsi';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_'.$var,$value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $setting = $this->action_m->get_single('setting',['id_setting' => 1]);

        if (!in_array(false, $arrAccess)) {
            $name_image_donasi = $this->input->post('name_image_donasi');
            $tujuan = './data/setting/';
            if (!empty($_FILES['image_donasi']['tmp_name'])) {
                $image_donasi = $_FILES['image_donasi'];
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg|PNG|JPG|JPEG';
                $config['file_name'] = 'LG'.uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_image_donasi = [];

                if (!$this->upload->do_upload('image_donasi')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_image_donasi = array('upload_data' => $this->upload->data());
                    $post['image_donasi'] = $data_image_donasi['upload_data']['file_name'];
                    if (file_exists($tujuan.$setting->image_donasi)) {
                        unlink($tujuan.$setting->image_donasi);
                    }
                }
            } else{
                if (!$name_image_donasi) {
                    if (file_exists($tujuan.$setting->image_donasi)) {
                        unlink($tujuan.$setting->image_donasi);
                    }
                    
                    $post['image_donasi'] = NULL;
                }
            }

            $update = $this->action_m->update('setting', $post, ['id_setting' => 1]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data berhasil dirubah';
                $data['reload'] = true;
            } else {
                $data['status'] = false;
                 $data['alert']['message'] = 'Data gagal dirubah';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    
}