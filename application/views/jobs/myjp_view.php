<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<div class="flash-jobs" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>

	<!-- card start -->
	<div class="card shadow mb-2" id="print">
		<!-- Card Header - Accordion -->
		<div class="d-block card-header py-3">
			<h5 class="m-0 font-weight-bold text-black-50">Profil Jabatan Anda</h5>
		</div>
		<!-- Card Content - Collapse -->
		<div class="collapse show">
			<!-- JP Viewer -->
			<?php $this->load->view('jobs/jp_viewer') ?>
			<!-- JP Viewer -->
			
			<?php if($approval['status_approval'] == 0): ?>
				<div class="card-footer badge-danger">
					<p class="text-center m-0 p-0">Silakan isi, lengkapi, dan submit Job Profile Anda. </p>
				</div>
			<?php elseif($approval['status_approval'] == 1): ?>
				<div class="card-footer badge-warning">
					<p class="text-center m-0 p-0">Job Profile sudah dikirim ke Atasan 1 anda, silakan tunggu hingga proses berikutnya. </p>
				</div>
			<?php elseif($approval['status_approval'] == 2): ?>
				<div class="card-footer badge-warning">
					<p class="text-center m-0 p-0">Job Profile sudah dikirim ke Atasan 2 anda, silakan tunggu hingga proses berikutnya. </p>
				</div>
			<?php elseif($approval['status_approval'] == 3): ?>
				<div class="card-footer badge-danger">
					<p class="text-center m-0 p-0">Anda diminta untuk merevisi job profle anda, klik tombol pesan untuk melihat revisi anda. </p>
				</div>
			<?php elseif($approval['status_approval'] == 4): ?>
				<div class="card-footer badge-success">
					<p class="text-center m-0 p-0">Job Profile Anda sudah siap, selamat bekerja. </p>
				</div>
			<?php endif; ?>
		</div>
	</div> 
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->