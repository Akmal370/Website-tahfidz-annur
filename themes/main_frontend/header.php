
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= $setting->description;?>">
  <meta name="author" content="<?= $setting->name; ?>">
  <meta property="og:title" content="<?= $setting->name; ?>">
  <meta property="og:description" content="<?= $setting->description;?>">
  <meta name="keywords" content="<?= $setting->keyword;?>">

  <title><?= MAINTITLE; ?> <?= (isset($title)) ? ' | '.$title : ''; ?></title>
  <link rel="shortcut icon" href="<?= image_check($setting->icon,'setting'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/user/') ?>css/plugins.css">
  <link rel="stylesheet" href="<?= base_url('assets/user/') ?>css/style.css">
  <link href="<?= base_url(); ?>assets/public/css/loading_custom.css" rel="stylesheet" type="text/css" />
  <script src="https://kit.fontawesome.com/c772e3a5a0.js" crossorigin="anonymous"></script>
  <style>
    @media (min-width: 992px) {
      .navbar-collapse .navbar-nav>.nav-item>.nav-link {
        position: relative;
      }

      .navbar-collapse .navbar-nav>.nav-item+.nav-item>.nav-link:before {
        content: "";
        display: block;
        position: absolute;
        width: 3px;
        height: 3px;
        top: 50%;
        left: -2px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 50%;
      }
    }
    .banner-slide{
      width : 100%;
      border-radius : 10px;
      background-position : center;
      background-repeat : no-repeat;
      background-size : cover;
    }
  </style>
</head>

<body class="onepage">
  <div class="content-wrapper">
    <header class="wrapper bg-gray">
      <nav class="navbar navbar-expand-lg extended extended-alt navbar-light navbar-bg-light">
        <div class="container flex-lg-column">
            <?php if($setting->logo) : ?>
          <div class="topbar d-flex flex-row justify-content-lg-center align-items-center">
            <div class="navbar-brand"><img src="<?= image_check($setting->logo,'setting') ?>" srcset="<?= image_check($setting->logo,'setting') ?> 2x" alt="" style="max-width : 150px;height : 60px;" /></div>
          </div>
          <?php endif;?>
          <!-- /.d-flex -->
          <div class="navbar-collapse-wrapper bg-white d-flex flex-row align-items-center justify-content-between">
            <div class="navbar-other w-100 d-none d-lg-block">
            </div>
            <!-- /.navbar-other -->
            <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
              <div class="offcanvas-header d-lg-none">
                <?php if($setting->logo) : ?>
                  <img src="<?= image_check($setting->logo,'setting') ?>" srcset="<?= image_check($setting->logo,'setting') ?> 2x" alt="" style="max-width : 150px;height : 60px;" />
                <?php endif;?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body d-flex flex-column h-100">
                <?php if($menu) : ?>
                <ul class="navbar-nav">
                  <?php foreach($menu AS $row) : ?>
                  <li class="nav-item"><a class="nav-link <?= (in_array($this->uri->segment(1),[$row->url])) ? 'active' : ''; ?>" href="<?= base_url($row->url); ?>"><?= ucwords($row->name); ?></a></li>
                  <?php endforeach;?>
                </ul>
                <?php endif;?>
                <!-- /.navbar-nav -->
                <div class="offcanvas-footer d-lg-none">
                  <div>
                    <a href="/cdn-cgi/l/email-protection#a3c5cad1d0d78dcfc2d0d7e3c6cec2cacf8dc0ccce" class="link-inverse"><span class="__cf_email__" data-cfemail="e28b8c848da2878f838b8ecc818d8f">[email&#160;protected]</span></a>
                    <br /> 
                    <?php if($webphone) : ?>
                    <?php foreach($webphone AS $row) : ?>
                    <?= phone_format('0'.$row->phone); ?><br />
                    <?php endforeach;?>
                    <?php endif;?>
                  </div>
                </div>
                <!-- /.offcanvas-footer -->
              </div>
            </div>
            <!-- /.navbar-collapse -->
            <div class="navbar-other w-100 d-flex">
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item">
                  <a href="<?= base_url('register'); ?>" class="btn btn-sm btn-primary">Daftar Member</a>
                </li>
                <li class="nav-item d-lg-none">
                  <button class="hamburger offcanvas-nav-btn"><span></span></button>
                </li>
              </ul>
              <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
          </div>
          <!-- /.navbar-collapse-wrapper -->
        </div>
        <!-- /.container -->
      </nav>
      <!-- /.navbar -->
      <div class="offcanvas offcanvas-end text-inverse" id="offcanvas-info" data-bs-scroll="true">
        <div class="offcanvas-header">
          <h3 class="text-white fs-30 mb-0">Sandbox</h3>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body pb-6">
          <div class="widget mb-8">
            <p>Sandbox is a multipurpose HTML5 template with various layouts which will be a great solution for your business.</p>
          </div>
          <!-- /.widget -->
          <div class="widget mb-8">
            <h4 class="widget-title text-white mb-3">Contact Info</h4>
            <address> Moonshine St. 14/05 <br /> Light City, London </address>
            <a href="/cdn-cgi/l/email-protection#63050a1110174d0f02101723060e020a0f4d000c0e"><span class="__cf_email__" data-cfemail="375e59515877525a565e5b1954585a">[email&#160;protected]</span></a><br /> 00 (123) 456 78 90
          </div>
          <!-- /.widget -->
          <div class="widget mb-8">
            <h4 class="widget-title text-white mb-3">Learn More</h4>
            <ul class="list-unstyled">
              <li><a href="#">Our Story</a></li>
              <li><a href="#">Terms of Use</a></li>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Contact Us</a></li>
            </ul>
          </div>
        </div>
        <!-- /.offcanvas-body -->
      </div>
      <!-- /.offcanvas -->
      <div class="offcanvas offcanvas-top bg-light" id="offcanvas-search" data-bs-scroll="true">
        <div class="container d-flex flex-row py-6">
          <form class="search-form w-100">
            <input id="search-form" type="text" class="form-control" placeholder="Type keyword and hit enter">
          </form>
          <!-- /.search-form -->
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <!-- /.container -->
      </div>
      <!-- /.offcanvas -->
    </header>
    <!-- /header -->