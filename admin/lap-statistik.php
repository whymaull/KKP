<?php
    ob_start();

    date_default_timezone_set('Asia/Jakarta');
    $now = new DateTime();
    $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
    $formattedDate = $formatter->format($now);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_lapas_cipinang"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function getVisitorStatsByMonth($conn) {
        $sql = "SELECT MONTH(tanggal_kunjungan) AS month, COUNT(id_kunjungan) AS total_visits
                FROM kunjungan
                GROUP BY MONTH(tanggal_kunjungan)";
        $result = $conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['month']] = $row['total_visits'];
            }
        }
        
        $visitor_stats = array_fill(0, 12, 0);
        foreach ($data as $month => $total) {
            $visitor_stats[$month - 1] = $total;
        }
        return $visitor_stats;
    }

    function getDeliveryStatsByMonth($conn) {
        $sql = "SELECT MONTH(tanggal_pengiriman) AS month, COUNT(id_pengiriman) AS total_deliveries
                FROM pengiriman_barang
                GROUP BY MONTH(tanggal_pengiriman)";
        $result = $conn->query($sql);
        $data = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['month']] = $row['total_deliveries'];
            }
        }
        
        $delivery_stats = array_fill(0, 12, 0);
        foreach ($data as $month => $total) {
            $delivery_stats[$month - 1] = $total;
        }
        return $delivery_stats;
    }

    $visitorStats = getVisitorStatsByMonth($conn);
    $deliveryStats = getDeliveryStatsByMonth($conn);
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Statistik Lapas</title>
    <style>
        body {
            font-family: Arial, sans-serif; 
            color: #333;
        }
        .header h3, .header h4, .header p {
            text-align: center;
            margin: 0px;
        }
        .line {
            border-top: 3px solid #000;
            margin: 10px auto;
            width: 100%;
        }
        .content h4{
            text-align: center;
        }
        .pengunjung-table {
            border-collapse: collapse;
            margin-top: 15px;
        }
        .pengunjung-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .pengunjung-table td {
            background-color: #fafafa;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .pengunjung-table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
        .signature {
            text-align: right;
        }
        .signature .date-section {
            margin-top: 20px;
            margin-right: 25px;
        }
        .signature .name {
            margin-top: 100px;
        }
        .signature .job{
            margin-right: 25px;
        }
        .signature p{
            margin: 0px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td>
                    <img src="assets/img/logo_lapas.png" width="100" height="120">
                </td>
                <td>
                    <h3>KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA</h3>
                    <h4>REPUBLIK INDONESIA</h4>
                    <h4>KANTOR WILAYAH DKI JAKARTA</h4>
                    <h4>LEMBAGA PEMASYARAKATAN KELAS I CIPINANG</h4>        
                    <p>Jl. H.Darip No.170 Jakarta Timur, 13410</p>
                    <p>Telp (021) 8191012 Fax (021) 8192214</p>
                    <p>Laman: lapascipinang.kemenkumham.go.id, Pos-el: lp.cipinang@kemenkumham.go.id</p>
                </td>
            </tr>   
        </table>
        <div class="line"></div>
    </div>

    <div class="content">
        <h4>DATA STATISTIK PENERIMAAN KUNJUNGAN DAN KIRIMAN LAPAS</h4>
        <table class="pengunjung-table">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle; width: 160px;">Bulan</th>
                    <th colspan="2">Jenis</th>
                    <th rowspan="2" style="vertical-align: middle; width: 100px;">Jumlah</th>
                </tr>
                <tr>
                    <th style="width: 100px;">Kunjungan</th>
                    <th style="width: 100px;">Kiriman Barang</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $total_visits = 0;
                    $total_deliveries = 0;

                    for ($i = 0; $i < 12; $i++) {
                        $monthly_visits = $visitorStats[$i];
                        $monthly_deliveries = $deliveryStats[$i];
                        $monthly_total = $monthly_visits + $monthly_deliveries;

                        $total_visits += $monthly_visits;
                        $total_deliveries += $monthly_deliveries;

                        echo "<tr>
                                <td>{$months[$i]}</td>
                                <td>{$monthly_visits}</td>
                                <td>{$monthly_deliveries}</td>
                                <td>{$monthly_total}</td>
                            </tr>";
                    }
                ?>
                <tr>
                    <th>Total</th>
                    <th><?php echo $total_visits; ?></th>
                    <th><?php echo $total_deliveries; ?></th>
                    <th><?php echo $total_visits + $total_deliveries; ?></th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="signature">
        <p style=" margin-top: 20px; margin-right: 25px;">Jakarta, <?php echo $formattedDate; ?></p>
        <p style="margin-top: 100px;"><strong>Lis Susanti, A.Md.I.P., S.Sos., S.Si.</strong></p>
        <p style="margin-right: 25px;">Kepala Bagian Tata Usaha</p>
    </div>

    <div class="footer">
        <p>© Lapas Cipinang 2024 - Semua Hak Dilindungi</p>
    </div>
</body>
</html>

<?php
    $html = ob_get_contents();
    ob_end_clean();

    require __DIR__ . '/../vendor/autoload.php';

    use Spipu\Html2Pdf\Html2Pdf;

    $html2pdf = new HTML2PDF('P', 'A4', 'id', true, 'UTF-8', [20, 20, 20]);
    $html2pdf->writeHTML($html);
    $html2pdf->Output("Laporan Statistik Lapas.pdf");
?>