<!-- outer wrapper -->

<!-- banner tema -->
<div class="banner-wrapper">
    <svg class="banner-tema"  viewBox="0 0 416 286" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">  
        <path d="M14 0H416.717V253C416.717 253 277.068 291.331 204.944 285.334C132.82 279.337 45.4386 263.344 14 167.386C-17.4387 71.4286 14 0 14 0Z" fill="url(#pattern0)"/>
        <defs>
            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0" transform="translate(-0.0148128) scale(0.000374818 0.00054615)"/>
            </pattern>
            <image id="image0" width="2747" height="1831" xlink:href="https://picsum.photos/1000/680" />
        </defs>
    </svg>
    <svg class="banner-pengumuman" width="305" height="277" viewBox="0 0 305 277" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 2.11911C0 2.11911 181.059 -18.0491 255.238 66.0531C329.417 150.155 298.694 278 298.694 278H0V2.11911Z" fill="#0000FF"/>
    </svg>

</div>
<!-- banner pengumuman -->

<!-- header -->
<div class="row portal-header m-0">
    <div class="col-12"></div>
s
    </div>
</div>

<!-- body -->
<div class="portal-body m-0">
    a
</div>

<!-- other application -->
<div class="portal-application">
    s
</div>

<!-- footer -->
<div class="portal-footer text-right text-dark">
    <div class="portal-footer-text">
        Copyright &copy; <?= date("Y", time()) ?> | Human Capital Centratama Group
    </div>
</div>


<!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-7">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        Nested Row within Card Body
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                                    </div>

                                    <?= $this->session->flashdata('message'); ?>

                                    <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="nik"
                                                name="nik" placeholder="Enter Your NIK"
                                                value="<?= set_value('nik'); ?>">
                                            <?= form_error('nik', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class=" form-group">
                                            <input type="password" class="form-control form-control-user" id="password"
                                                name="password" placeholder="Password">
                                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?=base_url('auth/registration')?>">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
