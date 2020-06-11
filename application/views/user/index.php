<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <!-- <div class="card mb-3 shadow-lg border-left-primary" style="max-width: 250px;">
        <div class="row no-gutters">
            <div class="col">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['emp_name']; ?></h5>
                    <p class="card-text"><?= $user['nik']; ?></p> -->
                    <!-- <p class="card-text"><small class="text-muted">Member since
                            <?= date('d F Y', $user['date_created']); ?></small></p> -->
                <!-- </div>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-lg">
                <div class="card-body">
            <?= form_open_multipart('user/edit'); ?>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Nik</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email" value="<?= $user['nik']; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" value="<?= $user['emp_name']; ?>">
                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <!-- <div class="form-group row">
                <div class="col-sm-2">Picture</div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/profile/').$user['image']; ?>" class="img-thumbnail">
                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
                <div class="form-group row justify-content-end mb-0">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
            </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
		<div class="col-lg-12">
			<div class="card shadow-lg">
				<div class="card-body">
					<form id="changePassword_form" action="<?= base_url('user') ?>" method="post">
						<div class="form-group">
							<label for="current_password">Current <span id="title">Password</span></label>
							<input type="password" class="form-control" id="current_password" name="current_password">
							<?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
						</div>
						<div class="form-group">
							<label for="new_password1">New Password</label>
							<input type="password" class="form-control" id="new_password1" name="new_password1">
							<?= form_error('new_password1', '<small class="text-danger pl-3">', '</small>'); ?>
						</div>
						<div class="form-group">
							<label for="new_password2">Repeat Password</label>
							<input type="password" class="form-control" id="new_password2" name="new_password2">
						</div>
						<div class="form-group mb-0">
							<button id="submitPassword" class="btn btn-primary">Change Password</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->