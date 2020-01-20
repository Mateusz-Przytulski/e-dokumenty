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
<div class="container mt-3">
    <h2 id="opinia" ">Lista dokumentów</h2>
    <input class="form-control" id="myInput" type="text" placeholder="Wyszukaj dokument">
    <br>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>Email</th>
            <th>Nazwa dokumentu</th>
            <th>Rodzaj użytkownika</th>
            <th>Zatwierdzony</th>
            <th>Sprawdź</th>
            <th>Edytuj</th>
            <th>Usuń</th>
        </tr>
        </thead>
        <tbody id="myTable">
        <?php
        $dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

        foreach ($dbh->query("SELECT * FROM dokument ORDER BY zatwierdzony desc") as $row)
        {
            $numerek = $row['id_uzytkownika'];
            foreach ($dbh->query("SELECT * FROM uzytkownik WHERE id_uzytkownika=$numerek") as $rows)
            {
                $nazwainstytucji = $rows['email'];
            }
            echo '<form method="post">';
            echo '<tr>';
            echo '<td>';
            print $nazwainstytucji;
            echo '</td>';
            echo '<td>';
            print $row['nazwa_dokumentu'];
            echo '</td>';
            echo '<td>';
            print $row['rodzaj_uzytkownika'];
            echo '</td>';
            echo '<td>';
            if($row['zatwierdzony']==1){echo 'Tak';} else {echo 'Nie';};
            echo '</td>';
            echo '<td>';
            echo '<a href="' . $row['id']. '.php">';echo "Sprawdź"; '</a>';
            echo '</td>';
            echo '<td>';
            echo '<a href="admin_edit_document.php?literka=' . $row['id']. '">';echo "Edytuj"; '</a>';
            echo '</td>';
            echo '<td>';
            echo '<a href="admin_delete_document.php?literka=' . $row['id']. '">';echo "Usuń"; '</a>';
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
