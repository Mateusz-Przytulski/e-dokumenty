<?php
session_start();
require_once "connect.php";
$zmienna=$_GET['literka'];
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
<div class="boxData container-fluid" id="opinia">
    <form id="logcenter" method="POST">
        <?php
        if ($_SESSION['admin']==1)
        {
            require_once "connect.php";
            $polaczenie = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            foreach ($polaczenie->query("SELECT * FROM dokument WHERE id=$zmienna") as $row)
            {
            }
            if($polaczenie->query("SELECT * FROM dokument WHERE id='".$zmienna."'"))
            {

                echo '<h1>'; echo"Potwierdź dokument"; echo '</h1>';
                echo "Admin:"; echo '<br />';
                if($row['zatwierdzony']==1){$potwierdzony="Zatwierdzony";} else {$potwierdzony="Niezatwierdzony";};
                print "<select name='potwierdzenie'> <option selected>".$potwierdzony."</option><option value='0'>Nie</option></option><option value='1'>Potwierdź</option></select>";
                echo '<br />';
                echo '<br />'; echo '<br />';
                ?>
                <input type='submit' value='Edytuj' name='edytuj' class='btn btn-primary' onclick="return confirm('Czy jesteś pewien, że chcesz edytować?')">
                <?php
            }
        }
        ?>

    </form>
</div>
<?php
if(isset($_POST['edytuj'])){
    $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

    $potwierdzenie = $_POST['potwierdzenie'];

    $sth = $pdo->prepare("UPDATE dokument SET zatwierdzony='$potwierdzenie' WHERE id=$zmienna");
    $sth->execute();
    header('Location: admin_list_of_documents.php');
    exit();
}
?>

</body>
</html>