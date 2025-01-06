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

    function getAgeDemographics($conn) {
        $sql = "SELECT 
                    FLOOR(DATEDIFF(CURRENT_DATE, tanggal_lahir) / 365) AS age,
                    jenis_kelamin
                FROM users
                WHERE role = 'user'";
        
        $result = $conn->query($sql);

        if (!$result) {
            die("Error: " . $conn->error);
        }

        $age_groups = [
            '<20' => ['laki-laki' => 0, 'perempuan' => 0],
            '20-30' => ['laki-laki' => 0, 'perempuan' => 0],
            '31-40' => ['laki-laki' => 0, 'perempuan' => 0],
            '41-50' => ['laki-laki' => 0, 'perempuan' => 0],
            '>50' => ['laki-laki' => 0, 'perempuan' => 0]
        ];

        $total_male = 0;
        $total_female = 0;

        while ($row = $result->fetch_assoc()) {
            $age = $row['age'];
            $gender = $row['jenis_kelamin'];

            if ($age < 20) {
                $age_groups['<20'][$gender]++;
            } elseif ($age <= 30) {
                $age_groups['20-30'][$gender]++;
            } elseif ($age <= 40) {
                $age_groups['31-40'][$gender]++;
            } elseif ($age <= 50) {
                $age_groups['41-50'][$gender]++;
            } else {
                $age_groups['>50'][$gender]++;
            }

            if ($gender == 'laki-laki') {
                $total_male++;
            } elseif ($gender == 'perempuan') {
                $total_female++;
            }
        }

        $result_data = [];
        foreach ($age_groups as $range => $data) {
            $result_data[] = [
                'range' => $range,
                'Laki-laki' => $data['laki-laki'],
                'Perempuan' => $data['perempuan'],
                'total' => $data['laki-laki'] + $data['perempuan']
            ];
        }

        $result_data['total_gender'] = [
            'Laki-laki' => $total_male,
            'Perempuan' => $total_female,
            'total' => $total_male + $total_female
        ];

        return $result_data;
    }
    $ageDemographics = getAgeDemographics($conn);
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Demografi Pengunjung</title>
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
        <h4>DEMOGRAFI USIA DAN JENIS KELAMIN PENGUNJUNG LAPAS</h4>
        <table class="pengunjung-table">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle; width: 160px;">Jarak Usia</th>
                    <th colspan="2">Jenis Kelamin</th>
                    <th rowspan="2" style="vertical-align: middle; width: 100px;">Jumlah</th>
                </tr>
                <tr>
                    <th style="width: 100px;">Laki-laki</th>
                    <th style="width: 100px;">Perempuan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ageDemographics as $key => $data): ?>
                    <?php if ($key !== 'total_gender'): ?>
                        <tr>
                            <td><?php echo $data['range']; ?></td>
                            <td><?php echo $data['Laki-laki']; ?></td>
                            <td><?php echo $data['Perempuan']; ?></td>
                            <td><?php echo $data['total']; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr style="font-weight: bold; background-color: #f2f2f2;">
                    <td>Total</td>
                    <td><?php echo $ageDemographics['total_gender']['Laki-laki']; ?></td>
                    <td><?php echo $ageDemographics['total_gender']['Perempuan']; ?></td>
                    <td><?php echo $ageDemographics['total_gender']['total']; ?></td>
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
    $html2pdf->Output("Laporan Demografi Pengunjung.pdf");
?>