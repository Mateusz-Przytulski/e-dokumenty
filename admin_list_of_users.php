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
    <h2 id="opinia">Lista osób zarejestrowanych</h2>
    <input class="form-control" id="myInput" type="text" placeholder="Wyszukaj użytkownika">
    <br>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th>Login</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Nazwisko</th>
            <th>Miasto</th>
            <th>Adres</th>
            <th>Pesel/NIP</th>
            <th>Edytuj</th>
            <th>Usuń</th>
        </tr>
        </thead>
        <tbody id="myTable">
        <?php
        $dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

        foreach ($dbh->query("SELECT * FROM uzytkownik ORDER BY admin desc") as $row)
        {
            echo '<form method="post">';
            echo '<tr>';
            echo '<td>';
            print $row['login'];
            echo '</td>';
            echo '<td>';
            print $row['email'];
            echo '</td>';
            echo '<td>';
            print $row['telefon'];
            echo '</td>';
            echo '<td>';
            print $row['nazwisko'];
            echo '</td>';
            echo '<td>';
            print $row['miasto'];
            echo '</td>';
            echo '<td>';
            print $row['adres'];
            echo '</td>';
            echo '<td>';
            print $row['pesel_nip'];
            echo '</td>';
            echo '<td>';
            echo '<a href="admin_edit_user.php?literka=' . $row['id_uzytkownika']. '">';echo "Edytuj"; '</a>';

            echo '</td>';
            echo '<td>';
            echo '<a href="admin_delete_user.php?literka=' . $row['id_uzytkownika']. '">';echo "Usuń"; '</a>';
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
