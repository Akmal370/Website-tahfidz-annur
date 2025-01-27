<?php defined('BASEPATH') or exit('No direct script access allowed');

class Function_ctl extends MY_Admin
{
    var $id_user = '';
    var $name = '';
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_user = $this->session->userdata(PREFIX_SESSION.'_id_user');
        $this->name = $this->session->userdata(PREFIX_SESSION.'_name');
    }

        // master USER

    public function tambah_user()
    {
        $role =  $this->input->post('role') ?? 1;
        // VARIABEL
        $arrVar['name']             = 'Nama lengkap';
        $arrVar['phone']           = 'Nomor telepon';
        $arrVar['email']           = 'Alamat email';
        if ($role == 1) {
            $arrVar['password']         = 'Kata sandi';
            $arrVar['repassword']       = 'Konfirmasi kata sandi';
        }
       

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                if (!in_array($var, ['password', 'repassword'])) {
                    $post[$var] = trim($$var);
                    $arrAccess[] = true;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {
                $image = $_FILES['image'];
                $tujuan = './data/user/';
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
            }
            $post['role'] = $role;
            if (!validasi_email($email)) {
                $data['status'] = 700;
                $data['alert']['message'] = 'Alamat email tidak valid!';
                echo json_encode($data);
                exit;
            }
            $user_mail = $this->action_m->get_single('user', ['email' => $email,'delete' => 'N']);
            if ($user_mail) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email sudah terdaftar!';
                echo json_encode($data);
                exit;
            }
             $user_telp = $this->action_m->get_single('user', ['phone' => $phone,'delete' => 'N']);
            if ($user_telp) {
                $data['status'] = false;
                $data['alert']['message'] = 'Nomor telepon sudah terdaftar!';
                echo json_encode($data);
                exit;
            }

            if ($password != $repassword) {
                $data['status'] = false;
                $data['alert']['message'] = 'Konfirmasi kata sandi tidak valid!';
                echo json_encode($data);
                exit;
            } else {
                $post['password'] = hash_my_password($email . $password);
            }
            $post['approve'] = 'Y';
            $post['user.create_by'] = $this->id_user;
            $insert = $this->action_m->insert('user', $post);
            if ($insert) {
               

                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil menambahkan data!';
                $data['load'][0]['parent'] = '#base_table';
                if ($role == 1) {
                     $data['load'][0]['reload'] = base_url('master/user #reload_table');
                }else{
                     $data['load'][0]['reload'] = base_url('master/member #reload_table');
                }
               
                $data['modal']['id'] = '#kt_modal_user';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal menambahkan data!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function ubah_user()
    {
        // VARIABEL
        $arrVar['id_user']          = 'user ID';
        $arrVar['name']             = 'Nama lengkap';
        $arrVar['phone']           = 'Nomor telepon';
        $arrVar['email']            = 'Alamat email';
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
        $result = $this->action_m->get_single('user', ['id_user' => $id_user,'delete' => 'N']);
        $password = $this->input->post('password')?? '';
        $repassword = $this->input->post('repassword')?? '';
        $name_image = $this->input->post('name_image')?? '';
         $tujuan = './data/user/';
        if ($result->email != $email) {
            if (!validasi_email($email)) {
                $data['status'] = 700;
                $data['alert']['message'] = 'Alamat email tidak valid!';
                echo json_encode($data);
                exit;
            }
            $cek_email = $this->action_m->get_single('user', ['email' => $email,'id_user !=' => $id_user,'delete' => 'N']);
            if ($cek_email) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email sudah terdaftar!';
                echo json_encode($data);
                exit;
            }   
            if (!$password) {
                $data['required'][] = ['req_password', 'Kata sandi tidak boleh kosong! Karena email berubah'];
                $arrAccess[] = false;
            } 
            if (!$repassword) {
                $data['required'][] = ['req_repassword', 'Konfirmasi kata sandi tidak boleh kosong! Karena email berubah'];
                $arrAccess[] = false;
            }   
             
        }
        if (!in_array(false, $arrAccess)) {
            if ($result->phone != $phone) {
                $cek_phone = $this->action_m->get_single('user', ['phone' => $phone,'id_user !=' => $id_user,'delete' => 'N']);
                if ($cek_phone) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Nomor telepon sudah terdaftar!';
                    echo json_encode($data);
                    exit;
                }      
            }

            if ($password) {
                if ($password != $repassword) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Konfirmasi kata sandi tidak valid!';
                    echo json_encode($data);
                    exit;
                } else {
                    $post['password'] = hash_my_password($email . $password);
                }
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
                    if ($name_image) {
                        if (file_exists($tujuan.$name_image)) {
                            unlink($tujuan.$name_image);
                        }
                    }
                    
                }
            }else{
                 if (!$name_image) {
                    if (file_exists($tujuan.$result->image)) {
                        unlink($tujuan.$result->image);
                    }
                    $post['image'] = '';
                }
            }
            
            $update = $this->action_m->update('user', $post, ['id_user' => $id_user]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil merubah data!';
                 $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/user #reload_table');
                $data['modal']['id'] = '#kt_modal_user';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal merubah data!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function hapus_user()
    {
        $id = $this->input->post('id');
        $res = $this->action_m->get_single('user',['id_user' => $id,'delete' => 'N']);
        if ($res) {
            $hapus = $this->action_m->update('user',['delete' => 'Y','delete_date' => date('Y-m-d H:i:s'),'delete_by' => $this->id_user],['id_user' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Berhasil menghapus data!';
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url('master/user #reload_table');
                if (file_exists('./data/user/'.$res->image)) {
                    unlink('./data/user/'.$res->image);
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





    
}


