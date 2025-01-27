<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller_ctl extends MY_Admin
{
    var $id_user = '';
    var $id_role = '';
    public function __construct()
    {
        // Load the constructer from MY_Controller
        parent::__construct();
        $this->id_user = $this->session->userdata(PREFIX_SESSION.'_id_user');
         $this->id_role = $this->session->userdata(PREFIX_SESSION.'_id_role');
        // $this->id_role = 4;
        // $this->id_user = 27;
        $this->access = $this->access();

    }

    public function index()
    {
        $this->umum();
    }

    public function profil()
    {
        $mydata = [];

         // LOAD MAIN DATA
        $this->data['title'] = 'Profil User';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "profile"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/setting/profil.js"></script>';

         // BUTTON 
        $this->data['button']['id'] = 'btn_update_profil';
        $this->data['button']['form_id'] = '#form_ubah_profil';

        $result = $this->action_m->get_single('user',['id_user' => $this->id_user]);

        $mydata['result'] = $result;
        // LOAD VIEW
        $this->data['content'] = $this->load->view('profil', $mydata, TRUE);
        $this->display();
    }


    public function umum()
    {
        $mydata = [];

         // LOAD MAIN DATA
        $this->data['title'] = 'Pengaturan Umum';
        // LOAD JS
        $this->data['js_add'][] = '<script>var page = "umum"</script>';
        $this->data['js_add'][] = '<script src="' . base_url() . 'assets/admin/js/modul/setting/umum.js"></script>';


        // BUTTON 
        $this->data['button']['id'] = 'btn_update_umum_setting';
        $this->data['button']['form_id'] = '#form_ubah_setting';
        


        $result = $this->action_m->get_single('setting',['id_setting' => 1]);
        $phone = $this->action_m->get_all('web_phone',['id_setting' => 1]);

        $mydata['result'] = $result;
        $mydata['phone'] = $phone;
        
        // LOAD VIEW
        $this->data['content'] = $this->load->view('umum', $mydata, TRUE);
        $this->display();
    }


    public function download()
    {
        $url = $this->input->get('url');
        $rename = $this->input->get('rename') ?? '';

        if ($url) {
            encrypt_path($url,$rename);
        }else{
            echo "URL Tidak tersedia!";
        }
    }

    public function cetak_excel()
    {
        $data = $this->input->get('data');
        $rename = $this->input->get('rename') ?? 'file-'.date('YmdHisa');

        $data = base64url_decode($data);
        
        $data = $this->rsa->publicDecrypt($data);
        
        $data = json_decode($data);
        

        $lc = 0;
        $lr = 1;
        $last_col = 'A';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        if (is_object($data)) {
            
            foreach ($data as $num => $arr) {
                foreach ($arr as $row => $value) {
                    $anum = alphabet_number($row,'ato0');
                    if ($lc < $anum) {
                        $lc = $anum;
                        $last_col = alphabet_number($lc,'0toa');
                    }
                    if ($lr < $num) {
                        $lr = $num;
                    }
                    $sheet->setCellValue($row.$num, $value);
                }
                
            }
            
        }else{
            var_dump('TIDAK VALID');die;
        }
        
       
            
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' =>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		];
        $sheet->getStyle('A1:'.$last_col.$lr)->applyFromArray($styleArray);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$rename.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
   
}
