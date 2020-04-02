<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; CentratamaGroup <?= date('Y'); ?> </span>
        </div>
    </div>

    <div id="my_div" class="row"></div>
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

<!-- custom javascript -->
<script src="<?= base_url('assets/'); ?>js/ryu.js"></script>

<script>
//activate dataTable
$(document).ready(function () {
    var mTable = $('#myTask').DataTable({
        "select": true,
    });

    $('#divisi').change(function(){
        mTable.column(0).search(this.value).order([0, 'asc']).draw();
    });

    $('#departement').change(function(){
        mTable.column(1).search(this.value).order([1, 'asc']).draw();
    });

    $('#status').change(function(){
        mTable.column(4).search(this.value).order([4, 'asc']).draw();
    });
});



//if using ajax
// $(document).ready(function() {
//     var mTabel = $('#history').DataTable({
//         "processing": true,
//         "serverSide": true,
//         "searchable": true,
//         "orderable": true,
//         "select": true,
//         "ajax": {
//             "url"  : "<?= base_url('history/getHistoryApproval'); ?>",
//             "type" : "post",
//             "data" : function(data){ //parameter buat dibawa ke url ajax 
//                     data.divisi = $('#divisi').val();
//                     data.departement = $('#departement').val();
//                     data.status = $('#status').val();
//                 }
//         },
//         // "columnDefs": [
//         //     {
//         //         "targets": [0],
//         //         "orderable": true
//         //     }
//         // ]
//     });

//     // $('divisi').change(function(){
//     //     mTabel.ajax.reload();
//     // });

//     // $('divisi').change(function(){
//     //     mTabel.ajax.reload();
//     // });
// });

// create function Jquery
// (function( $ ){
//    $.fn.myfunction = function() {
//       alert('hello world');
//       return this;
//    }; 
// })( jQuery );

// $('#my_div').myfunction();

</script>

</body>
</html>