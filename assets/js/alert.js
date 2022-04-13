$('.logout').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');

    Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Pilih tombol "Keluar" di bawah, jika Anda yakin untuk mengakhiri sesi Anda saat ini!',
        icon: 'warning',
        customClass: 'swal-wide',
        showCancelButton: true,
        confirmButtonColor: '#4CAF50',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Keluar',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value == true) {
            document.location.href = href;
        }
    })
})

$('.delete').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');

    Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Pilih tombol "Hapus Data" di bawah, jika Anda yakin untuk menghapus data ini!',
        icon: 'warning',
        customClass: 'swal-wide',
        showCancelButton: true,
        confirmButtonColor: '#4CAF50',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus Data!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value == true) {
            document.location.href = href;
        }
    })
})

$('.is-active').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');

    Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Pilih tombol "Active!" di bawah, jika Anda yakin untuk mengaktifkan Akun!',
        showCancelButton: true,
        customClass: 'swal-wide',
        confirmButtonColor: '#4CAF50',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Active!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value == true) {
            document.location.href = href;
        }
    })
})

$('.is-non-active').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');

    Swal.fire({
        title: 'Apakah anda yakin?',
        text: 'Pilih tombol "Non Active!" di bawah, jika Anda yakin untuk mengnonaktifkan Akun!',
        icon: 'warning',
        showCancelButton: true,
        customClass: 'swal-wide',
        confirmButtonColor: '#4CAF50',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Non Active!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value == true) {
            document.location.href = href;
        }
    })
})