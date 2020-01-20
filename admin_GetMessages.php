<?php
require_once "connect.php";
 $db = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);

  $query = $db->prepare("SELECT * FROM wiadomosci");
  $query ->execute();

  while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
    $iduzytkownika = $fetch['id_uzytkownika'];
    $wiadomosc = $fetch['wiadomosc'];
    $id = $fetch['id'];
      foreach ($db->query("SELECT * FROM uzytkownik WHERE id_uzytkownika='$iduzytkownika'") as $row)
      {
          $email = $row['email'];
      }

      echo "<li id='$id' class='msg'><b>$email:</b> ".$wiadomosc." <a href='admin_delete_message.php?literka=$id'> Skasuj</a></li> ";
  }
?>
