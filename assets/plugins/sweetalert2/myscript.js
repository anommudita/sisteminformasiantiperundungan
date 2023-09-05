
// tombol delete sekolah
$('.delete-sekolah').on('click', function(e){

    // e = event
    // mematikan funtion href yang seharusnya berjalan jika di klick
    e.preventDefault();
    
    //var href 
    const href = $(this).attr('href');

    Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus data sekolah ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Sekolah!'
            }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
                Swal.fire(
                'Hapus!',
                'Data berhasil dihapus.',
                'success'
                )
            }
            })

});



// tombol delete akun guru
$('.delete-akun_guru').on('click', function(e){

    // e = event
    // mematikan funtion href yang seharusnya berjalan jika di klick
    e.preventDefault();
    
    //var href 
    const href = $(this).attr('href');

    Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus data akun guru ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Akun Guru!'
            }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
                Swal.fire(
                'Hapus!',
                'Data berhasil dihapus.',
                'success'
                )
            }
            })

});



// tombol delete siswa
$('.delete-siswa').on('click', function(e){

    // e = event
    // mematikan funtion href yang seharusnya berjalan jika di klick
    e.preventDefault();
    
    //var href 
    const href = $(this).attr('href');

    Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus data siswa ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Siswa!'
            }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
                Swal.fire(
                'Hapus!',
                'Data berhasil dihapus.',
                'success'
                )
            }
            })

});


// tombol active akun guru
$('.active-akun').on('click', function(e){

    // e = event
    // mematikan funtion href yang seharusnya berjalan jika di klick
    e.preventDefault();
    
    //var href 
    const href = $(this).attr('href');

    Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin mengaktifkan akun guru ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aktifkan Akun!'
            }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
                Swal.fire(
                'Active User!',
                'Akun berhasil diaktifkan.',
                'success'
                )
            }
            })

});



// delete lapor siswa
$('.delete-lapor-siswa').on('click', function(e){

    // e = event
    // mematikan funtion href yang seharusnya berjalan jika di klick
    e.preventDefault();
    
    //var href 
    const href = $(this).attr('href');

    Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus laporan perundungan ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data!'
            }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
                Swal.fire(
                'Hapus Laporan Perundungan!',
                'berhasil dihapus.',
                'success'
                )
            }
            })

});

// delete log
// delete lapor siswa
$('.delete-log').on('click', function(e){

    // e = event
    // mematikan funtion href yang seharusnya berjalan jika di klick
    e.preventDefault();
    
    //var href 
    const href = $(this).attr('href');

    Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus log laporan siswa ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data!'
            }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
                Swal.fire(
                'Hapus Log Laporan Siswa!',
                'berhasil dihapus.',
                'success'
                )
            }
            })
});


// delete klasifikasi 
$('.delete-klasifikasi').on('click', function(e){

    // e = event
    // mematikan funtion href yang seharusnya berjalan jika di klick
    e.preventDefault();
    
    //var href 
    const href = $(this).attr('href');

    Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Ingin menghapus klasifikasi ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Data!'
            }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
                Swal.fire(
                'Hapus Klasifikasi!',
                'berhasil dihapus.',
                'success'
                )
            }
            })
});



// $('.notif').on('click', function(e){
//     Swal.fire({
//         title: 'Custom animation with Animate.css',
//         showClass: {
//         popup: 'animate__animated animate__fadeInDown'
//         },
//         hideClass: {
//         popup: 'animate__animated animate__fadeOutUp'}
// })
// });




// new DataTable('#dataTable');
// $('#akunGuru').DataTable( {
//     // paging: false,
//     // scrollY: 400
// } );


// $(document).ready(function() {
//     $('#akunGuru').DataTable( {
//         "language": {
//                         "search": "Cari:",
//                         "lengthMenu": "Menampilkan _MENU_ data",
//                         "info": "Menampilkan _START_ sampai _END_ data dari _TOTAL_ data",
//                         "infoEmpty": "Tidak ada data yang ditampilkan",
//                         "infoFiltered": "(dari total _MAX_ data)",
//                         "zeroRecords": "Tidak ada hasil pencarian ditemukan",
//                         "paginate": {
//                             "first": "&laquo;",
//                             "last": "&raquo;",
//                             "next": "&rsaquo;",
//                             "previous": "&lsaquo;"
//                         }
//                     }
//     } );
// } );











