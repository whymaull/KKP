<?php
session_start();
include 'functions/auth-admin.php';
include 'functions/jadwal-helper.php';
include 'functions/chart-helper.php';
include 'functions/fitur-helper.php';

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: /kkp-lapas/login.php");
  exit;
}

$visitor_stats = getVisitorStatsByMonth($conn);  
$delivery_stats = getDeliveryStatsByMonth($conn);
$visit_stats = getVisitStatsBySession($conn);
$age_groups = getAgeDemographics($conn);

// Panggil fungsi untuk mendapatkan data pengguna
$userDetails = getUserData($conn, $_SESSION['id_user']);

$stmt = $conn->query($sql_kunjungan); 
$result_kunjungan = $stmt->fetchAll(PDO::FETCH_ASSOC); 
$jadwal_kunjungan = [];
foreach ($result_kunjungan as $row) {
    $jadwal_kunjungan[] = [
        'title' => $row['nama_pengunjung'],
        'start' => $row['tanggal_kunjungan'],
        'backgroundColor' => '#00bcd4'
    ];
}

$stmt = $conn->query($sql_pengiriman); 
$result_pengiriman = $stmt->fetchAll(PDO::FETCH_ASSOC);
$jadwal_pengiriman = [];
foreach ($result_pengiriman as $row) {
    $jadwal_pengiriman[] = [
        'title' => $row['nama_pengirim'],
        'start' => $row['tanggal_pengiriman'],
        'backgroundColor' => '#fe9701'
    ];
}

// Gabungkan data kunjungan dan pengiriman
$events = array_merge($jadwal_kunjungan, $jadwal_pengiriman);

// Untuk mendapatkan total kunjungan dan kiriman barang
$kunjunganStats = getKunjunganStats($conn);
$pengirimanStats = getPengirimanStats($conn);
?>
<!DOCTYPE html>
<html lang="en">


<!-- index.php -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Lapas Cipinang Jakarta</title>
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/bundles/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/toggle.css">
    <link rel='shortcut icon' type='image/x-icon' href='assets/img/logo_lapas.png' />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <!-- navbar -->
            <?php include 'assets/components/navbar.php'; ?>

            <!-- sidebar -->
            <?php include 'assets/components/sidebar.php'; ?>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <!-- chart start -->
                    <div class="col-14">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik Pengunjung</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart4" class="chartsh"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Statistik Kunjungan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="summary">
                                        <div class="summary-chart active" data-tab-group="summary-tab"
                                            id="summary-chart">
                                            <div id="chart3" class="chartsh"></div>
                                        </div>
                                        <div data-tab-group="summary-tab" id="summary-text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Demografi Usia Pengunjung</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart2" class="chartsh"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chart end -->

                    <!-- feature start -->
                    <div class="row ">
                        <!-- feature 1 -->
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-statistic-4">
                                    <div class="align-items-center justify-content-between">
                                        <div class="row ">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                                <div class="card-content">
                                                    <h5 class="font-19">Kunjungan</h5>
                                                    <h2 class="mb-3 font-22"><?= $kunjunganStats['total_kunjungan']; ?>
                                                    </h2>
                                                    <p class="mb-0"><span
                                                            class="col-green"><?= $kunjunganStats['kunjungan_selesai']; ?>
                                                            Selesai</span></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                                <div class="banner-img">
                                                    <img src="assets/img/banner/1.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- feature 2 -->
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-statistic-4">
                                    <div class="align-items-center justify-content-between">
                                        <div class="row ">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                                <div class="card-content">
                                                    <h5 class="font-19">Kiriman</h5>
                                                    <h2 class="mb-3 font-22">
                                                        <?= $pengirimanStats['total_pengiriman']; ?></h2>
                                                    <p class="mb-0"><span
                                                            class="col-green"><?= $pengirimanStats['pengiriman_selesai']; ?>
                                                            Selesai</span></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                                <div class="banner-img">
                                                    <img src="assets/img/banner/notif.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- feature end -->

                        <!-- jadwal kunjungan start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Jadwal Kunjungan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="fc-overflow">
                                        <div id="jadwalKunjungan"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- jadwal kunjungan end -->
                </section>
            </div>
            <!-- footer -->
            <?php include 'assets/components/footer.php'; ?>
        </div>
    </div>
    <!-- JS Scripts -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/bundles/fullcalendar/fullcalendar.min.js"></script>
    <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
    var events = <?php echo json_encode($events); ?>;
    var calendar = $('#jadwalKunjungan').fullCalendar({
        height: 'auto',
        defaultView: 'month',
        editable: true,
        selectable: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
        },
        events: events
    });
    </script>
    <script>
    // Data for charts passed from PHP to JavaScript
    const visitorStats = <?php echo json_encode($visitor_stats); ?>;
    const deliveryStats = <?php echo json_encode($delivery_stats); ?>;
    const visitStats = <?php echo json_encode($visit_stats); ?>;
    const ageGroups = <?php echo json_encode($age_groups); ?>;

    // Months for x-axis
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    // Calculate the maximum value from both visitorStats and deliveryStats
    const maxVisitorStats = Math.max(...visitorStats);
    const maxDeliveryStats = Math.max(...deliveryStats);
    const maxStatsValue = Math.max(maxVisitorStats, maxDeliveryStats);

    // Chart for Visitor Stats (Month-wise, Line Chart)
    var optionsVisitorStats = {
        chart: {
            type: 'line',
            height: 350
        },
        series: [{
                name: 'Kunjungan',
                data: visitorStats
            },
            {
                name: 'Pengiriman Barang',
                data: deliveryStats
            }
        ],
        xaxis: {
            categories: months,
            labels: {
                rotate: -45,
                style: {
                    fontSize: '12px',
                    colors: ['#000'],
                }
            }
        },
        colors: ['#00bcd4', '#fe9701'],
        stroke: {
            curve: 'smooth'
        },
        markers: {
            size: 5,
            colors: ['#00bcd4', '#fe9701'],
            hover: {
                size: 7
            }
        },
        tooltip: {
            shared: true,
            intersect: false
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center'
        },
        yaxis: {
            max: maxStatsValue,
        },
    };
    new ApexCharts(document.querySelector("#chart4"), optionsVisitorStats).render();

    // Chart for Visit Stats (Total & Sesi-wise, Stacked Bar Chart)
    var optionsVisitStats = {
        chart: {
            type: 'bar',
            height: 350
        },
        series: [{
                name: 'Total Kunjungan',
                data: visitStats.total
            },
            {
                name: 'Sesi 1',
                data: visitStats.sesi1
            },
            {
                name: 'Sesi 2',
                data: visitStats.sesi2
            },
            {
                name: 'Sesi 3',
                data: visitStats.sesi3
            }
        ],
        xaxis: {
            categories: months,
            rotate: -45,
            style: {
                fontSize: '12px',
                colors: ['#000'],
            }
        },
        colors: ['#3498db', '#1abc9c', '#f39c12'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'rounded'
            }
        },
        tooltip: {
            shared: true,
            intersect: false
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center'
        },
        dataLabels: {
            enabled: false
        },
        yaxis: {
            max: maxStatsValue,
        },
    };
    new ApexCharts(document.querySelector("#chart3"), optionsVisitStats).render();

    // Chart for Age Demographics (Pie Chart)
    var optionsAgeGroups = {
        chart: {
            type: 'pie',
            height: 360,
            toolbar: {
                show: false
            }
        },
        series: ageGroups.values,
        labels: ageGroups.labels,
        colors: ['#e74c3c', '#f39c12', '#2ecc71', '#3498db', '#9b59b6'],
        tooltip: {
            y: {
                formatter: function(value) {
                    return value + " Pengunjung";
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center'
        }
    };
    new ApexCharts(document.querySelector("#chart2"), optionsAgeGroups).render();
    </script>


</body>

</html>