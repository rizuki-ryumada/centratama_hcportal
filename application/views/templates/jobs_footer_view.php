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

$(document).ready(function() { //buat nyembunyiin menu user
    $('a[data-target="#collapseUser"]').addClass('d-none');
});
</script>

</body>

</html>
