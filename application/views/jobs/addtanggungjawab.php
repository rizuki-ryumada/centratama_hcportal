<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <div class="card shadow-lg">
                <div class="card-body">
                    <?= form_open_multipart('user/addtanggungjawab'); ?>
                    <input type="text" name="id" value="<?= $my['position_id']; ?>" hidden readonly>
                    <div class="form-group row">
                        <label for="tanggung_jawab" class="col-sm-2 col-form-label">Tanggung Jawab</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggung_jawab" name="tanggung_jawab">
							<?= form_error('tanggung_jawab', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aktivitas" class="col">List Aktivitas</label>
                        <div class="col-sm-10">
                            <textarea name="aktivitas" id="aktivitas"></textarea>
							<?= form_error('aktivitas', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pengukuran" class="col">List Pengukuran</label>
                        <div class="col-sm-10">
                            <textarea name="pengukuran" id="pengukuran"></textarea>
							<?= form_error('pengukuran', '<small class="text-danger pl-3">', '</small>'); ?>
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