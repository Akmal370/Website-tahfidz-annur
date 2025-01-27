<!-- About Section Start -->
<?php 
    $obj = [];
    $title = '';
    $subtitle = '';
    $description = '';
    $mirror = 'N';
    $button = 'N';
    $button_name = '';
    $img = '';
    $button_link = '';
    if ($detail->data != '') {
        $obj = json_decode($detail->data);
        $title = (isset($obj->title)) ? $obj->title : ''; 
        $description = (isset($obj->description)) ? $obj->description : ''; 
        $subtitle = (isset($obj->subtitle)) ? $obj->subtitle : ''; 
        $mirror = (isset($obj->mirror)) ? $obj->mirror : 'N'; 
        $button = (isset($obj->button)) ? $obj->button : 'N'; 
        $button_name = (isset($obj->button_name)) ? $obj->button_name : 'button'; 
        $button_link = (isset($obj->button_link)) ? $obj->button_link : ''; 
        $img = (isset($obj->image)) ? $obj->image : ''; 
    }

    
?>
<!-- /section -->
    <section id="about">
      <div class="wrapper bg-gray">
        <div class="container py-14 py-md-16">
          <div class="row gx-md-8 gx-xl-12 gy-6 align-items-center <?= ($mirror == 'N') ? 'flex-row-reverse' :''; ?>">
            <div class="col-md-8 col-lg-6 order-lg-2 mx-auto">
              <?php if($img && file_exists('./data/hero/'.$img)) : ?>
              <div class="img-mask mask-2"><img src="<?= image_check($img,'hero') ?>" alt="" /></div>
              <?php endif;?>
            </div>
            <!--/column -->
            <div class="col-lg-6">
              <h2 class="display-5 mb-3"><?= $title; ?></h2>
              <?= $description; ?>
              <?php if($button == 'Y' && $button_link) : ?>
              <a href="<?= $button_link; ?>" class="btn btn-primary rounded-pill mt-2"><?= $button_name; ?></a>
              <?php endif;?>
            </div>
            <!--/column -->
          </div>
        </div>
        <!-- /.container -->
      </div>
      <!-- /.wrapper -->
    </section>
    <!-- /section -->