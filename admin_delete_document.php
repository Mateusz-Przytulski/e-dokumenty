<?php

session_start();
$zmienna=$_GET['literka'];
if(isset($zmienna)){
    require_once "connect.php";
    $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
    $pdo->exec("SET CHARACTER SET utf8");
    $delete=$pdo->exec("DELETE FROM dokument WHERE id=$zmienna");
    header('Location: admin_list_of_documents.php');
    exit();
}
?>