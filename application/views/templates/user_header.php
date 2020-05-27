<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Dean Abner Julian">

	<title><?= $title; ?> | HC Portal PT. Centratama Group</title>

	<link rel="shortcut icon" href="<?= base_url('assets/'); ?>img/logo2.ico">

	<!-- Custom fonts for this template-->
	<link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
	<!-- <link href="<?= base_url('assets/'); ?>vendor/bootstrap-toogle/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
	<link href="<?= base_url('assets/'); ?>css/style.css" rel="stylesheet">
	<link href="<?= base_url('assets/'); ?>css/custom.jquery.orgchart.min.css" rel="stylesheet" > <!-- Customized by Ryu -->
	<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
	<script src="<?= base_url('assets'); ?>/js/ckeditor/ckeditor.js"></script>
	<!-- <script src="<?php //base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script> moved from jobs_footer  and user_footer -->
	<!-- <script src="<?php //base_url('assets'); ?>/js/OrgChartJS/orgchart.js"></script> -->
	<style>
		.highlight {
			background-color: #2e279d;
			border-radius: 24px;
			color: white;
			text-align: center;
		}

		.node.me rect {
			fill: #FFCA28;
		}

		td,
		ol {
			text-align: left;
			margin-left: 2px;
			padding-left: 15px;
			padding-top: auto;
		}

		td,
		ul {
			text-align: left;
			margin-left: 2px;
			padding-left: 15px;
		}

		div.note {
			background-color: #e6e6e6;
			padding: 27px;
			border-radius: 50px;
		}

		#cke_tujuan,
		#cke_jenkar,
		#cke_ruangl,
		#cke_ruang,
		#cke_tantangan,
		#cke_hubInt,
		#cke_eksternal,
		#cke_internal,
		#cke_hubEks {
			box-shadow: 2px 2px;
		}

		td.span,
		.edit-hubInt,
		.edit-hubEks {
			cursor: pointer;
		}

		#cke_hubInt,
		#cke_hubEks,
		.simpanhubInt,
		.batalhubInt,
		.simpanhubEks,
		.batalhubEks,
		.simpan-profile,
		.kembali-profile,
		.editor-jenkar,
		.editor-tujuan,
		.editor-ruang,
		.editor-tantangan {
			display: none;
		}

		th.head-kualifikasi {
			width: 300px !important;
		}



		[node-me='My Position'] rect {
			fill: #750000;
		}
	</style>
</head>

<body id="page-top">
	<!-- Page Wrapper -->
	<div id="wrapper">
