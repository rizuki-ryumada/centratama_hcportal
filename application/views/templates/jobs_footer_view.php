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

$(document).ready(function() { //buat nyembunyiin menu user
    $('a[data-target="#collapseUser"]').addClass('d-none');
});
</script>

</body>

</html>
