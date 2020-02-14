        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-auto text-gray-800"><?= $title; ?></h1>

            <div class="row">
                <div class="col-lg">

                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
                    <?php if ($this->session->flashdata('flash')) : ?>
                        <!-- <div class="col-md-6 mt-2">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Menu Data <strong>Success</strong> <?= $this->session->flashdata('flash'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div> -->
                    <?php endif; ?>

                    <div class="card shadow-lg mt-3">
                        <div class="card-header">
                            <a href="" class="btn btn-primary tombolTambahData" data-toggle="modal" data-target="#addMenuModal">Add New
                                Menu</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" id="title">Menu</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($menu as $m) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $m['menu']; ?></td>
                                            <td><?= $m['target']; ?></td>
                                            <td><?= $m['icon']; ?></td>
                                            <td>
                                                <a href="<?= base_url('menu/editmenu/')  .  $m['id']; ?>" class="badge badge-info tampilModalUbah" data-toggle="modal" data-target="#addMenuModal" data-id="<?= $m['id']; ?>">Edit</a>
                                                <a href="<?= base_url('menu/deletemenu/')  .  $m['id']; ?>" class="badge badge-danger hapus">Delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- ADD Modal -->
        <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMenuModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="target" name="target" placeholder="Target name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="icon" name="icon" placeholder="Icon name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>