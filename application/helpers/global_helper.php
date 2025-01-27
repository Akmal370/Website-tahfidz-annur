<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function parse_raw_http_request(array &$a_data)
{
  // read incoming data
  $input = file_get_contents('php://input');

  // grab multipart boundary from content type header
  preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);
  $boundary = $matches[1];

  // split content by boundary and get rid of last -- element
  $a_blocks = preg_split("/-+$boundary/", $input);
  array_pop($a_blocks);

  // loop data blocks
  foreach ($a_blocks as $id => $block) {
    if (empty($block))
      continue;

    // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char

    // parse uploaded files
    if (strpos($block, 'application/octet-stream') !== FALSE) {
      // match "name", then everything after "stream" (optional) except for prepending newlines 
      preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
    }
    // parse all other fields
    else {
      // match "name" and optional value in between newline sequences
      preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
    }
    $a_data[$matches[1]] = $matches[2];
  }
}

function http_parse_headers($header)
{
  $retVal = array();
  $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
  foreach ($fields as $field) {
    if (preg_match('/([^:]+): (.+)/m', $field, $match)) {
      $match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower(trim($match[1])));
      if (isset($retVal[$match[1]])) {
        $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
      } else {
        $retVal[$match[1]] = trim($match[2]);
      }
    }
  }
  return $retVal;
}

function arrWeekDay($key = "")
{
  $arr = array(
    0 => 'Min',
    1 => 'Sen',
    2 => 'Sel',
    3 => 'Rab',
    4 => 'Kam',
    5 => 'Jum',
    6 => 'Sab'
  );

  if ($key) {
    return $arr[$key];
  } else {
    return $arr;
  }
}


function cek_align($data,$class = false)
{
  if ($data == 1) {
   $r = 'left';
   $a = 'start';
  }else if($data == 2){
    $r = 'center';
    $a = 'center';
  }else{
    $r = 'right';
    $a = 'end';
  }
  if ($class == 1) {
    return $a;
  }else{
    return $r;
  }
  
}

function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d')
{
  $date_aux = date_create_from_format($from_format, $date);
  return date_format($date_aux, $to_format);
}


function breadcrumb($parent, $arrchild = array())
{

  //arrchild => $arrchild[] = array('name' => 'namanya', 'link' => urlnya);


  $str = '<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: \'#kt_content_container\', \'lg\': \'#kt_toolbar_container\'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
          <!--begin::Title-->
          <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 mb-0">' . $parent . '</h1>
          <!--end::Title-->
          <!--begin::Separator-->
              <span class="h-20px border-gray-200 border-start mx-4"></span>
          <!--end::Separator-->
          <!--begin::Breadcrumb-->

          <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">';

  if (is_array($arrchild) && count($arrchild) > 0) {

    $cnt = count($arrchild);

    $i = 1;

    foreach ($arrchild as $arrval) {

      if ($i == $cnt) {
        $arrstr[] = '<!--begin::Item-->
          <li class="breadcrumb-item">' . $arrval['name'] . '</li>
          <!--end::Item-->
          ';
      } else {
        $arrstr[] = '<!--begin::Item-->
              <li class="breadcrumb-item text-muted">
                <a href="' . $arrval['link'] . '" class="text-muted text-hover-primary">' . $arrval['name'] . '</a>
              </li>
              <!--end::Item-->';
      }
      $i++;
    }

    $str .= implode('<li class="breadcrumb-item"><span class="bullet bg-gray-200 w-5px h-2px"></span></li>', $arrstr);
  }
  $str .= '</ul>
        <!--end::Breadcrumb-->
      </div>';

  return $str;
}


function short_text($text, $batas = 5, $pengganti = '...', $link = '')
{
  if (strlen($text) > $batas) {
    $data = substr($text, 0, $batas) . $pengganti;
  } else {
    $data = $text;
  }

  return $data;
}
function page_to_title($title,$sub = [])
{
  if (count($sub) > 0) {
       $title = str_replace("_", " ", $title);
       for ($i=0; $i < count($sub); $i++) { 
          if ($sub[$i] != (int)$sub[$i]) {
            $title .= ' ~ '.str_replace("_", " ", $sub[$i]);
          }
         
       }
  }else{
      $title = str_replace("_", " ", $title);
  }
 
  return $title;
}


function get_arr_uri($num = '')
{
  $val = $_SERVER['REQUEST_URI'];
  $val = explode('/',$val);

  $arr = [];
  if (count($val) > 2) {
    for ($i=2; $i < count($val) ; $i++) { 
      $arr[] = $val[$i];
    }
  }
  if ($num != '') {
    $arr = $arr[$num];
  }
  return $arr;
  
}

function search_encode($text, $encode = '--')
{
  if (preg_match("/$encode/i", $text)) {
    $data = str_replace($encode, " ", $text);
  } else {
    $data = $text;
  }

  return $data;
}

function gender_encode($gender = '')
{
  $data['L'] = 'Laki-laki';
  $data['P'] = 'Perempuan';
  if (isset($data[$gender])) {
    return $data[$gender];
  } else {
    return '';
  }
}

function status_payment($status = 99)
{
  $data[0] = 'menunggu pembayaran';
  $data[1] = 'menunggu konfirmasi';
  $data[2] = 'sukses';
  $data[3] = 'gagal';
  if (isset($data[$status])) {
    return $data[$status];
  } else {
    return $data;
  }
}

function status_wd($status = 99,$ambil = [])
{
  $data[0] = 'menunggu';
  $data[1] = 'sukses';
  $data[2] = 'gagal';
  if (isset($data[$status])) {
    return $data[$status];
  } else {
    if (is_array($ambil) && count($ambil) > 0) {
      $d = [];
      for ($i=0; $i < count($ambil) ; $i++) { 
        $d[$ambil[$i]] = $data[$ambil[$i]];
      }
      return $d;
    }else{
      return $data;
    }
    
  }
}

function nice_time($date){
    if(empty($date)) {
        return false;
    }
    
    $periods         = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "dekade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date       = strtotime($date);
    
    // check validity of date
    if(empty($unix_date)) {    
        return false;
    }
    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "yang lalu";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "dari sekarang";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        //$periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}";
}


function nice_text($str, $limit = null,$start = 0)
{
  $arr = [];
  $result = '';
  if (htmlspecialchars($str) != '') {
      if ($limit != NULL) {
        $arr = explode(' ',$str);
        for ($i=$start; $i < count($arr); $i++) { 
          if ($i <= $limit) {
            $result .= ' '.$arr[$i];
          }else{
            break;
          }
        }
        $result .= '...';
      }else{
        $arr = explode(' ',$str);
        for ($i=$start; $i < count($arr); $i++) { 
            $result .= ' '.$arr[$i];
        }
      }
  }

  return $result;
}

function wd_color($status = 99)
{
  $data[0] = 'warning';
  $data[1] = 'success';
  $data[2] = 'danger';
  if (isset($data[$status])) {
    return $data[$status];
  } else {
    return $data;
  }
}

function payment_color($status = 99)
{
  $data[0] = 'bg-light-warning';
  $data[1] = 'bg-light-info';
  $data[2] = 'bg-light-success';
  $data[3] = 'bg-light-danger';
  if (isset($data[$status])) {
    return $data[$status];
  } else {
    return $data;
  }
}
function setmenuactive($current_url, $class)
{
  if ($current_url == $class) {
    return "active";
  } else {
    if ($current_url == $class . "/index") {
      return "active";
    }
    return "";
  }
}

function set_menu_active($controller, $arrtarget = array(), $class = 'active', $exc = '')
{
  if ($controller) {
    if (in_array($controller, $arrtarget)) {
      return $class;
    } else {
      return $exc;
    }
  } else {
    return $exc;
  }
}
function initials($nama, $jmlh = 1)
{
  $words = explode(" ", $nama);
  $initials = null;
  $no = 1;
  foreach ($words as $w) {
    $num = $no++;
    $initials .= $w[0];
    if ($num == $jmlh) {
      break;
    }
  }
  return strtoupper($initials);
}
function set_submenu_active($controller, $arrtarget = array(), $c2 = '', $arrtarget2 = array(), $class = 'active', $exc = ''){
  if ($controller) {
    if (in_array($controller, $arrtarget)) {
      if ($c2) {
        if (in_array($c2, $arrtarget2)) {
          return $class;
        } else {
          return $exc;
        }
      } else {
        return $exc;
      }
    } else {
      return $exc;
    }
  } else {
    return $exc;
  }
}

function day_from_number($nomor = NULL)
{
  switch ($nomor) {
    case 1:
      return "Senin";
    case 2:
      return "Selasa";
    case 3:
      return "Rabu";
    case 4:
      return "Kamis";
    case 5:
      return "Jumat";
    case 6:
      return "Sabtu";
    case 7:
      return "Minggu";
    default:
      return array(1 => "Senin", 2 => "Selasa", 3 => "Rabu", 4 => "Kamis", 5 => "Jumat", 6 => "Sabtu", 7 => "Minggu");
  }
}


function month_from_number($nomor = NULL)
{
  switch ($nomor) {
    case 1:
      return "January";
    case 2:
      return "February";
    case 3:
      return "March";
    case 4:
      return "April";
    case 5:
      return "May";
    case 6:
      return "June";
    case 7:
      return "July";
    case 8:
      return "August";
    case 9:
      return "September";
    case 10:
      return "October";
    case 11:
      return "November";
    case 12:
      return "December";
    default:
      return array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
  }
}

function simple_number($number = '100')
{
  $jmlh = strlen($number);
  $ext = '';
  $value = $number;
  if ($jmlh >= 4 && $jmlh <= 6) {
    if ($jmlh == 4) {
      $value = substr($number, 0, 1);
      $koma = substr($number, 1, 1);
    } elseif ($jmlh == 5) {
      $value = substr($number, 0, 2);
      $koma = substr($number, 2, 1);
    } else {
      $value = substr($number, 0, 3);
      $koma = substr($number, 3, 1);
    }
    $ext = 'K';
  } elseif ($jmlh > 6 && $jmlh <= 9) {
    if ($jmlh == 7) {
      $value = substr($number, 0, 1);
      $koma = substr($number, 1, 1);
    } elseif ($jmlh == 8) {
      $value = substr($number, 0, 2);
      $koma = substr($number, 2, 1);
    } else {
      $value = substr($number, 0, 3);
      $koma = substr($number, 3, 1);
    }
    $ext = 'JT';
  } elseif ($jmlh > 9 && $jmlh <= 12) {
    if ($jmlh == 10) {
      $value = substr($number, 0, 1);
      $koma = substr($number, 1, 1);
    } elseif ($jmlh == 11) {
      $value = substr($number, 0, 2);
      $koma = substr($number, 2, 1);
    } else {
      $value = substr($number, 0, 3);
      $koma = substr($number, 3, 1);
    }
  } elseif ($jmlh > 12) {
    if ($jmlh == 13) {
      $value = substr($number, 0, 1);
      $koma = substr($number, 1, 2);
    } elseif ($jmlh == 14) {
      $value = substr($number, 0, 2);
      $koma = substr($number, 2, 3);
    } else {
      $value = substr($number, 0, 3);
      $koma = substr($number, 3, 4);
    }
    $ext = 'T';
  }
  $k = (intval($koma) > 0) ? ','.(String)$koma : '';
  return $value .$k. $ext;
}

function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}

function objectToArray($object) {
    if (is_object($object)) {
        $object = get_object_vars($object);
    }

    if (is_array($object)) {
        return array_map('objectToArray', $object);
    } else {
        return $object;
    }
}
function array_to_object($data)
{
    if (is_array($data) || is_object($data))
    {
        $result= new stdClass();
        foreach ($data as $key => $value)
        {
            $result->$key = array_to_object($value);
        }
        return $result;
    }
    return $data;
}
function encrypt_path($filename,$rename = '')
{
  $name = basename($filename);
  if ($rename != '') {
    $name = $rename;
  }
  /**
   * Make sure the downloads are *not* in a publically accessible path, otherwise, people
   * are still able to download the files directly.
   */
  //$filename = '/the/path/to/your/files/' . basename( $_GET['filename'] );

  /**
   * You can do a check here, to see if the user is logged in, for example, or if 
   * the current IP address has already downloaded it, the possibilities are endless.
   */


  if (file_exists($filename)) {
    /** 
     * Send some headers indicating the filetype, and it's size. This works for PHP >= 5.3.
     * If you're using PHP < 5.3, you might want to consider installing the Fileinfo PECL
     * extension.
     */
    $finfo = finfo_open(FILEINFO_MIME);
    header('Content-Disposition: attachment; filename= ' . $name);
    header('Content-Type: ' . finfo_file($finfo, $filename));
    header('Content-Length: ' . filesize($filename));
    header('Expires: 0');
    finfo_close($finfo);

    /**
     * Now clear the buffer, read the file and output it to the browser.
     */
    ob_clean();
    flush();
    readfile($filename);
    exit;
  }

  header('HTTP/1.1 404 Not Found');

  echo "<h1>File not found</h1>";
  exit;
}

function setencrypt($string)
{
  $stringenc = base64_encode($string);
  $stringenc = str_replace("=", "", $stringenc);
  return $stringenc;
}
function base64url_encode($data)
{
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function base64url_decode($data)
{
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}
function get_range_date($date1, $date2)
{

  $arr = array();
  $date2 = date('Y-m-d', strtotime($date2 . "+1 DAYS"));
  $begin = new DateTime($date1);
  $end = new DateTime($date2);

  if ($date1 == $date2) {
    $arr[] = $date1;
  } else {
    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);
    foreach ($period as $dt) {
      $arr[] = $dt->format('Y-m-d');
    }
  }
  return $arr;
}

function cek_email($email = '')
{
  $dicari = '@';
  if ($email != '') {
    if (preg_match("/$dicari/i", $email)) {
      $s = explode('@', $email);
      if ($s[1] == 'gmail.com') {
        $result = true;
      } else {
        $result = false;
      }
    } else {
      $result = false;
    }
  } else {
    $result = false;
  }

  return $result;
}

function bytes($bytes, $force_unit = NULL, $format = NULL, $si = TRUE)
{
  // Format string
  $format = ($format === NULL) ? '%01.2f %s' : (string) $format;

  // IEC prefixes (binary)
  if ($si == FALSE or strpos($force_unit, 'i') !== FALSE) {
    $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
    $mod   = 1024;
  }
  // SI prefixes (decimal)
  else {
    $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
    $mod   = 1000;
  }

  // Determine unit to use
  if (($power = array_search((string) $force_unit, $units)) === FALSE) {
    $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
  }

  return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
}

function reverse_date($date)
{
  list($y, $m, $d) = explode("-", $date);
  $newdate = $d . "-" . $m . "-" . $y;
  return $newdate;
}

function reverse_fulldate($date)
{
  list($date, $time) = explode(" ", $date);
  $newdate = reverse_date($date);
  return $newdate . " " . $time;
}

function getNamaHari($number)
{
  $arrHari = array('0' => 'Minggu', '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu');
  return $arrHari[$number];
}

function rupiah($angka, $format = "Rp. ")
{
  $hasil_rupiah = "$format" . number_format($angka, 0, ',', '.');
  return $hasil_rupiah;
}
function ifnull($value = NULL, $ganti = NULL)
{
  if (isset($value) == NULL || $value == '') {
    if ($ganti != NULL) {
      $data = $ganti;
    } else {
      $data = '';
    }
  } else {
    $data = $value;
  }

  return $data;
}


function obj_to_array($d)
{
  if (is_object($d)) {
    // Gets the properties of the given object
    // with get_object_vars function
    $d = get_object_vars($d);
  }
  if (is_array($d)) {
    /*
      * Return array converted to object
      * Using __FUNCTION__ (Magic constant)
      * for recursive call
      */
    return array_map(__FUNCTION__, $d);
  } else {
    // Return array
    return $d;
  }
}


function mydate($date, $format)
{
  if ($format == 1) {
    $dt = date_create($date);
    $tanggal = date('Y-m-d', $dt);
    $jam = date('H:i:s', $dt);
    $date_format = $tanggal . 'T' . $jam;
  } else {
    $dt = date_create($date);
    $date_format = date_format($dt, $format);
  }
  return $date_format;
}


function hash_my_password($pass)
{
  $data = hash('sha256', $pass);
  return $data;
}

function validasi_email($email)
{
  $r = true;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $r = false;
  }

  return $r;
}

function ckeditor_check($content = '')
{
  // Hapus semua tag HTML
  $clean_content = strip_tags($content, '<p><br>'); // Biarkan <p> dan <br> untuk diproses lebih lanjut
  // Hapus tag <p><br></p> yang sering muncul sebagai konten kosong
  $clean_content = preg_replace('/<p>(&nbsp;|\s|<br>|<\/?p>)*<\/p>/i', '', $clean_content);
  // Hapus whitespace yang tersisa
  $clean_content = trim($clean_content);

  return $clean_content;
}

function phone_check($phoneNumber) {
    // Menghapus karakter yang tidak diinginkan
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Memeriksa panjang nomor telepon
    if (strlen($phoneNumber) < 10 || strlen($phoneNumber) > 15) {
        return false;
    }

    // Memeriksa apakah hanya terdiri dari angka
    if (!preg_match('/^[0-9]+$/', $phoneNumber)) {
        return false;
    }

    return true;
}

function phone_format($phoneNumber) {
    // Remove any non-numeric characters from the phone number
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Check if the phone number has 10 digits (assuming a standard US phone number)
    if (strlen($phoneNumber) >= 10) {
        // Format the phone number as (XXX) XXX-XXXX
        $formattedPhoneNumber = sprintf("(%s) %s-%s",
            substr($phoneNumber, 0, 4),
            substr($phoneNumber, 4, 4),
            substr($phoneNumber, 8, 6)
        );

        return $formattedPhoneNumber;
    } else {
        // If the phone number doesn't have 10 digits, return an error or handle accordingly
        return "Invalid phone number";
    }
}

function selisih_hari($tgl1,$tgl2)
{
  $tgl1 = strtotime($tgl1); 
  $tgl2 = strtotime($tgl2); 

  $jarak = $tgl2 - $tgl1;

  $hari = $jarak / 60 / 60 / 24;
  return $hari;
}


function zip_file($name = 'DOKUMEN',$path = './data/',$path_tujuan = './data/zip/')
{
    $ci =& get_instance();
    // Directory to zip
    $dirPath = $path;

    // Destination zip file path and name
    $zipFilePath = $path_tujuan.$name.'.zip';

    // Load CodeIgniter's zip library
    $ci->load->library('zip');

    // Iterate through the directory and add files to the zip
    $ci->zip->read_dir($dirPath, FALSE);

    // Save the zip file to the server
    $ci->zip->archive($zipFilePath);

    return true;
}

function directori_member($path = './data/',$ext = true)
{
	$files = array_diff(scandir($path), array('.', '..'));
  $fix = [];
  if ($files) {
    foreach ($files as $file) {
      if (is_file($path.'/'.$file)) {
          $fix[] = $file;
      }
    }
  }
  $files = $fix;
  if ($ext == false) {
    $arr = [];
    foreach ($files as $file) {
      $arr[] = explode('.',$file)[0];
    }

    $files = $arr;
  }
	return $files;
}
  function size_file($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

function embed_link_youtube($url)
{
     $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
     $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

    if (preg_match($longUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }

    if (preg_match($shortUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }
    return 'https://www.youtube.com/embed/' . $youtube_id ;
}


function access_code($code)
{
    $arr['R'] = 'Melihat';
    $arr['C'] = 'Menambahkan';
    $arr['U'] = 'Merubah';
    $arr['D'] = 'Menghapus';
    $arr['B'] = 'Aksesbilitas';

    return $arr[$code];
}


function alphabet_number($var = 0,$type = '0toa')
{
  $alphabet = range('A', 'Z');

  // var_dump($var);die;
  if ($type == '0toa') {
    return $alphabet[$var]; // returns D
  }

  if ($type == 'ato0') {
    return array_search($var, $alphabet); // returns 3
  }

}


// Function to encode text to a random combination of words and numbers
function fake_encode($text,$min = 28) {
    $key = RAND_KEY;
    $iv = IV_KEY;
    $jml = strlen($text);
    if ($jml < $min) {
        $length = $min - $jml;
        $tbh = range(1,$length);
        $text .= '&|&'.implode('',$tbh);
    }
    $encrypted = openssl_encrypt($text, 'aes-256-cbc', $key, 0, $iv);
    $encrypted_base64 = base64url_encode($encrypted);
    return $encrypted_base64;
}

// Function to decode random words and numbers back to text
function fake_decode($chiper) {
    $key = RAND_KEY;
    $iv = IV_KEY;
    $chiper = base64url_decode($chiper);
    $decrypted = openssl_decrypt($chiper, 'aes-256-cbc', $key, 0, $iv);
    if (strpos($decrypted,'&|&')) {
      $exp = explode('&|&',$decrypted);
      $decrypted = $exp[0];
    }
    return $decrypted;
}
function getScheme() {
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return 'https';
    } else {
        return 'http';
    }
}
function sensor_text($text,$final_length = 20,$sensor = '*')
{
    if ($text != '') {
        if (strlen($text) > $final_length) {
          $length = $final_length;
        }else{
          $length = strlen($text);
        }

        $bagi = ($length / 3);
        $element = round($bagi);
        
        $length_sensor = $length - ($element * 2);
        $sen = '';
        for ($i=1; $i <= $length_sensor; $i++) { 
            $sen .= $sensor;
        }

        $first = substr($text,0, $element);
        $last = substr($text, ($element * -1));
        return $first .$sen.$last;
    }else{
        return false;
    }
    
}
function image_check($image = null, $path = null, $rename = NULL)
{
  if ($path == null) {
    $path = 'error';
  }
  if ($rename != NULL) {
    $pt = $rename;
  } else {
    $pt = 'notfound';
  }
  if ($image == null) {
    $file = 'gaada';

    $file = 'default/' . $pt . '.jpg';
  } else {
    if (file_exists(base_data() . $path . '/' . $image)) {
      $file = $path . '/' . $image;
    } else {
      $file = 'default/' . $pt . '.jpg';
      // $file = 'gaada';
    }
  }

  return base_url('data/' . $file);
}

function notelp_format($phone){ 
      
    // Pass phone number in preg_match function 
    if(preg_match( 
        '/^\+[0-9]([0-9]{3})([0-9]{3})([0-9]{4})$/',  
    $phone, $value)) { 
      
        // Store value in format variable 
        $format = $value[1] . '-' .  
            $value[2] . '-' . $value[3]; 
    } 
    else { 
         
        // If given number is invalid 
        return "Invalid phone number <br>"; 
    } 
      
    // Print the given format 
    return $format; 
} 

function base_data($path = null)
{
  $p = APPPATH . '../data/';
  if ($path == null) {
    return $p;
  } else {
    return $p . $path;
  }
}



function cek_ds_color($start, $durasi)
{
  $data = 'danger';
  if(strtotime($start) <= strtotime(date('Y-m-d H:i:s')) && strtotime("+".$durasi." minutes",strtotime($start)) >= strtotime(date('Y-m-d H:i:s'))){
    $data = 'primary';
  }else{
    if(strtotime($start) > strtotime(date('Y-m-d H:i:s'))) {
       $data = 'warning';
    }
  }
  return $data;
}

function cek_date_skale($start, $durasi, $clear = false)
{
  $data = ($clear == false) ? 'past' : 'telah berakhir';
  if(strtotime($start) <= strtotime(date('Y-m-d H:i:s')) && strtotime("+".$durasi." minutes",strtotime($start)) >= strtotime(date('Y-m-d H:i:s'))){
    $data = ($clear == false) ? 'now' : 'sedang berlangsung';
  }else{
    if(strtotime($start) > strtotime(date('Y-m-d H:i:s'))) {
       $data = ($clear == false) ? 'soon' : 'belum dimulai';
    }
  }
  return $data;
}

function range_date($start, $end = null, $durasi = 30)
{
  if ($end == null) {
    $end = strtotime("+".$durasi." minutes",strtotime($start));
  }

  $beauty_start = date('d',strtotime($start)).' '.month_from_number(date('m',strtotime($start))).' '.date('Y',strtotime($start)).' '.date('H:i',strtotime($start));
  $beauty_end = date('d',$end).' '.month_from_number(date('m',$end)).' '.date('Y',$end).' '.date('H:i',$end);
  return $beauty_start.' - '.$beauty_end;

  
}

function encrypt($data,$key = 'p'){
    if (openssl_public_encrypt($data, $encrypted, $key))
        $data = base64_encode($encrypted);
    else
        throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

    return $data;
}

function decrypt($data,$key= 'q'){
    if (openssl_private_decrypt(base64_decode($data), $decrypted, $key))
        $data = $decrypted;
    else
        $data = '';

    return $data;
}

function hour_format($time = 1, $format = 'itoH') {
  // Format nya H:i:s
    $f = explode('to',$format);
    $h = 1;
    $i = 0;
    $s = 0;
    if ($f[1] == 'H') {
      if ($f[0] == 'i') {
        $h = floor($time / 60);
        $i = ($time % 60);
      }
    }

    if ($f[1] == 'H') {
      if ($f[0] == 's') {
        $h = floor($time / 60 / 60);
        $i = ($time % 60);
      }
    }
    
    $arr['H'] = $h;
    $arr['i'] = $i;
    $arr['s'] = $s;
    
    return $arr;
}


function getFolderSize($dir) {
    $totalSize = 0;

    // Open the directory
    if ($handle = opendir($dir)) {
        // Loop through the directory contents
        while (false !== ($entry = readdir($handle))) {
            // Skip the . and .. entries
            if ($entry != "." && $entry != "..") {
                $filePath = $dir . DIRECTORY_SEPARATOR . $entry;
                
                // If it's a file, add its size to the total
                if (is_file($filePath)) {
                    $totalSize += filesize($filePath);
                }
                
                // If it's a directory, recursively calculate its size
                elseif (is_dir($filePath)) {
                    $totalSize += getFolderSize($filePath);
                }
            }
        }
        // Close the directory handle
        closedir($handle);
    }
    return $totalSize;
}

function formatSize($size) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $unitIndex = 0;

    while ($size >= 1024 && $unitIndex < count($units) - 1) {
        $size /= 1024;
        $unitIndex++;
    }

    return round($size, 2) . ' ' . $units[$unitIndex];
}
