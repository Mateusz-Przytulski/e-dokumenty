<?php
$dane = file_get_contents('C:\xampp\htdocs\WypelnianieDokumentow\e_dokumenty_pdf.rar');
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename=e_dokumenty_pdf.rar');
header('Content-length: '.strlen($dane));
echo $dane;

?>
