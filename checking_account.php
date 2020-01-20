<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
{
    header('Location: logowanie.php');
    exit();
}

require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno!=0)
{
    echo "Error: ".$polaczenie->connect_errno;
}
else
{
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");

    if ($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM uzytkownik WHERE login='%s'",
            mysqli_real_escape_string($polaczenie,$login))))
    {
        $ilu_userow = $rezultat->num_rows;
        if($ilu_userow>0)
        {
            $wiersz = $rezultat->fetch_assoc();

            if (password_verify($haslo, $wiersz['haslo']))
            {
                $_SESSION['zalogowany'] = true;
                $_SESSION['id_uzytkownika'] = $wiersz['id_uzytkownika'];
                $_SESSION['admin'] = $wiersz['admin'];
                $_SESSION['login'] = $wiersz['login'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['telefon'] = $wiersz['telefon'];
                $_SESSION['imie'] = $wiersz['imie'];
                $_SESSION['drugie_imie'] = $wiersz['drugie_imie'];
                $_SESSION['nazwisko'] = $wiersz['nazwisko'];
                $_SESSION['kraj'] = $wiersz['kraj'];
                $_SESSION['miasto'] = $wiersz['miasto'];
                $_SESSION['adres'] = $wiersz['adres'];
                $_SESSION['kod_pocztowy'] = $wiersz['kod_pocztowy'];
                $_SESSION['pesel_nip'] = $wiersz['pesel_nip'];
                $_SESSION['data_urodzenia'] = $wiersz['data_urodzenia'];
                $_SESSION['nazwa_firmy'] = $wiersz['nazwa_firmy'];
                $_SESSION['rodzaj_uzytkownika'] = $wiersz['rodzaj_uzytkownika'];
                $_SESSION['regon'] = $wiersz['regon'];


                unset($_SESSION['blad']);
                $rezultat->free_result();
                header('Location: admin_home.php');
            }
            else
            {
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: login.php');
            }
        } else {

            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
            header('Location: login.php');

        }

    }

    $polaczenie->close();
}
?>