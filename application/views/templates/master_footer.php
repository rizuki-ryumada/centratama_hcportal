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
<!-- <script src="<?= base_url('assets/'); ?>vendor/bootstrap-toogle/js/bootstrap-toggle.min.js"></script> -->

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- jquery validate plugin -->
<script src="<?= base_url('assets/'); ?>vendor/jquery-validate/jquery-validate.js"></script>

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
    
    // tombol edit employe
    $('.editEmp').click(function() {
        $.ajax({
            url: '<?= base_url('master/') ?>getEmployeDetailsAjax',
            data: {
                nik: $(this).data('nik')
            },
            method: 'POST',
            success: function(data){
                data = JSON.parse(data)
                $('#editEmployeModal').modal('show'); //menampilkan modal

                $('input[id="nik_edit"]').val(data.nik);
                $('input[name="onik"]').val(data.nik); // buat ditaruh di form origin NIK
                $('input[id="name_edit"]').val(data.emp_name);
                $('input[id="departemen_edit"]').val(data.departemen);
                $('input[id="position_edit"]').val(data.position_name);
                $('input[id="email_edit"]').val(data.email);

                // tambah option divisi
                // $('.div').empty(); //hapus dulu optionnya
                // $.each(data.divisi, function(i, v){
                //     $('.div').append('<option value="div-' + v.id + '">' + v.division + '</option>') //tambah 1 per 1 option
                // });
                $('#div_edit').val('div-' + data.div_id); //select value option dari data employe
                // tambah option entity
                // $('.entity').empty(); //hapus optionnya
                // $.each(data.entity, function(i, v){
                //     $('.entity').append('<option value="'+ v.id +'">'+ v.nama_entity +' | '+ v.keterangan +'</option>') //tambah 1 per satu option
                // });
                $('#entity_edit').val(data.id_entity); //select value option sesuai dari data employe

                //  tambah option role
                // $('.role').empty(); // kosongkan dulu optionnya
                // $.each(data.role, function(i, v){
                //     $('.role').append('<option value="'+ v.id +'">'+ v.role +'</option>'); // tambah 1 per 1 option
                // });
                $('#role_edit').val(data.role_id); // select value optiondari data employe

                // role surat
                if(data.akses_surat_id == 1){
                    $('input[id="role_surat_edit"]').prop('checked', true);
                } else {
                    $('input[id="role_surat_edit"]').prop('checked', false);
                }

                // is_active aktif karyawan
                if(data.is_active == 1){
                    $('input[id="is_active_edit"]').prop('checked', true);
                } else {
                    $('input[id="is_active_edit"]').prop('checked', false);
                }
            }
        });
        

    });
    
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
    
    // deklarasi datatables
    mTable = $('#departemen-table, #divisi-table, #employe-table').DataTable({
        "lengthMenu": [25, 50, 75, 100] ,
        "pageLength": 25
    });
    
    //filter table dengan DOM untuk divisi dan departemen
    $('#divisi').change(function(){
        mTable.column(3).search(this.value).draw();// filter kolom divisi
        mTable.column(4).search('').draw();// hapus filter kolom departemen
        mTable.order([4, 'asc']).draw(); // order berdasarkan kolom departemen
    });
    $('#departement').change(function(){
        mTable.column(4).search(this.value).order([4, 'asc']).draw(); 
    });
    $('#divisi').change(function(){
        var dipilih = $(this).val(); //ambil value dari yang terpilih
        
        if(dipilih == ""){
            mTable.column(4).search(dipilih).draw(); //kosongkan filter dom departement
            mTable.column(3).search(dipilih).draw(); //kosongkan filter dom departement
            mTable.order([0, 'asc']).draw();
        }
        
        $.ajax({
            url: "<?php echo base_url('master/getdepartement'); ?>",
            data: {
                divisi: dipilih //kirim ke server php
            },
            method: "POST",
            success: function(data) { //jadi nanti dia balikin datanya dengan variable data
                $('#departement').empty().append('<option value="">All</option>'); //kosongkan selection value dan tambahkan satu selection option
                
                $.each(JSON.parse(data), function(i, v) {
                    $('#departement').append('<option value="dept-' + v.id + '">' + v.nama_departemen + '</option>'); //tambahkan 1 per 1 option yang didapatkan
                });
            }
        })
    });

    /* -------------------------------------------------------------------------- */
    /*                      Mapping buat di editEmployeModal                      */
    /* -------------------------------------------------------------------------- */
    // mapping divisi select option untuk departemen
    $('#div_edit').change(function(){
        var dipilih = $(this).val(); //ambil value dari yang terpilih
        $.ajax({
            url: "<?php echo base_url('master/getdepartement'); ?>",
            data: {
                divisi: dipilih //kirim ke server php
            },
            method: "POST",
            success: function(data) { //jadi nanti dia balikin datanya dengan variable data
                $('input[id="departemen_edit"]').hide();
                $('#dept_edit').empty().show(); //kosongkan selection value dan tambahkan satu selection option
                $('input[id="position_edit"]').show();
                $('#pos_edit').empty().hide(); //kosongkan selection value dan tambahkan satu selection option
                
                $('#dept_edit').append('<option value="">Pilih Departemen...</option>'); // add first option
                $.each(JSON.parse(data), function(i, v) {
                    $('#dept_edit').append('<option value="' + v.id + '">' + v.nama_departemen + '</option>'); //tambahkan 1 per 1 option yang didapatkan
                });
            }
        });
    });
    // mapping departemen select option untuk posisi
    $('#dept_edit').change(function(){
        $.ajax({
            url: "<?= base_url('master/getPositionsAjax') ?>",
            data: {
                div: $('#div_edit').val(),
                dept: $(this).val()
            },
            method: "POST",
            success: function(data) {
                $('input[id="position_edit"]').hide();
                $('#pos_edit').empty().show(); //kosongkan selection value dan tambahkan satu selection option

                $('#pos_edit').append('<option value="">Pilih Posisi...</option>'); // add first option
                $.each(JSON.parse(data), function(i, v) {
                    $('#pos_edit').append('<option value="' + v.id + '">' + v.position_name + '</option>'); //tambahkan 1 per 1 option yang didapatkan
                });
            }
        })
    });
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                      Mapping buat di tambahEmployeModal                    */
    /* -------------------------------------------------------------------------- */
    // mapping divisi select option untuk departemen
    $('#div_tambah').change(function(){
        var dipilih = $(this).val(); //ambil value dari yang terpilih
        $.ajax({
            url: "<?php echo base_url('master/getdepartement'); ?>",
            data: {
                divisi: dipilih //kirim ke server php
            },
            method: "POST",
            success: function(data) { //jadi nanti dia balikin datanya dengan variable data
                $('input[id="departemen_tambah"]').hide();
                $('#dept_tambah').empty().show(); //kosongkan selection value dan tambahkan satu selection option
                $('input[id="position_tambah"]').show();
                $('#pos_tambah').empty().hide(); //kosongkan selection value dan tambahkan satu selection option
                
                $('#dept_tambah').append('<option value="">Pilih Departemen...</option>'); // add first option
                $.each(JSON.parse(data), function(i, v) {
                    $('#dept_tambah').append('<option value="' + v.id + '">' + v.nama_departemen + '</option>'); //tambahkan 1 per 1 option yang didapatkan
                });
            }
        });
    });
    // mapping departemen select option untuk posisi
    $('#dept_tambah').change(function(){
        $.ajax({
            url: "<?= base_url('master/getPositionsAjax') ?>",
            data: {
                div: $('#div_tambah').val(),
                dept: $(this).val()
            },
            method: "POST",
            success: function(data) {
                $('input[id="position_tambah"]').hide();
                $('#pos_tambah').empty().show(); //kosongkan selection value dan tambahkan satu selection option

                $('#pos_tambah').append('<option value="">Pilih Posisi...</option>'); // add first option
                $.each(JSON.parse(data), function(i, v) {
                    $('#pos_tambah').append('<option value="' + v.id + '">' + v.position_name + '</option>'); //tambahkan 1 per 1 option yang didapatkan
                });
            }
        })
    });
    /* -------------------------------------------------------------------------- */


    // fungsi ketika tambahEmployeModal dihidden
    $('#tambahEmployeModal, #editEmployeModal').on('hidden.bs.modal', function (e) {
        $('input[id="position_edit"], input[id="position_tambah"]').show();
        $('input[id="departemen_edit"], input[id="departemen_tambah"]').show();

        /* ---------------------------- reset form tambahEmploye --------------------------- */
        $("#div_tambah, #role_tambah, #entity_tambah").prop("selectedIndex", 0) //balikan seleksi option ke yg pertama
        $('input[id="is_active_tambah"], input[id="role_surat_tambah"]').prop('checked', false);
        /* -------------------------------------------------------------------------- */

        /* ------------- sembunyikan elemen select departemen dan posisi ------------ */
        $('.dept').hide();
        $('.pos').hide();

        $('#pos_tambah').empty().append('<option value="">Pilih Posisi...</option>').prop("selectedIndex", 0); //kosongkan selection value dan tambahkan satu selection option
        /* -------------------------------------------------------------------------- */
         
        $('input[type="password"]').val(""); //kosongkan input password
        $('#role_add').val('3'); // set default selected role to user di modal tambahEmployeModal ke USER
        $('*').validate().resetForm(); // reset validator pada editEmployeForm
    });

    // set default selected role to user di modal tambahEmployeModal ke USER
    $('#role_add').val('3');

    // edit employe validator
    $('#editEmployeForm').validate({
        rules: {
            nik: {
                required: true,
                minlength: 8
            },
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                minlength: 8
            }
        },
        messages: {
            nik: {
                required: "Harap masukkan nik karyawan",
                minlength: "NIK seharusnya terdiri dari 8 karakter"
            },
            name: {
                required: "Harap masukkan nama karyawan",
            },
            email: {
                required: 'Silakan masukkan email karyawan.',
                email: 'Harap masukkan email yang valid (username@provider)'
            },
            password: {
                minlength: "Password harus memiliki minimal 8 karakter"
            }
        }
    });

    // tambah employe validator
    $('#tambahEmployeForm').validate({
            rules: {
                nik: {
                    required: true,
                    minlength: 8
                },
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                divisi:{
                    required: true
                },
                departemen: {
                    required: true
                },
                position: {
                    required: true
                },
                entity: {
                    required: true
                },
                role: {
                    required: true
                }
            },
            messages: {
                nik: {
                    required: "Harap masukkan nik karyawan.",
                    minlength: "NIK seharusnya terdiri dari 8 karakter."
                },
                name: {
                    required: "Harap masukkan nama karyawan.",
                },
                email: {
                    required: 'Silakan masukkan email karyawan.',
                    email: 'Harap masukkan email yang valid (username@provider.mail).'
                },
                password: {
                    required: "Silakan masukkan password untuk login.",
                    minlength: "Password harus memiliki minimal 8 karakter."
                },
                role: {
                    required: "Silakan pilih Role Karyawan."
                },
                entity: {
                    required: "Silakan pilih Entity Karyawan."
                }
            }
        });
    
    // $( "form" ).each( function() {
    //     $( this ).validate({
    //         rules: {
    //             nik: {
    //                 required: true,
    //                 minlength: 8
    //             },
    //             name: {
    //                 required: true
    //             },
    //             email: {
    //                 required: true,
    //                 email: true
    //             },
    //             password: {
    //                 required: true,
    //                 minlength: 8
    //             },
    //             divisi:{
    //                 required: true
    //             },
    //             departemen: {
    //                 required: true
    //             },
    //             position: {
    //                 required: true
    //             },
    //             entity: {
    //                 reqiured: true
    //             },
    //             role: {
    //                 required: true
    //             }
    //         },
    //         messages: {
    //             nik: {
    //                 required: "Harap masukkan nik karyawan.",
    //                 minlength: "NIK seharusnya terdiri dari 8 karakter."
    //             },
    //             name: {
    //                 required: "Harap masukkan nama karyawan.",
    //             },
    //             email: {
    //                 required: 'Silakan masukkan email karyawan.',
    //                 email: 'Harap masukkan email yang valid (username@provider.mail).'
    //             },
    //             password: {
    //                 required: "Silakan masukkan password untuk login.",
    //                 minlength: "Password harus memiliki minimal 8 karakter."
    //             }
    //         },
    //         submitHandler: function(form) {
    //             // do other things for a valid form
    //             form.submit();
    //         }
    //     });
    // } );

});

</script>

</body>

</html>
