 <section id="portfolio">
      <div class="wrapper bg-gray">
        <div class="container py-10 py-md-12 text-center">
          <div class="row">
            <div class="col-lg-10 col-xl-8 col-xxl-7 mx-auto mb-8">
              <h2 class="display-5 mb-3">Gellery Kami</h2>
            </div>
            <!-- /column -->
          </div>
          <?php if($result) : ?>
          <!-- /.row -->
          <div class="grid grid-view projects-masonry">
            <div class="isotope-filter filter mb-10">
              <ul>
                <li><a class="filter-item active" data-filter="*">All</a></li>
                <?php if($category) : ?>
                    <?php foreach($category AS $row) : ?>
                    <li><a class="filter-item" data-filter=".filter-<?= $row->id_gallery_category; ?>"><?= $row->name; ?></a></li>
                    <?php endforeach;?>
                <?php endif;?>
              </ul>
            </div>
            <div class="row gx-md-6 gy-6 isotope">
            <?php foreach($result AS $row) : ?>
              <div class="project item col-md-6 col-xl-4 <?= 'filter-'.$row->id_gallery_category; ?>">
                <figure class="overlay overlay-1 rounded" style="height : 200px"><a href="<?= image_check($row->image,'gallery'); ?>" data-glightbox data-gallery="shots-group"> <img src="<?= image_check($row->image,'gallery'); ?>" alt="" /></a>
                  <figcaption>
                    <h5 class="from-top mb-0"><?= $row->title; ?></h5>
                  </figcaption>
                </figure>
              </div>
            <?php endforeach;?>
              
            </div>
            <!-- /.row -->
          </div>
          <!-- /.grid -->
          <?php else : ?>
            <div class="card mb-3 py-5 mb-xl-8 mt-0">
                    <div class="d-flex justify-content-center align-items-center flex-column w-100">
                        <img src="<?= image_check('empty.svg','default') ?>" alt="Tidak ada data" style="width : 200px">
                        <h3 class="text-primary">Data galeri tidak ditemukan</h3>
                        <p>Silahkan menambahkan galeri untuk mengisi halaman ini!</p>
                    </div>
                </div>
        <?php endif;?>
        </div>
        <!-- /.container -->
      </div>
      <!-- /.wrapper -->
    </section>