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
                                        <td><?= $employe['level_org']; ?></td>
                                        <td><?= $employe['division']; ?></td>
                                        <td><?= $employe['nama_departemen']; ?></td>
                                        <td>
                                        <button class="btn btn-success btn-circle btn-sm editEmp"
                                            data-id="<?= $employe['id']; ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <a href="#" class="btn btn-danger btn-circle btn-sm"
                                            data-id="<?= $employe['id']; ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow-lg" id="tambah-empform">
                <div class="card-header">
                    <h6>Form Tambah Employe</h6>
                </div>
                <div class="card-body">
                    <?= form_open('master/employe', 'class="needs-validation"'); ?>
                        <div class="form-group">
                            <label for="nik">Nik</label>
                            <input type="text" name="nik" id="nik" value="<?= $nik; ?>" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Employe</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm">
                        </div>
                        <div class="form-group">
                            <label for="level">Level Organisasi</label>
                            <select class="custom-select custom-select-sm" id="level">
                                <option value="N">N</option>
                                <option value="N-1">N-1</option>
                                <option value="Functional">Functional</option>
                                <option value="N-2">N-2</option>
                                <option value="N-3 & Below">N-3 & Below</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="div">Divisi</label>
                            <select class="custom-select custom-select-sm" id="div">
                                <option value="">-- Pilih Divisi --</option>
                                <?php foreach($divisi as $divisi): ?>
                                    <option value="<?= $divisi['id']; ?>"><?= $divisi['division']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="departemen">Departemen</label>
                            <select class="custom-select custom-select-sm" id="departemen" disabled>
                                
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>