<?php

session_start();

if ((isset($_SESSION['zalogowany']))) {
    header('Location: admin_home.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include "css/head.php"; ?>

</head>

<body>
<?php include "css/navbarNotLogged.php"; ?>
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

<div class="boxData container-fluid">
    <b><p>1. USŁUGI DLA UŻYTKOWNIKÓW I FIRM</p></b>
    <p>1.1 Bezpłatna usługa</p>
    <p>1.1.1 Dostęp do dokumentów opublikowanych w Serwisie</p>
    <p>1.1.2 Dostęp do wystawiania opinii dotyczących Serwisu</p>
    <p>1.2 Rozmowa na czacie online</p>
    <p>1.3 Możliwość edytowania danych</p>
    <div id="test">

    </div>
    <b><p>2. USŁUGI DLA INSTYTUCJI</p></b>
    <p>1.1 Bezpłatne wstawianie dokumentów</p>
    <p>1.1.1 Dostęp do dokumentów opublikowanych w Serwisie</p>
    <p>1.1.2 Dostęp do wystawiania opinii dotyczących Serwisu</p>
    <p>1.2 Rozmowa na czacie online</p>
    <p>1.3 Możliwość edytowania danych</p>
</div>

</body>
</html>
