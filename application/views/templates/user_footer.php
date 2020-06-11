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
<script src="<?= base_url('assets/'); ?>js/myscript.js"></script>
<script src="<?= base_url('assets/'); ?>js/scriptmodal.js"></script>

<!-- jquery validate plugin -->
<script src="<?= base_url('assets/'); ?>vendor/jquery-validate/jquery-validate.js"></script>

<script>
$('.custom-file-input').on('change', function() {
    let filename = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(filename);
});

$('#changePassword_form').validate({
    rules: {
        current_password:{
            required: true,
            minlength: 8
        },
        new_password1:{
            required: true,
            minlength: 8
        },
        new_password2:{
            required: true,
            minlength: 8
        }
    },
    messages:{
        current_password: {
            required: "Silakan password anda.",
            minlength: jQuery.validator.format("Password seharusnya memiliki minimal {0} karakter!")
        },
        new_password1: {
            required: "Silakan masukkan password baru anda.",
            minlength: jQuery.validator.format("Password seharusnya memiliki minimal {0} karakter!")
        },
        new_password2:{
            required: "Silakan masukkan password baru anda sekali lagi.",
            minlength: jQuery.validator.format("Password seharusnya memiliki minimal {0} karakter!")
        }
    }
});

$('#submitPassword').click(function(event){
    event.preventDefault(); // prevent default action

    console.log($('input[name="current_password"]').val());

    if($('input[name="new_password1"]').val() != $('input[name="new_password2"]').val()){
        $('input[name="new_password2"]').after('<small class="text-danger">Password yang diinput tidak sama.</small>');
    }
});


$('.menu-access').on('click', function() {
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

$('.surat-access').on('click', function() {
    const suratId = $(this).data('surat');
    const roleId = $(this).data('role');

    $.ajax({
        url: "<?= base_url('admin/changesurataccess') ?>",
        type: 'post',
        data:{
            suratId: suratId,
            roleId: roleId
        },
        success: function () {
            document.location.href = "<?= base_url('admin/roleAccessDoc/') ?>" + roleId;
        }
    });
});
</script>

</body>

</html>
