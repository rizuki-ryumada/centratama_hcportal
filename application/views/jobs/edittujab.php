<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
        <?= $this->session->flashdata('message'); ?>
            <div class="card shadow-lg">
                <div class="card-body">
                    <form action="<?= base_url('user/edittujuanjbtn'); ?>/<?= $tujab['id_posisi']; ?>" method="post">
                    <input type="hidden" name="id" value="<?= $tujab['id_posisi']; ?>">
                    <div class="form-group row">
                        <label for="tujuan_jabatan" class="col">Tujuan Jabatan</label>
                        <div class="col-sm-10">
                            <textarea name="tujuan_jabatan" id="tujuan_jabatan" value=""><?= $tujab['tujuan_jabatan']; ?></textarea>
							<?= form_error('tujuan_jabatan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
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