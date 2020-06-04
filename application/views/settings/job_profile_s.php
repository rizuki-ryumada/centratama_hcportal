<div class="container-fluid">
    <h1 class="h3 text-gray-800 mb-3">Job Profile - Settings</h1>
    <div class="card shadow">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col">
                    <div class="row mb-2">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mb-0 text-gray-600"><b>Approval Setting</b></h5>
                                    <small>Here you can change the status of approval settings and notify via email.</small>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <a href="<?= base_url('job_profile/') ?>settingApproval" class="btn btn-primary btn-icon-split" title="Status Approval Settings">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-cog text-white"></i>
                                        </span>
                                        <span class="text">Approval Settings</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row ">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h5 class="mb-0 text-gray-600"><b>Notify Based on Approval Status</b></h5>
                                    <small>Notify employes based on status via email to fill the Job Profile and submit it.</small>
                                </div>
                            </div>
                            <div class="row mt-3" >
                                <div class="col-3 my-1">
                                    <p><b>Not Submitted Yet</b></p>
                                </div>
                                <div class="col-1">
                                    <a href="<?= base_url('job_profile/') ?>settingNotification" class="btn btn-circle btn-danger"><i class="fa fa-envelope text-white"></i></a>
                                </div>
                                <div class="col my-1">
                                    <p>Last sent: 27 Agustus 2020</p>
                                </div>
                            </div>
                            <div class="row mt-3" >
                                <div class="col-3 my-1">
                                    <p><b>Submitted</b></p>
                                </div>
                                <div class="col-1">
                                    <a href="<?= base_url('job_profile/') ?>settingNotification" class="btn btn-circle btn-warning"><i class="fa fa-envelope text-white"></i></a>
                                </div>
                                <div class="col my-1">
                                    <p>Last sent: 27 Agustus 2020</p>
                                </div>
                            </div>
                            <div class="row mt-3" >
                                <div class="col-3 my-1">
                                    <p><b>First Approval</b></p>
                                </div>
                                <div class="col-1">
                                    <a href="<?= base_url('job_profile/') ?>settingNotification" class="btn btn-circle btn-warning"><i class="fa fa-envelope text-white"></i></a>
                                </div>
                                <div class="col my-1">
                                    <p>Last sent: 27 Agustus 2020</p>
                                </div>
                            </div>
                            <div class="row mt-3" >
                                <div class="col-3 my-1">
                                    <p><b>Revise</b></p>
                                </div>
                                <div class="col-1">
                                    <a href="<?= base_url('job_profile/') ?>settingNotification" class="btn btn-circle btn-info"><i class="fa fa-envelope text-white"></i></a>
                                </div>
                                <div class="col my-1">
                                    <p>Last sent: 27 Agustus 2020</p>
                                </div>
                            </div>
                            <div class="row mt-3" >
                                <div class="col-3 my-1">
                                    <p><b>Approved</b></p>
                                </div>
                                <div class="col-1">
                                    <a href="<?= base_url('job_profile/') ?>settingNotification" class="btn btn-circle btn-success"><i class="fa fa-envelope text-white"></i></a>
                                </div>
                                <div class="col my-1">
                                    <p>Last sent: 27 Agustus 2020</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</div>