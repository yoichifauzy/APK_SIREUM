<?php
require '../config/database.php';

// Ambil data kategori dan jumlahnya dari database untuk Area Chart
$sql = "SELECT k.nama_kategori, COUNT(g.id_foto) AS jumlah_foto
        FROM kategori k
        LEFT JOIN galeri g ON k.id_kategori = g.id_kategori
        GROUP BY k.nama_kategori";
$result = $koneksi->query($sql);

$area_labels = [];
$area_data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $area_labels[] = $row['nama_kategori'];
        $area_data[] = $row['jumlah_foto'];
    }
}

$area_labels_json = json_encode($area_labels);
$area_data_json = json_encode($area_data);

$query_reservasi = "SELECT SUM(jumlah_pengunjung) as total_jumlah_pengunjung FROM reservasi";
$result_reservasi = $koneksi->query($query_reservasi);

$query_operator = "SELECT COUNT(*) as jumlah_operator FROM operator";
$result_operator = $koneksi->query($query_operator);

$bar_labels = ['Jumlah Pengunjung', 'Jumlah Operator'];
$bar_data = [];

if ($result_reservasi && $result_reservasi->num_rows > 0) {
    $row = $result_reservasi->fetch_assoc();
    $bar_data[] = $row['total_jumlah_pengunjung'];
}

if ($result_operator && $result_operator->num_rows > 0) {
    $row = $result_operator->fetch_assoc();
    $bar_data[] = $row['jumlah_operator'];
}

$bar_labels_json = json_encode($bar_labels);
$bar_data_json = json_encode($bar_data);

$query2 = "SELECT jenis_kelamin_pengunjung, COUNT(*) as jumlah_pengunjung FROM pengunjung GROUP BY jenis_kelamin_pengunjung";
$result2 = $koneksi->query($query2);

$gender_labels = [];
$gender_data = [];

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $gender_labels[] = $row['jenis_kelamin_pengunjung'];
        $gender_data[] = $row['jumlah_pengunjung'];
    }
}

$gender_labels_json = json_encode($gender_labels);
$gender_data_json = json_encode($gender_data);

$query3 = "
    SELECT 
        SUM(CASE WHEN r.status_reservasi = 'Dikonfirmasi' THEN 1 ELSE 0 END) AS total_dikonfirmasi_reservasi,
        SUM(CASE WHEN r.status_reservasi = 'Menunggu Konfirmasi' THEN 1 ELSE 0 END) AS total_belum_dikonfirmasi_reservasi,
        SUM(CASE WHEN t.status_transaksi = 'Sukses' THEN 1 ELSE 0 END) AS total_sukses_transaksi,
        SUM(CASE WHEN t.status_tiket = 1 THEN 1 ELSE 0 END) AS total_tiket_dikonfirmasi,
        SUM(CASE WHEN t.status_tiket = 0 THEN 1 ELSE 0 END) AS total_tiket_belum_dikonfirmasi
    FROM reservasi r
    LEFT JOIN transaksi t ON r.id_reservasi = t.id_reservasi;
";
$result3 = $koneksi->query($query3);
$row3 = $result3->fetch_assoc();

$status_labels = ['Dikonfirmasi Reservasi', 'Belum Dikonfirmasi Reservasi', 'Sukses Transaksi', 'Tiket Dikonfirmasi', 'Tiket Belum Dikonfirmasi'];
$status_data = [
    $row3['total_dikonfirmasi_reservasi'],
    $row3['total_belum_dikonfirmasi_reservasi'],
    $row3['total_sukses_transaksi'],
    $row3['total_tiket_dikonfirmasi'],
    $row3['total_tiket_belum_dikonfirmasi']
];

$status_labels_json = json_encode($status_labels);
$status_data_json = json_encode($status_data);

$query4 = "
    SELECT 
        n.nama_negara AS kewarganegaraan,
        COUNT(p.id_pengunjung) AS jumlah_pengunjung
    FROM 
        pengunjung p
    INNER JOIN 
        negara n
    ON 
        p.kewarganegaraan = n.id_negara
    GROUP BY 
        n.nama_negara
    ORDER BY 
        jumlah_pengunjung DESC;
";
$result4 = $koneksi->query($query4);

$country_labels = [];
$country_data = [];

if ($result4->num_rows > 0) {
    while ($row = $result4->fetch_assoc()) {
        $country_labels[] = $row['kewarganegaraan'];
        $country_data[] = $row['jumlah_pengunjung'];
    }
}

$country_labels_json = json_encode($country_labels);
$country_data_json = json_encode($country_data);


// Ambil data dari tabel reservasi
$query5 = "SELECT jam_kunjungan FROM reservasi";
$result5 = $koneksi->query($query5);

$pagi = 0;
$siang = 0;
$sore = 0;
$malam = 0;

while ($row = $result5->fetch_assoc()) {
    $jam_kunjungan = $row['jam_kunjungan'];
    if ($jam_kunjungan >= '08:00:00' && $jam_kunjungan <= '10:30:00') {
        $pagi++;
    } elseif ($jam_kunjungan >= '10:35:00' && $jam_kunjungan <= '14:00:00') {
        $siang++;
    } elseif ($jam_kunjungan >= '14:05:00' && $jam_kunjungan <= '18:00:00') {
        $sore++;
    } elseif ($jam_kunjungan >= '18:05:00' && $jam_kunjungan <= '22:00:00') {
        $malam++;
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | ChartJS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-orange">
              <div class="card-header">
                <h3 class="card-title">Jumlah Kategori dalam Galeri</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 00px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Jenis Kelamin pengunjung</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 00px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- PIE CHART -->
            <div class="card card-lightblue">
              <div class="card-header">
                <h3 class="card-title">Jumlah Staus Dari Reservasi dan Transaksi</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 00px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-teal">
              <div class="card-header">
                <h3 class="card-title">Jumlah Registrasi Pengunjung dari Tiap Negara</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 00px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- BAR CHART -->
            <div class="card card-fuchsia">
              <div class="card-header">
                <h3 class="card-title">Perbandingan Jumlah Pengunjung dan Operator</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 00px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- STACKED BAR CHART -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Waktu Kunjungan Dari Pengunjung ke Museum</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="min-height: 00px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Add Content Here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
<script src="../assets/dist/js/adminlte.js"></script>
<script src="../assets/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    function getRandomColor() {
        return 'rgba(' + [
            Math.floor(Math.random() * 256),
            Math.floor(Math.random() * 256),
            Math.floor(Math.random() * 256),
            0.8
        ].join(',') + ')';
    }

    // Area Chart
    var areaLabels = <?php echo $area_labels_json; ?>;
    var areaData = <?php echo $area_data_json; ?>;
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
    var areaChartData = {
        labels: areaLabels,
        datasets: [{
            label: 'Jumlah Foto',
            backgroundColor: getRandomColor(),
            borderColor: getRandomColor(),
            data: areaData
        }]
    };
    new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: {
            maintainAspectRatio: false,
            responsive: true,
        }
    });

    // Donut Chart
    var genderLabels = <?php echo $gender_labels_json; ?>;
    var genderData = <?php echo $gender_data_json; ?>;
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
    var donutData = {
        labels: genderLabels,
        datasets: [{
            data: genderData,
            backgroundColor: genderLabels.map(() => getRandomColor()),
        }]
    };
    new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: {
            maintainAspectRatio: false,
            responsive: true,
        }
    });

    // Pie Chart
    var statusLabels = <?php echo $status_labels_json; ?>;
    var statusData = <?php echo $status_data_json; ?>;
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieData = {
        labels: statusLabels,
        datasets: [{
            data: statusData,
            backgroundColor: statusLabels.map(() => getRandomColor()),
        }]
    };
    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: {
            maintainAspectRatio: false,
            responsive: true,
        }
    });

    // Line Chart
    var countryLabels = <?php echo $country_labels_json; ?>;
    var countryData = <?php echo $country_data_json; ?>;
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
    var lineChartData = {
        labels: countryLabels,
        datasets: [{
            label: 'Registrasi Pengunjung',
            backgroundColor: getRandomColor(),
            borderColor: getRandomColor(),
            data: countryData
        }]
    };
    new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: {
            maintainAspectRatio: false,
            responsive: true,
        }
    });

    // Bar Chart
    var barLabels = <?php echo $bar_labels_json; ?>;
    var barData = <?php echo $bar_data_json; ?>;
    var barChartCanvas = $('#barChart').get(0).getContext('2d');
    var barChartData = {
        labels: barLabels,
        datasets: [{
            label: 'Jumlah',
            backgroundColor: barLabels.map(() => getRandomColor()),
            data: barData
        }]
    };
    new Chart(barChartCanvas, {
        type: 'polarArea',
        data: barChartData,
        options: {
            maintainAspectRatio: false,
            responsive: true,
        }
    });

    var ctx = document.getElementById('stackedBarChart').getContext('2d');
        var stackedBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Kunjungan'],
                datasets: [
                    {
                        label: 'Pagi',
                        data: [<?php echo $pagi; ?>],
                        backgroundColor: 'rgba(254, 254, 22, 0.9)'
                    },
                    {
                        label: 'Siang',
                        data: [<?php echo $siang; ?>],
                        backgroundColor: 'rgba(246, 2, 2, 0.9)'
                    },
                    {
                        label: 'Sore',
                        data: [<?php echo $sore; ?>],
                        backgroundColor: 'rgba(244, 216, 150, 0.55)'
                    },
                    {
                        label: 'Malam',
                        data: [<?php echo $malam; ?>],
                        backgroundColor: 'rgba(19, 26, 26, 0.9)'
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return Number.isInteger(value) ? value.toString() : null;
                            },
                            stepSize: 1
                        }
                    }
                }
            }
        });
  });
</script>

</body>
</html>
