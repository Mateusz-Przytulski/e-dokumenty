<?php

session_start();
require_once "connect.php";
$sprawdz = 'Firma';
$sprawdz1 = $_SESSION['rodzaj_uzytkownika'];
if (($sprawdz1 != $sprawdz) | (!isset($_SESSION['zalogowany'])) | $_SESSION['admin']==1)
{
    header('Location: user_home.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include "css/head.php"; ?>
</head>

<body>
<?php include "css/navbarCompany.php"; ?>

<?php
require_once "connect.php";
$dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
$licz = $_SESSION['id_uzytkownika'];
?>
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
    <div class="col-sm-12 col-md-12 text-center">
        <form action="company_edit_data.php" method="post">
            <h1>Twoje Dane</h1>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Nazwa:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['nazwa_firmy']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Email:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['email']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Numer telefonu:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['telefon']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">NIP:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['pesel_nip']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Regon:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['regon']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Kraj:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['kraj']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Miasto:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['miasto']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Adres:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='ul. ".$row['adres']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Kod pocztowy:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['kod_pocztowy']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-2" >Edytuj Dane</button>
        </form>
    </div>
</div>
</body>
</html>
