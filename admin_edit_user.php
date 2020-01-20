<?php

session_start();
require_once "connect.php";
$zmienna=$_GET['literka'];
if ($_SESSION['admin']==0)
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
    <div class="boxData container-fluid" style="text-align: center;">
        <form id="logcenter" method="POST">
            <?php
            if ($_SESSION['admin']==1)
            {
                $polaczenie = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
                foreach ($polaczenie->query("SELECT * FROM uzytkownik WHERE id_uzytkownika=$zmienna") as $row)
                {
                }
                if($polaczenie->query("SELECT * FROM uzytkownik WHERE id_uzytkownika='".$zmienna."'"))
                {
                    $loka = $row['id_uzytkownika'];
                    echo '<h1>'; echo"Edytuj uzytkownika"; echo '</h1>';
                    echo "Login"; echo '<br />';
                    print "<input type='text' name='login' value='".$row['login']."' required/>";
                    echo '<br />';
                    echo "E-mail"; echo '<br />';
                    print "<input type='text' name='email' value='".$row['email']."' required/>";
                    echo '<br />';
                    echo "Admin:"; echo '<br />';
                    print "<select name='admin'> <option selected>".$row['admin']."</option><option value='0'>zabierz</option></option><option value='1'>daj admina</option></select>";
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
        $login = $_POST['login'];
        $email = $_POST['email'];
        $admin = $_POST['admin'];

        $sth = $pdo->prepare("UPDATE uzytkownik SET login='$login', email='$email', admin='$admin' WHERE id_uzytkownika=$zmienna");
        $sth->execute();
        header('Location: admin_list_of_users.php');
        exit();
    }
    ?>

</body>
</html>