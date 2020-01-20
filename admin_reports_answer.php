<?php

session_start();
require_once "connect.php";
$zmienna=$_GET['literka'];

if ($_SESSION['admin']==0 | (!isset($_SESSION['zalogowany'])))
{
    header('Location: institution_home.php');
    exit();
}
$zmieniono = false;
if (isset($_POST['tekst']))
{
    $wszystko_ok = true;
    $zmienna=$_POST['id'];

    $tekst = $_POST['tekst'];

    if(!empty($tekst))
    {
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE zgloszenia SET problem='$tekst', odpowiedz=1 WHERE id=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}
if ($zmieniono==true)
{
    header('Location: admin_reports.php');
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include "css/head.php"; ?>

</head>

<body>
<?php include "css/navbarAdmin.php"; ?>
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
        <?php

        $dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

        foreach ($dbh->query("SELECT * FROM zgloszenia WHERE id='$zmienna'") as $row)
        {
            $idzmienna = $row['id_uzytkownika'];
            foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika='$idzmienna'") as $rows)
            {
                $nazwainstytucji = $rows['email'];
            }
            print "<input type='text' readonly class='form-control-plaintext' name='id' value='".$row['id']."' required/>";
            print "<input type='text' readonly class='form-control-plaintext' name='email' value=$nazwainstytucji required/>";
            echo '<br />';
            echo 'Treść zgłoszenia:';
            echo '<br />';
            print "<textarea type='text' rows='10' class='form-control' id='tekst' name='tekst' required/>" . $row['problem'] . " @odpowiedz</textarea>";
            echo '<br />';
            echo '<button type="submit" class="btn btn-primary">'; echo "Odpowiedz"; echo '</button>';

        }
        ?>
    </form>
</div>
</body>
</html>
