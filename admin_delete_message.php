<?php

session_start();
require_once "connect.php";
$zmienna=$_GET['literka'];
if(isset($zmienna)){

    $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
    $pdo->exec("SET CHARACTER SET utf8");
    $delete=$pdo->exec("DELETE FROM wiadomosci WHERE id=$zmienna");
    header('Location: chat_admin.php');
    exit();
}
?>