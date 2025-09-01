<?php
 session_start();
?>

<?php
// Panggil koneksi
require '../config/database.php';

// Query untuk menghitung jumlah konten
$query_jumlah = "SELECT COUNT(*) AS jumlah_konten FROM konten";
$result_jumlah = mysqli_query($koneksi, $query_jumlah);
$row_jumlah = mysqli_fetch_assoc($result_jumlah);
$jumlah_konten = $row_jumlah['jumlah_konten'];

// Query untuk mengambil data konten
$query_konten = "SELECT id_konten, nama_konten, isi_konten FROM konten";
$result_konten = mysqli_query($koneksi, $query_konten);

// Simpan data konten ke dalam array
$kontens = [];
while ($row = mysqli_fetch_assoc($result_konten)) {
    $kontens[] = $row;
}

// Query untuk menghitung jumlah galeri
$query_jumlah = "SELECT COUNT(*) AS jumlah_galeri FROM galeri";
$result_jumlah = mysqli_query($koneksi, $query_jumlah);
$row_jumlah = mysqli_fetch_assoc($result_jumlah);
$jumlah_galeri = $row_jumlah['jumlah_galeri'];

// Query untuk mengambil data galeri
$query_galeri = "
    SELECT 
        g.id_foto, 
        g.path_foto, 
        k.id_kategori, 
        k.nama_kategori 
    FROM galeri g
    JOIN kategori k ON g.id_kategori = k.id_kategori";
$result_galeri = mysqli_query($koneksi, $query_galeri);

// Simpan data operator ke dalam array
$galeris = [];
while ($row = mysqli_fetch_assoc($result_galeri)) {
    $galeris[] = $row;
}

// Query untuk menghitung jumlah Pengunjung
$query_jumlah = "SELECT SUM(jumlah_pengunjung) AS total_pengunjung FROM reservasi";
$result_jumlah = mysqli_query($koneksi, $query_jumlah);
$row_jumlah = mysqli_fetch_assoc($result_jumlah);
$total_pengunjung = $row_jumlah['total_pengunjung'];

// Query untuk mengambil data konten
$query_pengunjung = "
    SELECT 
        r.jumlah_pengunjung, 
        p.nama_pengunjung, 
        p.nomor_identitas_pengunjung, 
        p.alamat_pengunjung 
    FROM reservasi r
    JOIN pengunjung p ON r.id_pengunjung = p.id_pengunjung
";

$result_pengunjung = mysqli_query($koneksi, $query_pengunjung);

// Simpan data konten ke dalam array
$pengunjungs = [];
while ($row = mysqli_fetch_assoc($result_pengunjung)) {
    $pengunjungs[] = $row;
}

// Query untuk status_reservasi
$query_reservasi = "
    SELECT 
        SUM(CASE WHEN status_reservasi = 'Dikonfirmasi' THEN 1 ELSE 0 END) AS total_dikonfirmasi,
        SUM(CASE WHEN status_reservasi != 'Dikonfirmasi' THEN 1 ELSE 0 END) AS total_belum_dikonfirmasi
    FROM reservasi;
";
$result_reservasi = mysqli_query($koneksi, $query_reservasi);
$row_reservasi = mysqli_fetch_assoc($result_reservasi);

// Query untuk status_transaksi
$query_transaksi = "
    SELECT 
        COUNT(*) AS total_sukses 
    FROM transaksi 
    WHERE status_transaksi = 'Sukses';
";
$result_transaksi = mysqli_query($koneksi, $query_transaksi);
$row_transaksi = mysqli_fetch_assoc($result_transaksi);

// Query untuk status_ticket
$query_tiket = "
    SELECT 
        SUM(CASE WHEN r.status_reservasi = 'Dikonfirmasi' THEN 1 ELSE 0 END) AS total_dikonfirmasi_reservasi,
        SUM(CASE WHEN r.status_reservasi = 'Belum Dikonfirmasi' THEN 1 ELSE 0 END) AS total_belum_dikonfirmasi_reservasi,
        SUM(CASE WHEN t.status_transaksi = 'Sukses' THEN 1 ELSE 0 END) AS total_sukses_transaksi,
        SUM(CASE WHEN t.status_tiket = 1 THEN 1 ELSE 0 END) AS total_tiket_dikonfirmasi,
        SUM(CASE WHEN t.status_tiket = 0 THEN 1 ELSE 0 END) AS total_tiket_belum_dikonfirmasi
    FROM reservasi r
    LEFT JOIN transaksi t ON r.id_reservasi = t.id_reservasi;
";


$result_tiket = mysqli_query($koneksi, $query_tiket);
$row_tiket = mysqli_fetch_assoc($result_tiket);

// Hitung Total Semua Status
$total_dikonfirmasi = $row_reservasi['total_dikonfirmasi'];
$total_belum_dikonfirmasi = $row_reservasi['total_belum_dikonfirmasi'];
$total_sukses = $row_transaksi['total_sukses'];
$total_tiket_konfirmasi = $row_tiket['total_tiket_dikonfirmasi'];
$total_tiket_belum_konfirmasi = $row_tiket['total_tiket_belum_dikonfirmasi'];

$total_semua_status = 
    $total_dikonfirmasi +
    $total_belum_dikonfirmasi +
    $total_sukses +
    $total_tiket_konfirmasi +
    $total_tiket_belum_konfirmasi;


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Operator</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-icons/14.0.1/simpleicons.svg">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">
  

  <!-- Navbar -->
    <?php
        include 'navbar.php';

    ?>
  <!-- /.navbar -->

  <?php
        include 'sidebar.php';

    ?>
  <!-- Main Sidebar Container -->
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="m-0">
          <span class="badge badge-dark"><i class="fa-solid fa-layer-group"></i>&nbsp;Dashboard Operator</span>
        </h1>

          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $jumlah_konten; ?>&nbsp;Konten</h3>

                <p>Jumlah Konten</p>
              </div>
              <div class="icon">
              <i class="fa-solid fa-photo-film"></i>
              </div>
              <a href="#modal-default1" data-toggle="modal" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
               <h3><?= $jumlah_galeri; ?>&nbsp;Galeri</h3>

                <p>Jumlah Galeri</p>
              </div>
              <div class="icon">
                <i class="fa-solid fa-image fa-shake"></i>
              </div>
              <a href="#modal-default2" data-toggle="modal" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <h3><?= $total_pengunjung; ?>&nbsp;Tiket</h3>

                <p>Jumlah Penjualannya</p>
              </div>
              <div class="icon">
              <i class="fa-solid fa-person-through-window" style="color: #000000;"></i>
              </div>
              <a href="#modal-default3" data-toggle="modal" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <h3>&nbsp;<?php echo $total_semua_status; ?>&nbsp;Status</h3>

                <p>Status Reservasi dan Transaski</p>
              </div>
              <div class="icon">
              <i class="fa-solid fa-sitemap fa-fade"></i>
              </div>
              <a href="#modal-lg4" data-toggle="modal" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
         
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
                                             <!-- CHARTJS -->

                                                <?php
                                                    include 'chartjs.php';
                                                ?>
      </div><!-- /.container-fluid -->

     

    </section>
    <!-- /.content -->

                    <div class="modal fade" id="modal-default1">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Tampilan Mini Konten</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              
                            <div class="card">
                    
                    <!-- /.card-header -->
                                
                                  <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                      <th>Nama Konten</th>
                                      <th>Isi Konten</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($kontens as $konten): ?>
                                      <tr>
                                            <td><?= htmlspecialchars($konten['nama_konten']); ?></td>
                                            <td><?= htmlspecialchars($konten['isi_konten']); ?></td>
                                      </tr>
                                    <?php endforeach; ?>
                                    </tfoot>
                                  </table>
                               
                                <!-- /.card-body -->
                              </div>

                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                              
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>

                      <!-- Modal 2 -->
                      <div class="modal fade" id="modal-default2">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Info Galeri</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <div class="card">
                    
                    <!-- /.card-header -->
                                
                                  <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                      <th>Kategori Foto</th>
                                      <th>Foto</th>
                                      
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($galeris as $galeri): ?>
                                        <tr>
                                              <td><?= htmlspecialchars($galeri['nama_kategori']); ?></td>
                                              <td>
                                                  <!-- Menampilkan gambar -->
                                                  <img src="<?= htmlspecialchars($galeri['path_foto']); ?>" alt="Foto" width="100">
                                              </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tfoot>
                                  </table>
                               
                                <!-- /.card-body -->
                              </div>

                              </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                              
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>

                              <!-- Modal 3 -->
                  <div class="modal fade" id="modal-default3">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Jumlah Pengunjung Museum</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <div class="card">
                    
                    <!-- /.card-header -->
                                
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>Nama Pengunjung</th>
                              <th>Nomor Identitas</th>
                              <th>Jumlah Orang Pengunjung</th>
                              <th>Alamat Pengunjung</th>
                              
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($pengunjungs as $pengunjung): ?>
                              <tr>
                                  <td><?= htmlspecialchars($pengunjung['nama_pengunjung']); ?></td>
                                  <td><?= htmlspecialchars($pengunjung['nomor_identitas_pengunjung']); ?></td>
                                  <td><?= htmlspecialchars($pengunjung['jumlah_pengunjung']); ?></td>
                                  <td><?= htmlspecialchars($pengunjung['alamat_pengunjung']); ?></td>
                                  
                              </tr>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
                               
                                <!-- /.card-body -->
                              </div>

                              </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                              
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>

                      <!-- Modal 4 -->
                      <div class="modal fade" id="modal-lg4">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Jumlah Detail Status</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <div class="card">
                    
                    <!-- /.card-header -->
                                
                    <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Total Dikonfirmasi</th>
            <th>Total Belum Dikonfirmasi</th>
            <th>Total Transaksi Sukses</th>
            <th>Total Tiket Dikonfirmasi</th>
            <th>Total Tiket Belum Dikonfirmasi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- Menampilkan data yang sudah diambil dari query -->
            <td><?php echo $total_dikonfirmasi; ?></td>
            <td><?php echo $total_belum_dikonfirmasi; ?></td>
            <td><?php echo $total_sukses; ?></td>
            <td><?php echo $total_tiket_konfirmasi; ?></td>
            <td><?php echo $total_tiket_belum_konfirmasi; ?></td>
        </tr>
    </tbody>
</table>

                               
                                <!-- /.card-body -->
                              </div>

                              </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                              
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>

                 
                      
                      <!-- chartJS -->
                     

  </div>
  <!-- /.content-wrapper -->


<?php
    include 'footer.php';
?>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>

  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../assets/plugins/moment/moment.min.js"></script>
<script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.js"></script>
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../assets/dist/js/pages/dashboard.js"></script>

</body>
</html>

