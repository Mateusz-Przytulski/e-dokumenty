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
    <form method="get">
        <h1 id="opinia">Odpowiedzi na zgłoszenia</h1>
        <?php

        $dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

        $sprawdzenie = $_SESSION['id_uzytkownika'];
        foreach ($dbh->query("SELECT * FROM zgloszenia WHERE id_uzytkownika='$sprawdzenie'") as $row)
        {
            $sprawdz=$row['odpowiedz'];
            if($sprawdz==1) {
                echo '<br />';
                echo '<br />';
                echo 'Treść zgłoszenia:';
                echo '<br />';
                print "<textarea type='text' rows='10' class='form-control' id='tekst' name='tekst' required/>" . $row['problem'] . "</textarea>";
                echo '<br />';
                echo '<a href="user_reports_answer.php?literka=' . $row['id']. '">'; echo "Przejdź"; echo '</a>';
                echo '<br />';
                echo '<hr />';

            }
        }
        ?>
    </form>
</div>
</body>
</html>
