<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="card mb-3 shadow-lg border-left-primary" style="max-width: 250px;">
        <div class="row no-gutters">
            <div class="col">
                <div class="card-body">
                    <h5 class="card-title"><?= $user['emp_name']; ?></h5>
                    <p class="card-text"><?= $user['nik']; ?></p>
                    <!-- <p class="card-text"><small class="text-muted">Member since
                            <?= date('d F Y', $user['date_created']); ?></small></p> -->
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->