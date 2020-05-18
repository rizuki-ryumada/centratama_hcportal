<div class="container-fluid">
    <h1 class="h3 mb-3 text-gray-800">Settings</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if(!empty($this->session->userdata('msgapproval'))): ?>
                <div class="row">
                    <div class="alert alert-success alert-dismissible fade show col" role="alert">
                        <strong>Status Approval has been refreshed!.</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
            <?php $this->session->unset_userdata('msgapproval'); ?>
            <div class="row">
                <div class="col-1 text-center">
                    <div class="container d-flex h-100 m-0 px-auto"> <!-- this container make the element to vertically and horizontally centered -->
                        <div class="row justify-content-center align-self-center w-100 m-0">
                            <a href="<?= base_url('report/') ?>" type="button" class="btn btn-primary" data-placement="left" title="Back to Report Page"><i class="fa fa-chevron-left text-white"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-1 text-center">
                    <div class="container d-flex h-100 m-0 px-auto"> <!-- this container make the element to vertically and horizontally centered -->
                        <div class="row justify-content-center align-self-center w-100 m-0">
                            <a href="<?= base_url('jobs/') ?>startJobApprovalSystem" type="button" class="btn btn-danger" data-placement="left" title="Refresh Approval - If there is a Employe not listed down here."><i class="fa fa-sync text-white"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="divisi">Divisi :</label>
                        <select id="divisi" class="form-control form-control-sm">
                            <option value="">All</option>
                            <?php foreach($divisi as $v): ?>
                                <option value="<?= $v['division'] ?>"><?= $v['division'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="departement">Departement :</label>
                        <select id="departement" class="form-control form-control-sm">
                            <option value="">All</option>
                            <?php foreach($dept as $v): ?>
                                <option value="<?= $v['nama_departemen'] ?>"><?= $v['nama_departemen'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="status">Status :</label>
                        <select id="status" class="form-control form-control-sm">
                            <option value="">All</option>
                            <option value="0">Not Yet Submitted</option>
                            <option value="1">Submitted</option>
                            <option value="2">First Approval</option>
                            <option value="3">Need Revised</option>
                            <option value="4">Final Approval</option>
                        </select>
                    </div>
                </div>
            </div>
            

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="myTask" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th class="align-middle" >Division</th>
                            <th class="align-middle" >Department</th>
                            <th class="align-middle" >Position</th>
                            <th class="align-middle" >Employee Name</th>
                            <th class="align-middle" style="min-width: 170px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($approval_data as$v): ?>
                        <tr id="myTask-list">
                            <td><?= $v['divisi'] ?></td>
                            <td><?= $v['departement'] ?></td>
                            <td><?= $v['posisi'] ?></td>
                            <td><?= $v['emp_name'] ?></td>
                            <!-- <?php if($v['status_approval'] == 0): ?>
                                <td data-filter="1">
                                    <span class="badge badge-danger">Not Yet Submitted</span>
                                </td>
                            <?php elseif($v['status_approval'] == 1): ?>
                                <td data-filter="2">
                                    <span class="badge badge-warning">Submitted</span>
                                </td>
                            <?php elseif($v['status_approval'] == 2): ?>
                                <td data-filter="3">
                                    <span class="badge badge-warning">First Approval</span>
                                </td>
                            <?php elseif($v['status_approval'] == 3): ?>
                                <td data-filter="4">
                                    <span class="badge badge-danger">Need Revised</span>
                                </td>
                            <?php elseif($v['status_approval'] == 4): ?>
                                <td data-filter="5">
                                    <span class="badge badge-success">Final Approval</span>
                                </td>
                            <?php endif; ?> -->

                            <td data-filter="<?= $v['status_approval'] ?>">
                                <div class="col-auto my-1">
                                    <!-- <label class="mr-sm-2" for="inlineFormCustomSelect">Preference</label> -->
                                    <select class="custom-select mr-sm-2 status_approval" id="inlineFormCustomSelect" data-id="<?= $v['id_posisi'] ?>" style="
                                        <?php if($v['status_approval'] == 0): //styling buat warna select
                                            echo("background-color: red; color: white;");
                                       elseif($v['status_approval'] == 1): 
                                            echo("background-color: yellow; color: black;");
                                       elseif($v['status_approval'] == 2): 
                                            echo("background-color: yellow; color: black;");
                                       elseif($v['status_approval'] == 3): 
                                            echo("background-color: orange; color: white;");
                                       elseif($v['status_approval'] == 4): 
                                            echo("background-color: green; color: white;");
                                        endif; ?>
                                    ">
                                        <option <?php if($v['status_approval'] == 0){echo ('selected');} ?> value="0">Not Yet Submitted</option>
                                        <option <?php if($v['status_approval'] == 1){echo ('selected');} ?> value="1">Submitted</option>
                                        <option <?php if($v['status_approval'] == 2){echo ('selected');} ?> value="2">First Approval</option>
                                        <option <?php if($v['status_approval'] == 3){echo ('selected');} ?> value="3">Need Revised</option>
                                        <option <?php if($v['status_approval'] == 4){echo ('selected');} ?> value="4">Final Approval</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- <div class="table-responsive">
                <table class="table table-boredered" id="history" width="100%">
                    <thead>
                        <tr>
                            <th>Division</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Employee Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div> -->
        </div>
    </div>
</div>