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

<!-- <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script> -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

<!-- custom javascript -->
<script src="<?= base_url('assets/'); ?>js/ryu.js"></script>

<script>
//activate dataTable
$(document).ready(function () {
    var mTable = $('#myTask').DataTable({
        'dom': 'Bfrtip',
        'buttons': [
            {
                extend: 'excel',
                text: 'Export to Excel',
                title: '',
                filename: 'Report Job Profile-<?= date("dmo-Hi"); ?>',
                exportOptions: {
                    modifier: {
                        //Datatables Core
                        order: 'index',
                        page: 'all',
                        search: 'none'
                    },
                    columns: [0,1,2,3,4]
                }
            }
        ]
    });

    //filter table dengan DOM
    $('#divisi').change(function(){
        mTable.column(0).search(this.value).order([0, 'asc']).draw();// filter kolom pertama
        mTable.column(4).search('').order([4, 'asc']).draw();// hapus filter kolom ke 5
        mTable.column(1).search('').order([1, 'asc']).draw();// hapus filter kolom kedua
        $('#status').prop('selectedIndex',0);// kembalikan status ke default
    });
    $('#departement').change(function(){
        mTable.column(1).search(this.value).order([1, 'asc']).draw();
        mTable.column(4).search('').order([4, 'asc']).draw();
        $('#status').prop('selectedIndex',0);
    });
    $('#status').change(function(){
        mTable.column(4).search(this.value).order([4, 'asc']).draw();
    });

    //mapping untuk pilihan departemen, supaya dapat tampil sesuai dengan divisi yang dipilih
    $('#divisi').change(function(){
        var dipilih = $(this).val(); //ambil value dari yang terpilih

        if(dipilih == ""){
            mTable.column(1).search(dipilih).order([1, 'asc']).draw(); //kosongkan filter dom departement
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

    $('#myTask').on('change', '.status_approval', function() {
        let id = $(this).data('id');
        let value = $(this).find("option:selected").val();

        if(value == 0){
            console.log('Need to be Submitted');
            $('.status_approval[data-id='+id+']').css('background-color', 'red');
            $('.status_approval[data-id='+id+']').css('color', 'white');
        }else if(value == 1){
            console.log('Submitted');
            $('.status_approval[data-id='+id+']').css('background-color', 'yellow');
            $('.status_approval[data-id='+id+']').css('color', 'black');
        }else if(value == 2){
            console.log('first Approval');
            $('.status_approval[data-id='+id+']').css('background-color', 'yellow');
            $('.status_approval[data-id='+id+']').css('color', 'black');
        }else if(value == 3){
            console.log('Need to be revised');
            $('.status_approval[data-id='+id+']').css('background-color', 'orange');
            $('.status_approval[data-id='+id+']').css('color', 'white');
        }else if(value == 4){
            console.log('Final Approval');
            $('.status_approval[data-id='+id+']').css('background-color', 'green');
            $('.status_approval[data-id='+id+']').css('color', 'white');
        }

        $.ajax({
            url: '<?= base_url('job_profile/setStatusApproval') ?>',
            data: {
                id: id,
                status_approval: value
            },
            method: "POST",
            success: function(data) {
                Swal.fire(
                    'Berhasil!',
                    'Status Approval berhasil diubah.',
                    'success'
                );
            },
            error: function(data) {
                Swal.fire(
                    'ERROR!',
					'ERRRRRRROR',
					'error'
                );
            }
        });
        // console.log(id);
        // console.log(value);
    });

    $('#myTask').on('click', '.sendNotification', function() {
        let id_posisi = $(this).data('id');
        let nik = $(this).data('nik');

        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Anda akan mengirimkan email notifikasi ke karyawan yang berada di posisi ini.",
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('job_profile/sendNotification') ?>',
                    data: { 
                        id_posisi: id_posisi,
                        nik: nik
                    },
                    method: 'POST',
                    beforeSend: function(data) {
                        Swal.fire({
                            title: 'Harap Tunggu...',
                            html: 'Mengirim email ke karyawan pada posisi ini...',
                            allowOutsideClick: false,
                            // allowEscapeKey: false,
                            // timerProgressBar: true,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function(data) {
                        if (data == ""){
                            Swal.fire(
                                'Tidak Terkirim!',
                                'Posisi ini tidak memiliki karyawan.',
                                'error'
                            );
                        } else {
                            Swal.close();
                            console.log(data);
                            Swal.fire(
                                'Terkirim!',
                                'Email notifikasi telah dikirimkan ke karyawan.',
                                'success'
                            );
                        }
                    },
                    error: function(data){
                        Swal.close();
                        console.log(data);
                        let error = JSON.parse(data.responseText);
                        Swal.fire(
                            error.header,
                            error.txtStatus,
                            'error'
                        );
                    }
                });
            } else {
                Swal.fire(
                    'Tidak Terkirim!',
                    'Email notifikasi tidak dikirimkan.',
                    'error'
                );
            }
        });

        

    });

    $('.sendNotificatiOnStatus').click(function(){
        let status = $(this).data('status');

        if(status == 0){
            statusText = "<b class='badge badge-danger'>Need To Submit<b/>";
        } else if(status == 1 || status == 2){
            statusText = "<b class='badge badge-warning text-dark'>Need Approval<b/>";
        } else if(status == 3){
            statusText = "<b class='badge badge-info'>Need Revise<b/>";
        } else if(status == 4){
            statusText = "<b class='badge badge-success'>Approved<b/>";
        }

        Swal.fire({
            title: 'Apa anda yakin?',
            html: "Anda akan mengirimkan email notifikasi ke posisi dengan status " + statusText + ". <br/><br/><b class='badge badge-warning text-dark'>Proses ini akan memakan waktu lama.</b>",
            icon: 'warning',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }). then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('job_profile/sendNotificatiOnStatus') ?>',
                    data: {
                        status: status
                    },
                    method: 'POST',
                    beforeSend: (data) => { //sama kayak beforeSend: function(data){}
                    Swal.fire({
                            title: 'Harap Tunggu...',
                            html: 'Mengirim email ke karyawan pada posisi ini...',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: (data) => {
                        if (data == ""){
                            Swal.fire(
                                'Tidak Terkirim!',
                                'Posisi ini tidak memiliki karyawan.',
                                'error'
                            );
                        } else {
                            Swal.close();
                            console.log(data);
                            Swal.fire(
                                'Terkirim!',
                                'Email notifikasi telah dikirimkan ke karyawan.',
                                'success'
                            );
                        }
                    },
                    error: function(data){
                        Swal.close();
                        console.log(data);
                        let error = JSON.parse(data.responseText);
                        Swal.fire(
                            error.header,
                            error.txtStatus,
                            'error'
                        );
                    }
                })
            }
        })
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

// $(document).ready(function() { //buat buka menu report, grgr ini aslinya report page bukan submenu.
//     // $('a[data-target="#collapseUser"]').addClass('d-none');
//     if('report' == '<?php print_r($this->uri->segment(1)); ?>'){
//         $('a.nav-link').removeClass('collapsed');
//         $('div#collapseJobs').addClass('show');
//     }
// });
</script>

</body>
</html>

