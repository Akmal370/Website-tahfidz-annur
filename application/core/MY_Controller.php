<?php defined('BASEPATH') or exit('No direct script access allowed');



/**

 * CodeIgniter-HMVC

 *

 * @package    CodeIgniter-HMVC

 * @author     N3Cr0N (N3Cr0N@list.ru)

 * @copyright  2019 N3Cr0N

 * @license    https://opensource.org/licenses/MIT  MIT License

 * @link       <URI> (description)

 * @version    GIT: $Id$

 * @since      Version 0.0.1

 * @filesource

 *

 */


class MY_Controller extends MX_Controller

{

    //

    public $CI;



    /**

     * An array of variables to be passed through to the

     * view, layout,....

     */

    protected $data = array();



    /**

     * [__construct description]

     *

     * @method __construct

     */

    public function __construct()

    {



        parent::__construct();



        // This function returns the main CodeIgniter object.

        // Normally, to call any of the available CodeIgniter object or pre defined library classes then you need to declare.

        $CI = &get_instance();



        // Copyright year calculation for the footer

        $begin = 2019;

        $end =  date("Y");

        $date = "$begin - $end";



        // Copyright

        $this->data['copyright'] = $date;
    }



    function __nocache()
    {

        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');

        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');

        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);

        $this->output->set_header('Pragma: no-cache');
    }
}


class MY_Auth extends MY_Controller
{


    var $path_theme = '';
    public function __construct()
    {

        parent::__construct();

        $this->path_theme = 'main_auth';
        
    }



    function display($name = '')
    {
         $setting = $this->action_m->get_single('setting',['id_setting' => 1]);
        $this->data['setting'] = $setting;


        $tpl = $this->path_theme . '/layout_single';



        $this->load->view($tpl, $this->data);
    }
}

class MY_Admin extends MY_Controller
{


    var $path_theme = '';
    public function __construct()
    {

        parent::__construct();

        $this->path_theme = 'main_admin';
        if (!$this->session->userdata(PREFIX_SESSION.'_id_user')) {
            redirect('admin');
        }
        
        
    }



    function display($name = '')
    {       
        $setting = $this->action_m->get_single('setting',['id_setting' => 1]);
        $user = $this->action_m->get_single('user',['id_user' => $this->session->userdata(PREFIX_SESSION.'_id_user')]);
        if (!$user || $user->status == 'N' || $user->delete == 'Y') {
            redirect('logout');
        }
        $access = $this->access();

        $this->data['setting'] = $setting;
        $this->data['access'] = $access;


        $tpl = $this->path_theme . '/layout_single';

        $this->load->view($tpl, $this->data);
    }

    function access()
    {
        $order['order_by'] = 'urutan';
        $order['ascdesc'] = 'ASC';
        $res_cms = $this->action_m->get_all('page',['type' => 2,'imortal' => 'N','status' => 'Y','delete' => 'N','baseurl' => 'Y'],$order);
        
        $data = [];
        $cms = [];
        if ($res_cms) {
            $nc = 0;
            foreach ($res_cms as $key) {
                $ncc = $nc++;
                $cms[$ncc]['id_page'] = $key->id_page;
                $cms[$ncc]['icon'] = $key->icon;
                $cms[$ncc]['name'] = $key->name;
                $cms[$ncc]['baseurl'] = $key->baseurl;
                $cms[$ncc]['url'] = $key->url;
                $cms[$ncc]['dropdown'] = $key->dropdown;
                $cms[$ncc]['access'] = $key->access;
                $cms[$ncc]['urutan'] = $key->urutan;
            }
        }
        $data['cms'] = $cms;

        return $data;
    }
}

class MY_Frontend extends MY_Controller
{


    var $path_theme = '';
    public function __construct()
    {

        parent::__construct();

        $this->path_theme = 'main_frontend';
        
    }



    function display($name = '')
    {   
        
        $setting = $this->action_m->get_single('setting',['id_setting' => 1]);
        $phone = $this->action_m->get_all('web_phone',['id_setting' => 1]);
        $order['order_by'] = 'urutan';
        $order['ascdesc'] = 'ASC';
        $menu = $this->action_m->get_all('page',['status' => 'Y','delete' => 'N','type' => 2],$order);

        $this->data['setting'] = $setting;
        $this->data['menu'] = $menu;
        $this->data['webphone'] = $phone;
        $tpl = $this->path_theme . '/layout_single';

        $this->load->view($tpl, $this->data);
    }


}


// Backend controller

require_once(APPPATH . 'core/Backend_Controller.php');



// Frontend controller

require_once(APPPATH . 'core/Frontend_Controller.php');
