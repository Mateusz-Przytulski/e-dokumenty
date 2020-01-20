<?php

session_start();
$zmienna=$_GET['literka'];
if(isset($zmienna)){
    require_once "connect.php";
    $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
    $pdo->exec("SET CHARACTER SET utf8");
    $delete1=$pdo->exec("DELETE FROM zgloszenia WHERE id_uzytkownika=$zmienna");
    $delete2=$pdo->exec("DELETE FROM wiadomosci WHERE id_uzytkownika=$zmienna");
    $delete3=$pdo->exec("DELETE FROM opinie WHERE id_uzytkownika=$zmienna");
    $delete4=$pdo->exec("DELETE FROM dokument WHERE id_uzytkownika=$zmienna");
    $delete=$pdo->exec("DELETE FROM uzytkownik WHERE id_uzytkownika=$zmienna");
    header('Location: admin_list_of_users.php');
    exit();
}
?>