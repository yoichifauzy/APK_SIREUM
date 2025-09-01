<?php


// Periksa apakah admin sudah login
if (!isset($_SESSION['username_operator'])) {
    ?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <body></body>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Silakan login terlebih dahulu!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = '../login.php';
            }
        });
    </script>
    <?php
    exit();
}
$username_operator = $_SESSION['username_operator']; // Ambil username dari session
?>