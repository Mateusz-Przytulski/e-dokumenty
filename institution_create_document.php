<?php

session_start();
require_once "connect.php";
$sprawdz = 'Instytucja';
$sprawdz1 = $_SESSION['rodzaj_uzytkownika'];
if (($sprawdz1 != $sprawdz) | (!isset($_SESSION['zalogowany'])) | $_SESSION['admin']==1)
{
    header('Location: company_home.php');
    exit();
}
if(isset($_POST['typUzytkownika'])) {
    if($_POST['typUzytkownika']=='uzytkownik' || $_POST['typUzytkownika']=='firma'){

if(is_uploaded_file($_FILES['plik']['tmp_name'])) {
    $zmienna = $_POST['typUzytkownika'];
    $nazwa_instytucji = $_SESSION['nazwa_firmy'];
    $email_instytucji = $_SESSION['email'];
    $plik = $_FILES['plik'];
    $nazwa_dokumentu = $_POST['nazwa_dokumentu'];
    $wszystko_OK=true;

    if (isset($_POST['imie']))
    {
        $imie = 1;
    }
    else{
        $imie = 0;
    }

    if (isset($_POST['drugie_imie']))
    {
        $drugie_imie = 1;
    }
    else{
        $drugie_imie = 0;
    }

    if (isset($_POST['nazwisko']))
    {
        $nazwisko = 1;
    }
    else{
        $nazwisko = 0;
    }

    if (isset($_POST['email']))
    {
        $email = 1;
    }
    else{
        $email = 0;
    }

    if (isset($_POST['telefon']))
    {
        $telefon = 1;
    }
    else{
        $telefon = 0;
    }

    if (isset($_POST['data_urodzenia']))
    {
        $data_urodzenia = 1;
    }
    else{
        $data_urodzenia = 0;
    }

    if (isset($_POST['kraj']))
    {
        $kraj = 1;
    }
    else{
        $kraj = 0;
    }

    if (isset($_POST['miasto']))
    {
        $miasto = 1;
    }
    else{
        $miasto = 0;
    }

    if (isset($_POST['adres']))
    {
        $adres = 1;
    }
    else{
        $adres = 0;
    }

    if (isset($_POST['kod_pocztowy']))
    {
        $kod_pocztowy = 1;
    }
    else{
        $kod_pocztowy = 0;
    }

    if (isset($_POST['pesel_nip']))
    {
        $pesel_nip = 1;
    }
    else{
        $pesel_nip = 0;
    }

    if (isset($_POST['regon']))
    {
        $regon = 1;
    }
    else{
        $regon = 0;
    }

    if (isset($_POST['nazwa_firmy']))
    {
        $nazwa_firmy = 1;
    }
    else{
        $nazwa_firmy = 0;
    }
    $idzapis = $_SESSION['id_uzytkownika'];
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {

        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }  else {
            if ($wszystko_OK == true) {
                if ($polaczenie->query("INSERT INTO dokument VALUES (NULL, '$idzapis', '$nazwa_dokumentu','$zmienna', '$imie', '$drugie_imie', '$nazwisko', '$nazwa_firmy','$email', '$telefon', '$data_urodzenia', '$kraj', '$miasto', '$adres', '$kod_pocztowy', '$pesel_nip', '$regon', 0)")) {
                    $_SESSION['udanarejestracja'] = true;



                    header('Location: institution_home.php');
                } else {
                    throw new Exception($polaczenie->error);
                }
                $sql="SELECT * FROM dokument";
                $result = $polaczenie->query($sql);

                while ($row = $result->fetch_assoc())
                {
                    $loka = $row['id'];
                }
                $lokalizacja=''.$loka.'.php';
                if(is_uploaded_file($_FILES['plik']['tmp_name']))
                {
                    if(!move_uploaded_file($_FILES['plik']['tmp_name'], $lokalizacja))
                    {
                        echo 'problem: Nie udało się skopiować pliku do katalogu.';
                        return false;
                    }
                }
            }

            $polaczenie->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        echo '<br />Informacja developerska: ' . $e;
    }
}
    }
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include "css/head.php"; ?>
    <style>
        .error
        {
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
<?php include "css/navbarInstitution.php"; ?>
<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>

<div class="boxData container-fluid">
    <h1 id="opinia">Dodaj własny dokument</h1>
    <p id="opinia">Zanim dodasz dowolny dokument należ <?php
        echo '<a href="download.php">Pobrać</a>';
        ?> i zapoznać się z poradnikiem.</p>
    <div id="test">

    </div>
    <div id="test">

    </div>
    <b><p id="opinia">Dla kogo dokument</p></b>
    <form method="post" enctype="multipart/form-data">
        <div class="nav form-row" role="tablist">
            <div class="form-group col-sm-6">
                <input type="radio" id="uzytkownik" name="typUzytkownika" <?php if (isset($typUzytkownika) && $typUzytkownika=="uzytkownik") echo "checked";?> value="uzytkownik" <?php if(isset($_SESSION['f_zmienna']) && $_SESSION['f_zmienna']=="uzytkownik"){echo 'checked';}?>> Użytkownik
            </div>
            <div class="form-group col-sm-6">
                <input type="radio" id="firma" name="typUzytkownika" <?php if (isset($typUzytkownika) && $typUzytkownika=="firma") echo "checked";?> value="firma" <?php if(isset($_SESSION['f_zmienna']) && $_SESSION['f_zmienna']=="firma"){echo 'checked';}?>> Firma
            </div>
        </div>

        <b><p id="opinia">Nazwa dokumentu</p></b>
        <div class="form-row">
            <input type="text" class="form-control" name="nazwa_dokumentu" placeholder="Nazwa dokumentu">
        </div>
<p></p>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="imie" value=""> Imię</label>
            </div>
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="drugie_imie" value=""> Drugie imię</label>
            </div>
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="nazwisko" value=""> Nazwisko</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="email" value=""> Email</label>
            </div>
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="telefon" value=""> Telefon</label>
            </div>
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="data_urodzenia" value=""> Data urodzenia</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="kraj" value=""> Kraj</label>
            </div>
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="miasto" value=""> Miasto</label>
            </div>
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="adres" value=""> Adres</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="kod_pocztowy" value=""> Kod pocztowy</label>
            </div>
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="pesel_nip" value=""> Pesel lub NIP</label>
            </div>
            <div class="form-group col-md-4">
                <label><input type="checkbox" name="regon" value=""> Regon</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label><input type="checkbox" name="nazwa_firmy" value=""> Nazwa firmy</label>
            </div>
        </div>
        <b><p id="opinia">Dodaj plik</p></b>
        <div class="form-group">
            <input type="file" class="form-control-file border" name="plik">
        </div>

        <p></p>
        <button type="submit" class="btn btn-primary">Wyślij dokument</button>
    </form>
</div>

</body>
</html>