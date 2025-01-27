<!DOCTYPE html>
<html lang="en" data-bs-theme-mode="light">
	<!--begin::Head-->
	<head>
		<base href="<?= base_url();?>"/>
		<title><?= ucfirst(MAINTITLE) ?> <?= (isset($title)) ? ' | '.$title : ''; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- <link rel="canonical" href="https://preview.keenthemes.com/metronic8" /> -->
		<?php if($setting->icon) : ?>
		<link rel="shortcut icon" href="<?= image_check($setting->icon,'setting') ?>" />
		<?php endif;?>
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="<?= base_url('assets/public/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/admin/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center">
		