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


    
    public function approval()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 'Y') {
            $message = 'Berhasil menyetujui pendaftaran';
            $set['approve'] = $status;
            $update = $this->action_m->update('user',$set,['id_user' => $id]);
        }else{
            $message = 'Berhasil menolak pendaftaran';
            $update = $this->action_m->delete('user',['id_user' => $id]);
        }

        
        if ($update) {
             $data['status'] = true;
            $data['alert']['message'] = $message;
            sleep(1);
            echo json_encode($data);
            exit;
        }else{
            $data['status'] = false;
            $data['alert']['message'] = 'Gagal melakukan aksi';
            sleep(1);
            echo json_encode($data);
            exit;
        }
    }
}