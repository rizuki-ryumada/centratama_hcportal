<div class="container-fluid">
    <h1 class="h4 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <div class="row">
        <div class="col">
            <?= form_error('departemen', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('dephead', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('div_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover" id="departemen-table">
                            <thead>
                                <th>Nama Departement</th>
                                <th>Dep Head</th>
                                <th>Divisi</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php foreach($departemen as $dep): ?>
                                <tr>
                                    <td><?= $dep['nama_departemen']; ?></td>
                                    <td><?= $dep['dep_head']; ?></td>
                                    <td><?= $dep['division']; ?></td>
                                    <td>
                                        <button class="btn btn-success btn-circle btn-sm editDep" data-id="<?= $dep['id']; ?>">
                                                <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <a href="#" class="btn btn-danger btn-circle btn-sm" data-id="<?= $dep['id']; ?>">
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
            <div class="card shadow-lg" id="tambah-depform">
                <div class="card-header">
                    <h6>Form Tambah Departemen</h6>
                </div>
                <div class="card-body">
                    <?= form_open(); ?>
                        <div class="form-group">
                            <label for="departemen-name">Nama Departement</label>
                            <input type="text" class="form-control form-control-sm" name="departemen" id="departemen-name">
                        </div>
                        <div class="form-group">
                            <label for="departemen-head">Nik Departemen Head</label>
                            <input type="text" class="form-control form-control-sm" name="dephead" id="departemen-head">
                        </div>
                        <div class="form-group">
                            <label for="div-id">Divisi</label>
                            <select class="form-control form-control-sm" name="div_id" id="div-id">
                                    <option>-Pilih Divisi-</option>
                <?php foreach($divisi as $div): ?>
                    <option value="<?= $div['id']; ?>"><?= $div['division']; ?></option>
                <?php endforeach; ?>            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-icon-split btn-primary">
                        <span class="icon text-white">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Simpan</span>
                    </button>
                    </form>
                </div>
            </div>
            <div class="card text-white bg-warning" id="edit-depform">
            <div class="card-header">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="card-body">
                <h5 class="card-title">Form Edit Departement</h5>
                    <?= form_open('master/edit_departemen'); ?>
                        <input type="hidden" name="id" class="id-dept">
                        <div class="form-group">
                            <label for="departemen-name">Nama Departement</label>
                            <input type="text" class="form-control form-control-sm" name="departemen" id="edit-departemen-name">
                        </div>
                        <div class="form-group">
                            <label for="departemen-head">Nik Departemen Head</label>
                            <input type="text" class="form-control form-control-sm" name="dephead" id="edit-departemen-head">
                        </div>
                        <div class="form-group">
                            <label for="div-id">Divisi</label>
                            <select class="form-control form-control-sm" name="div_id" id="edit-div-id">
                            <option value="">-Pilih Divisi-</option>
                                <?php foreach($divisi as $div): ?>
                                    <option value="<?= $div['id']; ?>"><?= $div['division']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-icon-split btn-primary">
                        <span class="icon text-white">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Simpan</span>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>