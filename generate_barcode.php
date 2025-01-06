<?php
require_once 'lib/phpqrcode/qrlib.php'; // Include the PHP QR Code library

$path = 'assets/img/qrcode/';
$qrCodeFile = $path . time() . ".png"; // Path where the QR code will be saved

// Get the barcode code from the query string
$code = isset($_GET['code']) ? $_GET['code'] : ''; 

// Check if barcode is valid
if (!empty($code)) {
    // Set the content type to PNG image
    header('Content-Type: image/png');

    // Generate the QR code and output it directly
    QRcode::png($code, false, QR_ECLEVEL_H, 3); // Change the error correction level and size as needed
} else {
    echo "Invalid barcode code!";
}
?>
