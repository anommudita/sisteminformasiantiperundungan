<!-- Footer -->
<footer class="footer pt-0">
    <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6">
            <div class="copyright text-center text-lg-left text-muted">
                &copy; <?= date('Y') ?> <a href="#" class="font-weight-bold ml-1" target="_blank"><a href="#">Sistem Informasi Anti Perundungan</a></a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>

<!-- Argon Scripts -->
<!-- Core -->
<script src="<?= base_url('assets/themes/argon1/vendor/js-cookie/js.cookie.js'); ?>"></script>
<script src="<?= base_url('assets/themes/argon1/vendor/jquery.scrollbar/jquery.scrollbar.min.js'); ?>"></script>
<script src="<?= base_url('assets/themes/argon1/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js'); ?>"></script>

<!-- Argon JS -->
<script src="<?= base_url('assets/themes/argon1/js/argon9f1e.js?v=1.1.0'); ?>"></script>

<!-- datatabel -->
<script src="<?= base_url('assets/'); ?>plugins/datatables/datatables.min.js"></script>
<script src="<?= base_url('assets/'); ?>plugins/datatables/datatables.js"></script>

<!-- sweetalert2 -->
<script src="<?= base_url('assets/') ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/'); ?>/plugins/sweetalert2/myscript.js"></script>


<!-- Pastikan Anda telah memasukkan SweetAlert dan JavaScript-nya pada halaman HTML Anda

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formErrorElement = document.querySelector('.text-danger.ql-size-small');

        if (formErrorElement && formErrorElement.textContent.trim() !== '') {
            let timerInterval;

            Swal.fire({
                title: 'Auto close alert!',
                html: 'I will close in <b></b> milliseconds.',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const b = Swal.getHtmlContainer().querySelector('b');
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft();
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer');
                    // a.href = "<?= base_url('admin/akun_guru'); ?>";/
                }
            });
        }
    });
</script> -->



<script>
    $(document).ready(function($) {
        $('#dataTable').DataTable({
            // ajax: {
            //     url: '<?php echo site_url('admin/data_api?action=list'); ?>',
            //     dataSrc: 'data'
            // },
            // columns: [{
            //         data: 'id'
            //     },
            //     {
            //         data: 'nama'
            //     },
            //     {
            //         data: 'email'
            //     },
            //     {
            //     }
            // ],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Menampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ data dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data yang ditampilkan",
                "infoFiltered": "(dari total _MAX_ data)",
                "zeroRecords": "Tidak ada hasil pencarian ditemukan",
                "paginate": {
                    "first": "&laquo;",
                    "last": "&raquo;",
                    "next": "&rsaquo;",
                    "previous": "&lsaquo;"
                }
            }
        });
    });
</script>



<!-- Script untuk upload gambat agar terlihat ditampilan inputnya -->
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>


<!-- script untuk preview gambar -->
<script>
    function getImagePreview(event) {
        var image = URL.createObjectURL(event.target.files[0]);
        var iamgediv = document.getElementById('preview')

        var newImage = document.createElement('img');
        iamgediv.innerHTML = '';
        newImage.src = image;
        newImage.style.width = '100%';

        // Menambahkan class "img-thumbnail" pada elemen gambar
        newImage.classList.add('img-thumbnail');

        iamgediv.appendChild(newImage);
    }
</script>


<!-- Script untuk edit preview gambar -->
<script>
    function getImagePreviewEdit(event) {
        var image = URL.createObjectURL(event.target.files[0]);
        var iamgediv = document.getElementById('edit_preview')

        var newImage = document.createElement('img');
        iamgediv.innerHTML = '';
        newImage.src = image;
        newImage.style.width = '100%';

        // Menambahkan class "img-thumbnail" pada elemen gambar
        newImage.classList.add('img-thumbnail');

        iamgediv.appendChild(newImage);
    }
</script>

<!-- script untuk seleksi data yang akan ditampilkan -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ketika tombol Kabupaten di klik
        $('#kabupaten').on('change', function() {
            var kabupatenId = $(this).val();

            console.log(kabupatenId);

            // Hapus data kecamatan sebelumnya
            $('#kecamatan').empty();

            // Hapus data kota sebelumnya
            $('#kota').empty();

            // Ambil data kecamatan berdasarkan kabupatenId
            $.ajax({
                url: "<?php echo base_url('admin/getKecamatan'); ?>",
                type: "POST",
                data: {
                    kabupatenId: kabupatenId
                },
                dataType: "json",
                success: function(data) {
                    // Tambahkan opsi kecamatan ke dropdown
                    if (data.length > 0) {
                        $('#kecamatan').append('<option value="">Pilih..</option>');
                        $.each(data, function(key, value) {
                            $('#kecamatan').append('<option value="' + value.id + '">' + value.kecamatan + '</option>');
                        });
                    } else {
                        $('#kecamatan').append('<option value="">Tidak ada kecamatan</option>');
                    }
                }
            });
        });

        // Ketika tombol Kecamatan di klik
        $('#kabupaten').on('change', function() {
            var kabupatenId = $(this).val();

            // Hapus data kota sebelumnya
            $('#kota').empty();

            // Ambil data kota berdasarkan kecamatanId
            $.ajax({
                url: "<?php echo base_url('admin/getKota'); ?>",
                type: "POST",
                data: {
                    kabupatenId: kabupatenId
                },
                dataType: "json",
                success: function(data) {
                    // Tambahkan opsi kota ke dropdown
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            $('#kota').append('<option value="' + value.id + '">' + value.kota + '</option>');
                            // $('#kota').append('<option value="10">Kosongkan Kota</option>');
                        });
                    } else {
                        $('#kota').append('<option value="">Tidak ada kota</option>');
                    }
                }
            });
        });
    });
</script>




</body>

</html>