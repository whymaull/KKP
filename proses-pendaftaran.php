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

<!-- proses-pendaftaran.php -->

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
                                <h5>Proses Pendaftaran Online</h5>
                            </div>
                            <div class="card-body">
                                <h6>A. Akses Situs Web atau Aplikasi Resmi</h6>
                                <p>Kunjungi situs web atau aplikasi resmi milik Kementerian Hukum dan HAM atau Lapas
                                    terkait. Biasanya, layanan ini tersedia di <a href="https://www.ditjenpas.go.id"
                                        target="_blank">https://www.ditjenpas.go.id</a> atau situs khusus Lapas tempat
                                    Anda ingin melakukan kunjungan.</p>

                                <h6>B. Registrasi Akun</h6>
                                <p>Jika Anda belum memiliki akun, lakukan registrasi terlebih dahulu dengan memasukkan
                                    data pribadi yang diperlukan seperti:</p>
                                <ul>
                                    <li>Nama lengkap</li>
                                    <li>Nomor Identitas (KTP/SIM/Passport)</li>
                                    <li>Alamat email dan nomor telepon yang aktif</li>
                                    <li>Kata sandi untuk akun</li>
                                </ul>

                                <h6>C. Login ke Sistem</h6>
                                <p>Masuk ke sistem menggunakan akun yang telah Anda buat dengan memasukkan email dan
                                    kata sandi.</p>

                                <h6>D. Pilih Menu Pendaftaran Kunjungan</h6>
                                <p>Setelah masuk, pilih menu "Pendaftaran Kunjungan" atau "Kunjungan Online". Baca
                                    syarat dan ketentuan sebelum melanjutkan.</p>

                                <h6>E. Isi Formulir Pendaftaran</h6>
                                <p>Masukkan informasi berikut:</p>
                                <ul>
                                    <li>Nama pengunjung</li>
                                    <li>Hubungan dengan warga binaan (contoh: keluarga, teman, pengacara)</li>
                                    <li>Nama dan nomor identitas warga binaan yang akan dikunjungi</li>
                                    <li>Pilihan tanggal dan waktu kunjungan</li>
                                    <li>Alamat tempat tinggal pengunjung</li>
                                </ul>

                                <h6>F. Unggah Dokumen Pendukung</h6>
                                <p>Beberapa Lapas mungkin meminta Anda untuk mengunggah dokumen seperti:</p>
                                <ul>
                                    <li>Foto KTP</li>
                                    <li>Surat izin dari pihak tertentu (jika diperlukan)</li>
                                    <li>Surat tes kesehatan (terutama selama pandemi)</li>
                                </ul>

                                <h6>G. Konfirmasi dan Kirim</h6>
                                <p>Periksa kembali data yang telah diisi. Pastikan tidak ada kesalahan. Klik tombol
                                    "Kirim" atau "Daftar".</p>

                                <h6>H. Tunggu Persetujuan</h6>
                                <p>Sistem akan memproses pendaftaran Anda. Tunggu notifikasi melalui email atau pesan di
                                    aplikasi mengenai status permohonan kunjungan Anda (disetujui atau ditolak).</p>

                                <h6>I. Unduh atau Simpan Bukti Pendaftaran</h6>
                                <p>Jika permohonan disetujui, Anda akan mendapatkan bukti pendaftaran kunjungan berupa
                                    kode QR atau nomor referensi. Simpan bukti tersebut untuk ditunjukkan saat melakukan
                                    kunjungan ke Lapas.</p>

                                <h6>J. Lakukan Kunjungan Sesuai Jadwal</h6>
                                <p>Datang ke Lapas sesuai dengan jadwal yang telah dipilih. Tunjukkan bukti pendaftaran
                                    (kode QR atau nomor referensi) kepada petugas. Pastikan membawa dokumen fisik yang
                                    mungkin diperlukan, seperti KTP asli.</p>
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