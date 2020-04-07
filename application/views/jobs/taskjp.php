<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <div class="flash-jobs" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>

    <!-- card start -->
    <div class="card shadow mb-2" id="print">
        <!-- Card Header - Accordion -->
        <div  class="d-block card-header py-3" >
            <h5 class="m-0 font-weight-bold text-black-50"><?= $emp_name['emp_name']; ?></h5>
        </div>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-3 font-weight-bold">Divisi</div>
                    <div class="col-lg-7"> : <?= $mydiv['division']; ?></div>
                    <div class="col-lg-2"><?= date("d  M  Y") ?></div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 font-weight-bold">Departemen</div>
                    <div class="col-lg-8"> : <?= $mydept['nama_departemen']; ?></div>
                </div>
                <!-- start identifikasi jabatan -->
                <hr>
                <div class="row align-items-end mt-3 mb-2">
                    <div class="col">
                        <h5 class="font-weight-bold">Identifikasi Jabatan</h5>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 font-weight-bold">Nama Jabatan</div>
                    <div class="col-lg-8"> : <?= $posisi['position_name']; ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 font-weight-bold">Bertanggung Jawab Kepada</div>

                    <?php if ($my['posnameatasan1'] <= 1) : ?>
                    <form action="<?= base_url('jobs/insatasan'); ?>" method="post">
                        <input type="hidden" value="<?= $posisi['position_id'] ?>" name="id">
                        <div class="col mb-1">
                            <select name="position" class="form-control form-control-sm  border border-danger">
                                <?php foreach ($pos as $p) : ?>
                                <option value="<?= $p['id']; ?>"><?= $p['position_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col mb-1"><span class="badge badge-danger font-weight-bold">Pilih Posisi Atasan
                                Anda</span></div>
                        <div class="col mb-1">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
                    <?php else : ?>
                    <?php
						$id = $my['posnameatasan1'];
						$query = "SELECT `position_name`
                                FROM `position`
                                WHERE `id` = $id";
						$atasan = $this->db->query($query)->row_array();
						?>
                    <div class="col-lg-8"> : <?= $atasan['position_name']; ?></div>
                    <?php endif; ?>
                </div>
                <!-- start tujuan jabatan -->
                <hr>
                <div class="row mt-3 mb-2">
                    <div class="col">
                        <h5 class="font-weight-bold">Tujuan Jabatan</h5>
                    </div>
                </div>
                <div class="row ml-1 mb-2">
                    <?php if ($tujuanjabatan['tujuan_jabatan'] === 0) : ?>
                    <form method="post" action="<?= base_url('jobs/uptuj'); ?>">
                        <input type="hidden" name="id_posisi" value="<?= $tujuanjabatan['id_posisi']; ?>">
                        <div class="form-group">
                            <textarea class="form-control" name="tujuan_jabatan" id="tujuanjabatan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </form>

                    <?php else : ?>

                    <div class="col-lg-11 view-tujuan">
                        <?= $tujuanjabatan['tujuan_jabatan']; ?>
                    </div>
                    <div class="col-10 editor-tujuan">
                        <textarea name="tujuan" id="tujuan"><?= $tujuanjabatan['tujuan_jabatan']; ?></textarea>
                        <button type="submit" class="mt-2 btn btn-primary btn-sm" data-id="<?= $tujuanjabatan['id']; ?>"
                            id="simpan-tujuan">Save</button>
                        <button class="batal-edit-tujuan mt-2 btn btn-danger btn-sm">Cancel</button>
                        <br>
                    </div>
                    <div class="col justify-content-center">
                        <button type="button" class="btn btn-circle btn-sm btn-success edit-tujuan"
                            data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-1x fa-pencil-alt"></i>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- start tanggung jawab utama -->
                <hr>
                <div class="row align-items-end mb-2">
                    <div class="col">
                        <h5 class="font-weight-bold">Tanggung Jawab Utama, Aktivitas Utama & Indikator Kinerja:</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive">

                        <table id="tanggung-jawab" class="table">
                            <thead>
                                <tr>
                                    <!-- <td>No</td> -->
                                    <th>Tanggung Jawab Utama</th>
                                    <th>Aktivitas Utama</th>
                                    <th>Pengukuran</th>
                                    <th class="" width="8%"><a href="" class="nTgjwb btn btn-sm btn-primary"
                                            title="Add New" data-toggle="modal" data-target="#modalTanggungJwb"><i
                                                class="fas fa-plus-square"></i></a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php
								$posid = $posisi['position_id'];
								$sql = "SELECT `position`.`position_name`, `tanggung_jawab`.`keterangan`, `tanggung_jawab`.`list_aktivitas`, `tanggung_jawab`.`list_pengukuran`, `tanggung_jawab`.`id_tgjwb`
                                    FROM `position`
                                    INNER JOIN `tanggung_jawab` ON `tanggung_jawab`.`id_posisi` = `position`.`id`
                                    WHERE `position`.`id` = $posid";
								$tgjwb = $this->db->query($sql)->result_array();
								?>
                                <?php foreach ($tgjwb as $t) : ?>
                                <tr>
                                    <td><?= $t['keterangan']; ?></td>
                                    <td>
                                        <?= $t['list_aktivitas']; ?>
                                    </td>
                                    <td>
                                        <?= $t['list_pengukuran']; ?>
                                    </td>
                                    <td>
                                        <a href="#" data-id="<?= $t['id_tgjwb']; ?>" data-toggle="modal"
                                            data-target="#modalTanggungJwb"
                                            class="eTgjwb btn btn-sm btn-circle btn-success" data-placement="top"
                                            title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="<?= base_url('jobs/hapusTanggungJawab/')  .  $t['id_tgjwb']; ?>"
                                            class="hapusJobs btn btn-sm btn-circle btn-danger" data-placement="top"
                                            title="Delete"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- start ruang lingkup -->
                <hr>
                <?php
				$sql = "SELECT * FROM `ruang_lingkup` WHERE `id_posisi` = $posid";
				$ruangl = $this->db->query($sql)->row_array();
				?>
                <div class="row align-items-end mt-auto mb-2" id="hal6">
                    <div class="col-11">
                        <h5 class="font-weight-bold">Ruang Lingkup Jabatan</h5>
                        <h6 class="font-weight-light mt-2"><em>(Ruang lingkup dan skala kegiatan yang berhubungan dengan
                                pekerjaan)</em></h6>
                    </div>
                    <div class="col d-flex justify-content-center">
                        <button type="button" class="btn btn-circle btn-sm btn-success edit-ruang" data-toggle="tooltip"
                            data-placement="top" title="Edit"><i class="fas fa-1x fa-pencil-alt"></i></button>
                    </div>
                </div>
                <?php if ($ruangl <= 1) : ?>
                <div class="col-6 mb-3">
                    <form action="<?= base_url('jobs/addruanglingkup'); ?>" method="post">
                        <input type="hidden" name="id" value="<?= $posid; ?>">
                        <div class="form-group">
                            <textarea class="form-control" name="ruangl" id="ruangl" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </form>
                </div>
                <?php else : ?>
                <div class="row">
                    <div class="col-11 view-ruang">
                        <?= $ruangl['r_lingkup']; ?>
                    </div>
                </div>
                <div class="editor-ruang mb-3">
                    <textarea name="ruang" id="ruang"><?= $ruangl['r_lingkup']; ?></textarea>
                    <button type="submit" class="mt-2 btn btn-primary btn-sm" data-id="<?= $ruangl['id']; ?>"
                        id="simpan-ruang">Save</button>
                    <button class="batal-edit-ruang mt-2 btn btn-danger btn-sm">Cancel</button>
                </div>
                <?php endif; ?>
                <!-- start wewenang -->
                <hr>
                <div class="row mt-auto mb-2">
                    <div class="col">
                        <h5 class="font-weight-bold">Wewenang Pengambilan Keputusan Dan Pengawasan</h5>
                        <h6 class="font-weight-light mt-2"><em>Uraian jenis wewenang yang diperlukan dalam
                                menjalankan
                                aktivitas pekerjaan :</em></h6>
                    </div>
                </div>
                <div class="col-lg table-responsive">
                    <table class="table" id="wewenang">
                        <thead class="font-weight-bold">
                            <tr>
                                <td>Kewenangan</td>
                                <td>Anda</td>
                                <td>Atasan 1</td>
                                <td>Atasan 2</td>
                                <td><button id="addwen" class="btn btn-sm btn-primary ml-n1"><i
                                            class="fas fa-plus-square"></i></button></td>
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php
							$sql = "SELECT * FROM `wewenang` WHERE `id_posisi` = $posid";
							$wen = $this->db->query($sql)->result_array();
							?>
                            <?php foreach ($wen as $w) : ?>
                            <tr>
                                <td><?= $w['id']; ?></td>
                                <td><?= $w['kewenangan']; ?></td>
                                <td><?= $w['wen_sendiri']; ?></td>
                                <td><?= $w['wen_atasan1']; ?></td>
                                <td><?= $w['wen_atasan2']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot id="newWen">
                            <tr>
                                <form action="<?= base_url('jobs/addwen'); ?>" method="post">
                                    <td><input type="text" name="wewenang" class="form-control" required
                                            placeholder="Masukkan Kewenangan"></td>
                                    <td>
                                        <select name="wen_sendiri" class="form-control" required>
                                            <option value="">Wewenang Anda</option>
                                            <option value="-">-</option>
                                            <option value="R">R : Responsibility</option>
                                            <option value="A">A : Accountability</option>
                                            <option value="V">V : Veto</option>
                                            <option value="C">C : Consult</option>
                                            <option value="I">I : Informed</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="wen_atasan1" class="form-control" required>
                                            <option value="">Wewenang Atasan Pertama</option>
                                            <option value="-">-</option>
                                            <option value="R">R : Responsibility</option>
                                            <option value="A">A : Accountability</option>
                                            <option value="V">V : Veto</option>
                                            <option value="C">C : Consult</option>
                                            <option value="I">I : Informed</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="wen_atasan2" class="form-control" required>
                                            <option value="">Wewenang Atasan Kedua</option>
                                            <option value="-">-</option>
                                            <option value="R">R : Responsibility</option>
                                            <option value="A">A : Accountability</option>
                                            <option value="V">V : Veto</option>
                                            <option value="C">C : Consult</option>
                                            <option value="I">I : Informed</option>
                                        </select>
                                    </td>
                                    <td><button type="submit" class="btn btn-primary btn-sm mr-n3">Save</button>
                                    </td>
                                </form>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="note">
                        <ul class="ml-2">
                            <li>R : Responsibility = Memiliki tanggung jawab dan wewenang untuk mengambil keputusan</li>
                            <li>A : Accountability = tidak dapat mengambil keputusan tetapi bertanggung jawab dalam
                                pelaksanaan dan hasilnya</li>
                            <li>V : Veto = dapat meng-anulir atau mem-blok suatu keputusan</li>
                            <li>C : Consult= sebelum mengambil keputusan harus memberi masukan dan mengkonsultasikan
                                lebih
                                dahulu dengan atasan</li>
                            <li>I : Informed = harus diberi informasi setelah keputusan diambil</li>
                        </ul>
                    </div>
                </div>
                <!-- start hubungan kerja -->
                <hr>
                <div class="row mt-4" id="hal5">
                    <div class="col">
                        <h5 class="font-weight-bold">Hubungan Kerja</h5>
                        <h6 class="font-weight-light mt-2"><em>Uraian tujuan dan hubungan jabatan dengan pihak luar
                                dan
                                pihak dalam perusahaan selain dengan atasan langsung maupun bawahan, yang diperlukan
                                dalam melakukan pekerjaan :</em></h6>
                    </div>
                </div>
                <?php
				$sql = "SELECT * FROM `hub_kerja` WHERE `id_posisi` = $posid";
				$hub = $this->db->query($sql)->row_array();
				?>

                <?php if ($hub <= 1) : ?>

                <form method="post" action="<?= base_url('jobs/addHubungan'); ?>">
                    <input type="hidden" name="id" value="<?= $posid; ?>" />
                    <div class="form-group">
                        <label for="internal">Hubungan Internal</label>
                        <textarea class="form-control" name="internal" id="internal"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="eksternal">Hubungan Eksternal</label>
                        <textarea class="form-control" name="eksternal" id="eksternal"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </form>

                <?php else : ?>

                <div class="row ml-2">
                    <div class="col-5">
                        <h5><strong>Hubungan Internal</strong></h5>
                        <div class="hubIntData"><?= $hub['hubungan_int']; ?></div>
                        <textarea id="hubInt"><?= $hub['hubungan_int']; ?></textarea>
                        <button data-id="<?= $hub['id']; ?>"
                            class="btn btn-primary btn-sm simpanhubInt mt-1 mb-2">Save</button>
                        <button class="btn btn-danger btn-sm batalhubInt mt-1 mb-2">Cancel</button>
                    </div>
                    <div class="col-sm-1 d-flex justify-content-center">
                        <span class="edit-hubInt btn btn-sm btn-circle btn-success" data-toggle="tooltip"
                            data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></span>
                    </div>
                    <div class="col-5">
                        <h5><strong>Hubungan Ekternal</strong></h5>
                        <div class="hubEksData"> <?= $hub['hubungan_eks']; ?>
                        </div>
                        <textarea id="hubEks"><?= $hub['hubungan_eks']; ?></textarea>
                        <button data-id="<?= $hub['id']; ?>"
                            class="btn btn-primary btn-sm simpanhubEks mt-1">Save</button>
                        <button class="btn btn-danger btn-sm batalhubEks mt-1">Cancel</button>
                    </div>
                    <div class="col-sm-1 d-flex justify-content-center">
                        <span class="edit-hubEks btn btn-sm btn-circle btn-success" data-toggle="tooltip"
                            data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></span>
                    </div>
                </div>

                <?php endif; ?>
                <!-- start jumlah staff -->
                <?php
				$dataStaff = [$staff['manager'], $staff['supervisor'], $staff['staff']];
				?>
                <hr>
                <div class="row align-items-end mt-2">
                    <div class="col">
                        <h5 class="font-weight-bold">Jumlah Dan Level Staf Yang Dibawahi</h5>
                        <h6 class="font-weight-light mt-2"><em>Jumlah dan level staf yang memiliki garis
                                pertanggungjawaban ke jabatan :</em></h6>
                    </div>
                </div>
                <dl class="row mt-2">
                    <dt class="col-2">Jumlah Staff</dt>
                    <dd class="col-1">
                        <p class="jumTotStaff"><?= array_sum($dataStaff); ?></p>
                    </dd>
                    <dd class="col-9">Orang</dd>

                    <dt class="col-2">Manager</dt>
                    <dd class="col-2">
                        <div class="input-group input-group-sm mb-3">
                            <input type="text" id="totMgr" class="form-control form-control-sm"
                                value="<?= $staff['manager']; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Orang</span>
                            </div>
                        </div>
                    </dd>
                    <dd class="col-8"></dd>

                    <dt class="col-2">Supervisor</dt>
                    <dd class="col-2">
                        <div class="input-group input-group-sm mb-3">
                            <input type="text" id="totSpvr" class="form-control form-control-sm"
                                value="<?= $staff['supervisor']; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Orang</span>
                            </div>
                        </div>
                    </dd>
                    <dd class="col-8"></dd>


                    <dt class="col-2">Staff</dt>
                    <dd class="col-2">
                        <div class="input-group input-group-sm mb-3">
                            <input type="text" id="totStaf" class="form-control form-control-sm"
                                value="<?= $staff['staff']; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Orang</span>
                            </div>
                        </div>
                    </dd>
                </dl>
                <!-- start tantangan dan maslah utama -->
                <hr>
                <?php
				$sql = "SELECT * FROM `tantangan` WHERE `id_posisi` = $posid";
				$tan = $this->db->query($sql)->row_array();
				?>

                <?php if ($tan <= 1) : ?>
                <div class="row align-items-end mt-2">
                    <div class="col">
                        <h5 class="font-weight-bold">Tantangan Dan Masalah Utama</h5>
                        <h6 class="font-weight-light mt-2"><em>Tantangan yang melekat pada jabatan dan masalah yang
                                sulit/ rumit yang dihadapi dalam kurun waktu cukup panjang :</em></h6>
                    </div>
                </div>
                <div class="col-6">
                    <form method="post" action="<?= base_url('jobs/addtantangan/'); ?>">
                        <input type="hidden" name="id" value="<?= $my['position_id']; ?>">
                        <div class="form-group">
                            <textarea name="tantangan" id="tantangan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </form>
                </div>
                <?php else : ?>
                <div class="row mt-2">
                    <div class="col-11">
                        <h5 class="font-weight-bold">Tantangan Dan Masalah Utama</h5>
                        <h6 class="font-weight-light mt-2"><em>Tantangan yang melekat pada jabatan dan masalah yang
                                sulit/ rumit yang dihadapi dalam kurun waktu cukup panjang :</em></h6>
                    </div>
                    <div class="col-sm-1 d-flex justify-content-center">
                        <button type="button" class="btn btn-circle btn-sm btn-success edit-tantangan"
                            data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-1x fa-pencil-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="view-tantangan">
                    <?= $tan['text']; ?>
                </div>
                <div class="editor-tantangan">
                    <textarea name="tantangan" id="tantangan"><?= $tan['text']; ?></textarea>
                    <button id="simpan-tantangan" data-id="<?= $tan['id']; ?>"
                        class="mt-2 btn btn-primary btn-sm">Simpan</button>
                    <button class="batal-edit-tantangan mt-2 btn btn-danger btn-sm">Batal</button>
                </div>
                <?php endif; ?>
                <!-- start kualifikasi dan pengalaman -->
                <hr>
                <?php
				$sql = "SELECT * FROM `kualifikasi` WHERE `id_posisi` = $posid";
				$kualifikasi = $this->db->query($sql)->row_array();
				?>
                <?php if ($kualifikasi <= 1) : ?>
                <div class="row align-items-end mt-4">
                    <div class="col">
                        <h5 class="font-weight-bold">Kualifikasi dan Pengalaman</h5>
                        <h6 class="font-weight-light mt-2"><em>Persyaratan minimum yang harus dipenuhi : pendidikan,
                                lama pengalaman kerja yang relevan, kompetensi (soft dan technical skill), atau
                                kualifikasi personal maupun profesional lainnya :</em></h6>
                    </div>
                </div>
                <div class="col-6 ml-2 mt-2">
                    <form action="<?= base_url('jobs/addkualifikasi'); ?>" method="post">
                        <input type="hidden" name="id" value="<?= $posid; ?>">
                        <div class="form-group">
                            <label for="pend">Pendidikan Formal</label>
                            <textarea class="form-control" name="pend" id="pend" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="pengalmn">Pengalaman Kerja</label>
                            <textarea class="form-control" name="pengalmn" id="pengalmn" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="pengtahu">Pengetahuan</label>
                            <textarea class="form-control" name="pengtahu" id="pengtahu" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kptnsi">Kompetensi & Keterampilan</label>
                            <textarea class="form-control" name="kptnsi" id="kptnsi" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
                </div>
                <?php else : ?>
                <div class="row mt-4">
                    <div class="col-11">
                        <h5 class="font-weight-bold">Kualifikasi dan Pengalaman </h5>
                        <h6 class="font-weight-light mt-2"><em>Persyaratan minimum yang harus dipenuhi : pendidikan,
                                lama pengalaman kerja yang relevan, kompetensi (soft dan technical skill), atau
                                kualifikasi personal maupun profesional lainnya :</em></h6>
                    </div>
                    <div class="col-sm-1 d-flex justify-content-center">
                        <button type="button" class="btn btn-circle btn-sm btn-success edit-kualifikasi"
                            data-id="<?= $posid; ?>" data-toggle="modal" data-target="#modalKualifikasi"
                            data-placement="top" title="Edit">
                            <i class="fas fa-1x fa-pencil-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tableK" class="table table-borderless tableK" width="25%">
                        <tbody>
                            <tr>
                                <th class="head-kualifikasi">Pendidikan Formal</th>
                                <td id="pendidikan">: <?= $kualifikasi['pendidikan']; ?></td>
                            </tr>
                            <tr>
                                <th class="head-kualifikasi">Pengalaman Kerja</th>
                                <td id="pengalaman">: <?= $kualifikasi['pengalaman']; ?></td>
                            </tr>
                            <tr>
                                <th class="head-kualifikasi">Pengetahuan</th>
                                <td id="pengetahuan">: <?= $kualifikasi['pengetahuan']; ?></td>
                            </tr>
                            <tr>
                                <th class="head-kualifikasi">Kompetensi & Keterampilan</th>
                                <td id="kompetensi">: <?= $kualifikasi['kompetensi']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
                <!-- start jenjang karir -->
                <hr>
                <?php
				$sql = "SELECT * FROM `jenjang_kar` WHERE `id_posisi` = $posid";
				$jenk = $this->db->query($sql)->row_array();
				?>

                <?php if ($jenk <= 1) : ?>
                <div class="row align-items-end mt-3">
                    <div class="col">
                        <h5 class="font-weight-bold">Jabatan Berikutnya Di Masa Depan</h5>
                        <h6 class="font-weight-light mt-2"><em>Pergerakan karir yang memungkinkan setelah memegang
                                jabatan ini? (baik yang utama/ primary maupun yang secondary):</em></h6>
                    </div>
                </div>
                <div class="col-6">
                    <form action="<?= base_url('jobs/addjenjangkarir'); ?>" method="post">
                        <input type="hidden" name="id" value="<?= $posid; ?>">
                        <div class="form-group">
                            <label for="jenkar">Jabatan Di Masa Depan :</label>
                            <textarea class="form-control" name="jenkar" id="jenkar" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </form>
                </div>
                <?php else : ?>
                <div class="row mt-3">
                    <div class="col-11">
                        <h5 class="font-weight-bold">Jabatan Berikutnya Di Masa Depan</h5>
                        <h6 class="font-weight-light mt-2"><em>Pergerakan karir yang memungkinkan setelah memegang
                                jabatan ini? (baik yang utama/ primary maupun yang secondary):</em></h6>
                    </div>
                    <div class="col-sm-1 d-flex justify-content-center">
                        <button type="button" class="btn btn-circle btn-sm btn-success edit-jenjang"
                            data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-1x fa-pencil-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="view-jenjang">
                    <?= $jenk['text']; ?>
                </div>
                <div class="editor-jenkar">
                    <textarea name="jenkar" id="jenkar"><?= $jenk['text']; ?></textarea>
                    <button type="submit" class="mt-2 btn btn-primary btn-sm" data-id="<?= $jenk['id']; ?>"
                        id="simpan-jenjang">Save</button>
                    <button class="batal-edit-jenjang mt-2 btn btn-danger btn-sm">Cancel</button>
                </div>
                <?php endif; ?>
                <hr>
                <?php if($atasan != 0): ?>
					<!-- start Struktur Organisasi -->
					<div class="row mt-3">
						<div class="col-11">
							<h5 class="font-weight-bold mb-3">Struktur Organisasi</h5>
						</div>
						<div class="w-100" id="chart-container"></div> 
					</div>
				<?php endif; ?>

            </div>
            <div class="card-footer">
                <div class="row justify-content-md-center">
                    <button type="button" class="col-5 btn btn-warning btn-sm" data-toggle="modal"
                        data-target="#revisi-modal">Revisi</button>
                    <div class="col-1"></div>
                    <button type="button" class="col-5 btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#setujui-modal">Setujui</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dangerrrrrr -->
    <!-- <div class="card shadow">
		<div class="card-header">
			<h6 class="m-0 font-weight-bold text-black-50">Struktur Organisasi</h6>
		</div> -->

    <!-- the new orgchart -->
    <!-- <div class="card-body">  -->
    <!--orgchart Container -->
    <!-- <div id="chart-container"></div>  -->
    <!-- /orgchart Container -->

    <!-- orgchart edit panel -->
    <!-- <div id="edit-panel">
					<span id="chart-state-panel" class="radio-panel">
						<input type="radio" name="chart-state" id="rd-view" value="view"><label for="rd-view">View</label>
						<input type="radio" name="chart-state" id="rd-edit" value="edit" checked="true"><label for="rd-edit">Edit</label>
					</span>
					
					<label class="selected-node-group">Selected node:</label>
					<input type="text" id="selected-node" class="selected-node-group">
					
					<label>New node:</label>
					<ul id="new-nodelist">
						<li><input type="text" class="new-node"></li>
					</ul>
					
					<i class="fa fa-plus-circle btn-inputs" id="btn-add-input"></i>
					<i class="fa fa-minus-circle btn-inputs" id="btn-remove-input"></i>
					
					<span id="node-type-panel" class="radio-panel">
						<input type="radio" name="node-type" id="rd-parent" value="parent"><label for="rd-parent">Parent(root)</label>
						<input type="radio" name="node-type" id="rd-child" value="children"><label for="rd-child">Child</label>
						<input type="radio" name="node-type" id="rd-sibling" value="siblings"><label for="rd-child">Sibling</label>
					</span>

					<button id="btn-add-nodes">Add</button>
					<button id="btn-delete-nodes">Delete</button>
					<button id="btn-reset">Reset</button>
				</div> -->
    <!-- /orgchart edit panel -->
    <!-- </div> -->

    <!-- old orgchart -->
    <!-- <div class="card-body">
			<div id="tree" />
		</div> -->
    <!-- save button planned for orgchart -->
    <!-- <div class="card-body">
			<button type="submit" class="mt-2 btn btn-primary btn-sm" id="simpan-chart">Save</button>
		</div> -->
    <!-- save button planned for orgchart -->
    <!-- </div> -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- modal tanggung jawab -->
<div class="modal fade" id="modalTanggungJwb" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTanggungJwbTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="idtgjwb" id="idtgjwb">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Tanggung Jawab Utama:</label>
                        <textarea class="form-control" id="tJwb-text" name="tanggung_jawab" required="true"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Aktivitas Utama:</label>
                        <textarea class="form-control" id="aUtm-text" name="aktivitas" required="true"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Pengukuran:</label>
                        <textarea class="form-control" id="pgkrn-text" name="pengukuran" required="true"></textarea>
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

<!-- modal kualifikasi -->
<div class="modal fade" id="modalKualifikasi">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Kualifikasi dan Pengalaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form action="<?= base_url('jobs/updateKualifikasi'); ?>" method="post"> -->
                <input type="hidden" name="id" id="id" value="<?= $posid; ?>">
                <div class="form-group">
                    <label for="pend">Pendidikan Formal</label>
                    <textarea class="form-control" name="pend" id="pend" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="pengalmn">Pengalaman Kerja</label>
                    <textarea class="form-control" name="pengalmn" id="pengalmn" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="pengtahu">Pengetahuan</label>
                    <textarea class="form-control" name="pengtahu" id="pengtahu" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="kptnsi">Kompetensi & Keterampilan</label>
                    <textarea class="form-control" name="kptnsi" id="kptnsi" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm" id="save-kualifikasi">Save</button>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>

<!-- Submit Modal -->
<!-- Button trigger modal -->

<!-- Modal Setujui -->
<div class="modal fade" id="setujui-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <ul>
                        <li>Anda akan memproses Job Profil karyawan ini ke proses selanjutnya.</li>
                        <li>Setelah anda menyetujui Job Profile ini anda tidak dapat mengubahnya kembali.</li>
                    </ul>
				</p>
				<form id="revisi-form" action="<?= base_url('/jobs/taskAction'); ?>" method="post">
					<input type="hidden" name="pesan_revisi" value="null">
					<input type="hidden" name="nik" value="<?= $this->input->get('task'); ?>">
					<input type="hidden" name="status_approval" value="true">
					<input type="hidden" name="status_sebelum" value="<?= $status; ?>" />
				</form>
            </div>
            <div class="modal-footer">
				<input type="submit" form="revisi-form" style="btn btn-light" value="Setujui">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Periksa lagi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Revisi -->
<div class="modal fade" id="revisi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<h5>Pesan Revisi</h5>
				<hr/>
				<p>Silakan masukkan pesan untuk karyawan, agar mempermudah dalam melakukan revisi.</p>
				<form id="setuju_form" action="<?= base_url('jobs/'); ?>taskAction" method="post">
					<textarea rows="4" cols="45" name="pesan_revisi"></textarea>
					<input type="hidden" name="nik" value="<?= $this->input->get('task'); ?>">
					<input type="hidden" name="status_approval" value="false" />
					<input type="hidden" name="status_sebelum" value="<?= $status; ?>" />
				</form>
            </div>
            <div class="modal-footer">
				<input type="submit" form="setuju_form" style="btn btn-light" value="Revisi">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Periksa lagi</button>
            </div>
        </div>
    </div>
</div>


<script>
// for submitting form
function submitForm(){
	document.getElementById("setuju_form").submit();
};
</script>