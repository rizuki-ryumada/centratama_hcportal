<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-auto text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">

        <?php if(validation_errors()): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= validation_errors(); ?>
                    </div>
                    <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow-lg mt-3">
                <div class="card-body">
                    <form action="<?php base_url('menu/updatesubmenu'); ?>" method="post">
                        <input type="hidden" name="id" value="<?= $subMenuId['id']; ?>">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $subMenuId['title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="menu_id">Menu</label>
                            <select name="menu_id" id="menu_id" class="form-control">
                                    <option value="">Select Menu</option>
                                    <?php foreach($menu as $m): ?>
                                    <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="url">Url</label>
                            <input type="text" class="form-control" id="url" name="url" value="<?= $subMenuId['url']; ?>">
                        </div>
                        <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_active"
                                        id="is_active" checked>
                                    <label class="form-check-label" for="is_active">
                                        Active?
                                    </label>
                                </div>
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
<!-- End of Main Content -->