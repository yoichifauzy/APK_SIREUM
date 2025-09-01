<?php
 function cekLogin() {
    session_start();
    if (!isset($_SESSION['nama_pengunjung'])) {
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
}

?>