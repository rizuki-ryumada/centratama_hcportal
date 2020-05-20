<style>
    form li, div > p {
        
    }
    form img{
        
    }
    /* form label, form button {
        background-color: #7F9CCB;
        padding: 5px 10px;
        border-radius: 5px;
        border: 1px ridge black;
        font-size: 0.8rem;
        height: auto;
    } */
    
</style>

<div class="container-fluid">
    <h1 class="h3 mb-auto text-gray-800"><?= $title; ?></h1>
    <div class="card shadow my-3">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h4><b>Banner</b></h4>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h5>Theme</h5>
                            <p class="mb-0">Ubah gambar tema di halaman Portal.</p>
                            <div class="row">
                                <div class="col">
                                    <div>
                                        <p>
                                            <ul>
                                                <li>Pastikan ukuran gambar <span class="badge badge-danger">1000x680</span>, atau berada di rasio <span class="badge badge-danger">1 : 0.68</span> </li>
                                                <li>Pastikan ukuran berkas gambar tidak melebihi <span class="badge badge-danger">2 MB</span></li>
                                            </ul>
                                        </p>
                                    </div>
                                    <div>
                                        <form id="banner-tema" method="POST" enctype="multipart/form-data">
                                            <div id="tema-preview">
                                                <p>Tidak ada file dipilih</p>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="file" class="form-control-file" id="bannerTemaInput" name="tema" accept=".jpg, .jpeg, .png" placeholder="Pilih File...">
                                                </div>
                                                <div class="col-6">
                                                    <label class="btn btn-primary m-0" for="bannerTemaInput">Pilih Tema</label>
                                                    <button class="btn btn-success" type="submit" form="banner-tema" value="Submit">Ubah Tema</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="settings-image-wrapper d-flex justify-content-center">
                                        <!-- aturan -->
                                        <!-- <img class="" src="<?= base_url('assets/'); ?>img/tema.jpg" alt="tema"> -->
                                        <!-- tampilan preview tema -->
                                        <svg class="settings-image" viewBox="0 0 444 291" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <path d="M20.3976 -2L444 -1.99989V261.351C444 261.351 273.624 290 217.656 290C161.687 290 45.3154 269.846 12.7306 173.901C-19.8541 77.9548 20.3976 -2 20.3976 -2Z" fill="url(#pattern0)"/>
                                            <defs>
                                                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0" transform="translate(-0.0113811) scale(0.00037232 0.00054615)"/>
                                                </pattern>
                                                <!-- <image id="image0" width="2747" height="1831" xlink:href="https://picsum.photos/1000/680" /> -->
                                                <image id="image0" width="2747" height="1831" xlink:href="<?= base_url('assets/'); ?>img/tema.jpg" />
                                            </defs>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5>Theme</h5>
                            <p class="mb-0">Ubah gambar tema di halaman Portal.</p>
                            <div class="row">
                                <div class="col">
                                    <div>
                                        <p>
                                            <ul>
                                                <li>Pastikan ukuran gambar <span class="badge badge-danger">1000x680</span>, atau berada di rasio <span class="badge badge-danger">1 : 0.9</span> </li>
                                                <li>Pastikan ukuran berkas gambar tidak melebihi <span class="badge badge-danger">2 MB</span></li>
                                            </ul>
                                        </p>
                                    </div>
                                    <div>
                                        <form id="banner-tema" method="POST" enctype="multipart/form-data">
                                            <div id="tema-preview">
                                                <p>Tidak ada file dipilih</p>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="file" class="form-control-file" id="bannerTemaInput" name="tema" accept=".jpg, .jpeg, .png" placeholder="Pilih File...">
                                                </div>
                                                <div class="col-6">
                                                    <label class="btn btn-primary m-0" for="bannerTemaInput">Pilih Tema</label>
                                                    <button class="btn btn-success" type="submit" form="banner-tema" value="Submit">Ubah Tema</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="settings-image-wrapper d-flex justify-content-center">
                                        <!-- aturan -->
                                        <!-- <img class="" src="<?= base_url('assets/'); ?>img/tema.jpg" alt="tema"> -->
                                        <!-- tampilan preview tema -->
                                        <svg class="settings-image" viewBox="0 0 444 291" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <path d="M20.3976 -2L444 -1.99989V261.351C444 261.351 273.624 290 217.656 290C161.687 290 45.3154 269.846 12.7306 173.901C-19.8541 77.9548 20.3976 -2 20.3976 -2Z" fill="url(#pattern0)"/>
                                            <defs>
                                                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0" transform="translate(-0.0113811) scale(0.00037232 0.00054615)"/>
                                                </pattern>
                                                <!-- <image id="image0" width="2747" height="1831" xlink:href="https://picsum.photos/1000/680" /> -->
                                                <image id="image0" width="2747" height="1831" xlink:href="<?= base_url('assets/'); ?>img/tema.jpg" />
                                            </defs>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </>
</div>