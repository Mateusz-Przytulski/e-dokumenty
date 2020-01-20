<?php

session_start();
require_once "connect.php";
$sprawdz = 'Użytkownik';
$sprawdz1 = $_SESSION['rodzaj_uzytkownika'];
if (($sprawdz1 != $sprawdz) | (!isset($_SESSION['zalogowany'])) | $_SESSION['admin']==1)
{
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include "css/head.php"; ?>
</head>

<body>
<?php include "css/navbarUser.php"; ?>

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
        <form action="user_edit_data.php" method="post">
            <h1>Twoje Dane</h1>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Imię:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['imie']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Drugie imię:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['drugie_imie']."' required/>";
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <b><label for="staticEmail" class="col-form-label">Nazwisko:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['nazwisko']."' required/>";
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
                    <b><label for="staticEmail" class="col-form-label">Pesel:</label></b>
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
                    <b><label for="staticEmail" class="col-form-label">Data urodzenia:</label></b>
                </div>
                <div class="col-sm-8">
                    <?php
                    foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika = $licz") as $row)
                    {
                        print "<input type='text' readonly class='form-control-plaintext' value='".$row['data_urodzenia']."' required/>";
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
