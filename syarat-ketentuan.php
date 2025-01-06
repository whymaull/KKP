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

<!-- syarat-ketentuan.php -->

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
                                <h5>Syarat & Ketentuan</h5>
                            </div>
                            <div class="card-body">
                                <!-- isi konten syarat dan ketentuan -->
                                <h6>Persyaratan Kunjungan:</h6>
                                <ul>
                                    <li><strong>Identitas Diri:</strong> Pengunjung wajib membawa kartu identitas asli
                                        yang masih berlaku, seperti KTP, SIM, atau paspor.</li>
                                    <li><strong>Surat Izin Kunjungan:</strong> Bagi warga binaan yang masih berstatus
                                        tahanan, pengunjung harus membawa surat izin kunjungan dari pihak penahan
                                        (kejaksaan, kepolisian, atau pengadilan).</li>
                                </ul>

                                <h6>Ketentuan Kunjungan:</h6>
                                <ul>
                                    <li><strong>Jumlah Pengunjung:</strong> Maksimal 3 orang dewasa dan 2 anak-anak
                                        diperbolehkan untuk mengunjungi satu warga binaan dalam satu sesi kunjungan.
                                    </li>
                                    <li><strong>Frekuensi Kunjungan:</strong> Kunjungan tatap muka hanya diperbolehkan
                                        satu kali dalam sehari dan maksimal dua kali dalam seminggu.</li>
                                </ul>

                                <h6>Pendaftaran Kunjungan:</h6>
                                <p>Pengunjung diharapkan mengunduh aplikasi "Rutan Cipinang" melalui Play Store untuk
                                    melakukan pendaftaran kunjungan. Langkah-langkahnya meliputi:</p>
                                <ul>
                                    <li>Mengisi data pribadi sesuai identitas resmi.</li>
                                    <li>Mengisi data warga binaan yang akan dikunjungi serta memilih tanggal kunjungan.
                                    </li>
                                    <li>Setelah pendaftaran, cetak kertas antrian dengan memindai barcode di tempat Self
                                        Service Kunjungan yang telah disediakan di lokasi.</li>
                                </ul>

                                <h6>Ketentuan Barang Bawaan:</h6>
                                <ul>
                                    <li>Pengunjung tidak diperkenankan membawa barang-barang terlarang seperti
                                        handphone, senjata tajam, narkoba, minuman keras, dan sejenisnya. Semua barang
                                        bawaan akan diperiksa oleh petugas sebelum masuk.</li>
                                </ul>

                                <h6>Pakaian:</h6>
                                <p>Pengunjung diharapkan mengenakan pakaian yang sopan dan tidak diperkenankan memakai
                                    topi, celana pendek, jaket, atau membawa tas ransel.</p>

                                <h6>Kedatangan:</h6>
                                <p>Disarankan untuk datang lebih awal guna mengantisipasi antrean dan memastikan kuota
                                    kunjungan masih tersedia.</p>
                            </div>
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