<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- load floating contact -->
    <?php $this->load->view('templates/komponen/floating_contact') ?>
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<!-- card start -->
	<div class="card shadow mb-2" id="print">
		<!-- Card Header - Accordion -->
		<div h class=" row card-header py-3">
			<div class="col-0,5 h-100 my-0">
				<div class="h-100">
					<div class="my-0">
						<a class="btn btn-primary btn-sm" href="<?= base_url('job_profile/report'); ?>report" style="width: 50px;"><strong><i class="fa fa-chevron-left"></i></strong></a>
					</div>
				</div>
			</div>
			<div class="col-11">
				<div class="h-100">
					<div class="my-2">
						<?php if(!empty($emp_name['emp_name'])): ?>
							<h5 class="m-0 font-weight-bold text-black-50"><?= $emp_name['emp_name']; ?></h5>
						<?php else: ?>
							<h5 class="m-0 font-weight-bold text-black-50">No Employe</h5>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Card Content - Collapse -->
		<div class="collapse show" id="collapseCardExample">
			<!-- JP Editor -->
			<?php $this->load->view('job_profile/jp_viewer'); ?>
			<!-- /JP Editor -->

			<?php if($statusApproval['status_approval'] == 0): ?>
				<div class="card-footer badge-danger">
					<p class="text-center m-0 p-0">Kindly complete your job profile and submit for approvals.</p>
				</div>
			<?php elseif($statusApproval['status_approval'] == 1): ?>
				<div class="card-footer badge-warning">
					<p class="text-center m-0 p-0">Your job profile is awaiting for approvals.</p>
				</div>
			<?php elseif($statusApproval['status_approval'] == 2): ?>
				<div class="card-footer badge-warning">
					<p class="text-center m-0 p-0">Your job profile is awaiting for final approval.</p>
				</div>
			<?php elseif($statusApproval['status_approval'] == 3): ?>
				<div class="card-footer badge-danger">
					<p class="text-center m-0 p-0">Your job profile need to be revised. Kindly click notes button for comments and re-submit. </p>
				</div>
			<?php elseif($statusApproval['status_approval'] == 4): ?>
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