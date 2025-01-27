 <section id="portfolio">
      <div class="wrapper bg-gray">
        <div class="container py-10 py-md-12 text-center">
          <div class="row">
            <div class="col-lg-10 col-xl-8 col-xxl-7 mx-auto mb-8">
              <h2 class="display-5 mb-3">Berita Terkini</h2>
              <p class="lead fs-lg">Kenali kami lebih dalam dengan melihat berita terkini tentang kami</p>
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
                    <li><a class="filter-item" data-filter=".filter-<?= $row->id_news_category; ?>"><?= $row->name; ?></a></li>
                    <?php endforeach;?>
                <?php endif;?>
              </ul>
            </div>
            <div class="row gx-md-6 gy-6 isotope">
            <?php foreach($result AS $row) : ?>
              <div class="project item col-md-6 col-xl-4 <?= 'filter-'.$row->id_news_category; ?>">
                <figure class="overlay overlay-1 rounded" style="height : 200px"><a href="<?= image_check($row->image,'news'); ?>" data-glightbox data-gallery="shots-group"> <img src="<?= image_check($row->image,'news'); ?>" alt="" /></a>
                  <figcaption>
                    <h5 class="from-top mb-0"><?= $row->title; ?></h5>
                  </figcaption>
                </figure>
                <div class="card mt-1 d-flex justify-content-start align-items-start flex-column px-4 py-3">
                    <div class="w-100 d-flex justify-content-end align-items-center">
                        <span class="alert alert-sm py-1 px-2 fs-10 alert-primary"><?= $row->category; ?></span>
                    </div>
                    <h3 class="text-start fs-20" style="height : 50px"><?= short_text($row->title,40); ?></h3>
                    <p class="text-start text-muted fs-13"><?= short_text($row->short_description,100); ?></p>
                    <a href="<?= base_url('detail/'.$row->id_news); ?>" class="btn btn-sm btn-primary">Baca selengkapnya</a>
                </div>
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
                        <h3 class="text-primary">Data berita tidak ditemukan</h3>
                        <p>Silahkan menambahkan berita untuk mengisi halaman ini!</p>
                    </div>
                </div>
        <?php endif;?>
        </div>
        <!-- /.container -->
      </div>
      <!-- /.wrapper -->
    </section>