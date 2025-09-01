<?php
require '../config/database.php';
include 'middleware.php';
cekLogin();

// Validasi apakah id_reservasi tersedia di URL
if (!isset($_GET['id_reservasi']) || empty($_GET['id_reservasi'])) {
?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

    <body></body>
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: 'Silakan masuk ke menu reservasi terlebih dahulu!',
            icon: 'Error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'reservasi.php';
        });
    </script>
    <?php
    exit(); // Menghentikan eksekusi PHP
}

// Ambil id_reservasi dari URL
$id_reservasi = $_GET['id_reservasi'];

// Cek apakah transaksi untuk reservasi ini sudah ada
$query_check = "SELECT * FROM transaksi WHERE id_reservasi = '$id_reservasi'";
$result_check = mysqli_query($koneksi, $query_check);

if ($result_check && mysqli_num_rows($result_check) > 0) {
    die("Error: Transaksi untuk reservasi ini sudah dibuat!");
}

// Ambil data reservasi termasuk id_money
$query_reservasi = "
    SELECT r.*, m.id_money, m.harga_update 
    FROM reservasi r
    JOIN money m ON r.id_money = m.id_money
    WHERE r.id_reservasi = '$id_reservasi' AND 
    (r.status_reservasi = 'Menunggu Konfirmasi' OR r.status_reservasi = 'Dikonfirmasi')
";
$result_reservasi = mysqli_query($koneksi, $query_reservasi);

// Validasi apakah data reservasi ditemukan
if (!$result_reservasi || mysqli_num_rows($result_reservasi) === 0) {
    die("Error: Data reservasi tidak ditemukan atau status belum dikonfirmasi.");
}

// Ambil data reservasi
$data_reservasi = mysqli_fetch_assoc($result_reservasi);

// Ambil data harga dan id_money
$id_money = $data_reservasi['id_money'];
$harga_per_orang = $data_reservasi['harga_update'];

// Hitung total harga
$jumlah_pengunjung = $data_reservasi['jumlah_pengunjung'];
$total_harga = $jumlah_pengunjung * $harga_per_orang;

// Inisialisasi tanggal transaksi
$tanggal_transaksi = date('Y-m-d');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $nomor_identitas = isset($_POST['nomor_identitas']) ? $_POST['nomor_identitas'] : null;
    $nomor_pembayaran = isset($_POST['nomor_pembayaran']) ? $_POST['nomor_pembayaran'] : null;
    $tanggal_transaksi = ($metode_pembayaran === 'Online') ? date('Y-m-d') : $_POST['tanggal_transaksi'];
    $tanggal_reservasi = $data_reservasi['tanggal_reservasi'];

     // Validasi tanggal transaksi
     if ($metode_pembayaran === 'COD' && $tanggal_transaksi > $tanggal_reservasi) {
        die("Error: Tanggal transaksi tidak boleh melebihi tanggal reservasi!");
    }

    if ($metode_pembayaran === 'Online' && empty($nomor_pembayaran)) {
        die("Nomor pembayaran harus diisi untuk metode pembayaran online.");
    }

    if ($metode_pembayaran === 'COD') {
        if (empty($nomor_identitas)) {
            die("Nomor identitas harus diisi untuk metode pembayaran COD.");
        }

        // Validasi nomor identitas terhadap tabel pengunjung
        $query_identitas = "
            SELECT * FROM pengunjung 
            WHERE id_pengunjung = '{$data_reservasi['id_pengunjung']}' 
            AND nomor_identitas_pengunjung = '$nomor_identitas'
        ";
        $result_identitas = mysqli_query($koneksi, $query_identitas);

        if (!$result_identitas || mysqli_num_rows($result_identitas) === 0) {
    ?>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

            <body></body>
            <script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Nomor identitas tidak sesuai dengan data pengunjung yang terdaftar.',
                    icon: 'Error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.history.back();
                });
            </script>
<?php
            exit(); // Menghentikan eksekusi PHP
        }
    }

    // Data untuk dimasukkan ke tabel transaksi
    $id_pengunjung = $data_reservasi['id_pengunjung'];
    $nomor_transaksi = uniqid('TRX');

    // Query untuk menyimpan data ke tabel transaksi
    $query_insert = "
    INSERT INTO transaksi (
        id_reservasi, 
        id_pengunjung, 
        id_money, 
        nomor_transaksi, 
        tanggal_transaksi, 
        status_transaksi, 
        metode_transaksi, 
        uang_transaksi, 
        nomor_payment
    ) VALUES (
        '$id_reservasi', 
        '$id_pengunjung', 
        '$id_money', 
        '$nomor_transaksi', 
        '$tanggal_transaksi', 
        'Sukses', 
        '$metode_pembayaran', 
        '$total_harga', 
        '$nomor_pembayaran'
    )
";


    if (mysqli_query($koneksi, $query_insert)) {
        // Ambil id_transaksi yang baru saja dibuat
        $id_transaksi_baru = mysqli_insert_id($koneksi);

        // Redirect ke halaman e-ticket.php dengan membawa id_transaksi
        header("Location: e-ticket.php?id_transaksi=$id_transaksi_baru");
        exit();
    } else {
        die("Error: " . mysqli_error($koneksi));
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transaksi</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <?php
        include 'navbar.php';

        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <div class="col-sm-6">
                                <h1 class="m-0 bg-navy text-white p-2 rounded w-50 text-center">Transaksi</h1>
                            </div>
                            <div class="col-sm-6">

                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content d-flex justify-content-center" style="min-height: 100vh; align-items: flex-start;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Proses Pembayaran</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Tanggal Pemesanan</label>
                                                    <input type="text" class="form-control" value="<?= $data_reservasi['tanggal_pemesanan']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Tanggal Reservasi</label>
                                                    <input type="text" class="form-control" value="<?= $data_reservasi['tanggal_reservasi']; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Tanggal Transaksi</label>
                                                    <input type="date" class="form-control" id="tanggalTransaksi" name="tanggal_transaksi" value="<?= $tanggal_transaksi; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Jumlah Kunjungan</label>
                                                    <input type="text" class="form-control" value="<?= $jumlah_pengunjung; ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Total Harga</label>
                                                    <input type="text" class="form-control" value="Rp<?= $total_harga; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Metode Pembayaran</label>
                                            <select class="form-control" name="metode_pembayaran" id="metodePembayaran" required>
                                                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                                                <option value="COD">COD (Bayar di Tempat)</option>
                                                <option value="Online">Online (Gopay)</option>
                                                <option value="Online">Online (OVO)</option>
                                                <option value="Online">Online (Dana)</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="formIdentitas" style="display: none;">
                                            <label>Nomor Identitas</label>
                                            <input type="text" class="form-control" name="nomor_identitas" placeholder="Masukkan Nomor Identitas">
                                        </div>

                                        <div id="formOnline" style="display: none;">
                                            <div class="form-group">
                                                <label>Nomor Payment anda</label>
                                                <input type="text" class="form-control" name="nomor_pembayaran" placeholder="Masukkan Nomor Payment">
                                            </div>

                                            <i class="fa-solid fa-money-bill-transfer fa-lg"></i>
                                            <div>
                                                <label>Nomor Payment Museum</label>
                                                <input type="text" class="form-control" name="nomor_pembayaran" placeholder="0838 1945 2025" disabled>
                                            </div>
                                        </div><br>

                                        <button type="submit" class="btn btn-success">Bayar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="../assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->

    <!-- Page specific script -->

    <script>
        const metodePembayaran = document.getElementById('metodePembayaran');
        const formIdentitas = document.getElementById('formIdentitas');
        const formOnline = document.getElementById('formOnline');
        const tanggalTransaksiInput = document.getElementById('tanggalTransaksi');
        const tanggalReservasi = "<?= $data_reservasi['tanggal_reservasi']; ?>"; // Ambil tanggal reservasi dari PHP

        metodePembayaran.addEventListener('change', function() {
            if (this.value === 'COD') {
                formIdentitas.style.display = 'block';
                formOnline.style.display = 'none';
                tanggalTransaksiInput.disabled = false; // Enable input tanggal transaksi
                tanggalTransaksiInput.setAttribute('max', tanggalReservasi); // Set batas maksimal tanggal
            } else if (this.value === 'Online') {
                formIdentitas.style.display = 'none';
                formOnline.style.display = 'block';
                tanggalTransaksiInput.disabled = true; // Disable input tanggal transaksi
                tanggalTransaksiInput.value = '<?= date('Y-m-d'); ?>'; // Set nilai ke tanggal hari ini
            } else {
                formIdentitas.style.display = 'none';
                formOnline.style.display = 'none';
                tanggalTransaksiInput.disabled = true; // Default: disable input tanggal transaksi
            }
        });

        // Validasi tanggal transaksi saat pengguna memilih tanggal
        tanggalTransaksiInput.addEventListener('change', function() {
            const selectedDate = this.value;
            if (selectedDate > tanggalReservasi) {
                alert('Tanggal transaksi tidak boleh melebihi tanggal reservasi!');
                this.value = ''; // Reset input tanggal
            }
        });
    </script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>