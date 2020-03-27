<!-- Begin Page Content -->
<div class="container-fluid">

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
		<a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button">
			<h6 class="m-0 font-weight-bold text-black-50">Recruitment Officer</h6>
		</a>
		<!-- Card Content - Collapse -->
		<div class="collapse show" id="collapseCardExample">
			<div class="card-body">
                <div class="row">
                    <div class="col-1 status-logo"> <!-- status logo -->
                        <div class="container d-flex h-100 m-0 p-0">
                            <div class="row justify-content-center align-self-center p-0 m-0">
                                <i class="fa fa-exclamation-circle fa-3x" style="color: red"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 status-text"> <!-- status text -->
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-3">Atasan 1</div><div class="col-1">:</div><div class="col-8">Organization Development Dept. Head</div>
                                </div>
                                <div class="row">
                                    <div class="col-3">Atasan 2</div><div class="col-1">:</div><div class="col-8">Human Capital Division Head</div>
                                </div>
                                
                                <!-- <div class="row">
                                    <div class="col-12"></div>
                                </div> -->
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4">Status</div><div class="col-1">:</div><div class="col-7">
                                        <span class="badge badge-success">Selesai</span>
                                        <span class="badge badge-danger">Belum diisi</span>
                                        <span class="badge badge-warning">Direview Atasan 1</span>
                                        <span class="badge badge-warning">Direview Atasan 2</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">Diperbarui</div><div class="col-1">:</div><div class="col-7">4 Agustus 2020, 20:30</div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-3">Pesan</div><div class="col-1">:</div><div class="col-8"><i class="fas fa-comment-dots text-info"></i></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-1 status-action"> <!-- status action -->
                        <div class="container d-flex h-100 m-0 p-2"> <!-- this container make the element to vertically and horizontally centered -->
                            <div class="row justify-content-center align-self-center p-0 m-0">
                                <i class="fa fa-pencil-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
			</div>

			<div class="card-footer badge-danger">
				Silakan Isi Job Profile Anda
			</div>
		</div>
	</div> <!-- /Profil Jabatan anda -->
    
    <div class="card shadow mb-2" id=""> <!-- My Task -->
		<!-- Card Header - Accordion -->
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-black-50">My Task</h6>
		</div>
		<!-- Card Content - Collapse -->
		<div class="collapse show">
        
			<div class="card-body">
				<div class="row mb-2">
					<table id="myTask" class="table table-striped table-hover"  style="display: table;width:100%">
                        <thead>
                            <th>Employee Name</th>
                            <th>Job Position</th>
                            <th>Date</th>
                            <th class="text-center" >Action</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hartanto Kusmanto</td>
                                <td>Finance Division Head</td>
                                <td>30 Agustus 2020</td>
                                <td>
                                    <div class="container d-flex h-100 m-0 px-auto"> <!-- this container make the element to vertically and horizontally centered -->
                                        <div class="row justify-content-center align-self-center w-100 m-0">
                                            <i class="fa fa-search mx-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Yuana Susatyo</td>
                                <td>MNO Sales Division Head</td>
                                <td>31 Agustus 2020</td>
                                <td>
                                    <div class="container d-flex h-100 m-0 px-auto"> <!-- this container make the element to vertically and horizontally centered -->
                                        <div class="row justify-content-center align-self-center w-100 m-0">
                                            <i class="fa fa-search mx-auto"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
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