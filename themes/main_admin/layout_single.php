
<?php include_once("header.php"); ?>
<?php include_once("sidemenu.php"); ?>
<?php echo $content; ?>
<div id="alert-container-noreload" class="alert-container-noreload"></div>
<audio id="alert-sound-noreload" src="<?= base_url('data/attr/notif.mp3'); ?>"></audio>
<?php include('./themes/global_extension/modal_embed.php') ?>
<?php include('./themes/global_extension/loading_modal.php') ?>
<?php include_once("footer.php"); ?>
