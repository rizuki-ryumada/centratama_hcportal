        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-auto text-gray-800"><?= $title; ?></h1>

            <div class="row">
                <div class="col-lg-6">

                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <?php if($this->session->flashdata('flash')) : ?>
                    <div class="col-md-6 mt-2">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Menu Data <strong>Success</strong> <?= $this->session->flashdata('flash'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="card shadow-lg mt-3">
                        <div class="card-header">
                            <h5>Setting Access Menu</h5>
                            <!-- <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addRoleModal">Add New
                                Role</a> -->
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($role as $r) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $r['role']; ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="badge badge-warning">Access</a>
                                            <a href="" class="badge badge-info">Edit</a>
                                            <a href="<?= base_url('menu/delete/') . $r['id'];?>"
                                                class="badge badge-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
				<div class="col-lg-6">
                    <div class="card shadow-lg mt-3">
                        <div class="card-header">
                            <h5>Setting Access Document Number</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-header">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach($doc as $d): ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $d['role']; ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/roleaccessdoc/') . $d['id']; ?>" class="badge badge-warning">Access</a>
                                                <a href="" class="badge badge-info">Edit</a>
                                                <a href="<?= base_url('menu/delete/') . $d['id'];?>"
                                                    class="badge badge-danger">Delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++ ?>
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
        <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php base_url('admin/role'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>