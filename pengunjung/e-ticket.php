<?php
// Mulai session
require '../config/database.php';
include 'middleware.php';
cekLogin();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_pengunjung'])) {
  header("Location: ../index.php"); // Redirect ke halaman login jika belum login
  exit();
}

// Ambil ID pengunjung dari session
$id_pengunjung = $_SESSION['id_pengunjung'];

// Periksa koneksi
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk memeriksa apakah ada reservasi aktif untuk pengguna
$query = "
SELECT 
    r.id_reservasi,
    r.status_reservasi,
    p.nama_pengunjung,
    r.nomor_reservasi,
    t.nomor_transaksi,
    r.tanggal_pemesanan,
    r.tanggal_reservasi,
    t.tanggal_transaksi,
    t.status_transaksi,
    r.jam_kunjungan,
    r.jumlah_pengunjung,
    t.metode_transaksi,
    t.status_tiket
FROM 
    reservasi r
JOIN pengunjung p ON r.id_pengunjung = p.id_pengunjung
JOIN transaksi t ON r.id_reservasi = t.id_reservasi
WHERE 
    r.id_pengunjung = ? AND 
    (r.status_reservasi = 'Menunggu Konfirmasi' OR r.status_reservasi = 'Dikonfirmasi')
ORDER BY r.id_reservasi DESC, t.id_transaksi DESC
LIMIT 1
";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_pengunjung);
$stmt->execute();
$result = $stmt->get_result();


// Redirect ke reservasi.php jika tidak ada reservasi aktif
if ($result->num_rows === 0) {
  $stmt->close();
  $koneksi->close();
  header("Location: reservasi.php?message=reservasi_diperlukan");
  exit();
}


// Ambil data reservasi
$data_reservasi = $result->fetch_assoc();
// Check for status_tiket



// Tutup statement dan koneksi
$stmt->close();
$koneksi->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E- Ticket</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">
    <!-- Navbar -->
    <!-- /.navbar -->
    <?php
    include 'navbar.php';

    ?>
    <!-- Main Sidebar Container -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">


          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col-12">

              <!-- Main content -->
              <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="user-block d-flex align-items-center">

                    <img src="../gambar/logo.jpg" alt="user image" style="width: 10%; height: 95%; border-radius: 50%; ">



                    <div class="ml">
                      <span class="username">
                        <a href="#" class="text-danger" style="font-size: 1.7rem; font-weight: bold;">Museum Nusantara</a>
                      </span>
                      <span class="description" style="font-size: 1.4rem; color: #6c757d;">Wonderful Indonesia</span>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    <br>
                    <address>
                      <strong>Lokasi</strong><br>
                      <i class="fa-solid fa-location-dot"></i>&nbsp; Jl. Nusantara Baru<br>
                      <i class="fa-solid fa-paper-plane"></i>&nbsp;Nusantara City, IKN 9999<br>

                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <br>
                    <address>
                      <strong>Informasi Kontak</strong><br>
                      <i class="fa-solid fa-phone"></i>&nbsp; (+62) 8888-888-88 <br>
                      <i class="fa-solid fa-envelope"></i>&nbsp; sireumnusantara@gmail.com <br>

                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <?php if (!empty($data_reservasi)): ?>
                      <span style="margin-bottom: 10px;"><b>Status Reservasi</b></span><br>
                      <span class="badge bg-warning px-2 py-1" style="font-size:20px ; margin-bottom:10px;">
                        <?= !empty($data_reservasi['status_reservasi']) ? htmlspecialchars($data_reservasi['status_reservasi']) : 'belum dikonfirmasi' ?>

                      </span><br>
                      <span style="margin-bottom: 10px;"><b>Status Transaksi</b></span><br>
                      <span class="badge bg-danger px-2 py-1" style="font-size:20px ;">
                        <?= !empty($data_reservasi['status_transaksi']) ? htmlspecialchars($data_reservasi['status_transaksi']) : 'belum dikonfirmasi' ?>
                      </span><br>
                      <hr>
                    <?php else: ?>
                      <p>Data tidak ditemukan</p>
                    <?php endif; ?>

                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Nama<br>Pengunjung
                          </th>
                          <th>No<br>Reservasi
                          </th>
                          <th>No<br>Transaksi
                          </th>
                          <th>Tgl<br>Pemesanan
                          </th>
                          <th>Tgl<br>Reservasi
                          </th>
                          <th>Tgl<br>Transaksi
                          </th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($data_reservasi)): ?>
                          <tr>
                            <td><?= htmlspecialchars($data_reservasi['nama_pengunjung']) ?></td>
                            <td><?= htmlspecialchars($data_reservasi['nomor_reservasi']) ?></td>
                            <td><?= htmlspecialchars($data_reservasi['nomor_transaksi']) ?></td>
                            <td><?= htmlspecialchars($data_reservasi['tanggal_pemesanan']) ?></td>
                            <td><?= htmlspecialchars($data_reservasi['tanggal_reservasi']) ?></td>
                            <td><?= htmlspecialchars($data_reservasi['tanggal_transaksi']) ?></td>
                          </tr>
                        <?php else: ?>
                          <tr>
                            <td colspan="6" class="text-center">Data tidak ditemukan</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>

                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <!-- accepted payments column -->
                  <div class="col-6">
                    <p class="lead">Didukung Oleh</p>
                    <img src="../assets/dist/img/sponsor/1.png" alt="Visa" width="100" height="50" style="border-radius: 5px;">
                    <img src="../assets/dist/img/sponsor/2.png" alt="Mastercard" width="100" height="50" style="border-radius: 5px;">
                    <img src="../assets/dist/img/sponsor/3.png" alt="American Express" width="100" height="50" style="border-radius: 5px;">


                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                      "Museum Nusantara adalah pintu waktu, tempat kisah nenek moyang berbisik di setiap sudut ruang. Di sini, jejak sejarah dirajut dengan kebanggaan, menghadirkan warisan bangsa untuk semua yang ingin memahami, mencintai, dan merawat identitas Nusantara."
                    </p>
                  </div>
                  <!-- /.col -->
                  <div class="col-6">
                    <p class="lead">Museum Nusantara Sejarah Untuk Semua</p>

                    <div class="table-responsive">
                      <table class="table">
                        <tr>
                          <th style="width:50%">Jam Kunjungan</th>
                          <td><?= !empty($data_reservasi['jam_kunjungan']) ? htmlspecialchars($data_reservasi['jam_kunjungan']) : '-' ?></td>
                        </tr>
                        <tr>
                          <th>Jumlah Pengunjung</th>
                          <td><?= !empty($data_reservasi['jumlah_pengunjung']) ? htmlspecialchars($data_reservasi['jumlah_pengunjung']) : '-' ?></td>
                        </tr>
                        <tr>
                          <th>Metode Pembayaran</th>
                          <td>
                            <?php if (!empty($data_reservasi['metode_transaksi'])): ?>
                              <span class="badge badge-info" style="font-size: 1rem; padding: 10px 15px;">
                                <?= htmlspecialchars($data_reservasi['metode_transaksi']) ?>
                              </span>
                            <?php endif; ?>
                          </td>
                        </tr>

                      </table>

                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->



                <!-- this row will not appear when printing -->
                <div class="row no-print">
                  <div class="col-12">


                    <?php
                    // Pastikan kolom status_tiket ada dalam hasil query
                    $status_tiket = isset($data_reservasi['status_tiket']) ? $data_reservasi['status_tiket'] : null;

                    // Memeriksa apakah status_tiket ada dan nilainya
                    if ($status_tiket === null) {
                      echo '<p>Status tiket tidak ditemukan atau belum dikonfirmasi.</p>';
                    } else {
                      if ($status_tiket == 1) {
                        echo '<button type="button" class="btn btn-primary float-right" style="margin-right: 5px;" id="generatePDF">
                <i class="fas fa-download"></i> Generate PDF
              </button>';
                      } else {
                        echo '<button type="button" class="btn btn-secondary float-right" style="margin-right: 5px;" disabled>
      <i class="fas fa-download"></i> Generate PDF
    </button>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "warning",
            title: "Tiket Belum Dikonfirmasi",
            text: "Silakan tunggu beberapa menit hingga tiket dikonfirmasi.",
            confirmButtonText: "OK"
        });
    </script>';
                      }
                    }
                    ?>

                    <button type="button" class="btn btn-success float-right" style="margin-right: 10px;" onclick="refreshPage();">
                      <i class="fas fa-sync-alt"></i> Refresh
                    </button>

                  </div>
                </div>
              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
  <!-- AdminLTE App -->
  <script src="../assets/dist/js/adminlte.min.js"></script>
  <!-- Tambahkan di dalam <head> atau sebelum </body> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>


  <script>
    document.getElementById('generatePDF').addEventListener('click', function() {
      if (this.disabled) {

        Swal.fire({
          icon: 'warning',
          title: 'Tiket Belum Dikonfirmasi',
          text: 'Silakan tunggu beberapa menit hingga tiket dikonfirmasi.',
          confirmButtonText: 'OK'
        });
        return;
      }

      // Jika tidak disabled, jalankan logika generate PDF
      const invoiceElement = document.querySelector('.invoice');
      setTimeout(function() {
        const options = {
          margin: 0.2,
          filename: 'sireum_nusantara.pdf',
          image: {
            type: 'jpeg',
            quality: 0.98
          },
          html2canvas: {
            scale: 2
          },
          jsPDF: {
            unit: 'in',
            format: 'a4',
            orientation: 'portrait'
          }
        };
        html2pdf().set(options).from(invoiceElement).save();
      }, 500);
    });
  </script>

  <script>
    function refreshPage() {
      Swal.fire({
        icon: 'info',
        title: 'Memuat Ulang Halaman',
        text: 'Halaman sedang dimuat ulang...',
        showConfirmButton: false,
        timer: 2000, // Halaman akan reload setelah 2 detik
        didClose: () => {
          location.reload();
        }
      });
    }
  </script>




</body>

</html>