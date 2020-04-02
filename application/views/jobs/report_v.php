<div class="container-fluid">
    <h1 class="h3 mb-3 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="divisi">Divisi :</label>
                        <select id="divisi" class="form-control form-control-sm">
                            <option value="">All</option>
                            <?php foreach($divisi as $v): ?>
                                <option value="<?= $v['division'] ?>"><?= $v['division'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="departement">Departement :</label>
                        <select id="departement" class="form-control form-control-sm">
                            <option value="">All</option>
                            <?php foreach($dept as $v): ?>
                                <option value="<?= $v['nama_departemen'] ?>"><?= $v['nama_departemen'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="status">Status :</label>
                        <select id="status" class="form-control form-control-sm">
                            <option value="">All</option>
                            <option value="1">Belum disubmit</option>
                            <option value="2">Direview Atasan 1</option>
                            <option value="3">Direview Atasan 2</option>
                            <option value="4">Revisi</option>
                            <option value="5">Selesai</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="myTask" width="100%">
                    <thead>
                        <tr>
                            <th>Division</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Employee Name</th>
                            <th>Status</th>
                            <th style="min-width: 45px;" ></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($approval_data as$v): ?>
                        <tr id="myTask-list">
                            <td><?= $v['divisi'] ?></td>
                            <td><?= $v['departement'] ?></td>
                            <td><?= $v['posisi'] ?></td>
                            <td><?= $v['name'] ?></td>
                            <?php if($v['status_approval'] == 0): ?>
                                <td data-filter="1">
                                    <span class="badge badge-danger">Belum disubmit</span>
                                </td>
                            <?php elseif($v['status_approval'] == 1): ?>
                                <td data-filter="2">
                                    <span class="badge badge-warning">Direview Atasan 1</span>
                                </td>
                            <?php elseif($v['status_approval'] == 2): ?>
                                <td data-filter="3">
                                    <span class="badge badge-warning">Direview Atasan 2</span>
                                </td>
                            <?php elseif($v['status_approval'] == 3): ?>
                                <td data-filter="4">
                                    <span class="badge badge-danger">Revisi</span>
                                </td>
                            <?php elseif($v['status_approval'] == 4): ?>
                                <td data-filter="5">
                                    <span class="badge badge-success">Selesai</span>
                                </td>
                            <?php endif; ?>
                            <td>
                                <div class="container d-flex h-100 m-0 px-auto"> <!-- this container make the element to vertically and horizontally centered -->
                                    <div class="row justify-content-center align-self-center w-100 m-0">
                                        <a id="myTask-button" style="display: none;" href="<?= base_url('jobs/reportjp'); ?>?task=<?= $v['nik']; ?>&status=<?= $v['status_approval'] ?>"><i class="fa fa-search mx-auto"></i></a>    
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- <div class="table-responsive">
                <table class="table table-boredered" id="history" width="100%">
                    <thead>
                        <tr>
                            <th>Division</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Employee Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div> -->
        </div>
    </div>
</div>