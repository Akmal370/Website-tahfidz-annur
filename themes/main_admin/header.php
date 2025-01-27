<!DOCTYPE html>

<html lang="en" data-bs-theme-mode="light">

<head>
    <base href="<?= base_url(); ?>" />
    <title><?= MAINTITLE; ?> <?= (isset($title)) ? ' | ' . $title : '';  ?></title>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!-- UNTUK SEO -->
    <?php if($setting->icon) : ?>
    <link rel="shortcut icon" href="<?= image_check($setting->icon,'setting'); ?>" />
    <?php endif;?>
    <!-- UNTUK CSS -->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="<?= base_url(); ?>assets/public/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/public/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?= base_url(); ?>assets/public/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/admin/css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/public/css/custom_pribadi.css" rel="stylesheet" type="text/css" />
     <link href="<?= base_url(); ?>assets/public/css/loading_custom.css" rel="stylesheet" type="text/css" />
     <script src="https://kit.fontawesome.com/c772e3a5a0.js" crossorigin="anonymous"></script>
         <script type="text/javascript" src="<?=base_url('assets/public/plugins/ckeditor5/ckeditor.js'); ?>"></script>
     <script>
         var CKEditor_tool = ["heading", "alignment","|",'fontSize','fontColor', 'fontBackgroundColor',"|", "bold", "italic", "link", "bulletedList", "numberedList", "|", "outdent", "indent", "|", "blockQuote", "insertTable", "mediaEmbed", "undo", "redo"];
     </script>
    <!--end::Global Stylesheets Bundle-->
    <!--end::Global Stylesheets Bundle-->
    <?php
    if (isset($css_add) && is_array($css_add)) {
        foreach ($css_add as $css) {
            echo $css;
        }
    } else {
        echo (isset($css_add) && ($css_add != "") ? $css_add : "");
    }
    ?>

    <style>
        .cursor-pointer{
            cursor: pointer !important;
        }
        .cursor-disabled{
            cursor: not-allowed !important;
        }
        .cursor-scroll{
            cursor: all-scroll;
        }
        /* .form-control,
        .form-select{
            border : 1px solid var(--bs-gray-300) !important;
        } */
        .menu-accordion.active{
            color : #FF286B !important;
        }
        .swal2-textarea{
            color : #FFFFFF !important;
        }

        .background-partisi{
            background-position : center !important;
            background-repeat : no-repeat !important;
            background-size :cover !important;
        }
        .swal2-textarea {
            color : black !important;
        }
    </style>
</head>

<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" <?= ($this->uri->segment(1) == 'website') ? 'data-kt-app-sidebar-minimize="on"' : '';?> class="app-default">
    <script>
		var defaultThemeMode = "light"; 
		var themeMode; 
		if ( document.documentElement ) { 
			if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
				themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
			} else { 
				if ( localStorage.getItem("data-bs-theme") !== null ) { 
					themeMode = localStorage.getItem("data-bs-theme"); 
				} else { 
					themeMode = defaultThemeMode; 
				} 
			} 
			if (themeMode === "system") { 
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
			} document.documentElement.setAttribute("data-bs-theme", themeMode); 
		}
		</script>