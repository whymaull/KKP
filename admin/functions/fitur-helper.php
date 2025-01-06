<?php
include 'config-admin/database.php';

function getKunjunganStats($conn) {
    $sql = "SELECT 
                COUNT(*) AS total_kunjungan, 
                SUM(CASE WHEN status_kunjungan = 'selesai' THEN 1 ELSE 0 END) AS kunjungan_selesai 
            FROM kunjungan";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getPengirimanStats($conn) {
    $sql = "SELECT 
                COUNT(*) AS total_pengiriman, 
                SUM(CASE WHEN status_pengiriman = 'selesai' THEN 1 ELSE 0 END) AS pengiriman_selesai 
            FROM pengiriman_barang";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>