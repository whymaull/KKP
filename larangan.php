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

<!-- larangan-ketentuan.php -->

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
                                <h5>Larangan & Ketentuan</h5>
                            </div>
                            <div class="card-body">
                                <h6><strong>Barang yang Dilarang:</strong></h6>
                                <ul>
                                    <li><strong>Narkoba dan sejenisnya:</strong> Segala bentuk obat terlarang atau zat
                                        adiktif.</li>
                                    <li><strong>Handphone:</strong> Perangkat komunikasi seluler.</li>
                                    <li><strong>Senjata tajam:</strong> Pisau, gunting, atau alat lain yang berpotensi
                                        membahayakan.</li>
                                    <li><strong>Senjata api:</strong> Segala jenis senjata yang menggunakan peluru.</li>
                                    <li><strong>Laptop:</strong> Komputer jinjing atau perangkat elektronik sejenis.
                                    </li>
                                    <li><strong>Kamera:</strong> Alat untuk mengambil gambar atau merekam video.</li>
                                    <li><strong>Tape recorder:</strong> Alat perekam suara.</li>
                                    <li><strong>Minuman keras:</strong> Alkohol dalam bentuk apapun.</li>
                                    <li><strong>Obat-obatan terlarang:</strong> Obat tanpa resep atau yang dilarang
                                        peredarannya.</li>
                                    <li><strong>Makanan berkemasan kaleng dan kaca:</strong> Untuk mencegah potensi
                                        bahaya.</li>
                                    <li><strong>Makanan dengan aroma menyengat:</strong> Yang dapat mengganggu
                                        lingkungan sekitar.</li>
                                    <li><strong>Rokok dan vape:</strong> Produk tembakau dan rokok elektrik.</li>
                                </ul>
                                <h6><strong>Ketentuan Tambahan:</strong></h6>
                                <ul>
                                    <li><strong>Pakaian:</strong> Pengunjung diharapkan mengenakan pakaian yang sopan.
                                        Dilarang memakai topi, celana pendek, jaket, atau membawa tas ransel.</li>
                                    <li><strong>Barang Bawaan:</strong> Semua barang bawaan akan diperiksa secara
                                        seksama oleh petugas. Produk kemasan mungkin akan dipindahkan ke plastik
                                        transparan yang disediakan oleh pihak Lapas.</li>
                                </ul>
                                <p>Informasi ini sesuai dengan ketentuan yang berlaku di Lapas Kelas I Cipinang. Untuk
                                    memastikan kunjungan berjalan lancar, sebaiknya ikuti semua aturan yang telah
                                    ditetapkan dan selalu berkoordinasi dengan petugas Lapas.</p>
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