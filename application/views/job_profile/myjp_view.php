<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">Job Profile</h1>

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
			<?php $this->load->view('job_profile/jp_viewer') ?>
			<!-- JP Viewer -->
			
			<?php if($approval['status_approval'] == 0): ?>
				<div class="card-footer badge-danger">
					<p class="text-center m-0 p-0">Kindly complete your job profile and submit for approvals.</p>
				</div>
			<?php elseif($approval['status_approval'] == 1): ?>
				<div class="card-footer badge-warning">
					<p class="text-center m-0 p-0">Your job profile is awaiting for approvals.</p>
				</div>
			<?php elseif($approval['status_approval'] == 2): ?>
				<div class="card-footer badge-warning">
					<p class="text-center m-0 p-0">Your job profile is awaiting for final approval.</p>
				</div>
			<?php elseif($approval['status_approval'] == 3): ?>
				<div class="card-footer badge-danger">
					<p class="text-center m-0 p-0">Your job profile need to be revised. Kindly click notes button for comments and re-submit. </p>
				</div>
			<?php elseif($approval['status_approval'] == 4): ?>
				<div class="card-footer badge-success">
					<p class="text-center m-0 p-0">Your job profile is approved.</p>
				</div>
			<?php endif; ?>
		</div>
	</div> 
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->