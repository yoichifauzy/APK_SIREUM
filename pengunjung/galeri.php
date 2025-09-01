<?php
require '../config/database.php'; // Pastikan koneksi database sudah diatur
include 'middleware.php';
cekLogin();

// Ambil data kategori dan galeri
$queryKategori = "SELECT * FROM kategori";
$resultKategori = mysqli_query($koneksi, $queryKategori);

$queryGaleri = "SELECT galeri.*, kategori.nama_kategori 
                FROM galeri 
                JOIN kategori ON galeri.id_kategori = kategori.id_kategori";
$resultGaleri = mysqli_query($koneksi, $queryGaleri);

$galeriData = [];
while ($row = mysqli_fetch_assoc($resultGaleri)) {
    $galeriData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Galeri</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="../assets/plugins/ekko-lightbox/ekko-lightbox.css">
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
          <h1 class="m-0 bg-navy text-white p-2 rounded w-25 text-center">Galeri</h1>
          </div>
          <div class="col-sm-6">
           
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card card-danger">
              <div class="card-header">
                <h4 class="card-title">Manajemen Data Galeri</h4>
              </div>
              <div class="card-body">
                <div>
                  
                  <div class="mb-2">
                    
                    <div class="float-right">
                    <select class="custom-select" style="width: auto;" data-sortOrder>
                      <option value="all">Semua Kategori</option>
                      <?php while ($row = mysqli_fetch_assoc($resultKategori)) : ?>
                        <option value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
                      <?php endwhile; ?>
                    </select>
                      
                    </div>
                  </div>
                </div>
                <div>
                  <div class="filter-container p-0 row" id="galeri-container"> <!--- Bagian gambar yang sesuai nama kategorinya -->
                    
                  <?php foreach ($galeriData as $galeri) : ?>
                      <div class="filtr-item col-sm-3" data-category="<?= $galeri['id_kategori'] ?>" data-sort="<?= $galeri['nama_kategori'] ?>">
                        <a href="../operator/upload/galeri/<?= $galeri['foto'] ?>" data-toggle="lightbox" data-title="<?= $galeri['nama_kategori'] ?>">
                        <div class="figure-frame" style="padding: 10px; background: #fff; border: 4px solid rgb(239, 239, 234); border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                          <img src="../operator/upload/galeri/<?= $galeri['foto'] ?>" class="img-fluid mb-2" alt="<?= $galeri['nama_kategori'] ?>" style="width: 300px; height: 150px; object-fit: cover;" />
                        </div>
                        </a>
                      </div>
                    <?php endforeach; ?>
                    
                  </div>
                </div>

              </div>
            </div>
          </div>
          
        </div>
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
<!-- Bootstrap -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Ekko Lightbox -->
<script src="../assets/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- Filterizr-->
<script src="../assets/plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- Page specific script -->
<!-- Pastikan Anda sudah menyertakan SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Tampilkan SweetAlert setelah halaman selesai dimuat
    Swal.fire({
      icon: 'info',
      title: 'Selamat Datang!',
      text: 'Lihat-lihat dulu galeri, nanti juga tergoda!',
      confirmButtonText: 'OK'
    });
  });
</script>


<script>
  $(function () {
    // Lightbox
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    // Filter Kategori
    $('select[data-sortOrder]').on('change', function() {
      var selectedCategory = $(this).val(); // Ambil kategori yang dipilih

      if (selectedCategory === 'all') {
        // Jika 'Semua Kategori' dipilih, tampilkan semua gambar
        $('.filtr-item').show();
      } else {
        // Jika kategori tertentu dipilih, hanya tampilkan gambar yang sesuai
        $('.filtr-item').each(function() {
          var category = $(this).data('category');
          if (category == selectedCategory) {
            $(this).show(); // Tampilkan gambar yang sesuai kategori
          } else {
            $(this).hide(); // Sembunyikan gambar yang tidak sesuai kategori
          }
        });
      }
    });

    // Set initial filter to show all images
    $('select[data-sortOrder]').trigger('change');
  });
</script>



</body>
</html>
