<!-- Begin Page Content -->
<style>
    html, body{
        min-width: 1100px;
        min-height: 600px;
    }
</style>
<div class="container-fluid">

    <!-- load floating contact -->
    <?php $this->load->view('templates/komponen/floating_contact') ?>
	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<div class="row">
		<div class="col-lg">
			<?= $this->session->flashdata('message'); ?>
		</div>
	</div>
	<div class="flash-jobs" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>

	<div class="card shadow mb-2" id="print"> <!-- Profil Jabatan anda -->
		<!-- Card Header - Accordion -->
		<div class="d-block card-header py-3">
			<h5 class="m-0 font-weight-bold text-black-50"><?= $posisi['position_name']?></h5>
		</div>
		<!-- Card Content - Collapse -->
		<div class="collapse show">
			<div class="card-body">
                <div class="row">
                    <div class="col-1 status-logo"> <!-- status logo -->
                        <div class="container d-flex h-100 m-0 p-0">
                            <div class="row justify-content-center align-self-center p-0 m-0">
                                <?php if($statusApproval['status_approval'] == 0): ?>
                                    <i class="fa fa-exclamation-circle fa-3x" style="color: red"></i>
                                <?php elseif($statusApproval['status_approval'] == 1): ?>
                                    <i class="fa fa-ellipsis-h fa-3x" style="color: gold"></i>
                                <?php elseif($statusApproval['status_approval'] == 2): ?>
                                    <i class="fa fa-ellipsis-h fa-3x" style="color: gold"></i>
                                <?php elseif($statusApproval['status_approval'] == 3): ?>
                                    <i class="fa fa-exclamation-triangle fa-3x" style="color: red"></i>
                                <?php elseif($statusApproval['status_approval'] == 4): ?>
                                    <i class="fa fa-check-circle fa-3x" style="color: green"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 status-text"> <!-- status text -->
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <?php if(!empty($approver[0]['position_name'])): //cek jika tidak punya atasan1?>
                                        <div class="col-3">Approver 1</div><div class="col-1">:</div><div class="col-8"><?= $approver[0]['position_name']; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <?php if(!empty($approver[1]['position_name'])): //cek jika tidak punya atasan2?> 
                                        <div class="col-3">Approver 2</div><div class="col-1">:</div><div class="col-8"><?= $approver[1]['position_name']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-12"></div>
                                </div> -->
                            </div>
                            <div class="col-5">
                                    <!-- Status Approval Infomation
                                    0 = Belum diisi
                                    1 = Direview Atasan 1
                                    2 = Direview Atasan 2
                                    3 = Revisi
                                    4 = Selesai -->
                                <div class="row">
                                <!-- card status -->
                                    <div class="col-4">Status</div><div class="col-1">:</div><div class="col-7">
                                        <?php if($statusApproval['status_approval'] == 0): ?>
                                            <span class="badge badge-danger">Not Yet Submitted</span>
                                        <?php elseif($statusApproval['status_approval'] == 1): ?>
                                            <span class="badge badge-warning">Submitted</span>
                                        <?php elseif($statusApproval['status_approval'] == 2): ?>
                                            <span class="badge badge-warning">First Approval</span>
                                        <?php elseif($statusApproval['status_approval'] == 3): ?>
                                            <span class="badge badge-danger">Need Revised</span>
                                        <?php elseif($statusApproval['status_approval'] == 4): ?>
                                            <span class="badge badge-success">Final Approval</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php if(!$statusApproval['status_approval'] == 0): ?>
                                        <div class="col-4">Updated</div><div class="col-1">:</div><div class="col-7"><?= date('d F Y, H:i', $statusApproval['diperbarui']); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <?php if($statusApproval['pesan_revisi'] !== "null" && $statusApproval['status_approval'] == 3): ?>
                                        <div class="col-4">Notes</div><div class="col-1">:</div>
                                        <div class="col-7">
                                            <a tabindex="0" class="btn badge" role="button" data-toggle="popover" data-trigger="focus" data-placement="bottom" title="Pesan" data-content="<?= $statusApproval['pesan_revisi']; ?>"><i class="fas fa-comment-dots text-info"></i></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-1 status-action"> <!-- status action -->
                        <div class="container d-flex h-100 m-0 p-2"> <!-- this container make the element to vertically and horizontally centered -->
                            <div class="row justify-content-center align-self-center p-0 m-0">
                                <?php if($statusApproval['status_approval'] == 0 || $statusApproval['status_approval'] == 3): ?>
                                    <a href="<?= base_url('job_profile/myjp')?>"><i class="fa fa-pencil-alt fa-2x"></i></a>
                                <?php else: ?>
                                    <a href="<?= base_url('job_profile/myjp')?>"><i class="fa fa-search fa-2x"></i></a>
                                 <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
            
            <!-- footer message -->
            <?php if($statusApproval['status_approval'] == 0): ?>
                <div class="card-footer badge-danger">
                    Kindly complete your job profile and submit for approvals.
                </div>
            <?php elseif($statusApproval['status_approval'] == 1): ?>
                <div class="card-footer badge-warning">
                    Your job profile is awaiting for approvals.
                </div>
            <?php elseif($statusApproval['status_approval'] == 2): ?>
                <div class="card-footer badge-warning">
                    Your job profile is awaiting for final approval.
                </div>
            <?php elseif($statusApproval['status_approval'] == 3): ?>
                <div class="card-footer badge-danger">
                    Your job profile need to be revised. Kindly click notes button for comments and re-submit.
                </div>
            <?php elseif($statusApproval['status_approval'] == 4): ?>
                <div class="card-footer badge-success">
                    Your job profile is approved.
                </div>
            <?php endif; ?>
		</div>
	</div> <!-- /Profil Jabatan anda -->
    
    <div class="card shadow mb-2" id=""> <!-- My Task -->
		<!-- Card Content - Collapse -->
		<div>
			<div class="card-body">
				<div class="row mb-2">
					<table id="myTask" class="table table-striped table-hover"  style="display: table;width:100%">
                        <thead class="text-center">
                            <th class="align-middle" >Division</th>
                            <th class="align-middle" >Departement</th>
                            <th class="align-middle" >Position</th>
                            <th class="align-middle" >Employee Name</th>
                            <th class="align-middle" >Date</th>
                            <!-- <th class="align-middle"  style="min-width: 60px;">View Details</th> -->
                            <th class="align-middle" >View Details</th>
                        </thead>
                        <tbody>
                            <?php foreach($my_task as $v): ?>
                                <tr id="myTask-list">
                                    <td><?= $v['divisi'] ?></td>
                                    <td><?= $v['departement'] ?></td>
                                    <td><?= $v['posisi'] ?></td>
                                    <td><?= $v['emp_name'] ?></td>
                                    <td><?= date('d F Y, H:i', $v['diperbarui']); ?></td>
                                    <td>
                                        <div class="container d-flex h-100 m-0 px-auto"> <!-- this container make the element to vertically and horizontally centered -->
                                            <div class="row justify-content-center align-self-center w-100 m-0">
                                                <a id="myTask-button" href="<?= base_url('job_profile/taskJp'); ?>?task=<?= $v['nik']; ?>&id=<?= $v['id_posisi']; ?>&status=<?= $v['status_approval'] ?>"><i class="fa fa-search mx-auto"></i></a>    
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
				</div>

			</div>
			<!-- <div class="card-footer">
				This Is Footer
			</div> -->
		</div>
	</div> <!-- /My Task -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->