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
<div class="container mt-3">
    <h2 id="opinia" ">Lista dokumentów</h2>
    <input class="form-control" id="myInput" type="text" placeholder="Wyszukaj dokument">
    <br>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>Nazwa dokumentu</th>
            <th>Sprawdź</th>
            <th>Uzupełnij dane</th>
        </tr>
        </thead>
        <tbody id="myTable">
        <?php
        $dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

        foreach ($dbh->query("SELECT * FROM dokument WHERE zatwierdzony=1 AND rodzaj_uzytkownika='firma'") as $row)
        {
            echo '<form method="post">';
            echo '<tr>';
            echo '<td>';
            print $row['nazwa_dokumentu'];
            echo '</td>';

            echo '<td>';
            echo '<a href="' . $row['id']. '.php">';echo "Sprawdź"; '</a>';
            echo '</td>';
            echo '<td>';
            echo '<a href="company_fill_in_the_data.php?literka=' . $row['id']. '">';echo "Uzupełnij dane"; '</a>';
            echo '</td>';
            echo '</tr>';
            echo '</form>';
        }
        ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</div>
</body>
</html>
