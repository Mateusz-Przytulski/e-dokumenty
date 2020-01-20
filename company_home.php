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

<button onclick="topFunction()" id="stopka" title="Idź w górę"><img src="css/img/s1.png" width="30"></button>

<img src="css/img/tlo3.png" alt="" class="img-fluid">

<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>
<div style="background-color: rgb(192, 222, 232);">
    <h1 id="opinia">O nas</h1>

    <p id="opinia">Bezpłatny program</p>
    <p id="opinia">Oferujemy szybkie wypełnianie i tworzenie dokumentów</p>
    <p id="opinia">Możliwość komunikacji poprzez czat online z innymi użytkownikami bądź administracją.</p>
</div>
<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>
<div  style="background-color: rgb(211, 209, 209);">
    <h2 id="opinia">Opinie</h2>
    <div id="test">

    </div>

    <div class="form-row" >
        <?php

        $dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

        foreach ($dbh->query("SELECT * FROM opinie") as $row)
        {
            $zmienna=$row['id'];

            $opinia=$row['opinia'];

            if($zmienna%3==0){

                echo '<div class="form-group col-md-4">';
                echo '<label>';

                echo '</label>';
                print "<textarea type='text' rows='3' class='form-control rounded-0' id='test2' name='tekst' required/>$opinia</textarea>";
                echo '</div>';
            }
            if($zmienna%3!=0) {
                echo '<div class="form-group col-md-4">';
                echo '<label>';

                echo '</label>';
                print "<textarea type='text' rows='3' class='form-control rounded-0' id='test2' name='tekst' required/>$opinia</textarea>";
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>
<div id="test">

</div>
<footer class="position-static">
    <div class="nav form-row" >
        <div class="form-group col-sm-10">
            <br/>
            Copyright © 2018-2019 EDOKUMENTY | Stworzone przez Mateusz Przytulski studenta VI semestru Informatyki | Na potrzeby pracy dyplomowej
        </div>

        <div class="form-group col-sm-2">

        </div>
    </div>

</footer>

<script>
    <?php
    include "js/stopka.js";
    ?>
</script>
</body>
</html>