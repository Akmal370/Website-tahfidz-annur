
        <script>
            var BASE_URL = '<?= base_url(); ?>';
            var hostUrl = "<?= base_url(); ?>assets/admin/";
            var css_btn_confirm = 'btn btn-primary';
            var css_btn_cancel = 'btn btn-danger';
            var image_default = '<?= image_check('user.jpg','default') ?>';
        </script>
        <!--end::Main-->
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="<?= base_url('assets/'); ?>public/plugins/global/plugins.bundle.js"></script>
		<script src="<?= base_url('assets/'); ?>public/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		
		<!--end::Custom Javascript-->
        <?php

        if (isset($js_add) && is_array($js_add)) {
            foreach ($js_add as $js) {
                echo $js;
            }
        } else {
            echo (isset($js_add) && ($js_add != "") ? $js_add : "");
        }

        ?>
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>