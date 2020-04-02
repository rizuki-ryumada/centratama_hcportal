<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<div class="alert alert-warning shadow-lg" role="alert">
		<h4 class="alert-heading">Berhasil</h4>
		<p>Job profile anda berhasil dikirimkan, mohon untuk menunggu tindakan dari atasan anda.</p>
		<hr>
		<p class="mb-0">Terima kasih.</p>
	</div>

	<div class="card shadow-lg" style="width: 25rem;">
		<div class="card-body">
			<h5 class="card-title">Status job profile</h5>
			<?php if ($approval['status_approval'] == 'Dikirim') : ?>
			<span class="badge badge-warning mb-2">Dikirim</span>
			<br class="mb-1"> Pada tanggal <?= date('d F Y', $approval['diperbarui']); ?>
			<?php elseif ($approval['status_approval'] == 'Disetujui1') : ?>
			<span class="badge badge-success mb-2">Disetujui atasan 1</span>
			<?php elseif ($approval['status_approval'] == 'Ditolak') : ?>
			<span class="badge badge-danger mb-2 mr-2">Ditolak</span><a href="#" class="badge badge-success">Ubah Job
				Profile</a>
			<?php endif; ?>
			<br>
			<a href="#" class="btn btn-primary btn-sm mt-2"><span><i class="fas fa-eye mr-2"></i></span>Lihat Job
				Profile</a>
		</div>
	</div>
</div>
</div>
