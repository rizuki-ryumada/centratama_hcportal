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
                        <table class="table table-borderless table-hover" id="divisi-table">
                            <thead>
                                <th>Divisi</th>
                                <th>Nik Div Head</th>
                                <th>Nama Div Head</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php foreach ($divisi as $div): ?>
                                <tr>
                                    <td><?= $div['division']; ?></td>
                                    <td><?= $div['nik_div_head']; ?></td>
                                    <td><?= $div['emp_name']; ?></td>
                                    <td>
                                        <button class="btn btn-success btn-circle btn-sm editDiv"
                                            data-id="<?= $div['id']; ?>">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <a href="#" class="btn btn-danger btn-circle btn-sm"
                                            data-id="<?= $div['id']; ?>">
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
            <div class="card shadow-lg" id="tambah-divform">
                <div class="card-header">
                    <h6>Form Tambah Divisi</h6>
                </div>
                <div class="card-body">
                    <?= form_open(); ?>
                    <div class="form-group">
                        <label for="divisi-name">Nama Divisi</label>
                        <input type="text" class="form-control form-control-sm" name="divisi" id="divisi-name">
                    </div>
                    <div class="form-group">
                        <label for="div_head">Division Head</label>
                        <select class="form-control form-control-sm" name="div_head" id="divisi-head">
                            <option value="">-Pilih Division Head-</option>
                            <?php foreach($div_head as $div): ?>
                            <option value="<?= $div['nik']; ?>"><?= $div['emp_name']; ?></option>
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
            <div class="card text-white bg-warning" id="edit-divform">
                <div class="card-header">
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Form Edit Divisi</h5>
                    <?= form_open('master/edit_divisi'); ?>
                    <input type="hidden" name="id" class="id-div">
                    <div class="form-group">
                        <label for="divisi-name">Nama Divisi</label>
                        <input type="text" class="form-control form-control-sm" name="divisi" id="edit-divisi-name">
                    </div>
                    <div class="form-group">
                        <label for="div_head">Pilih Division Head</label>
                        <select class="form-control form-control-sm" name="div_head" id="edit-divisi-head">
                            <option value="">-Pilih Division Head-</option>
                            <?php foreach($div_head as $div): ?>
                            <option value="<?= $div['nik']; ?>"><?= $div['emp_name']; ?></option>
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