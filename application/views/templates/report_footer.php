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

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/swall/sweetalert2.all.min.js"></script>

<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

<script>
$(document).ready(function() {
    $(document).on('change', '#divisi', function() {
        let div_id = $(this).val();
            $.ajax({
                url: '<?= base_url('master/getDeptAjax') ?>',
                type: 'POST',
                async: false,
                dataType: 'json',
                data: {
                    div_id: div_id
                },
                success: function(data) {
                    if (data != '') {
                        let option = "";
                        let i;
                        let div_id = $('#divisi').val();
                        for (i = 0; i < data.length; i++) {
                            option += '<option value=' + data[i].nama_departemen + '>' + data[i].nama_departemen + '</option>';
                        }
                        $('#departemen').html("<option selected value=''>All</option>" +option);
                    }

                }
            });
    });
});

var mTable;

$(document).ready(function(){
    mTable = $('#myTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax":{
            "url": "<?= base_url('reportjobs/getreport') ?>",
            "type": 'post',
            "data": function(data){
                data.divisi = $('#divisi').val();
                data.departemen = $('#departemen').val();
                }
                },
        "columnDefs": [
            { 
                "targets": [ 0 ], //first column / numbering column
                "orderable": true //set not orderable
            }
        ]
    });

    $('#divisi').change(function() {
        mTable.ajax.reload();
    });
    $('#departemen').change(function() {
        mTable.ajax.reload();
    })
});

$(document).ready(function() {
    nTable = $('#table-nomor').DataTable({
        "autoWidth" : true,
        "processing" : true,
		"language" : { processing: '<div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div>'},
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url('surat/ajax_no') ?>",
            "type": "post",
            "data": function(data){
                data.jenis_surat = $('#jenis-surat').val();
            }
        },
        "columnDefs": [
            { "width": "185px", "targets": [0], "orderable": true },
            { "width": "185px", "targets": [1], "orderable": true },
            { "width": "100px", "targets": [2], "orderable": true },
            { "width": "120px", "targets": [3], "orderable": true },
            { "width": "185px", "targets": [4], "orderable": true },
            { "width": "150px", "targets": [5], "orderable": true }
        ]
    });

    $('#jenis-surat').change(function(){
        nTable.ajax.reload();
    })
})


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

$(document).ready(function() {
	$("#jenis").change(function() {
		var id = $(this).val();

		$.ajax({
			url: "<?= base_url('surat/getSub') ?>",
			method: "POST",
			data: {
				jenis: id
			},
			async: true,
			dataType: "json",
			success: function(data) {
				var html = "";
				var i;
				for (i = 0; i < data.length; i++) {
					html +=
						"<option value=" +
						data[i].tipe_surat +
						">" +
						data[i].tipe_surat +
						"</option>";
				}
				$("#tipe").html(html);
			}
		});
		return false;
	});
});



$(document).ready(function() {
	$("#entity").change(function() {
		var entity = $("#entity").val();
		var jenis = $("#jenis").val();
		var sub = $("#tipe").val();
		var isi = "";

		$.ajax({
			url: "<?= base_url('surat/lihatnomor') ?>",
			method: "POST",
			data: {
				jenis : jenis,
				entity: entity,
				sub: sub
			},
			async: true,
			dataType: "json",
			success: function(data) {
				isi =
					data.no +
					"/" +
					data.entity +
					"-HC/" +
					data.sub +
					"/" +
					data.bulan +
					"/" +
					data.tahun;
				$(".hasil").val(isi);
			}
		});
	});
});
</script>

</body>

</html>