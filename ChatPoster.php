<?php
session_start();
require_once "connect.php";
$db = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

if(isset($_POST['text']) && isset($_POST['name'])) {
    $tresc = strip_tags(stripslashes($_POST['text']));
    $id = $_SESSION['id_uzytkownika'];

    if(!empty($tresc)) {
        $insert = $db->prepare("INSERT INTO wiadomosci VALUES(NULL, '.$id.', '".$tresc."')");
        $insert->execute();

    }
}
?>



