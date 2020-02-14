        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total
                                        Karyawan Saat Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $this->db->count_all('employe', false); ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
				$data = $this->db->get_where('job_approval', ['atasan1' => $my['position_id']])->result_array();
				if ($data) {
					echo '<div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Approval job profile</div>
                                            <div class="h5 font-weight-bold text-gray-800">' . count($data) . '<a href="#" class="ml-2 card-link text-warning">Review List</a></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-pencil-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
				} else {
				}
				?>
            </div>

            <!-- Content Row -->

            <div class="row">
                <div class="col-6 mb-2">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                    src="<?= base_url('assets'); ?>/img/undraw_new_decade.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <?= $this->calendar->generate(date('Y'), date('m')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
