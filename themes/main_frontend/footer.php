 </div>
  <!-- /.content-wrapper -->
  <footer class="bg-gray">
    <hr class="mt-11 mt-md-12 mb-7" />
    <div class="container pt-13 pb-7">
      <div class="row gx-lg-0 gy-6">
        <div class="col-lg-4">
          <div class="widget">
            <?php if($setting->logo) : ?>
            <img class="mb-4" src="<?= image_check($setting->logo,'setting'); ?>" srcset="<?= image_check($setting->logo,'setting'); ?> 2x" alt="" />
            <?php endif;?>
            <?php if($setting->sort_description) : ?>
            <p class="lead mb-0"><?= $setting->sort_description; ?></p>
            <?php endif;?>
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <?php if($webphone) : ?>
        <div class="col-lg-3 offset-lg-2">
          <div class="widget">
            <div class="d-flex flex-row">
              <div>
                <div class="icon text-primary fs-28 me-4 mt-n1"> 
                  <i class="fa-solid fa-phone"></i>
                </div>
              </div>
              <div>
                <h5 class="mb-1">Nomor Telepon</h5>
                <p class="mb-0">
                  
                  <?php foreach($webphone AS $row) : ?>
                  <?= phone_format('0'.$row->phone); ?><br />
                  <?php endforeach;?>
                  
                </p>
              </div>
            </div>
            <!--/div -->
          </div>
          <!-- /.widget -->
        </div>
        <?php endif;?>
        <!-- /column -->
        <?php if($setting->address) : ?>
        <div class="col-lg-3">
          <div class="widget">
            <div class="d-flex flex-row">
              <div>
                <div class="icon text-primary fs-28 me-4 mt-n1"> 
                  <i class="fa-solid fa-address-book"></i>
                </div>
              </div>
              <div class="align-self-start justify-content-start">
                <h5 class="mb-1">Alamat</h5>
                <address><?= $setting->address; ?></address>
              </div>
            </div>
            <!--/div -->
          </div>
          <!-- /.widget -->
        </div>
        <!-- /column -->
        <?php endif;?>
      </div>
      <!--/.row -->
      <hr class="mt-11 mt-md-12 mb-7" />
      <div class="d-md-flex align-items-center justify-content-between">
        <p class="mb-2 mb-lg-0">© <?= $setting->name;?> <?= date('Y'); ?></p>
      </div>
    </div>
    <!-- /.container -->
  </footer>
  <script>
    
    var BASE_URL = BASEURL =  '<?= base_url(); ?>';
    var hostUrl = "<?= base_url(); ?>assets/user/";
    var css_btn_confirm = 'btn btn-primary';
    var css_btn_cancel = 'btn btn-danger';
    var base_foto = '<?= image_check('notfound.jpg','default') ?>';
    var user_base_foto = '<?= image_check('user.jpg','default') ?>';
     addEventListener('keypress', function(e) {
        if (e.keyCode === 13 || e.which === 13) {
            e.preventDefault();
            return false;
        }
    });
    var div_loading = '<div class="logo-spinner-parent">\
                        <div class="logo-spinner">\
                            <img src="<?= image_check('icon_blue.png','attribut'); ?>" alt="">\
                            <div class="logo-spinner-loader"></div>\
                        </div>\
                        <p id="text_loading">Tunggu sebentar...</p>\
                    </div>';
                
</script>
  <script src="<?= base_url(); ?>assets/public/plugins/global/plugins.bundle.js"></script>
<script src="<?= base_url(); ?>assets/public/js/scripts.bundle.js"></script>
  <script src="<?= base_url('assets/user/') ?>js/plugins.js"></script>
  <script src="<?= base_url('assets/user/') ?>js/theme.js"></script>
   <script src="<?= base_url('assets/public/'); ?>js/alert.js"></script>
  <script src="<?= base_url('assets/public/') ?>js/function.js"></script>
  <script src="<?= base_url('assets/public/') ?>js/global.js"></script>
  <script src="<?= base_url('assets/public/') ?>js/mekanik.js"></script>
</body>

</html>