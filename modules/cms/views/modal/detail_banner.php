<div class="shadow d-flex justify-content-center align-items-center flex-column position-relative overflow-hidden">
    <?php $ext = explode('.',$result->file); ?>
    <?php if(in_array($ext[1],['mp4'])) : ?>
        <video src="<?= image_check($result->file,'banner'); ?>" style="width : 100%;height:100%;" autoplay muted loop preload="auto"></video>
        <div class="position-absolute d-flex justify-content-center align-items-center flex-column" style="width : 100%;height:100%;background-image: linear-gradient(rrgb(44 212 36 / 63%), rgb(0 0 0 / 36%));">
            <h4 class="text-white text-center" style="font-size : 20px;width : 90%;"><?= $result->title ?></h4>
            <p class="text-white text-center" style="font-size : 15px;width : 90%;"><?= $result->description ?></p>
            <?php if($result->button == 'Y') : ?>
            <button class="btn btn-sm btn-warning" style="min-width : 100px;min-height : 10px;font-size : 15px"><?= $result->button_name ?></button>
            <?php endif; ?>
        </div>
    <?php else :?>
        <div class="background-partisi d-flex justify-content-center align-items-center flex-column" style="width : 100%;height:300px;background-image: linear-gradient(rrgb(44 212 36 / 63%), rgb(0 0 0 / 36%)),url('<?= image_check($result->file,'banner') ?>');">
            <h4 class="text-white text-center" style="font-size : 20px;width : 90%;"><?= $result->title ?></h4>
            <p class="text-white text-center" style="font-size : 15px;width : 90%;"><?= $result->description ?></p>
            <?php if($result->button == 'Y') : ?>
            <button class="btn btn-sm btn-warning" style="min-width : 100px;min-height : 10px;font-size : 15px"><?= $result->button_name ?></button>
            <?php endif; ?>
        </div>
    <?php endif;?>
    
    
    <?php if($wave) : ?>
    <div class="wave-cms-banner">
        <img src="<?= base_url('data/attr/wave-'.$wave.'.png'); ?>" alt="">
    </div>
    <?php endif;?>
</div>
