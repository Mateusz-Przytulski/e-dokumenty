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

    <div id="logowanie">
        <div class="boxData container-fluid">
            <form action="checking_account.php" method="post">
                <h1>Logowanie</h1>
                <br /><input type="text" name="login" placeholder="Login" required/> <br />
                 <br /><input type="password" name="haslo" placeholder="Hasło" required/> <br /> <br />

                <input type="checkbox" class="btn btn-primary" /> Zapamiętaj mnie<br />
                <p></p>
                <input type="submit" value="Zaloguj się" class="btn btn-primary" /> <br />

                Nie masz jeszcze konta? <span><div><a style="color: gray;" href="register.php">Zarejestruj się!</a></div></span>

                <?php
                    if(isset($_SESSION['blad'])){
                        echo $_SESSION['blad'];
                        unset($_SESSION['blad']);
                    }
                ?>
            </form>
        </div>
    </div>


</body>
</html>