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
var editFormDept = $('#edit-depform').hide();
var editFormDiv = $('#edit-divform').hide();

$(document).ready(function(){

    // Ini Adalah Aksi Edit Departemen

    $('.editDep').on('click' ,function(){
        $('#tambah-depform').slideUp();
        editFormDept.fadeIn(1000);
        const id = $(this).data('id');

        $.ajax({
            url: '<?= base_url('master'); ?>/getdepbyid',
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('.id-dept').val(data.id)
                $('#edit-departemen-name').val(data.nama_departemen);
                $('#edit-departemen-head').val(data.dep_head);
                $('#edit-div-id').val(data.div_id);
            }
        })
    });

    // Ini adalah aksi Divisi

    $('.editDiv').on('click' ,function(){
        $('#tambah-divform').slideUp();
        editFormDiv.fadeIn(1000);
        const id = $(this).data('id');

        $.ajax({
            url: '<?= base_url('master'); ?>/getdivbyid',
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('.id-div').val(data.id);
                $('#edit-divisi-name').val(data.division);
                $('#edit-divisi-head').val(data.nik_div_head);
            }
        })
    });

    $('.close').on('click', function(){
        $(this).closest('#edit-depform, #edit-divform').slideUp();
        $('#tambah-depform, #tambah-divform').fadeIn(1000);
    })

    const flashdata = $(".flash-data").data("flashdata");
    if (flashdata) {
        Swal.fire({
            title: "Good Jobs",
            text: "Data success " + flashdata,
            type: "success",
            animation: false,
            customClass: {
                popup : "animated jackInTheBox"
            }
        })
    }

});
$('#departemen-table, #divisi-table, #employe-table').DataTable({
    "lengthMenu": [25, 50, 75, 100] ,
    "pageLength": 25
});
</script>

</body>

</html>
