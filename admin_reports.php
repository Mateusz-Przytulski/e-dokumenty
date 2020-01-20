<?php

session_start();
require_once "connect.php";
if ($_SESSION['admin']==0 | (!isset($_SESSION['zalogowany'])))
{
    header('Location: institution_home.php');
    exit();
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
    <form method="get">
        <?php

        $dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

        foreach ($dbh->query("SELECT * FROM zgloszenia") as $row)
        {
            $zmienna = $row['id_uzytkownika'];
            foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika='$zmienna'") as $rows)
            {
                $email = $rows['email'];
            }


            $sprawdz=$row['odpowiedz'];
            if($sprawdz==0) {
                print $email;
                echo '<br />';
                echo '<br />';
                echo 'Treść zgłoszenia:';
                echo '<br />';
                print "<textarea type='text' rows='10' class='form-control' id='tekst' name='tekst' required/>" . $row['problem'] . "</textarea>";
                echo '<br />';
                echo '<a href="admin_reports_answer.php?literka=' . $row['id']. '">'; echo "Przejdź"; echo '</a>';
                echo '<br />';
                echo '<hr />';

            }
        }
        ?>
    </form>
</div>
</body>
</html>
