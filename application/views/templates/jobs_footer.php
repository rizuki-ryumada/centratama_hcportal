<!-- Footer -->
<footer class="sticky-footer bg-white">
	<div class="container my-auto">
		<div class="copyright text-center my-auto">
			<span>Copyright &copy; CentratamaGroup <?= date('Y'); ?> </span>
		</div>
	</div>
</footer>
<!-- End of Footer -->

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
		$('.hapusJobs').on('click', function(e) {
			e.preventDefault();
			const href = $(this).attr("href");
			Swal.fire({
				title: "Yakin Ingin Menghapus?",
				text: "Aksi ini akan menghapus data secara permanen!",
				type: "danger",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Ya!",
				cancelButtonText: "Batal!"
			}).then(result => {
				if (result.value) {
					document.location.href = href;
				}
			});
		})

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
				$('.modal-body form').attr('action', '<?= base_url('jobs/addtanggungjawab') ?>');
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
					if (data === '<b>-</b>') {
						$("div[class~='view-ruang']").html(data).fadeIn(1000);
					} else {
						$("div[class~='view-ruang']").html(ruang).fadeIn(1000);
					}
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
				}
			});
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
			})
		})

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

		$('.btnApprove').on('click', function() {
			const nik = $(this).data('mynik');
			const id_posisi = $(this).data('position');
			const atasan1 = $(this).data('atasan1');
			const atasan2 = $(this).data('atasan2');

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
		});

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
			width: 500
		});
		CKEDITOR.replace('internal', {
			width: 500
		});
		CKEDITOR.replace('eksternal', {
			width: 500
		});
		CKEDITOR.replace('ruangl', {
			width: 500
		});
		CKEDITOR.replace('ruang', {
			width: 500
		});
		CKEDITOR.replace('tujuan');

		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
			$('.nTgjwb').tooltip();
			$('.eTgjwb').tooltip();
			$('.hapusJobs').tooltip();
			$('.edit-kualifikasi').tooltip();
		});

		$('#departemen-table').DataTable();

	});

	
</script>

</body>

</html>
