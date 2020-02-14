<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
        <?= $this->session->flashdata('message'); ?>
            <div class="card shadow-lg">
                <div class="card-body">
                    <form action="<?= base_url('user/aksitanggungjawab'); ?>/<?= $tj['id_tgjwb']; ?>" method="post">
                    <input type="hidden" name="id" value="<?= $tj['id_tgjwb']; ?>">
                    <div class="form-group row">
                        <label for="tanggung_jawab" class="col-sm-2 col-form-label">Tanggung Jawab</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggung_jawab" name="tanggung_jawab" value="<?=  $tj['keterangan']; ?>">
							<?= form_error('tanggung_jawab', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aktivitas" class="col">List Aktivitas</label>
                        <div class="col-sm-10">
                            <textarea name="aktivitas" id="aktivitas" value=""><?= $tj['list_aktivitas']; ?></textarea>
							<?= form_error('aktivitas', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pengukuran" class="col">List Pengukuran</label>
                        <div class="col-sm-10">
                            <textarea name="pengukuran" id="pengukuran" value=""><?= $tj['list_pengukuran']; ?></textarea>
							<?= form_error('pengukuran', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?= base_url('user/deltj/') .  $tj['id_tgjwb']; ?>" class="btn btn-danger">Hapus Data</a>
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