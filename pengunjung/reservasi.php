<?php
require '../config/database.php'; // File koneksi MySQLi
include 'middleware.php';
cekLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil data dari form
  $tanggal_pemesanan = $_POST['tanggal_pemesanan'];
  $tanggal_reservasi = $_POST['tanggal_reservasi'];
  $jam_kunjungan = $_POST['jam_kunjungan'];
  $jumlah_pengunjung = $_POST['jumlah_pengunjung'];
  $id_pengunjung = $_SESSION['id_pengunjung']; // Ambil id_pengunjung dari sesi
  $status_reservasi = 'Menunggu Konfirmasi';
  $nomor_reservasi = uniqid('RSV'); // Nomor reservasi unik

  // Ambil id_money (sesuaikan logika ini dengan kebutuhan Anda)
  $query_money = "SELECT id_money FROM money ORDER BY id_money LIMIT 1"; // Ambil data id_money yang valid
  $result_money = mysqli_query($koneksi, $query_money);

  if (!$result_money || mysqli_num_rows($result_money) === 0) {
?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

    <body></body>
    <script>
      Swal.fire({
        title: 'Gagal!',
        text: 'Data harga tidak ditemukan!',
        icon: 'Error',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'reservasi.php';
      });
    </script>
  <?php
    exit(); // Menghentikan eksekusi PHP
  }

  $data_money = mysqli_fetch_assoc($result_money);
  $id_money = $data_money['id_money']; // Ambil id_money pertama

  // Validasi tanggal di server
  if (strtotime($tanggal_reservasi) < strtotime($tanggal_pemesanan)) {
  ?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

    <body></body>
    <script>
      Swal.fire({
        title: 'Gagal!',
        text: 'Reservasi tidak boleh dilakukan sebelum tanggal pemesanan!',
        icon: 'Error',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'reservasi.php'; // Redirect ke halaman form
      });
    </script>
  <?php
    exit(); // Menghentikan eksekusi PHP
  }

  // Konversi ke format 24 jam
  $time_24hr = date("H:i:s", strtotime($jam_kunjungan));

  // Validasi jam kunjungan
  if ($time_24hr < "08:00:00" || $time_24hr > "22:00:00") {
  ?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

    <body></body>
    <script>
      Swal.fire({
        title: 'Peringatan!',
        text: 'Jam kunjungan harus antara pukul 08:00 dan 22:00!',
        icon: 'Warning',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'reservasi.php';
      });
    </script>
  <?php
    exit(); // Menghentikan eksekusi PHP
  }


  // Insert ke tabel reservasi
  $query_reservasi = "
        INSERT INTO reservasi (id_pengunjung, id_money, nomor_reservasi, tanggal_reservasi, jam_kunjungan, tanggal_pemesanan, jumlah_pengunjung, status_reservasi)
        VALUES ('$id_pengunjung', '$id_money', '$nomor_reservasi', '$tanggal_reservasi', '$jam_kunjungan', '$tanggal_pemesanan', '$jumlah_pengunjung', '$status_reservasi')
    ";

  if (mysqli_query($koneksi, $query_reservasi)) {
    // Ambil id_reservasi yang baru saja dibuat
    $id_reservasi = mysqli_insert_id($koneksi);

    // Redirect ke transaksi.php
  ?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

    <body></body>
    <script>
      Swal.fire({
        title: 'Success!',
        text: 'Reservasi berhasil dibuat!',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = 'transaksi.php?id_reservasi=<?= $id_reservasi ?>';
      });
    </script>
<?php
    exit(); // Menghentikan eksekusi PHP
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
  <title>Reservasi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/bootstrap5.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Include Bootstrap Timepicker CSS -->


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
              <h1 class="m-0 bg-navy text-white p-2 rounded w-25 text-center">Reservasi</h1>
            </div>
            <div class="col-sm-6 text-right">
              <span class="badge bg-success p-2" style="font-size: 1rem;">Jam Buka: 08:00 - 22:00</span>
            </div>
            <div class="col-sm-6">
              <?php
              if (isset($_GET['message']) && $_GET['message'] === 'reservasi_diperlukan') {
                echo '<div id="alert-message" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Perhatian!</strong> Anda harus melakukan reservasi terlebih dahulu.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
              }
              ?>


            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content d-flex justify-content-center" style="min-height: 100vh; align-items: flex-start;">
        <div class="container">
          <div class="row justify-content-center">
            <!-- left column -->
            <div class="col-md-10">
              <!-- Horizontal Form -->
              <div class="card card-danger">
                <div class="card-header">
                  <h3 class="card-title">Form Reservasi Museum</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" class="form-horizontal">
                  <div class="card-body">
                    <div class="form-group row">
                      <label for="inputDate" class="col-sm-3 col-form-label bg-maroon text-white rounded">Tanggal Pemesanan</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input class="form-control" style="background-color:rgba(96, 99, 104, 0.69); color: white; font-weight: bold;" name="tanggal_pemesanan" id="otomatisDate">
                          <div class="input-group-append">
                            <span class="input-group-text">
                              <i class="fa-solid fa-calendar"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Tanggal Reservasi -->
                    <div class="form-group row">
                      <label for="tanggalReservasi" class="col-sm-3 col-form-label bg-info text-white rounded">Tanggal Reservasi</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input class="form-control" id="tanggalReservasi" name="tanggal_reservasi" placeholder="Pilih Tanggal">
                          <div class="input-group-append">
                            <span class="input-group-text" id="calendarReservasiIcon">
                              <i class="fa-solid fa-calendar"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Tanggal Transaksi -->

                    <!-- Jam Kunjungan -->
                    <div class="form-group row">
                      <label for="jamKunjungan" class="col-sm-3 col-form-label bg-info text-white rounded">Jam Kunjungan</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input type="text" class="form-control" id="jamKunjungan" name="jam_kunjungan" placeholder="Jam Kunjungan" required>
                          <div class="input-group-append">
                            <span class="input-group-text" id="timeIcon">
                              <i class="fa-solid fa-clock"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputTime" class="col-sm-3 col-form-label bg-warning text-white rounded">Jumlah Kunjungan</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <!-- Input untuk waktu -->
                          <input type="number" class="form-control timepicker" id="" name="jumlah_pengunjung" placeholder="Jumlah Orang Kunjungan" required>
                          <div class="input-group-append">
                            <span class="input-group-text" id="">
                              <i class="fa-solid fa-user-plus"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="offset-sm-3 col-sm-9">
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input " id="exampleCheck2" required>
                          <label class="form-check-label" for="exampleCheck2">Data Sudah Benar</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer d-flex justify-content-end">
                    <button
                      type="button"
                      class="btn btn-danger me-2"
                      onclick="confirmCancellation()">Batal</button>
                    <button type="submit" class="btn btn-block btn-success" style="width: 20%;">Pesan</button>
                  </div>

                  <!-- /.card-footer -->
                </form>

              </div>
              <!-- /.card -->
            </div>
            <!--/.col (left) -->
          </div>
          <!-- /.row -->
        </div>
      </section>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.2.0
      </div>
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../assets/plugins/jquery/jquery.min.js"></script>
  <!-- Include jQuery (Pastikan ini berada sebelum Bootstrap Timepicker) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-timepicker@0.5.2/js/bootstrap-timepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <!-- Bootstrap 4 -->
  <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="../assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../assets/dist/js/adminlte.min.js"></script>

  <!-- Page specific script -->
  <script>
    $(function() {
      bsCustomFileInput.init();
    });
  </script>

  <script>
    $(document).ready(function() {
      // Inisialisasi Flatpickr dengan tema Bootstrap
      $('#inputTime').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K", // Format 12 jam dengan AM/PM
        time_24hr: false, // Format waktu 12 jam
        theme: "bootstrap5", // Gunakan tema Bootstrap 5
      });

      // Fokus pada input waktu saat ikon diklik
      $('#timeIcon').on('click', function() {
        $('#inputTime').focus();
      });
    });
  </script>


  <script>
    // Mendapatkan elemen input
    const dateInput = document.getElementById("otomatisDate");

    // Mendapatkan tanggal hari ini di zona waktu Jakarta
    const todayInJakarta = new Date().toLocaleDateString("en-CA", {
      timeZone: "Asia/Jakarta"
    });

    // Mengatur atribut min, max, dan value ke tanggal hari ini di Jakarta
    dateInput.value = todayInJakarta;
    dateInput.min = todayInJakarta;
    dateInput.max = todayInJakarta;

    // Opsional: Menonaktifkan input manual
    dateInput.addEventListener("keydown", function(e) {
      e.preventDefault(); // Mencegah input manual
    });
  </script>

  <script>
    // Event listener untuk ikon waktu (jam_kunjungan)
    document.getElementById("timeIcon").addEventListener("click", function() {
      document.getElementById("jamKunjungan")._flatpickr.open();
    });
  </script>


  <script>
    // Inisialisasi Flatpickr untuk tanggal_reservasi (hanya tanggal)
    flatpickr("#tanggalReservasi", {
      dateFormat: "Y-m-d", // Format hanya tanggal (YYYY-MM-DD)
      enableTime: false, // Nonaktifkan waktu
    });

    // Inisialisasi Flatpickr untuk tanggal_transaksi (hanya tanggal)
    flatpickr("#tanggalTransaksi", {
      dateFormat: "Y-m-d", // Format hanya tanggal (YYYY-MM-DD)
      enableTime: false, // Nonaktifkan waktu
    });

    // Inisialisasi Flatpickr untuk jam_kunjungan (hanya waktu)
    flatpickr("#jamKunjungan", {
      enableTime: true, // Aktifkan waktu
      noCalendar: true, // Nonaktifkan kalender
      dateFormat: "H:i", // Format waktu 24 jam (HH:mm)
      time_24hr: true, // Gunakan format waktu 24 jam
    });

    // Event listener untuk ikon kalender (tanggal_reservasi)
    document.getElementById("calendarReservasiIcon").addEventListener("click", function() {
      document.getElementById("tanggalReservasi")._flatpickr.open();
    });
  </script>

  <script>
    // Menghilangkan alert setelah 5 detik
    setTimeout(function() {
      const alertElement = document.getElementById('alert-message');
      if (alertElement) {
        alertElement.classList.remove('show'); // Menambahkan animasi fade-out Bootstrap
        setTimeout(() => alertElement.remove(), 150); // Menghapus elemen setelah animasi selesai
      }
    }, 5000); // 5000ms = 5 detik
  </script>
</body>

</html>