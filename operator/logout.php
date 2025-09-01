<?php
// Mulai session
session_start();

// Jika pengguna memilih "Ya", proses logout tetap dijalankan
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Hapus semua data sesi
    session_unset();
    session_destroy();

    // Redirect ke halaman login dengan pesan logout berhasil
    header('Location: ../index.php?logout=success');
    exit();
}

// Jika pengguna memilih "Tidak", kembalikan ke dashboard
if (isset($_GET['confirm']) && $_GET['confirm'] === 'no') {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Logout</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body></body>
<script>
    // Tampilkan SweetAlert untuk konfirmasi logout
    Swal.fire({
        title: 'Konfirmasi Logout',
        text: "Apakah Anda yakin ingin logout?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke logout.php dengan konfirmasi "Ya"
            window.location.href = "logout.php?confirm=yes";
        } else {
            // Redirect ke dashboard.php dengan konfirmasi "Tidak"
            window.location.href = "dashboard.php";
        }
    });
</script>
</head>

<body>
</body>

</html>