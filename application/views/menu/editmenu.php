<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-auto text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">

            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <div class="card shadow-lg mt-3">
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $menu['id']; ?>">
                        <div class="form-group">
                            <label for="menu">Menu Name</label>
                            <input type="text" class="form-control" id="menu" name="menu" value="<?= $menu['menu']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Save Changes</button>
                    </form>
                </div>
            </div>

        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->x