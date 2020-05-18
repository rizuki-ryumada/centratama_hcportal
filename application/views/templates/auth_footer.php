    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- jquery validate plugin -->
    <script src="<?= base_url('assets/'); ?>vendor/jquery-validate/jquery-validate.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

    </body>

    <script>
        $('#loginForm').validate({
            rules: {
                nik: {
                    required: true,
                    minlength: 8
                },
                password:{
                    required: true,
                    minlength: 8
                }
            },
            messages:{
                nik:{
                    required: "Silakan masukkan NIK anda",
                    minlength: jQuery.validator.format("NIK anda harus minimal {0} karakter!")
                },
                password: {
                    required: "Silakan masukkan password anda",
                    minlength: jQuery.validator.format("Password seharusnya memiliki minimal {0} karakter!")
                }
            }
        });

        $(document).ready(function() {
            if(<?= $this->session->userdata('error'); ?> == 1){
                $('#loginModal').modal('show');
            };
        });
    </script>

    <?php $this->session->unset_userdata('error'); ?>
    </html>