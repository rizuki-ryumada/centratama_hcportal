<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- card start -->
    <div class="card shadow mb-2" id="print">
        <!-- Card Header - Accordion -->
        <div  class="d-block card-header py-3" >
            <?php if(!empty($emp_name['emp_name'])): ?>
			    <h5 class="m-0 font-weight-bold text-black-50"><?= $emp_name['emp_name']; ?></h5>
			<?php else: ?>
				<h5 class="m-0 font-weight-bold text-black-50">No Employe</h5>
			<?php endif; ?>
        </div>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
            <!-- JP Editor -->
			<?php $this->load->view('jobs/jp_editor'); ?>
            <!-- /JP Editor -->
            
            <div class="card-footer">
                <div class="row justify-content-md-center">
                    <button type="button" class="col-5 btn btn-warning btn-sm" data-toggle="modal"
                        data-target="#revisi-modal">Revise</button>
                    <div class="col-1"></div>
                    <button type="button" class="col-5 btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#setujui-modal">Approve</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Setujui -->
<div class="modal fade" id="setujui-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                    Anda akan memproses Job Profil karyawan ini ke proses selanjutnya.
				</p>
				<form id="revisi-form" action="<?= base_url('/jobs/taskAction'); ?>" method="post">
					<input type="hidden" name="pesan_revisi" value="null">
					<input type="hidden" name="id_posisi" value="<?= $this->input->get('id'); ?>">
					<input type="hidden" name="status_approval" value="true">
					<input type="hidden" name="status_sebelum" value="<?= $status; ?>" />
				</form>
            </div>
            <div class="modal-footer">
				<input type="submit" form="revisi-form" style="btn btn-light" value="Approve">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Periksa lagi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Revisi -->
<div class="modal fade" id="revisi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<h5>Pesan Revisi</h5>
				<hr/>
				<p>Silakan masukkan pesan untuk karyawan, agar mempermudah dalam melakukan revisi.</p>
				<form id="setuju_form" action="<?= base_url('jobs/'); ?>taskAction" method="post">
					<textarea rows="4" cols="45" name="pesan_revisi"></textarea>
					<input type="hidden" name="id_posisi" value="<?= $this->input->get('id'); ?>">
					<input type="hidden" name="status_approval" value="false" />
					<input type="hidden" name="status_sebelum" value="<?= $status; ?>" />
				</form>
            </div>
            <div class="modal-footer">
				<input type="submit" form="setuju_form" style="btn btn-light" value="Revise">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Periksa lagi</button>
            </div>
        </div>
    </div>
</div>


<script>
// // for submitting form
// function submitForm(){
// 	document.getElementById("setuju_form").submit();
// };
</script>