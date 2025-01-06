<?php
function getVisitorStatsByMonth($conn) {
    $sql = "SELECT MONTH(tanggal_kunjungan) AS month, COUNT(id_kunjungan) AS total_visits
            FROM kunjungan
            GROUP BY MONTH(tanggal_kunjungan)";
    $stmt = $conn->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Inisialisasi array dengan nilai 0 untuk setiap bulan
    $visitor_stats = array_fill(0, 12, 0); // 12 bulan (Jan-Dec)
    
    foreach ($data as $row) {
        $visitor_stats[$row['month'] - 1] = $row['total_visits'];
    }
    return $visitor_stats;
}


function getDeliveryStatsByMonth($conn) {
    // Get delivery data for each month
    $sql = "SELECT MONTH(tanggal_pengiriman) AS month, COUNT(id_pengiriman) AS total_deliveries
            FROM pengiriman_barang
            GROUP BY MONTH(tanggal_pengiriman)";
    $stmt = $conn->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Initialize an array for all months (1 to 12)
    $delivery_stats = array_fill(0, 12, 0);  // Default to 0 for all months
    
    // Populate the delivery stats with actual data
    foreach ($data as $row) {
        $delivery_stats[$row['month'] - 1] = $row['total_deliveries'];  // Adjust month index (1-based to 0-based)
    }

    return $delivery_stats;
}


function getVisitStatsBySession($conn) {
    $sql = "SELECT 
                MONTH(tanggal_kunjungan) AS month,
                COUNT(CASE WHEN sesi_kunjungan = 'Sesi 1' THEN 1 END) AS sesi1,
                COUNT(CASE WHEN sesi_kunjungan = 'Sesi 2' THEN 1 END) AS sesi2,
                COUNT(CASE WHEN sesi_kunjungan = 'Sesi 3' THEN 1 END) AS sesi3
            FROM kunjungan
            GROUP BY MONTH(tanggal_kunjungan)";
    $stmt = $conn->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $visit_stats = [
        'total' => [],
        'sesi1' => [],
        'sesi2' => [],
        'sesi3' => []
    ];
    foreach ($data as $row) {
        $visit_stats['total'][] = $row['sesi1'] + $row['sesi2'] + $row['sesi3'];
        $visit_stats['sesi1'][] = $row['sesi1'];
        $visit_stats['sesi2'][] = $row['sesi2'];
        $visit_stats['sesi3'][] = $row['sesi3'];
    }
    return $visit_stats;
}

function getAgeDemographics($conn) {
    $sql = "SELECT 
                FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) AS age
            FROM users
            WHERE role ='user'";
    $stmt = $conn->query($sql);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $age_groups = ['<20' => 0, '20-30' => 0, '31-40' => 0, '41-50' => 0, '>50' => 0];
    foreach ($data as $row) {
        $age = $row['age'];
        if ($age < 20) {
            $age_groups['<20']++;
        } elseif ($age <= 30) {
            $age_groups['20-30']++;
        } elseif ($age <= 40) {
            $age_groups['31-40']++;
        } elseif ($age <= 50) {
            $age_groups['41-50']++;
        } else {
            $age_groups['>50']++;
        }
    }

    return [
        'labels' => array_keys($age_groups),
        'values' => array_values($age_groups)
    ];
}
?>
