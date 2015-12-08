<?
include "qrcode/phpqrcode.php";
$value=$_GET["ct"];
$errorCorrectionLevel = "L";
$matrixPointSize = "20";
QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);
exit;
?>