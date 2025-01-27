<?php defined('BASEPATH') or exit('No direct script access allowed');

class Function_ctl extends MY_Controller
{
    var $id_user = '';
    var $name = '';
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_user = $this->session->userdata(PREFIX_SESSION.'_id_user');
        $this->name = $this->session->userdata(PREFIX_SESSION.'_name');
        $this->image = $this->session->userdata(PREFIX_SESSION.'_image');
       
        
    }

    // FUNGSI AUTH
    public function login_proses()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');

        $email = strtolower($email);
        if (!$_POST) {
            redirect('auth');
        }
        if (!$email || !$password) {
            $data['status'] = 700;
            $data['message'] = 'Tidak ada data terdeteksi! Silahkan coba lagi';
            echo json_encode($data);
            exit;
        }
        if (!validasi_email($email)) {
            $data['status'] = 700;
            $data['message'] = 'Alamat email tidak valid';
            echo json_encode($data);
            exit;
        }

        $result = $this->action_m->get_single('user', ['email' => $email,'user.delete' => 'N']);
        if ($result) {
            if ($result->status == 'N') {
                if ($result->reason) {
                    $reason = ' dengan alasan </br></br><b>"' . $result->reason . '"</b></br></br>';
                } else {
                    $reason = '!';
                }
                $data['status'] = 700;
                $data['message'] = 'Akses anda telah dimatikan' . $reason . '! Hubungi admin jika terjadi kesalahan';
                echo json_encode($data);
                exit;
            }
            if ($result->role == 2) {
                $data['status'] = 700;
                $data['message'] = 'Member tidak memiliki akses masuk!';
                echo json_encode($data);
                exit;
            }
            if ($result->password == hash_my_password($email . $password)) {
                $arrSession[PREFIX_SESSION.'_id_user'] = $result->id_user;
                $arrSession[PREFIX_SESSION.'_id_role'] = $result->role;
                $arrSession[PREFIX_SESSION.'_name'] = $result->name;
                $arrSession[PREFIX_SESSION.'_email'] = $result->email;
                $arrSession[PREFIX_SESSION.'_phone'] = $result->phone;
                $arrSession[PREFIX_SESSION.'_image'] = $result->image;

                $this->session->set_userdata($arrSession);

                $data['status'] = 200;
                $data['message'] = 'Anda berhasil masuk! Selamat datang <b>'. $result->name.'</b>';
                $data['redirect'] = base_url('dashboard');
               
            } else {
                $data['status'] = 500;
                $data['message'] = 'Kata sandi salah! Silahkan coba kembali';
            }
        } else {
            $data['status'] = 500;
            $data['message'] = 'Email tidak terdaftar! Silahkan coba kembali';
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    public function register_proses()
    {
        $name      = $this->input->post('name');
        $email      = $this->input->post('email');
        $phone      = $this->input->post('phone');
        $email      = strtolower($email);
        // PERIKSA INPUT
        if (!$email || !$name || !$phone) {
            $data['status'] = 500;
            $data['message'] = 'Data tidak terdeteksi! Silahkan cek ulang data yang anda masukan';
            echo json_encode($data);
            exit;
        }
        if (!validasi_email($email)) {
            $data['status'] = 700;
            $data['message'] = 'Email tidak valid! Silahkan cek dan coba lagi.';
            echo json_encode($data);
            exit;
        }

        // CEK USER
        $result = $this->action_m->get_single('user', ['email' => $email]);
        if ($result) {
            $data['status'] = 500;
            $data['message'] = 'Email yang anda masukan sudah terdaftar!';
            echo json_encode($data);
            exit;
        }

        $no_telp = $this->action_m->get_single('user', ['phone' => $phone]);
        if ($no_telp) {
            $data['status'] = 500;
            $data['message'] = 'Nomor telepon yang anda masukan sudah terdaftar!';
            echo json_encode($data);
            exit;
        }

        $arrInsert['email'] = $email;
        $arrInsert['name'] = $name;
        $arrInsert['phone'] = $phone;
        $arrInsert['role'] = 2;
        $insert = $this->action_m->insert('user', $arrInsert);

        if ($insert) {
            $data['status'] = 200;
            $data['message'] = 'Anda berhasil mendaftar! Tunggu admin kami menghubungi anda';
            $data['redirect'] = base_url('user');
        } else {
            $data['status'] = 700;
            $data['message'] = 'Gagal menambah data! silahkan cek data atau coba lagi nanti';
        }
        echo json_encode($data);
        exit;
    }


    public function logout()
    {
        $this->session->unset_userdata(PREFIX_SESSION.'_id_user');
        $this->session->unset_userdata(PREFIX_SESSION.'_name');
        $this->session->unset_userdata(PREFIX_SESSION.'_image');
        $this->session->unset_userdata(PREFIX_SESSION.'_id_role');
        $this->session->unset_userdata(PREFIX_SESSION.'_phone');
        $this->session->unset_userdata(PREFIX_SESSION.'_email');

        redirect('login');
    }

}