<?php defined('BASEPATH') or exit('No direct script access allowed');

class Function_ctl extends MY_Controller 
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

    public function update()
    {
        // VARIABEL
        $arrVar['name']             = 'Nama lengkap';
        $arrVar['email']            = 'Alamat email';
        $arrVar['phone']           = 'Nomor telepon';

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
        $id_user = $this->id_user;

        $result = $this->action_m->get_single('user', ['id_user' => $id_user]);
        $password = $this->input->post('password');
        $new_password = $this->input->post('new_password');
        $repassword = $this->input->post('repassword');
        $name_image = $this->input->post('name_image');

        if ($result->email != $email) {
            $cek_email = $this->action_m->get_single('user', ['email' => $email]);
            if ($cek_email) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email sudah terdaftar!';
                echo json_encode($data);
                exit;
            }   
            if (!$password) {
                $data['required'][] = ['req_password', 'Kata sandi tidak boleh kosong! Karena alamat email berubah'];
                $arrAccess[] = false;
            } 

            if (!$new_password) {
                $data['required'][] = ['req_new_password', 'Kata sandi baru tidak boleh kosong! Karena alamat email berubah'];
                $arrAccess[] = false;
            } 
            if (!$repassword) {
                $data['required'][] = ['req_repassword', 'Konfirmasi kata sandi tidak boleh kosong! Karena alamat email berubah'];
                $arrAccess[] = false;
            }     
        }
        if (!in_array(false, $arrAccess)) {
            $tujuan = './data/user/';
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image'];
                
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg';
                $config['file_name'] = uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_user = [];

                if (!$this->upload->do_upload('image')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_user = array('upload_data' => $this->upload->data());
                    $post['image'] = $data_user['upload_data']['file_name'];
                    $arrSession[PREFIX_SESSION.'_image'] = $data_user['upload_data']['file_name'];
                    if (file_exists($tujuan.$result->image)) {
                        unlink($tujuan.$result->image);
                    }
                }
            }else{
                if (!$name_image) {
                    if (file_exists($tujuan.$result->image)) {
                        unlink($tujuan.$result->image);
                    }
                    
                    $post['image'] = NULL;
                }
            }
            if (!validasi_email($email)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email tidak valid! ';
                echo json_encode($data);
                exit;
            }

            if ($result->phone != $phone) {
                $cek_phone = $this->action_m->get_single('user', ['phone' => $phone]);
                if ($cek_phone) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Nomor telepon telah terdaftar!';
                    echo json_encode($data);
                    exit;
                }
            }

            if ($password) {
                if (hash_my_password($result->email.$password) == $result->password) {
                    if ($new_password != $repassword) {
                        $data['status'] = false;
                        $data['alert']['message'] = 'Konfirmasi kata sandi tidak valid!';
                        echo json_encode($data);
                        exit;
                    } else {
                        $post['password'] = hash_my_password($email . $new_password);
                    }
                }else{
                    $data['status'] = false;
                    $data['alert']['message'] = 'Kata sandi tidak valid!';
                    echo json_encode($data);
                    exit;
                }
                
            }
            $update = $this->action_m->update('user', $post, ['id_user' => $id_user]);
            if ($update) {
                $arrSession[PREFIX_SESSION.'_name'] = $name;
                $arrSession[PREFIX_SESSION.'_email'] = $email;
                $arrSession[PREFIX_SESSION.'_phone'] = $phone;
                $this->session->set_userdata($arrSession);
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


    public function switch($db = 'user')
    {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        $reason = $this->input->post('reason') ?? '';
         $res = $this->action_m->get_single($db,['id_'.$db => $id]);
        if (!$res) {
             $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan!';
            echo json_encode($data);
            exit;
        }
        $set['status'] = $action;
        if ($action == 'N') {
            $set['reason'] = $reason;
        } else {
            $set['reason'] = '';
        }

        $update = $this->action_m->update($db, $set, ['id_'.$db => $id]);
        $alasan = '';
        if ($update) {
            $data['status'] = 200;
            $data['alert']['icon'] = 'success';
            if ($action == 'Y') {
                $data['alert']['message'] = 'Berhasil membuka akses!';
            } else {
                if ($reason != '') {
                    $alasan .= '</br><b>Dengan alasan : </b>"'.$reason;
                }
                $data['alert']['message'] = 'Berhasil menutup akses! '.$alasan;
            }
        } else {
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            if ($action == 'Y') {
                $data['alert']['message'] = 'Gagal membuka akses!';
            }else{
                $data['alert']['message'] = 'Gagal menutup akses!';
            }
            
        }
        echo json_encode($data);
        exit;
    }

    public function drag($action = 'delete',$db = 'user',$path = 'master|user')
    {
        $path = base64url_decode($path);
        $real = $this->input->post('real_delete') ?? false;
        $id = $this->input->post('id_batch');
        $cek = $this->action_m->get_all($db,['id_'.$db => $id]);
        if (!$cek) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data tidak ditemukan!';
            echo json_encode($data);
            exit;
        }
        if (!$id) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data tidak ditemukan!';
            echo json_encode($data);
            exit;
        }
        if ($action == 'block') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_'.$db] = $value;
                $set[$num]['status'] = 'N';
                $set[$num]['block_by'] = $this->id_user;
                $set[$num]['block_date'] = date('Y-m-d H:i:s');
            }
            $block = $this->action_m->update_batch($db, $set, 'id_'.$db);
            if ($block) {
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menutup akses!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url($path.' #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menutup akses!'.'!';
            }
        } elseif ($action == 'unblock') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_'.$db] = $value;
                $set[$num]['status'] = 'Y';
                $set[$num]['block_by'] = NULL;
                $set[$num]['block_date'] = NULL;
            }
            $block = $this->action_m->update_batch($db, $set, 'id_'.$db);
            if ($block) {

                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil membuka akses!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url($path.' #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal membuka akses!'.'!';
            }
        } elseif ($action == 'delete') {
            $set = [];
            if ($real == false) {
                $no = 0;
                foreach ($id as $value) {
                    $num = $no++;
                    $set[$num]['id_'.$db] = $value;
                    $set[$num]['delete'] = 'Y';
                    $set[$num]['delete_date'] = date('Y-m-d H:i:s');
                    $set[$num]['delete_by'] = $this->id_user;
                }
                
                
                $delete = $this->action_m->update_batch($db, $set,'id_'.$db);
            }else{
                $i = [];
                foreach ($id as $value) {
                    $i[] = $value;
                }
                $set['id_'.$db] = $i;
                $delete = $this->action_m->delete_batch($db, $set);
            }
            
            if ($delete) {

                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url($path.' #reload_table');
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menghapus data!';
            }
        } elseif($action == 'delete2'){
            $set = [];
            $i = [];
            foreach ($id as $value) {
                $i[] = $value;
            }
            $set['id_'.$db] = $i;
            $delete = $this->action_m->delete_batch($db, $set);
            if ($delete) {
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url($path.' #reload_table');
                if ($cek) {
                    foreach ($cek as $key) {
                        if ($db == 'banner') {
                            if (file_exists('./data/'.$db.'/'.$key->file)) {
                                unlink('./data/'.$db.'/'.$key->file);
                            }
                        }else{
                            if (file_exists('./data/'.$db.'/'.$key->image)) {
                                unlink('./data/'.$db.'/'.$key->image);
                            }
                        }
                        
                    }
                }
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menghapus data!';
            }
        }else {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data tidak ditemukan!2';
        }
        echo json_encode($data);
        exit;
    }

    public function get_single($db = 'user')
    {
        $id = $this->input->post('id');

        $result = $this->action_m->get_single($db, ['id_'.$db => $id]);
        echo json_encode($result);
        exit;
    }



    public function update_umum()
    {
        // VARIABEL
        $arrVar['name']            = 'Nama';
        $arrVar['email']            = 'Alamat email';
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
        $keyword = $this->input->post('keyword');
        $sort_description = $this->input->post('sort_description');
        $description = $this->input->post('description');
        $address = $this->input->post('address');

        $setting = $this->action_m->get_single('setting',['id_setting' => 1]);
        if ($keyword) {
            $keyword = json_decode($keyword, true);
            $aru = [];
            foreach ($keyword as $key) {
                $val = str_replace(["'",'"',"`"], "", $key['value']);
                $aru[] = $val;
            }
            $post['keyword'] = implode(',',$aru);
        }else{
            $post['keyword'] = NULL;
        }
        $post['sort_description'] = $sort_description;
        $post['description'] = $description;
        $post['address'] = $address;


        $phone = $this->input->post('phone');
        $name_phone = $this->input->post('name_phone');
        if ($phone) {
            $no = 0;
            foreach ($phone as $id => $ph) {
                if ($ph !='') {
                    $num = $no++;
                    $p[$num]['id_setting'] = 1;
                    $p[$num]['phone'] = $ph;
                    $p[$num]['name'] =  (isset($name_phone[$id])) ? $name_phone[$id] : NULL;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            $name_logo = $this->input->post('name_logo');
            $tujuan = './data/setting/';
            if (!empty($_FILES['logo']['tmp_name'])) {
                $logo = $_FILES['logo'];
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg|PNG|JPG|JPEG';
                $config['file_name'] = 'LG'.uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_logo = [];

                if (!$this->upload->do_upload('logo')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_logo = array('upload_data' => $this->upload->data());
                    $post['logo'] = $data_logo['upload_data']['file_name'];
                    if (file_exists($tujuan.$setting->logo)) {
                        unlink($tujuan.$setting->logo);
                    }
                }
            } else{
                if (!$name_logo) {
                    if (file_exists($tujuan.$setting->logo)) {
                        unlink($tujuan.$setting->logo);
                    }
                    
                    $post['logo'] = NULL;
                }
            }

            $name_icon = $this->input->post('name_icon');
            if (!empty($_FILES['icon']['tmp_name'])) {
                $icon = $_FILES['icon'];
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = 'png|jpg|jpeg|PNG|JPG|JPEG';
                $config['file_name'] = 'ICN'.uniqid();
                $config['file_ext_tolower'] = true;

                $this->load->library('upload', $config);

                $data_icon = [];

                if (!$this->upload->do_upload('icon')) {

                    $error = $this->upload->display_errors();
                    $data['status'] = false;
                    $data['alert']['message'] = $error;
                    echo json_encode($data);
                    exit;
                } else {
                    $data_icon = array('upload_data' => $this->upload->data());
                    $post['icon'] = $data_icon['upload_data']['file_name'];
                    if (file_exists($tujuan.$setting->icon)) {
                        unlink($tujuan.$setting->icon);
                    }
                }
            } else{
                if (!$name_icon) {
                    if (file_exists($tujuan.$setting->icon)) {
                        unlink($tujuan.$setting->icon);
                    }
                    
                    $post['icon'] = NULL;
                }
            }
            if (!validasi_email($email)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email tidak valid! ';
                echo json_encode($data);
                exit;
            }
            $update = $this->action_m->update('setting', $post, ['id_setting' => 1]);
            if ($update) {
                if ($phone) {
                    $this->action_m->delete('web_phone',['id_setting' => 1]);
                    $this->action_m->insert_batch('web_phone',$p);
                }
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


    public function tambah_halaman()
    {
        // VARIABEL
        $arrVar['name']            = 'Nama halaman';
        $arrVar['baseurl']            = 'Kategori Url';
        $arrVar['url']            = 'Url halaman';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $url = strtolower($url);
        $post['url'] = $url;
        if (strpos($url, ' ')) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Url halaman tidak boleh mengandung spasi';
            echo json_encode($data);
            exit;
        }
        if (!in_array(false, $arrAccess)) {
            $cek = $this->action_m->get_all('page',['delete' => 'N']);
            $arr_url = [];
            $arr_name = [];
            $user_page = [];
            if ($cek) {
                foreach ($cek as $row) {
                    $arr_url[] = $row->url;
                    $arr_name[] = $row->name;
                    if ($row->type == 2) {
                        $user_page[] = $row->id_page;
                    }
                }
            }

            $post['urutan'] = 100;
            if (count($user_page) >= 6) {
                $data['status'] = false;
                $data['alert']['message'] = 'Limit halaman sudah penuh! Hubungi admin jika terjadi kesalahan';
                echo json_encode($data);
                exit;
            }
            if (in_array($name,$arr_name)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Nama halaman sudah tersedia';
                echo json_encode($data);
                exit;
            }
             if (in_array($url,$arr_url)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Url halaman sudah tersedia';
                echo json_encode($data);
                exit;
            }
            $post['urutan'] = count($user_page) + 1;
            $post['type'] = 2;
            $insert = $this->action_m->insert('page', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil menambahkan data!';
                $data['reload'] = true;
                $data['modal']['id'] = '#kt_modal_page';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                 $data['alert']['message'] = 'Gagal menambahkan halaman! coba lagi nanti atau hubungi admin';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function ubah_halaman()
    {
        // VARIABEL
        $arrVar['name']            = 'Nama halaman';
        $arrVar['url']            = 'Url halaman';
        $arrVar['id_page'] = 'halaman ID';
         $arrVar['baseurl']            = 'Kategori Url';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
         if (strpos($url, ' ')) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Url halaman tidak boleh mengandung spasi';
            echo json_encode($data);
            exit;
        }
        $url = strtolower($url);
        $post['url'] = $url;

        if (!in_array(false, $arrAccess)) {
            $result = $this->action_m->get_single('page',['delete' => 'N','id_page' => $id_page]);
            $cek = $this->action_m->get_all('page',['delete' => 'N']);
            $arr_url = [];
            $arr_name = [];
            $user_page = [];
            if ($cek) {
                foreach ($cek as $row) {
                    
                    if ($row->type == 2 && $row->name != $result->name) {
                        $arr_url[] = $row->url;
                        $arr_name[] = $row->name;
                        $user_page[] = $row->id_page;
                    }
                }
            }

            if ($name == $result->name && $url == $result->url) {
                $data['status'] = false;
                $data['alert']['message'] ='Tidak ada data yang di rubah!';
                echo json_encode($data);
                exit;
            }
            if (count($user_page) >= 6) {
                $data['status'] = false;
                $data['alert']['message'] = 'Limit halaman sudah penuh! Hubungi admin jika terjadi kesalahan';
                echo json_encode($data);
                exit;
            }
            if (in_array($name,$arr_name)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Nama halaman sudah tersedia';
                echo json_encode($data);
                exit;
            }
             if (in_array($url,$arr_url)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Url halaman sudah tersedia';
                echo json_encode($data);
                exit;
            }
            

            $update = $this->action_m->update('page', $post, ['id_page' => $id_page]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil merubah data!';
                $data['reload'] = true;
                $data['modal']['id'] = '#kt_modal_page';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function hapus_halaman()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('page',['id_page' => $id,'delete' => 'N']);
        if ($res) {
            $hapus = $this->action_m->delete('page', ['id_page' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Data halaman berhasil dihapus';


                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['reload'] = true;
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Data halaman gagal dihapus! Coba lagi nanti atau laporkan';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data halaman tidak ditemukan';
        }
        

        echo json_encode($data);
        exit;
    }

     public function sorting_page()
    {
        $data = $this->input->post('data');
        $data = json_decode($data);
        $data = $data->order;

        $no = 0;
        if (count($data) > 0) {
            foreach ($data as $row) {
                $num = $no++;
                $set[$num]['id_page'] = $row->id;
                $set[$num]['urutan'] = $row->position;
            }
            $update = $this->action_m->update_batch('page',$set,'id_page');
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
}