        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

            <div class="row">


                <div class="col-lg-6">

                    <!-- Collapsable Card Example -->
                    <div class="card shadow mb-4">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                            role="button" aria-expanded="true" aria-controls="collapseCardExample">
                            <h6 class="m-0 font-weight-bold text-primary"><?= date("d F Y (l)"); ?></h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseCardExample">
                            <div class="card-body">
                                Selamat datang di Website Human Capital
                                <strong><?= $user['emp_name']; ?></strong>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->