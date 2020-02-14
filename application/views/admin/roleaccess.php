<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-auto text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow-lg mt-3">
                <div class="card-header">
                    <h5>Role : <?= $role['role']; ?></h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role</th>
                                <th scope="col">Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($menu as $m) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $m['menu']; ?></td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input menu-access" type="checkbox" <?= check_access($role['id'], $m['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>">
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->