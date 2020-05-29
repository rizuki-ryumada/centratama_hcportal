<!-- Footer -->
<?php $this->load->view('templates/footer_copyright'); ?>

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- orgchart -->
<script src="<?= base_url('assets/'); ?>js/orgchart/jquery.orgchart.min.js"></script>
<!-- <script src="<?php base_url(); ?>assets/js/orgchart/jquery.orgchart.min.js"></script> -->
<!-- <script src="<?php base_url(); ?>assets/js/orgchart/jquery.orgchart.min.js"></script> -->
<script src="<?= base_url('assets/'); ?>js/orgchart/html2canvas.min.js"></script>

<script src="<?= base_url('assets/'); ?>vendor/jquery-tabledit/jquery.tabledit.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/swall/sweetalert2.all.min.js"></script>

<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
<script src="<?= base_url('assets/'); ?>js/chartorg.js"></script>

<script>
//masukkin data ke variabel javascript dari php

var assistant_atasan1 = <?= $assistant_atasan1; ?>;
var atasan = <?= $atasan; ?>;
var datasource = <?php echo $orgchart_data; ?>; 
var datasource_assistant1 = <?php echo($orgchart_data_assistant1); ?>;
var datasource_assistant2 = <?php echo($orgchart_data_assistant2); ?>;

//contoh data
// var datasource_assistant = [
//     {
//         "id": "194",
//         "position_name": "Employee Relation & Safety Officer",
//         "dept_id": "26",
//         "div_id": "6",
//         "id_atasan1": "196",
//         "id_atasan2": "1",
//         "assistant": "1",
//         "atasan_assistant": "Human Capital Division Head"
//     },
//     {
//         "id": "195",
//         "position_name": "HCIS Officer",
//         "dept_id": "26",
//         "div_id": "6",
//         "id_atasan1": "196",
//         "id_atasan2": "1",
//         "assistant": "1",
//         "atasan_assistant": "Human Capital Division Head"
//     },
//     {
//         "id": "195",
//         "position_name": "HCIS Officer",
//         "dept_id": "26",
//         "div_id": "6",
//         "id_atasan1": "196",
//         "id_atasan2": "1",
//         "assistant": "1",
//         "atasan_assistant": "Human Capital Division Head"
//     },
//     {
//         "id": "195",
//         "position_name": "HCIS Officer",
//         "dept_id": "26",
//         "div_id": "6",
//         "id_atasan1": "196",
//         "id_atasan2": "1",
//         "assistant": "1",
//         "atasan_assistant": "Human Capital Division Head"
//     }
// ];


//pid 1
//masukin data nodes ke form input juga
//


//id tampilkan id atasan 1 2 yang punya jabatan lebih tinggi
//tampilkan id atasan 1 yang sama semua



// var nodes = [
// 	{
// 		id: "1",
// 		title: "Masukkan Jabatan Atasan Anda",
// 		me: ""
// 	},
// 	{
// 		id: "2",
// 		pid: "1",
// 		title: "Masukkan Jabatan",
// 		me: ""
// 	},
// 	{
// 		id: "3",
// 		pid: "1",
// 		title: "Masukkan Jabatan",
// 		me: ""
// 	},
// 	{
// 		id: "4",
// 		pid: "1",
// 		title: "Masukkan Jabatan",
// 		me: ""
// 	},
// 	{
// 		id: "5",
// 		pid: "2",
// 		title: "Masukkan Jabatan",
// 		me: "Posisi Saya Ini Paling Tinggi Lo"
// 	}
// ];
//
</script>

<script>

	$(document).ready(function() {
		$('.hapusJobs').click(function(e) {
			// e.preventDefault();
			const href = $(this).attr("href");
			Swal.fire({
				title: "Yakin Ingin Menghapus?",
				text: "Aksi ini akan menghapus data secara permanen!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya!",
				cancelButtonText: "Batal!"
			}).then((result) => {
				if(result.value) {
					$.ajax({
						url: href,
						success: function() {
							swal.fire(
								'Berhasil!',
								'Data Berhasil Dihapus!<br>Halaman sedang direfresh ulang...',
								'success'
							);
							setTimeout(function() {
								location.reload();
							}, 2000);
						}
					});
				} else {
					//nothing
				}
			});
		});

		// start aksi tujuan jabatan
		$('.edit-tujuan').on('click', function() {
			$(this).hide();
			$("div[class~='view-tujuan']").hide();
			$('.editor-tujuan').fadeIn().focus();
		});

		$('#simpan-tujuan').on('click', function() {
			const id = $(this).data('id');
			const tujuan = CKEDITOR.instances['tujuan'].getData();
			$.ajax({
				url: "<?php echo base_url('jobs/edittujuan'); ?>",
				data: {
					id: id,
					tujuan: tujuan
				},
				method: "POST",
				success: function(data) {
					$('.edit-tujuan').fadeIn();
					$("div[class~='view-tujuan']").html(tujuan).fadeIn();
					$('.editor-tujuan').hide();
					Swal.fire(
						'Berhasil!',
						'Data Berhasil Diubah!',
						'success'
					)
				}
			});
		});

		$('#simpan-tujuan-baru').click(function() {
			const id = $(this).data('id');
			const tujuan = CKEDITOR.instances['tujuanbaru'].getData();
			$.ajax({
				url: "<?= base_url('jobs/uptuj'); ?>",
				data: {
					id: id,
					tujuan: tujuan
				},
				method: "POST",
				success: function(data) {
					$('.edit-tujuan').removeClass('d-none');
					$('.edit-tujuan').addClass('d-block');
					$("div[class~='view-tujuan']").removeClass('d-none');
					$("div[class~='view-tujuan']").html(tujuan).addClass('d-block');
					$("#add-tujuan_jabatan").hide();
					location.reload();//for speed

					// swal.fire( //for showing the modal, it is like application
					// 	'Berhasil!',
					// 	'Data Berhasil Dimasukkan!<br>Halaman sedang direfresh ulang...',
					// 	'success'
					// )
					// setTimeout(function() {
					// 	location.reload();
					// }, 2000);
				}
			});
		});

		$('.batal-edit-tujuan').on('click', function() {
			$('.edit-tujuan').fadeIn();
			$("div[class~='view-tujuan']").fadeIn();
			$('.editor-tujuan').hide();
		});
		// end aksi tujuan jabatan

		//start edit tanggung jawab
		$(function() {
			$('.nTgjwb').on('click', function() {
				$('#modalTanggungJwbTitle').html('Tambah Tanggung Jawab Utama, Aktivitas Utama & Indikator Kerja');
				$('.modal-footer button[type=submit]').html('Simpan');
				$('#idtgjwb').val("");
				$('#tJwb-text').val("");
				CKEDITOR.instances['aUtm-text'].setData("");
				CKEDITOR.instances['pgkrn-text'].setData("");
				// $('.modal-body form').attr('action', '<?= base_url('jobs/addtanggungjawab') ?>');
			});

			$('.eTgjwb').on('click', function() {
				$('#modalTanggungJwbTitle').html('Edit Tanggung Jawab Utama, Aktivitas Utama & Indikator Kerja');
				$('.modal-footer button[type=submit]').html('Simpan Perubahan');
				$('.modal-body form').attr('action', '<?= base_url('jobs/edittanggungjawab') ?>');
				const id = $(this).data('id');

				$.ajax({
					url: '<?= base_url('jobs/getTjByID') ?>',
					data: {
						id: id
					},
					method: 'post',
					dataType: 'json',
					success: function(data) {
						$('#idtgjwb').val(data.id_tgjwb);
						$('#tJwb-text').val(data.keterangan);
						CKEDITOR.instances['aUtm-text'].setData(data.list_aktivitas);
						CKEDITOR.instances['pgkrn-text'].setData(data.list_pengukuran);
					}
				})
			});
		});

		/////////////////////////////////// Tambah Tanggung jawab baru /////////////////////////////////
		$('#submit-tgjwb').click(function() {
			const id_posisi = $(this).data('id_posisi');
			const idtgjwb = $('input[name="idtgjwb"]').val();
			const tjwb = $('textarea[name="tanggung_jawab"]').val();
			const autm = CKEDITOR.instances['aUtm-text'].getData();
			const pgkrn = CKEDITOR.instances['pgkrn-text'].getData();
			
			if(idtgjwb == ""){
				// console.log("add mode");
				var url_submit = '<?= base_url('jobs/addtanggungjawab'); ?>';
			}else{
				// console.log("edit mode");
				var url_submit = '<?= base_url('jobs/edittanggungjawab') ?>';
			}

			$.ajax({
				url: url_submit,
				data: {
					idtgjwb: idtgjwb,
					id_posisi: id_posisi,
					tanggung_jawab: tjwb,
					aktivitas: autm,
					pengukuran: pgkrn
				},
				method: "POST",
				success: function(data){
					if(idtgjwb == ""){
						location.reload();

						// swal.fire(
						// 	'Berhasil!',
						// 	'Data Berhasil Dimasukkan!<br>Halaman sedang direfresh ulang...',
						// 	'success'
						// )
						// setTimeout(function() {
						// 	location.reload();
						// }, 2000);
					}else{
						location.reload();

						// swal.fire(
						// 	'Berhasil!',
						// 	'Data berhasil diubah.<br/>Halaman sedang direfresh ulang',
						// 	'success'
						// );
						// setTimeout(function() {
						// 	location.reload();
						// }, 2000);
					}
				}
			});
		});

		// -------------start ruang lingkup---------------//
		$('.edit-ruang').on('click', function() {
			$(this).hide();
			$("div[class~='view-ruang']").hide();
			$('.editor-ruang').slideDown("fast");
		});

		$('#simpan-ruang').on('click', function() {
			const id = $(this).data('id');
			const ruang = CKEDITOR.instances['ruang'].getData();
			$.ajax({
				url: "<?php echo base_url('jobs/editruanglingkup'); ?>",
				data: {
					id: id,
					ruang: ruang
				},
				method: "POST",
				success: function(data) {
					$('.edit-ruang').fadeIn(1000);
					$('.editor-ruang').hide();
					Swal.fire(
						'Berhasil!',
						'Data Berhasil Diubah!',
						'success'
					);
					if (data === '<b>-</br>') {
						$("div[class~='view-ruang']").html(data).fadeIn(1000);
					} else {
						$("div[class~='view-ruang']").html(ruang).fadeIn(1000);
					}
				}
			});
		});

		$('#simpan-ruangl-baru').click(function(){
			const id = $(this).data('id');
			const ruangl = CKEDITOR.instances['add-ruangl'].getData();
			$.ajax({
				url: "<?= base_url('jobs/addruanglingkup') ?>",
				data: {
					id: id,
					ruangl: ruangl
				},
				method: "POST",
				success: function(data){
					location.reload();

					// swal.fire(
					// 	'Berhasil!',
					// 	'Data Berhasil Dimasukkan!<br>Halaman sedang direfresh ulang...',
					// 	'success'
					// )
					// setTimeout(function() {
					// 	location.reload();
					// }, 2000);
				}
			});
		});

		$('.batal-edit-ruang').on('click', function() {
			$('.edit-ruang').fadeIn(1000);
			$("div[class~='view-ruang']").fadeIn(500);
			$('.editor-ruang').hide();
		});

		// start add wewenang
		const newWen = $('#newWen').hide();
		$('#addwen').on('click', function() {
			newWen.show().fadeIn();
		});

		// start edit wewenang
		$(document).ready(function() {
			$('#wewenang').Tabledit({
				url: '<?= base_url('jobs/aksiwewenang') ?>',
				inputClass: 'form-control input-sm',
				editButton: false,
				restoreButton: false,
				hideIdentifier: true,
				buttons: {
					delete: {
						class: 'btn btn-sm btn-circle btn-danger hapus',
						html: '<i class="fas fa-trash-alt"></i>',
						action: 'delete'
					},
					confirm: {
						class: 'btn btn-sm btn-danger',
						html: 'Yakin?'
					}
				},
				columns: {
					identifier: [0, 'id'],
					editable: [
						[1, 'kewenangan'],
						[2, 'wen_sendiri', '{"R": "R", "A": "A", "V": "V", "C": "C", "I": "I"}'],
						[3, 'wen_atasan1', '{"R": "R", "A": "A", "V": "V", "C": "C", "I": "I"}'],
						[4, 'wen_atasan2', '{"R": "R", "A": "A", "V": "V", "C": "C", "I": "I"}']
					]
				},
				onSuccess: function(data, textStatus, jqXHR) {
					if (data == 'delete') {
						$('.tabledit-deleted-row').remove();
					}
				},
				onAjax: function(action, serialize) {
					// open your xhr here 
					console.log("on Ajax");
					console.log("action : ", action);
					console.log("data : ", serialize);
				}
			});
		});

		// add wewenang baru
		$('#add-wewenang-baru').click(function() {
			let id = $(this).data('id');
			let wewenang = $('input[name="wewenang"]').val();
			let wen_sendiri = $('#wen_sendiri').val();
			let wen_atasan1 = $('#wen_atasan1').val();
			let wen_atasan2 = $('#wen_atasan2').val();

			console.log(wewenang);
			console.log(wen_sendiri);
			console.log(wen_atasan1);
			console.log(wen_atasan2);

			if(wewenang == ""){
				Swal.fire(
					'Error!',
					'Wewenang tidak boleh kosong!',
					'error'
				)
			}else{
				$.ajax({
					url: '<?= base_url('jobs/addwen') ?>',
					data: {
						id: id,
						wewenang: wewenang,
						wen_sendiri: wen_sendiri,
						wen_atasan1: wen_atasan1,
						wen_atasan2: wen_atasan2
					},
					method: "POST",
					success: function(data) {
						location.reload();

						// swal.fire(
                        //     'Berhasil!',
                        //     'Data Berhasil Dimasukkan!<br>Halaman sedang direfresh ulang...',
                        //     'success'
                        // )
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 2000);
					}
				});
			}
		});


		// start hub_kerja
		const flashjobs = $(".flash-jobs").data("flashdata");
		if (flashjobs) {
			Swal.fire({
				title: "Data",
				text: "Success " + flashjobs,
				type: "success",
				animation: false,
				customClass: {
					popup: "animated jackInTheBox"
				}
			});
		}


		$('.edit-hubInt').on('click', function() {
			$("div[class~='hubIntData']").hide();
			$('#cke_hubInt').fadeIn().focus();
			$('.simpanhubInt').fadeIn();
			$('.batalhubInt').fadeIn();
		});
		// ------------------------------aksi hub int ----------------//
		$('.simpanhubInt').on('click', function() {
			const hubInt = CKEDITOR.instances['hubInt'].getData();
			const id = $(this).data('id');
			var tipe = 'internal';
			$.ajax({
				url: "<?php echo base_url('jobs/edithub'); ?>",
				data: {
					id: id,
					hubInt: hubInt,
					tipe: tipe
				},
				method: 'POST',
				success: function(data) {
					$("div[class~='hubIntData']").html(hubInt).fadeIn();
					$('#cke_hubInt').hide();
					$('.simpanhubInt').hide();
					$('.batalhubInt').hide();
					Swal.fire(
						'Berhasil!',
						'Data Berhasil Diubah!',
						'success'
					)
				}
			})
		});

		$('.batalhubInt').on('click', function() {
			$("div[class~='hubIntData']").fadeIn();
			$('#cke_hubInt').hide();
			$('.simpanhubInt').hide();
			$('.batalhubInt').hide();
		});
		//endhubint

		$('.edit-hubEks').on('click', function() {
			$("div[class~='hubEksData']").hide();
			$('#cke_hubEks').fadeIn().focus();
			$('.simpanhubEks').fadeIn();
			$('.batalhubEks').fadeIn();
		});

		//////////////////////////////// aksi hub eks //////////////////////////////////
		$('.simpanhubEks').on('click', function() {
			const hubEks = CKEDITOR.instances['hubEks'].getData();
			const id = $(this).data('id');
			var tipe = 'eksternal';
			$.ajax({
				url: "<?php echo base_url('jobs/edithub'); ?>",
				data: {
					id: id,
					hubEks: hubEks,
					tipe: tipe
				},
				method: 'POST',
				success: function(data) {
					$("div[class~='hubEksData']").html(hubEks).fadeIn();
					$('#cke_hubEks').hide();
					$('.simpanhubEks').hide();
					$('.batalhubEks').hide();
					Swal.fire(
						'Berhasil!',
						'Data Berhasil Diubah!',
						'success'
					)
				}
			})
		});

		$('.batalhubEks').on('click', function() {
			$("div[class~='hubEksData']").fadeIn();
			$('#cke_hubEks').hide();
			$('.simpanhubEks').hide();
			$('.batalhubEks').hide();
		});

		/* aksi untuk tambah hubungan eksternal dan internal baru */
		$('#simpan-hubungan-baru').click(function() {
			const id = $(this).data('id');
			const internal = CKEDITOR.instances['internal'].getData();
			const eksternal = CKEDITOR.instances['eksternal'].getData();
			$.ajax({
				url: "<?= base_url('jobs/addHubungan'); ?>",
				data: {
					id: id,
					internal: internal,
					eksternal: eksternal
				},
				method: "POST",
				success: function(data) {
					location.reload();

					// swal.fire(
					// 	'Berhasil!',
					// 	'Data Berhasil Dimasukkan!<br>Halaman sedang direfresh ulang...',
					// 	'success'
					// 	);
					// setTimeout(function() {
					// 	location.reload();
					// }, 2000);
				}
			});
		});

		//start jumlah staff
		$('document').ready(function() {
			function hitung() {
				mgr = parseInt($("#totMgr").val());
				spvr = parseInt($("#totSpvr").val());
				staf = parseInt($("#totStaf").val());
				total = 0;

				if (isNaN(mgr)) mgr = 0;
				if (isNaN(spvr)) spvr = 0;
				if (isNaN(staf)) staf = 0;

				total = mgr + spvr + staf;
				$(".jumTotStaff").html(total);
			};

			$("#totMgr, #totSpvr, #totStaf").keyup(function() {
				hitung();
				$.ajax({
					url: "<?= base_url('jobs/updatestaff') ?>",
					data: {
						id_posisi: <?= $staff['id_posisi'] ?>,
						mgr: mgr,
						spvr: spvr,
						staf: staf
					},
					method: 'post',
					success: function(data) {
						console.log(data);
					}
				})
			});
		});


		// ---------------aksi tantangan---------------//
		$('.edit-tantangan').on('click', function() {
			$(this).hide();
			$("div[class~='view-tantangan']").hide();
			$('.editor-tantangan').slideDown("fast");
		});

		$('#simpan-tantangan').on('click', function() {
			const id = $(this).data('id');
			const tantangan = CKEDITOR.instances['tantangan'].getData();
			$.ajax({
				url: "<?php echo base_url('jobs/edittantangan'); ?>",
				data: {
					id: id,
					tantangan: tantangan
				},
				method: "POST",
				success: function(data) {
					$('.edit-tantangan').fadeIn();
					$("div[class~='view-tantangan']").html(tantangan).fadeIn(2000);
					$('.editor-tantangan').hide();
					Swal.fire(
						'Berhasil!',
						'Data Berhasil Diubah!',
						'success'
					)
				}
			});
		});

		$('#simpan-tantangan_baru').click(function() {
			const id = $(this).data('id');
			const tantangan = CKEDITOR.instances['tantangan-baru'].getData();
			$.ajax({
				url: "<?= base_url('jobs/addtantangan'); ?>",
				data: {
					id: id,
					tantangan: tantangan
				},
				method: "POST",
				success: function(data) {
					location.reload();

					// swal.fire(
					// 	'Berhasil!',
					// 	'Data Berhasil Dimasukkan!<br>Halaman sedang direfresh ulang...',
					// 	'success'
					// )
					// setTimeout(function() {
					// 	location.reload();
					// }, 2000);
				}
			});
		});

		$('.batal-edit-tantangan').on('click', function() {
			$('.edit-tantangan').fadeIn();
			$("div[class~='view-tantangan']").fadeIn(500);
			$('.editor-tantangan').hide();
		});

		// --------------aksi kualifikasi----------------//
		$('.edit-kualifikasi').on('click', function() {
			const id = $(this).data('id');
			$.ajax({
				url: '<?= base_url('jobs/getKualifikasiById') ?>',
				data: {
					id: id
				},
				method: 'post',
				dataType: 'json',
				success: function(data) {
					$('#pend').val(data.pendidikan);
					$('#pengalmn').val(data.pengalaman);
					$('#pengtahu').val(data.pengetahuan);
					$('#kptnsi').val(data.kompetensi);
				}
			});
		});

		$('#save-kualifikasi').on('click', function() {
			var id_posisi = $('#id').val();
			var pendidikan = $('#pend').val();
			var pengalaman = $('#pengalmn').val();
			var pengetahuan = $('#pengtahu').val();
			var kompetensi = $('#kptnsi').val();
			$.ajax({
				url: '<?= base_url('jobs/updateKualifikasi') ?>',
				data: {
					id_posisi: id_posisi,
					pendidikan: pendidikan,
					pengalaman: pengalaman,
					pengetahuan: pengetahuan,
					kompetensi: kompetensi
				},
				method: 'post',
				success: function(data) {

					$('td#pendidikan').html(pendidikan)
					$('td#pengalaman').html(pengalaman)
					$('td#pengetahuan').html(pengetahuan)
					$('td#kompetensi').html(kompetensi)

					$('.close').click();
					Swal.fire(
						'Berhasil!',
						'Data Berhasil Diubah!',
						'success'
					);
				}
			});
		});

		$('#simpan-kualifikasi-baru').click(function() {
			const id_posisi = $('#id').val();
			const pendidikan = $('#pend').val();
			const pengalaman = $('#pengalmn').val();
			const pengetahuan = $('#pengtahu').val();
			const kompetensi = $('#kptnsi').val();

			//cek jika salah satu form ada yang kosong
			if(pendidikan != "" && pengalaman != "" && pengetahuan != "" && kompetensi != ""){
				$.ajax({
					url: '<?= base_url('jobs/addkualifikasi') ?>',
					data: {
						id_posisi: id_posisi,
						pendidikan: pendidikan,
						pengalaman: pengalaman,
						pengetahuan: pengetahuan,
						kompetensi: kompetensi
					},
					method: 'POST',
					success: function(data){
						location.reload();

						// swal.fire(
						// 	'Berhasil!',
						// 	'Data Berhasil Dimasukkan!<br>Halaman sedang direfresh ulang...',
						// 	'success'
						// )
						// setTimeout(function() {
						// 	location.reload();
						// }, 2000);
					}
				});
			} else {
				swal.fire(
					'Ada data yang masih kosong',
					'Harap isi form kualifikasi dan pengalaman dengan lengkap!',
					'error'
				);
			}
		});

		// --------------aksi jenjang karir----------------//
		$('.edit-jenjang').on('click', function() {
			$(this).hide();
			$("div[class~='view-jenjang']").hide();
			$('.editor-jenkar').fadeIn(1000);
		});

		$('#simpan-jenjang').on('click', function() {
			const id = $(this).data('id');
			const jenkar = CKEDITOR.instances['jenkar'].getData();
			$.ajax({
				url: "<?php echo base_url('jobs/editjenjang'); ?>",
				data: {
					id: id,
					jenkar: jenkar
				},
				method: "POST",
				success: function(data) {
					$('.edit-jenjang').fadeIn();
					$("div[class~='view-jenjang']").html(jenkar).fadeIn(1000);
					$('.editor-jenkar').hide();
					Swal.fire(
						'Berhasil!',
						'Data Berhasil Diubah!',
						'success'
					)
				}
			});
		});

		$('#simpan-jenk-baru').click(function() {
			const id = $(this).data('id');
			const jenkar = CKEDITOR.instances['jenkar'].getData();
			$.ajax({
				url: "<?= base_url('jobs/addjenjangkarir'); ?>",
				data: {
					id: id,
					jenkar: jenkar
				},
				method: "POST",
				success: function(data){
					location.reload();
					
					// swal.fire(
					// 	'Berhasil!',
					// 	'Data Berhasil Dimasukkan!<br>Halaman sedang direfresh ulang...',
					// 	'success'
					// )
					// setTimeout(function() {
					// 	location.reload();
                    // }, 2000);
				},
				fail: function(data){
					swal.fire(
						'ERROR!',
						'Data tidak berhasil dimasukkan!<br/>Silakan cek form jenjang karir anda',
						'error'
					);
				}
			});
		});

		$('.batal-edit-jenjang').on('click', function() {
			$('.edit-jenjang').fadeIn();
			$("div[class~='view-jenjang']").fadeIn(500);
			$('.editor-jenkar').hide();
		});
		// ---------------end jenjang karir---------------///

		$('.custom-file-input').on('change', function() {
			let filename = $(this).val().split('\\').pop();
			$(this).next('.custom-file-label').addClass("selected").html(filename);
		});

		$('.form-check-input').on('click', function() {
			const menuId = $(this).data('menu');
			const roleId = $(this).data('role');

			$.ajax({
				url: "<?= base_url('admin/changeaccess'); ?>",
				type: 'post',
				data: {
					menuId: menuId,
					roleId: roleId
				},
				success: function() {
					document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
				}
			});
		});

		//tombol buat submit Job Profile
		$('.btnApprove').on('click', function() {
			const nik = $(this).data('mynik');
			const id_posisi = $(this).data('position');
			const atasan1 = $(this).data('atasan1');
			const atasan2 = $(this).data('atasan2');

			// console.log(valid_tujuanjabatan);
			// console.log(valid_ruangl);
			// console.log(valid_tu_mu);
			// console.log(valid_kualifikasi);
			// console.log(valid_jenk);
			// console.log(valid_hub);
			// console.log(valid_tgjwb);
			// console.log(valid_wen);
			// console.log(valid_atasan);

			if(	valid_tujuanjabatan == "fill" &&
				valid_ruangl == "fill" && 
				valid_tu_mu == "fill" &&
				valid_kualifikasi == "fill" &&
				valid_jenk == "fill" &&
				valid_hub == "fill" &&
				valid_tgjwb == "fill" &&
				valid_wen == "fill" &&
				valid_atasan == "fill"
				)	{ //validator Job Profile, variabelnya ada di file ../application/views/jobs/jp_editor.php

						$('#submit-modal').modal('hide'); //hide modal submit
						Swal.fire(
							'Job Profile anda sudah lengkap',
							'Terima kasih sudah mengisi Job Profile anda, berikutnya Job Profile akan di-<i>review</i> oleh approver 1 anda.<br/><br/><small>mengarahkan anda kembali ke halaman index JP...</small>',
							'success'
						);
						
						setTimeout(function() { //nunggu waktu 2 detik lalu set approve status
							$.ajax({
								url: "<?= base_url('jobs/setApprove') ?>",
								type: 'post',
								data: {
									nik: nik,
									id_posisi: id_posisi,
									atasan1: atasan1,
									atasan2: atasan2
								},
								success: function(data) {
									console.log(data);
									// location.reload();
									document.location.href = "<?= base_url('jobs'); ?>";
								},
								fail: function() {
									console.log('fail');
								}
							});		
						}, 3000);
					} else {
						$('#submit-modal').modal('hide');// hide modal submit
						swal.fire(
							'Error',
							'Harap isi semua data Job Profile!',
							'error'
						);
					}
		});

		//scroll ke atas jika submit modal ketutup, modal ada di ../application/view/jobs/myjp.php
		$('#submit-modal').on('hidden.bs.modal', function (e) {
			$('html, body').animate({scrollTop:(0)}, '2000');
		});

		//replace input text with CKEDITOR
		/* add setting like this if enter scrolled page to bottom
		CKEDITOR.replace( 'editor1', {
			enterMode: CKEDITOR.ENTER_BR
		} ); 
		*/
		CKEDITOR.replace('tujuan_jabatan', {
			width: 800
		});
		CKEDITOR.replace('hubInt', {
			width: 400,
			height: 100
		});
		CKEDITOR.replace('hubEks', {
			width: 400,
			height: 100
		});
		CKEDITOR.replace('aUtm-text');
		CKEDITOR.replace('pgkrn-text');
		CKEDITOR.replace('tantangan', {
			width: 500
		});
		CKEDITOR.replace('jenkar', {
			enterMode: CKEDITOR.ENTER_BR
		});
		CKEDITOR.replace('internal', {
			enterMode: CKEDITOR.ENTER_BR
		});
		CKEDITOR.replace('eksternal', {
			enterMode: CKEDITOR.ENTER_BR
		});
		CKEDITOR.replace('add-ruangl', {
			enterMode: CKEDITOR.ENTER_BR
		});
		CKEDITOR.replace('ruang', {
			width: 500
		});
		CKEDITOR.replace('tujuan');
		CKEDITOR.replace('tujuanbaru', {
			enterMode: CKEDITOR.ENTER_BR
		});
		CKEDITOR.replace('tantangan-baru', {
			enterMode: CKEDITOR.ENTER_BR
		});

		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
			$('.nTgjwb').tooltip();
			$('.eTgjwb').tooltip();
			$('.hapusJobs').tooltip();
			$('.edit-kualifikasi').tooltip();
		});

		$('#departemen-table').DataTable();

	});

$(document).ready(function() { //buat nyembunyiin menu user
    $('a[data-target="#collapseUser"]').addClass('d-none');
});
</script>

</body>

</html>
