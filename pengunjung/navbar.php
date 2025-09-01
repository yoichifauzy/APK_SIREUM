<?php
require 'cek.php';
?>



<body class="hold-transition layout-top-nav">
<style>
.nav-item .nav-link:hover {
    background-color:rgb(254, 251, 247) !important; /* Warna latar */
    color: black !important; /* Warna teks */
}
.dropdown-menu .dropdown-item:hover {
    background-color: red !important;
    color: white !important;
}


</style>



  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>
    <?php
$current_page = basename($_SERVER['PHP_SELF']); // Mendapatkan nama file saat ini
?>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="konten.php" class="nav-link <?php echo ($current_page == 'konten.php') ? 'active' : ''; ?>">Konten</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="galeri.php" class="nav-link <?php echo ($current_page == 'galeri.php') ? 'active' : ''; ?>">Galeri</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="reservasi.php" class="nav-link <?php echo ($current_page == 'reservasi.php') ? 'active' : ''; ?>">Reservasi</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="transaksi.php" class="nav-link <?php echo ($current_page == 'transaksi.php') ? 'active' : ''; ?>">Pembayaran</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="e-ticket.php" class="nav-link <?php echo ($current_page == 'e-ticket.php') ? 'active' : ''; ?>">Ticket</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="kontak.php" class="nav-link <?php echo ($current_page == 'kontak.php') ? 'active' : ''; ?>">Review</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle btn btn-dark text-white" href="#" id="dropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo htmlspecialchars($nama_pengunjung); ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="logout.php">
                <i class="nav-icon fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;&nbsp;<b>Log out</b>
            </a>
        </div>
    </li>
</ul>


  </nav>

  <!-- /.navbar -->
