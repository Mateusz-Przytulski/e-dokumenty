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
    $imie = $row['imie'];
    $drugie_imie = $row['drugie_imie'];
    $nazwisko = $row['nazwisko'];
    $email = $row['email'];
    $kraj = $row['kraj'];
    $miasto = $row['miasto'];
    $adres = $row['adres'];
    $kodpocztowy = $row['kod_pocztowy'];
    $pesel_lub_nip = $row['pesel_nip'];
    $dataurodzenia = $row['data_urodzenia'];
    $nazwa_firmy = $row['nazwa_firmy'];
    $regon = $row['regon'];
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


$pdf->Cell(130 ,8,''.$imie.' '.$nazwisko.'',0,0);
$pdf->Cell(59 ,8,''.$miasto.' '.date("Y-m-d").'',0,1);
$pdf->Cell(130 ,8,'Nr PESEL:'.$pesel_lub_nip.'',0,1);
$pdf->Cell(0 ,15,'',0,1);
$pdf->Cell(120 ,8,'',0,0);
$pdf->Cell(69 ,8,'Pełnomocnik',0,1,'L');
$pdf->Cell(120 ,8,'',0,0);
$pdf->Cell(69 ,8,'ds. Praktyk',0,1,'L');
$pdf->Cell(120 ,8,'',0,0);
$pdf->Cell(69 ,8,'mgr inż. Mirosław',0,1,'L');
$pdf->Cell(0 ,15,'',0,1);
$pdf->MultiCell(189 ,8,"    Zwracam się z uprzejmą prośbą o wyrażenie zgody na odbywanie praktyki w panstwa firmie.",0,1);
$pdf->Cell(0 ,15,'',0,1);
$pdf->Cell(120 ,3,'',0,0);
$pdf->MultiCell(60 ,3,'..........................................',0,1);
$pdf->Cell(120 ,8,'',0,0);
$pdf->Cell(60 ,8,'Czytelny podpis',0,1, 'C');

$pdf->Output();
?>

