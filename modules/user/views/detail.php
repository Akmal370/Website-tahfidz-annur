
<section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
    <div class="row">
        <div class="col-md-10 col-xl-8 mx-auto">
        <div class="post-header">
            <!-- /.post-category -->
            <h1 class="display-1 mb-4"><?= $result->title; ?></h1>
            <ul class="post-meta mb-5">
            <li class="post-date"><i class="fa-solid fa-calendar-days"></i><span><?= date('d M Y',strtotime($result->create_date)); ?></span></li>
            <li class="post-likes"><a role="button"><i class="fa-solid fa-layer-group"></i><span><?= $result->category; ?></a></li>
            </ul>
            <!-- /.post-meta -->
        </div>
        <!-- /.post-header -->
        </div>
        <!-- /column -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container -->
</section>
<!-- /section -->
<section class="wrapper bg-light">
    <div class="container pb-14 pb-md-16">
    <div class="row">
        <div class="col-lg-10 mx-auto">
        <div class="blog single mt-n17">
            <div class="card">
            <figure class="card-img-top"><img src="<?= image_check($result->image,'news') ?>" alt="" /></figure>
            <div class="card-body">
                <div class="classic-view">
                <article class="post">
                    <div class="post-content mb-5">
                    <p><?= $result->short_description; ?></p>
                    <?= $result->long_description;?>
                    </div>
                </article>
                <!-- /.post -->
                </div>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.blog -->
        </div>
        <!-- /column -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container -->
</section>
<!-- /section -->
