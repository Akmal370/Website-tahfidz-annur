
<div class="row">
    <?php
        $sos = json_decode($result->sosmed);
    ?>
    <div class="col-12 d-flex flex-column justify-content-center align-items-center text-center">
        <div class="testi-thumb mb-3">
            <div class="modal-image" style="background-image: url('<?= image_check($result->image,'tokoh') ?>')"></div>
        </div>
        <div class="content">
            <h4>
                <a role="button" class="text-center"><?= $result->name;?></a>
            </h4>
            <p class="text-center"><?= $result->address;?></p>
        </div>
    </div>
    <?php if($sos && !empty($sos)) : ?>
    <div class="col-12 d-flex justify-content-center align-items-center mt-3">
        <div class="gt-social style2 d-flex judtify-content-center align-items-center">
            <?php foreach($sos AS $key => $url): ?>
            <a href="<?= $url; ?>" target="_BLANK"><i class="<?= $sosmed[$key]; ?>"></i></a>
            <?php endforeach;?>
        </div>
    </div>
    <?php endif;?>

    <div class="col-12 mt-3 px-3">
        <?= $result->description;?>
    </div>
</div>