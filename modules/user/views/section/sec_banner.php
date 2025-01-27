<?php
    $obj = [];
    $height = 100;
    if ($detail->data != '') {
        $obj = json_decode($detail->data);
        $height = (isset($obj->height)) ? $obj->height : 100; 
    }
    $banner = (isset($attribut['banner'][$detail->id_cms_section])) ? $attribut['banner'][$detail->id_cms_section] : [];
    if ($banner) {
        usort($banner, function($a, $b) {
            return $a['urutan'] <=> $b['urutan']; // Urutan menaik
        });
    }
    
?>
<?php if($banner) : ?>
    <section>
      <div class="wrapper bg-gray overflow-hidden">
        <div class="container-fluid px-xl-0 pt-6 pb-10">
          <div class="swiper-container swiper-auto" data-margin="30" data-dots="true" data-nav="true" data-centered="true" data-loop="true" data-items-auto="true">
            <div class="swiper overflow-visible">
              <div class="swiper-wrapper">
                <?php foreach($banner AS $row) : ?>
                <div class="swiper-slide" style="width : 85vw;">
                  <div class="banner-slide" style="height : <?= $height ?>vh;background-image : url('<?= image_check($row['file'],'banner') ?>')"></div>
                </div>
                <?php endforeach;?>
              </div>
              <!--/.swiper-wrapper -->
            </div>
            <!-- /.swiper -->
          </div>
          <!-- /.swiper-container -->
        </div>
        <!-- /.cotnainer -->
      </div>
      <!-- /.overflow-hidden -->
    </section>
<?php endif;?>