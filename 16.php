<?php
//Strona A4 posiada 219mm
//Do dyspozycji jest 189mm

//wpisanie tekstu
//$pdf->Cell(podajemy szerokość od lewej strony ,wysokość,'tekst', ramka przy samym tekście domyślnie 0, kończenie linii 1-nowa linia 0-zostajemy);
//przykład: $pdf->Cell(130 ,5,''.$nazwainstytucji.'',0,0);

//tworzenie kolumn
//$pdf->Cell(podajemy szerokość od lewej strony, wysokość kolumny, 'tekst', ramka przy tworzeniu kolumn 1, nowa linia 1-nowa linia 0-zostajemy, tekst do lewej, wyśrodkowany, do prawej 'L/C/R');
//przykład: $pdf->Cell(60, 6, 'Aircraft', 1, 0, 'C');

//ustawianie czcionki
//$pdf->SetFont(ustawienie czcionki DejaVu pozwala na polskie znaki, styl zostawiamy pusty, rozmiar czcionki);
//przykład: $pdf->SetFont('DejaVu','',14);

//ustawianie koloru
//$pdf->SetTextColor(red,green,blue); zmiana koloru czcionki
//$pdf->SetTextColor(255,255,255); ustawienie koloru na biały

//wysokość odstępu najlepiej stosowaćprzy tworzeniu kolumn
//$pdf->Ln(wysokość odstępu);
//przykład: $pdf->Ln(0); stosowany przy kolumnach zrobi 0odstęp

//zmienne w polu tekstowym
//''.$miasto.', '.$kodpocztowy.' ul. '.$adres.'' ///// pobierze miasto, kod pocztowy, i dopisze ul. adres

//dzisiejsza data
//'.date("Y-m-d").''

//możliwe do wykorzystania zmienne:
//użytkownik: $imie, $drugie_imie, $nazwisko, $email, $kraj, $miasto, $adres, $kodpocztowy, $pesel_lub_nip, $dataurodzenia
//firma: $email, $kraj, $miasto, $adres, $kodpocztowy, $pesel_lub_nip, $dataurodzenia, $nazwa_firmy, $regon

session_start();
$zmienna = $_SESSION['id_uzytkownika'];
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$dbh = new mysqli($host, $db_user, $db_password, $db_name);
foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika=$zmienna") as $row)
{
                                $imie=$row['imie'];
                                $drugie_imie=$row['drugie_imie'];
                                $nazwisko=$row['nazwisko'];
                                $email=$row['email'];
                                $kraj=$row['kraj'];
                                $miasto=$row['miasto'];
                                $adres=$row['adres'];
                                $kodpocztowy=$row['kod_pocztowy'];
                                $pesel_lub_nip=$row['pesel_nip'];
                                $dataurodzenia=$row['data_urodzenia'];
                                $nazwa_firmy=$row['nazwa_firmy'];
                                $regon=$row['regon'];
                            }

require('fpdf/fpdf.php');
require('t2/tfpdf.php');
define('FPDF_FONTPATH','t2/font/');

//tworzymy obiekt pdf
$pdf = new tFPDF();

//dodanie dowej strony
$pdf->AddPage();
//ustawienie polskich znaków i czcionki 14pt
$pdf->AddFont('DejaVu','','arial.ttf',true);
$pdf->SetFont('DejaVu','',14);


$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(34 ,5,''.$miasto.', '.date("Y-m-d").'',0,1);

$pdf->Cell(130 ,0.2,'...............................................................',0,0);
$pdf->Cell(34 ,0.2,'.......................................',0,1);

$pdf->Cell(0 ,2,'',0,1);

$pdf->SetFont('DejaVu','',9);

$pdf->Cell(30 ,5,'',0,0);
$pdf->Cell(113 ,5,'(nazwa instytucji)',0,0);
$pdf->Cell(20 ,5,'(miejscowość i data)',0,1);

$pdf->SetFont('DejaVu','',14);

$pdf->Cell(0 ,10,'',0,1);

$pdf->Cell(130 ,5,''.$imie.' '.$nazwisko.'',0,1);

$pdf->Cell(130 ,0.2,'...............................................................',0,1);

$pdf->Cell(0 ,2,'',0,1);

$pdf->SetFont('DejaVu','',9);

$pdf->Cell(30 ,5,'',0,0);
$pdf->Cell(113 ,10,'(imię i nazwisko)',0,1);

$pdf->SetFont('DejaVu','',14);

$pdf->Cell(130 ,5,''.$dataurodzenia.'',0,0);
$pdf->Cell(34 ,5,''.$pesel_lub_nip.'',0,1);

$pdf->Cell(130 ,0.2,'...............................................................',0,0);
$pdf->Cell(34 ,0.2,'.......................................',0,1);

$pdf->Cell(0 ,2,'',0,1);

$pdf->SetFont('DejaVu','',9);

$pdf->Cell(30 ,5,'',0,0);
$pdf->Cell(123 ,5,'(data urodzenia)',0,0);
$pdf->Cell(20 ,5,'(pesel)',0,1);

$pdf->SetFont('DejaVu','',14);

$pdf->Cell(140 ,5,'',0,1);

$pdf->Cell(140 ,5,''.$miasto.', '.$kodpocztowy.' ul. '.$adres.'',0,1);

$pdf->Cell(140 ,0.5,'......................................................................................................................................',0,1);

$pdf->Cell(0 ,2,'',0,1);

$pdf->SetFont('DejaVu','',9);

$pdf->Cell(90 ,5,'',0,0);
$pdf->Cell(113 ,5,'(adres)',0,1);

$pdf->Cell(0 ,10,'',0,1);


$pdf->SetFont('DejaVu','',14);

$pdf->Ln(8);
$pdf->Cell(60, 6, ''.$email.'', 1, 0, 'C');
$pdf->Cell(129, 6, ''.$miasto.', '.$kodpocztowy.' ul. '.$adres.'', 1, 0, 'C');

$pdf->Ln();

$pdf->Cell(30, 6, ''.$imie.'', 1);
$pdf->Cell(30, 6, ''.$nazwisko.'', 1);
$pdf->Cell(32.25, 6, ''.$kraj.'', 1, 0, 'C');
$pdf->Cell(32.25, 6, ''.$miasto.'', 1, 0, 'C');
$pdf->Cell(32.25, 6, ''.$kodpocztowy.'', 1, 0, 'C');
$pdf->Cell(32.25, 6, ''.$dataurodzenia.'', 1, 0, 'C');
$pdf->Ln(8);

$pdf->Cell(0 ,30,'',0,1);

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(34 ,5,'.......................................',0,1);

$pdf->SetFont('DejaVu','',9);

$pdf->Cell(30 ,5,'',0,0);
$pdf->Cell(115 ,5,'',0,0);
$pdf->Cell(20 ,5,'(czytelny podpis)',0,1);

$pdf->SetFont('DejaVu','',14);




$pdf->SetTextColor(255,255,255);



$pdf->Output();
?>

