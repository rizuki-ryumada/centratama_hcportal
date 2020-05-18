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
    const input =  document.querySelector('#bannerTemaInput');
    const preview = document.querySelector('#tema-preview');

    input.style.opacity = 0;
    
    input.addEventListener('change', updateImageDisplay);
    
    function updateImageDisplay() {
        while(preview.firstChild) {
            preview.removeChild(preview.firstChild);
        }
        
        const curFiles = input.files;
        if(curFiles.length === 0){
            const para = document.createElement('p');
            para.textContent = 'Tidak ada file dipilih';
            preview.appendChild(para);
        } else {
            const list = document.createElement('ol');
            preview.appendChild(list);
            
            for(const file of curFiles) {
                const listItem = document.createElement('li');
                const para = document.createElement('p');
                if(validFileType(file)) {
                    para.textContent = 'Nama File: '+file.name+', Ukuran File: '+returnFileSize(file.size)+'.';
                    const image = document.createElement('img');
                    image.src = URL.createObjectURL(file);
                    
                    listItem.appendChild(image);
                    listItem.appendChild(para);
                } else {
                    para.textContent = 'Nama File '+file.name+': Bukan tipe file yang valid. Coba pilih file yang lain.';
                    listItem.appendChild(para);
                }
                
                list.appendChild(listItem);
            }
        }
    }
    
    const fileTypes = [
    "image/apng",
    "image/bmp",
    "image/gif",
    "image/jpeg",
    "image/pjpeg",
    "image/png",
    "image/svg+xml",
    "image/tiff",
    "image/webp",
    "image/x-icon"
    ]
    
    function validFileType(file) {
        return fileTypes.includes(file.type);
    }
    
    function returnFileSize(number){
        if(number < 1024) {
            return number + 'bytes';
        } else if(number >= 1024 && number < 1048576) {
            return (number/1024).toFixed(1) + 'KB';
        } else if(number >= 1048576){
            return (number/1048576).toFixed(1) + 'MB';
        }
    }
</script>

</body>

</html>
