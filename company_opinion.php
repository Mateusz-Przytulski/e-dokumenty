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

if (!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}
if (isset($_POST['tekst']))
{
    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    if (isset($_SESSION['zalogowany']))
    {
        $iduzytkownika = $_SESSION['id_uzytkownika'];
        $tekst = $_POST['tekst'];
        try
        {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if ($polaczenie->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                if ($polaczenie->query("INSERT INTO opinie VALUES (NULL, '$iduzytkownika', '$tekst')"))
                {
                    header('Location: user_home.php');
                }
                else
                {
                    throw new Exception($polaczenie->error);
                }
                $polaczenie->close();
            }

        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
            echo '<br />Informacja developerska: '.$e;
        }
    }
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
    <form method="post">
        <div class="mb-3">
            <div class="text-center">
                <label class="text-center" for="validationTextarea"><h2>Wystaw opinie</h2></label>
            </div>
            <textarea name="tekst" minlength="20" maxlength="5000" rows="10" class="form-control" id="validationTextarea" placeholder="Napisz swoją opinie" required></textarea>
        </div>
        <p></p>
        <button type="submit" onclick="return confirm('Czy jesteś pewien, że chcesz wystawić opinie?')" class="btn btn-primary">Wystaw</button>
    </form>
</div>
</body>
</html>
