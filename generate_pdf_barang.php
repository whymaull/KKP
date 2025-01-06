<?php
require_once('lib/tcpdf/tcpdf.php'); // Include the TCPDF library

// Get the barcode code from the query string
$code = isset($_GET['code']) ? $_GET['code'] : '';

if (empty($code)) {
    echo "Invalid barcode code!";
    exit;
}

require_once 'config/database.php';

$query = "SELECT p.*, u.nama_lengkap AS nama_pengirim, w.nama_wbp AS nama_wbp, j.nama_jenis AS nama_jenis
          FROM pengiriman_barang p
          LEFT JOIN users u ON p.id_user = u.id_user  -- Join to get the nama_pengirim
          LEFT JOIN wbp w ON p.id_wbp = w.id_wbp  -- Join to get the nama_wbp
          LEFT JOIN jenis_barang j ON p.id_jenis = j.id_jenis  -- Join to get the nama_jenis
          WHERE p.kode_barcode = :code";

$stmt = $conn->prepare($query);

// Bind the parameter using PDO's bindParam() or bindValue()
$stmt->bindParam(':code', $code, PDO::PARAM_STR);  // :code is a placeholder in the query
$stmt->execute();

// Fetch the result
$pengiriman = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pengiriman) {
    echo "No data found for the given barcode.";
    exit;
}

// Create a new TCPDF instance
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Lapas Cipinang');
$pdf->SetAuthor('Lapas Cipinang');
$pdf->SetTitle('Pengiriman Barcode');
$pdf->SetSubject('Status Pengiriman');

// Add a page to the PDF
$pdf->AddPage();

// Set font for the PDF
$pdf->SetFont('helvetica', '', 12);

// Add the visitor's details
$pdf->Cell(0, 10, 'Nama Pengirim: ' . $pengiriman['nama_pengirim'], 0, 1);
$pdf->Cell(0, 10, 'Hubungan dengan WBP: ' . $pengiriman['hubungan_wbp'], 0, 1);
$pdf->Cell(0, 10, 'Nama WBP: ' . $pengiriman['nama_wbp'], 0, 1);
$pdf->Cell(0, 10, 'Jenis Barang: ' . $pengiriman['nama_jenis'], 0, 1);
$pdf->Cell(0, 10, 'Tanggal Pengiriman: ' . $pengiriman['tanggal_pengiriman'], 0, 1);
$pdf->Cell(0, 10, 'Status: ' . ucfirst($pengiriman['status_pengiriman']), 0, 1);

// Add a space before the barcode
$pdf->Ln(10);

// Add the barcode (QR code)
$pdf->write2DBarcode($code, 'QRCODE,L', 50, 100, 50, 50, null, 'N');

// Output the PDF (force download)
$pdf->Output('pengiriman_' . $pengiriman['kode_barcode'] . '.pdf', 'D'); // 'D' will force download

?>
