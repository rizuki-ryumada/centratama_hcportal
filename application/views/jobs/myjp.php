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
			<!-- JP Editor -->
			<?php $this->load->view('jobs/jp_editor'); ?>
			<!-- /JP Editor -->

			<div class="card-footer">
				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#submit-modal">Submit</button>
				<br>
				<small class="text-muted">* Pastikan semua data anda telah terisi dengan benar.<strong><br>* Setelah anda menekan tombol submit, anda tidak akan bisa mengubah untuk sementara.</strong></small>
			</div>
		</div>
	</div> 
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Submit Modal -->
<div class="modal fade" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <p>
	  Sebelum melakukan submit Job Profile,
	  <ul>
		  <li>Pastikan semua data anda telah terisi dengan benar.</li>
		  <li>Setelah anda menekan tombol submit, anda tidak akan bisa mengubah untuk sementara.</li>
	  </ul>
	  </p>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-light btnApprove" data-mynik="<?= $user['nik']; ?>" data-position="<?= $posisi['id']; ?>" data-atasan1="<?= $posisi['id_approver1']; ?>" data-atasan2="<?= $posisi['id_approver2']; ?>">Submit</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Periksa lagi</button>
      </div>
    </div>
  </div>
</div>