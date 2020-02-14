<div class="container-fluid">
    <h1 class="h3 mb-auto text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <div class="card shadow-lg mt-3">
                <div class="card-header">
                    <h5>Role : <?= $role['role']; ?></h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Role</th>
                                <th scope="col">Access</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach($surat as $s): ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $s['jenis_surat']; ?></td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input surat-access" <?= check_surat_access($role['id'], $s['id']); ?> data-role="<?= $role['id']; ?>" data-surat="<?= $s['id']; ?>">
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
</div>