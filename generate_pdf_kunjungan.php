<?php
require_once('lib/tcpdf/tcpdf.php'); // Include the TCPDF library

// Get the barcode code from the query string
$code = isset($_GET['code']) ? $_GET['code'] : '';

if (empty($code)) {
    echo "Invalid barcode code!";
    exit;
}

// Fetch the kunjungan details along with the visitor's name and WBP's name from the database
require_once 'config/database.php';

// Prepare the query to fetch kunjungan details and join with the users table to get the names
$query = "SELECT k.*, u.nama_lengkap AS nama_pengunjung, w.nama_wbp AS nama_wbp
          FROM kunjungan k
          LEFT JOIN users u ON k.id_user = u.id_user  -- Join to get the nama_pengunjung
          LEFT JOIN wbp w ON k.id_wbp = w.id_wbp  -- Join to get the nama_wbp
          WHERE k.kode_barcode = :code";

$stmt = $conn->prepare($query);

// Bind the parameter using PDO's bindParam() or bindValue()
$stmt->bindParam(':code', $code, PDO::PARAM_STR);  // :code is a placeholder in the query
$stmt->execute();

// Fetch the result
$kunjungan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kunjungan) {
    echo "No data found for the given barcode.";
    exit;
}

// Create a new TCPDF instance
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Lapas Cipinang');
$pdf->SetAuthor('Lapas Cipinang');
$pdf->SetTitle('Kunjungan Barcode');
$pdf->SetSubject('Status Kunjungan');

// Add a page to the PDF
$pdf->AddPage();

// Set font for the PDF
$pdf->SetFont('helvetica', '', 12);

// Add the visitor's details
$pdf->Cell(0, 10, 'Nama Pengunjung: ' . $kunjungan['nama_pengunjung'], 0, 1);
$pdf->Cell(0, 10, 'Hubungan dengan WBP: ' . $kunjungan['hubungan_wbp'], 0, 1);
$pdf->Cell(0, 10, 'Nama WBP: ' . $kunjungan['nama_wbp'], 0, 1);
$pdf->Cell(0, 10, 'Sesi: ' . $kunjungan['sesi_kunjungan'], 0, 1);
$pdf->Cell(0, 10, 'Tanggal Kunjungan: ' . $kunjungan['tanggal_kunjungan'], 0, 1);
$pdf->Cell(0, 10, 'Status: ' . ucfirst($kunjungan['status_kunjungan']), 0, 1);

// Add a space before the barcode
$pdf->Ln(10);

// Add the barcode (QR code)
$pdf->write2DBarcode($code, 'QRCODE,L', 50, 100, 50, 50, null, 'N');

// Output the PDF (force download)
$pdf->Output('kunjungan_' . $kunjungan['kode_barcode'] . '.pdf', 'D'); // 'D' will force download

?>
