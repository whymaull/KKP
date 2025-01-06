<?php
session_start();

require_once 'config/database.php';
include_once 'functions/user.php';

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- jadwal-kunjungan.php -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Lapas Cipinang Jakarta</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo_lapas.png" />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <?php include 'assets/components/navbar.php';?>
            <?php include 'assets/components/sidebar.php';?>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Jadwal Kunjungan Lapas Cipinang Jakarta</h5>
                            </div>
                            <div class="card-body">
                                <h6>Hari Kunjungan:</h6>
                                <ul>
                                    <li>Senin hingga Kamis: Layanan kunjungan tersedia.</li>
                                    <li>Jumat hingga Minggu dan Hari Libur Nasional: Layanan kunjungan ditiadakan.</li>
                                </ul>

                                <h6>Jam Kunjungan:</h6>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sesi</th>
                                            <th>Waktu</th>
                                            <th>Kuota Pengunjung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sesi 1</td>
                                            <td>09.00 - 10.00 WIB</td>
                                            <td>100 pengunjung</td>
                                        </tr>
                                        <tr>
                                            <td>Sesi 2</td>
                                            <td>10.30 - 11.30 WIB</td>
                                            <td>65 pengunjung</td>
                                        </tr>
                                        <tr>
                                            <td>Sesi 3</td>
                                            <td>12.30 - 14.30 WIB</td>
                                            <td>35 pengunjung</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <h6>Ketentuan Kunjungan:</h6>
                                <ul>
                                    <li>Frekuensi Kunjungan: Setiap warga binaan dapat menerima kunjungan tatap muka
                                        satu kali dalam sehari dan maksimal dua kali dalam seminggu.</li>
                                    <li>Masa Tunggu: Warga binaan dapat dikunjungi setelah 7 hari sejak dipindahkan ke
                                        Rutan.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer -->
            <?php include 'assets/components/footer.php'; ?>

        </div>
    </div>

    <!-- JS Scripts -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>