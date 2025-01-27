<?php defined('BASEPATH') or exit('No direct script access allowed');

class Function_ctl extends MY_Frontend
{
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
    }

    public function donasi()
    {
        // VARIABEL
        $arrVar['name']             = 'Nama';
        $arrVar['code']             = 'Kode';
        $arrVar['email']            = 'Email';
        $arrVar['nominal']           = 'Nominal donasi';

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
        $post['message'] = $message = $this->input->post('message');
        if (!in_array(false, $arrAccess)) {
            if (!validasi_email($email)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email tidak valid!';
                echo json_encode($data);
                exit;
            }
            $insert = $this->action_m->insert('donasi', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Donasi anda telah disalurkan!';
                $data['reload'] = true;
            } else {
                $data['status'] = false;
                 $data['alert']['message'] = 'Donasi anda gagal disalurkan!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    public function payment()
    {
        // Load Midtrans library
        require_once APPPATH.'../vendor/Midtrans/Midtrans.php';

        // Konfigurasi server key Midtrans
        \Midtrans\Config::$serverKey = 'SB-Mid-server-uLeRwg6iDUKk0HPF5uOqY0sI';
        \Midtrans\Config::$isProduction = false; // Ubah ke true untuk production
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Debugging: Set default values
        $id = $this->input->post('id') ?? 'DONATE'.date('YmdHis'); // Order ID unik
        // VARIABEL
        $arrVar['name']             = 'Nama';
        $arrVar['email']            = 'Email';
        $arrVar['nominal']           = 'Nominal donasi';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $this->input->post($var);
            if (!$$var) {
                $data['required'][] = ['req_'.$var,$value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                if ($var == 'nominal') {
                    $$var = preg_replace('/[^0-9]/', '', $$var);
                }
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $post['message'] = $message = $this->input->post('message');
        if (!in_array(false, $arrAccess)) {
            if ($nominal <= 0) {
                $data['status'] = false;
                $data['alert']['message'] = 'Nominal tidak boleh kosong!';
                echo json_encode($data);
                exit;
            }
            if (!validasi_email($email)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email tidak valid!';
                echo json_encode($data);
                exit;
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $id,
                    'gross_amount' => $nominal,
                ]
            ];

            // Generate Snap Token
            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                // Return Snap Token untuk frontend
                echo json_encode([
                    'status' => true,
                    'token' => $snapToken,
                    'debug' => [
                        'order_id' => $id,
                        'gross_amount' => $nominal,
                    ]
                ]);
                exit;
            } catch (Exception $e) {
                // Tampilkan error untuk debugging
                $dt['status'] = false;
                $dt['alert']['message'] = $e->getMessage();
                $dt['debug']['order_id'] = $id;
                $dt['debug']['gross_amount'] = $nominal;
                echo json_encode($dt);
                exit;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
        

    }
}