<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    
    <div class="row">
        <div class="col">
            <?= form_error('divisi', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('div_head', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="divisi">Divisi :</label>
                                <select id="divisi" class="custom-select form-control form-control-sm">
                                    <option value="">All</option>
                                    <?php foreach($divisi as $v): ?>
                                        <option value="div-<?= $v['id'] ?>"><?= $v['division'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="departement">Departement :</label>
                                <select id="departement" class="custom-select form-control form-control-sm">
                                    <option value="">All</option>
                                    <?php foreach($dept as $v): ?>
                                    <option value="dept-<?= $v['id'] ?>"><?= $v['nama_departemen'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-1 text-center">
                            <div class="container d-flex h-100 m-0 px-auto"> <!-- this container make the element to vertically and horizontally centered -->
                                <div class="row justify-content-center align-self-center w-100 m-0">
                                    <a type="button" class="btn btn-primary" data-placement="left" title="Add New Employe" data-toggle="modal" data-target="#tambahEmployeModal"><i class="fa fa-plus text-white"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover" id="employe-table">
                            <thead>
                                <th>Nik</th>
                                <th>Employe Name's</th>
                                <th>Level Org.</th>
                                <th>Divisi</th>
                                <th>Departemen</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php foreach($employe as $employe): ?>
                                <tr>
                                    <td><?= $employe['nik']; ?></td>
                                    <td><?= $employe['emp_name']; ?></td>
                                    <td><?= $employe['hirarki_org']; ?></td>
                                    <td data-filter="div-<?= $employe['div_id'] ?>"><?= $employe['division'] ?></td>
                                    <td data-filter="dept-<?= $employe['dept_id'] ?>"><?= $employe['nama_departemen'] ?></td>
                                    <td>
                                        <!-- <button class="btn btn-success btn-circle btn-sm editEmp" data-nik="<?= $employe['nik']; ?>" type="button" data-toggle="modal" data-target="#editEmployeModal"><i class="fas fa-pencil-alt"></i></button> -->
                                        <button class="btn btn-success btn-circle btn-sm editEmp" data-nik="<?= $employe['nik']; ?>" type="button"><i class="fas fa-pencil-alt"></i></button>
                                        <!-- //TODO tambah popup sebelum user dapa menghapus employe -->
                                        <a href="<?= base_url('master/deleteEmploye') ?>?nik=<?= $employe['nik'] ?>" class="btn btn-danger btn-circle btn-sm" ><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit karyawan -->
<div class="modal fade" id="tambahEmployeModal" tabindex="-1" role="dialog" aria-labelledby="tambahEmployeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-user text-primary"></i> Tambah Employe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tambahEmployeForm" action="<?= base_url('master/tambahEmploye') ?>" method="POST">
                    <div class="row">
                        <div class="col form-group">
                            <label for="nik_tambah">NIK</label>
                            <input name="nik" type="text" class="form-control" id="nik_tambah" placeholder="Enter a NIK" maxlength="8" required>
                        </div>
                        <div class="col form-group">
                            <label for="name_tambah">Name</label>
                            <input name="name" type="text" class="form-control" id="name_tambah" placeholder="Enter a Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="div_tambah">Divisi</label>
                            <select name="divisi" id="div_tambah" class="div custom-select form-control form-control-sm">
                                <option value="0">Pilih Divisi...</option>
                                <?php foreach($divisi as $v): ?>
                                    <option value="div-<?= $v['id'] ?>"><?= $v['division'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="departemen_tambah">Departemen</label>
                            <input type="text" id="departemen_tambah" class="form-control" value="Harap pilih Divisi" readonly>
                            <select name="departemen" id="dept_tambah" class="dept custom-select form-control form-control-sm" style="display: none;">
                                <option value=""></option>
                            </select> 
                        </div>
                        <div class="col form-group">
                            <label for="pos_tambah">Position</label>
                            <select name="position" id="pos_tambah" class="pos custom-select form-control form-control-sm" style="display: none;">
                                <option value=""></option>
                            </select>
                            <input type="text" id="position_tambah" class="form-control" value="Harap pilih Departemen" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="entity_tambah">Entity</label>
                            <select name="entity" id="entity_tambah" class="custom-select form-control form-control-sm">
                                <option value="">Pilih Entity...</option>
                                <?php foreach($entity as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['nama_entity']. " | " .$v['keterangan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="role_tambah">Role</label>
                            <select name="role" id="role_tambah" class="custom-select form-control form-control-sm">
                                <option value="">Pilih Role...</option>
                                <?php foreach($role as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['role'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-2 form-group">
                            <label for="role_surat_tambah">Role Surat</label>
                            <input name="role_surat" id="role_surat_tambah" type="checkbox" class="form-control" >
                        </div>
                        <div class="col-2 form-group">
                            <label for="is_active_tambah">is_active</label>
                            <input name="is_active" type="checkbox" id="is_active_tambah" class="form-control" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="email_tambah">Email</label>
                            <input name="email" type="email" id="email_tambah" class="form-control" placeholder="Enter email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="password_tambah">Password</label>
                            <input name="password" type="password" class="form-control" id="password_tambah" placeholder="Enter password">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Add Employe</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit karyawan -->
<div class="modal fade" id="editEmployeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-user text-primary"></i> Edit Employe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editEmployeForm" action="<?= base_url('master/editEmploye') ?>" method="POST">
                    <div class="row">
                        <div class="col form-group">
                            <label for="nik_edit">NIK</label>
                            <input name="nik" type="text" class="form-control" id="nik_edit" placeholder="Enter a NIK" maxlength="8" required>
                            <input type="hidden" name="onik" >
                        </div>
                        <div class="col form-group">
                            <label for="name_edit">Name</label>
                            <input name="name" type="text" class="form-control" id="name_edit" placeholder="Enter a Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="div_edit">Divisi</label>
                            <select name="divisi" id="div_edit" class="div custom-select form-control form-control-sm">
                                <?php foreach($divisi as $v): ?>
                                    <option value="div-<?= $v['id'] ?>"><?= $v['division'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="departemen_edit">Departemen</label>
                            <input type="text" class="form-control" id="departemen_edit" readonly>
                            <select name="departemen" id="dept_edit" class="dept custom-select form-control form-control-sm" style="display: none;">
                                <option value=""></option>
                            </select> 
                        </div>
                        <div class="col form-group">
                            <label for="position_edit">Position</label>
                            <input type="text" class="form-control" id="position_edit" readonly>
                            <select name="position" id="pos_edit" class="pos custom-select form-control form-control-sm" style="display: none;">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="entity_edit">Entity</label>
                            <select name="entity" id="entity_edit" class="custom-select form-control form-control-sm">
                                <?php foreach($entity as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['nama_entity']. " | " .$v['keterangan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col form-group">
                            <label for="role_edit">Role</label>
                            <select name="role" id="role_edit" class="custom-select form-control form-control-sm">
                                <?php foreach($role as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['role'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-2 form-group">
                            <label for="role_surat_edit">Role Surat</label>
                            <input name="role_surat" type="checkbox" class="form-control" id="role_surat_edit" >
                        </div>
                        <div class="col-2 form-group">
                            <label for="is_active_edit">is_active</label>
                            <input name="is_active" type="checkbox" class="form-control" id="is_active_edit">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="email_edit">Email</label>
                            <input name="email" type="email" class="form-control" id="email_edit" placeholder="Enter email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <label for="password_edit">Password</label>
                            <input name="password" type="password" class="form-control" id="password_edit" placeholder="Enter password to change">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Save changes</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>