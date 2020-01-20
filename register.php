<?php

session_start();
if ((isset($_SESSION['zalogowany']))) {
    header('Location: admin_home.php');
    exit();
}
if (isset($_POST['uzytkownikLogin']))
{
    $zmienna = $_POST['typUzytkownika'];
    if($zmienna == "uzytkownik"){

    $wszystko_OK=true;

    //Sprawdź poprawność loginu
    $loginuzytkownik = $_POST['uzytkownikLogin'];

    if ((strlen($loginuzytkownik) < 5) || (strlen($loginuzytkownik) > 21)) {
        $wszystko_OK = false;
        $_SESSION['u_login'] = "Login musi posiadać od 6 do 20 znaków!";
    }

    //sprawdzanie czy login ma polskie znaki
    if (ctype_alnum($loginuzytkownik) == false) {
        $wszystko_OK = false;
        $_SESSION['u_login'] = "Login nie może składać z polskich znaków";
    }

    //Sprawdź poprawność hasła
    $haslouzytkownik = $_POST['uzytkownikHaslo'];
    $haslosprawdz = '/^[0-9a-zA-Ząćęłńóśźż\\-]+$/';
    if ((strlen($haslouzytkownik) < 5) || (strlen($haslouzytkownik) > 21)) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = "Hasło musi posiadać od 6 do 20 znaków!";
    }
    if (preg_match($haslosprawdz, $haslouzytkownik) == false) {
        $wszystko_OK = false;
        $_SESSION['e_haslo'] = "Hasło nie może składać z polskich znaków";
    }

    $haslo_hash = password_hash($haslouzytkownik, PASSWORD_DEFAULT);

    // Sprawdź poprawność adresu email
    $emailuzytkownik = $_POST['uzytkownikEmail'];
    $emailB = filter_var($emailuzytkownik, FILTER_SANITIZE_EMAIL);

    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $emailuzytkownik)) {
        $wszystko_OK = false;
        $_SESSION['u_email'] = "Podaj poprawny adres e-mail!";
    }

    //sprawdzenie numeru telefonu
    $telefon = $_POST['uzytkownikTelefon'];

    if (strlen($telefon) != 11) {
        $wszystko_OK = false;
        $_SESSION['u_nrtelefonu'] = "Telefon musi posiadać 9cyfrowy numer!";
    }

    $telefonsprawdz = '/[0-9]{3}[\\-]{1}[0-9]{3}[\\-]{1}[0-9]{3}+$/';
    if (preg_match($telefonsprawdz, $telefon) == false) {
        $wszystko_OK = false;
        $_SESSION['u_nrtelefonu'] = "Numer telefonu musi zawierać 9cyfrowy numer!";
    }

    //sprawdzenie imienia
    $imie = $_POST['uzytkownikImie'];
    $sprawdz = '/^[A-Za-zĄĘÓŁŻŹąęółśżźćń]+$/';

    if (preg_match($sprawdz, $imie) == false) {
        $wszystko_OK = false;
        $_SESSION['u_imie'] = "Imię musi zaczynać się z wielkiej litery a następnie z małych";
    }



    //sprawdzenie drugiego imienia
    $drugieimie = $_POST['uzytkownikDrugieimie'];
    if (strlen($drugieimie) != 0) {
        if (preg_match($sprawdz, $drugieimie) == false) {
            $wszystko_OK = false;
            $_SESSION['u_drugieimie'] = "Drugie imię musi zaczynać się z wielkiej litery a następnie z małych";
        }


    }

    //sprawdzanie nazwiska
    $nazwisko = $_POST['uzytkownikNazwisko'];

    if (preg_match($sprawdz, $nazwisko) == false) {
        $wszystko_OK = false;
        $_SESSION['u_nazwisko'] = "Nazwisko musi zaczynać się z wielkiej litery a następnie z małych";

    }



    //Czy zaakceptowano regulamin?
    if (!isset($_POST['regulamin'])) {
        $wszystko_OK = false;
        $_SESSION['e_regulamin'] = "Potwierdź akceptację regulaminu!";
    }

    //Zapamiętaj wprowadzone dane
    $_SESSION['fr_loginUzytkownik'] = $loginuzytkownik;
    $_SESSION['fr_hasloUzytkownik'] = $haslouzytkownik;
    $_SESSION['fr_emailUzytkownik'] = $emailuzytkownik;
    $_SESSION['fr_telefonUzytkownik'] = $telefon;
    $_SESSION['fr_imieUzytkownik'] = $imie;
    $_SESSION['fr_drugieimieUzytkownik'] = $drugieimie;
    $_SESSION['fr_nazwiskoUzytkownik'] = $nazwisko;
    $_SESSION['f_zmienna'] = $zmienna;

    if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            //Czy login jest już zarezerwowany?
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE login='$loginuzytkownik'");

            if (!$rezultat) throw new Exception($polaczenie->error);

            $ile_takich_nickow = $rezultat->num_rows;
            if ($ile_takich_nickow > 0) {
                $wszystko_OK = false;
                $_SESSION['u_login'] = "Istnieje już taki login!";
            }

            //Czy email już istnieje?
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE email='$emailuzytkownik'");

            if (!$rezultat) throw new Exception($polaczenie->error);

            $ile_takich_maili = $rezultat->num_rows;
            if ($ile_takich_maili > 0) {
                $wszystko_OK = false;
                $_SESSION['u_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
            }

            //Czy nr telefonu juz istnieje
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE telefon='$telefon'");
            if (!$rezultat) throw new Exception($polaczenie->error);
            $ile_takich_numerow = $rezultat->num_rows;
            if ($ile_takich_numerow > 0) {
                $wszystko_OK = false;
                $_SESSION['u_nrtelefonu'] = "Istnieje już konto przypisane do tego numeru telefonu!";
            }

            if ($wszystko_OK == true) {
                //Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy

                if ($polaczenie->query("INSERT INTO uzytkownik VALUES (NULL, 0, '$loginuzytkownik', '$haslo_hash', '$emailuzytkownik', '$telefon', '$imie', '$drugieimie', '$nazwisko', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', 'Nie podano', '', 'Użytkownik','')")) {
                    $_SESSION['udanarejestracja'] = true;
                    header('Location: login.php');
                } else {
                    throw new Exception($polaczenie->error);
                }
            }
            $polaczenie->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
        echo '<br />Informacja developerska: ' . $e;
    }

    }
}

if (isset($_POST['firmaLogin']))
{
    $wszystko_OK=true;
    if($zmienna == "firma") {
        //Sprawdź poprawność loginu
        $loginfirma = $_POST['firmaLogin'];

        if ((strlen($loginfirma) < 5) || (strlen($loginfirma) > 21)) {
            $wszystko_OK = false;
            $_SESSION['f_loginfirmy'] = "login musi posiadać od 6 do 20 znaków!";
        }

        //sprawdzanie czy login ma polskie znaki
        if (ctype_alnum($loginfirma) == false) {
            $wszystko_OK = false;
            $_SESSION['f_loginfirmy'] = "Login nie może składać z polskich znaków";
        }

        //Sprawdź poprawność hasła
        $haslofirma = $_POST['firmaHaslo'];
        $haslosprawdz = '/^[0-9a-zA-Ząćęłńóśźż\\-]+$/';

        if ((strlen($haslofirma) < 5) || (strlen($haslofirma) > 21)) {
            $wszystko_OK = false;
            $_SESSION['f_haslofirmy']="Hasło musi posiadać od 6 do 20 znaków!";
        }

        if (preg_match($haslosprawdz, $haslofirma) == false) {
            $wszystko_OK = false;
            $_SESSION['f_haslofirmy']="Hasło nie może składać z polskich znaków";
        }

        $haslo_hash = password_hash($haslofirma, PASSWORD_DEFAULT);

        // Sprawdź poprawność adresu email
        $emailfirma = $_POST['firmaEmail'];
        $emailB = filter_var($emailfirma, FILTER_SANITIZE_EMAIL);

        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $emailfirma)) {
            $wszystko_OK = false;
            $_SESSION['f_emailfirmy']="Podaj poprawny adres e-mail!";
        }

        //sprawdzenie nazwy firmy
        $nazwafirmy = $_POST['firmaNazwa'];
        $sprawdz = '/^[a-zA-Ząćęłńóśźż\\ \\-]+$/';

        if (preg_match($sprawdz, $nazwafirmy) == false) {
            $wszystko_OK = false;
            $_SESSION['f_nazwafirmy']="Nazwa firmy nie może mieć znaków specjalnych lub liczb";
        }

        //sprawdzenie nip
        $nip = $_POST['firmaNip'];

        if (strlen($nip) != 13) {
            $wszystko_OK = false;
            $_SESSION['f_nipfirmy']="NIP musi posiadać 10cyfrowy numer!";
        }

        $nipsprawdz = '/[0-9]{3}[\\-]{1}[0-9]{3}[\\-]{1}[0-9]{2}[\\-][0-9]{2}+$/';
        if (preg_match($nipsprawdz, $nip) == false) {
            $wszystko_OK = false;
            $_SESSION['f_nipfirmy']="NIP musi zawierać 10cyfrowy numer!";
        }

        //sprawdzenie kraju
        $krajfirma = $_POST['firmaKraj'];

        if (preg_match($sprawdz, $krajfirma) == false) {
            $wszystko_OK = false;
            $_SESSION['f_krajFirma']="Zła nazaw kraju";
        }

        if (ctype_alpha($krajfirma) == false) {
            $wszystko_OK = false;
            $_SESSION['f_krajFirma']="Kraj nie powinien mieć cyfr lub znaków specjalnych!";
        }

        //sprawdzanie adresu
        $adresfirmy = $_POST['firmaAdres'];
        $sprawdzadres = '/^[0-9a-zA-Ząćęłńóśźż\\-\\ ]+$/';

        if (preg_match($sprawdzadres, $adresfirmy) == false) {
            $wszystko_OK = false;
            $_SESSION['f_adresfirmy']="Zły adres firmy";
        }

        //sprawdzenie nip
        $kodpocztowyfirma = $_POST['firmaKodpocztowy'];

        if (strlen($kodpocztowyfirma) != 6) {
            $wszystko_OK = false;
            $_SESSION['f_kodpocztowyfirmy']="Kod pocztowy musi posiadać 5cyfrowy numer!";
        }

        $kodpocztowysprawdz = '/[0-9]{2}[\\-]{1}[0-9]{3}+$/';
        if (preg_match($kodpocztowysprawdz, $kodpocztowyfirma) == false) {
            $wszystko_OK = false;
            $_SESSION['f_kodpocztowyfirmy']="Kod pocztowy musi zawierać 5cyfrowy numer!";
        }

        //sprawdzenie miasta firmy
        $miastofirmy = $_POST['firmaMiasto'];
        $sprawdz = '/^[a-zA-Ząćęłńóśźż\\ \\-]+$/';

        if (preg_match($sprawdz, $miastofirmy) == false) {
            $wszystko_OK = false;
            $_SESSION['f_miastofirmy']="Miasto nie może mieć znaków specjalnych lub liczb";
        }

        //Czy zaakceptowano regulamin?
        if (!isset($_POST['regulamin2'])) {
            $wszystko_OK = false;
            $_SESSION['e_regulamin2'] = "Potwierdź akceptację regulaminu!";
        }

        //Zapamiętaj wprowadzone dane

        $_SESSION['fr_loginFirma'] = $loginfirma;
        $_SESSION['fr_hasloFirma'] = $haslofirma;
        $_SESSION['fr_emailFrima'] = $emailfirma;
        $_SESSION['fr_nazwaFirma'] = $nazwafirmy;
        $_SESSION['fr_nipFirma'] = $nip;
        $_SESSION['fr_krajFirma'] = $krajfirma;
        $_SESSION['fr_adresFirma'] = $adresfirmy;
        $_SESSION['fr_kodpocztowyFirma'] = $kodpocztowyfirma;
        $_SESSION['fr_miastoFirma'] = $miastofirmy;
        $_SESSION['f_zmienna'] = $zmienna;

        if (isset($_POST['regulamin2'])) $_SESSION['fr_regulamin2'] = true;

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if ($polaczenie->connect_errno != 0) {
                throw new Exception(mysqli_connect_errno());
            } else {
                //Czy login jest już zarezerwowany?
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE login='$loginfirma'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nickow = $rezultat->num_rows;
                if ($ile_takich_nickow > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_loginfirmy'] = "Istnieje już taki login!";
                }

                //Czy email już istnieje?
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE email='$emailfirma'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_maili = $rezultat->num_rows;
                if ($ile_takich_maili > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_emailfirmy'] = "Istnieje już konto przypisane do tego adresu e-mail!";
                }

                //Czy nazwa firmy juz istnieje
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE nazwa_firmy='$nazwafirmy'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nazwfirm = $rezultat->num_rows;
                if ($ile_takich_nazwfirm > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_nazwafirmy'] = "Istnieje już konto przypisane do nazwy firmy!";
                }

                //Czy nip juz istnieje
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE pesel_nip='$nip'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nipfirm = $rezultat->num_rows;
                if ($ile_takich_nipfirm > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_nipfirmy'] = "Istnieje już konto przypisane do tego NIP-u!";
                }

                //Czy adres juz istnieje
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE adres='$adresfirmy'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nipfirm = $rezultat->num_rows;
                if ($ile_takich_nipfirm > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_nipfirmy'] = "Istnieje już konto przypisane do tego NIP-u!";
                }

                if ($wszystko_OK == true) {
                    //dodanie do bazy

                    if ($polaczenie->query("INSERT INTO uzytkownik VALUES (NULL, 0, '$loginfirma', '$haslo_hash', '$emailfirma', 'Nie podano', '', '', '', '$krajfirma', '$miastofirmy', '$adresfirmy', '$kodpocztowyfirma', '$nip', '', '$nazwafirmy', 'Firma','Nie podano')")) {
                        $_SESSION['udanarejestracja'] = true;
                        header('Location: login.php');
                    } else {
                        throw new Exception($polaczenie->error);
                    }
                }
                $polaczenie->close();
            }
        } catch (Exception $e) {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
            echo '<br />Informacja developerska: ' . $e;
        }
    }
}

if (isset($_POST['instytucjaLogin']))
{
    $wszystko_OK=true;
    if($zmienna == "instytucja") {
        //Sprawdź poprawność loginu
        $logininstytucja = $_POST['instytucjaLogin'];

        if ((strlen($logininstytucja) < 5) || (strlen($logininstytucja) > 21)) {
            $wszystko_OK = false;
            $_SESSION['f_logininstytucji'] = "login musi posiadać od 6 do 20 znaków!";
        }

        //sprawdzanie czy login ma polskie znaki
        if (ctype_alnum($logininstytucja) == false) {
            $wszystko_OK = false;
            $_SESSION['f_logininstytucji'] = "Login nie może składać z polskich znaków";
        }

        //Sprawdź poprawność hasła
        $hasloinstytucja = $_POST['instytucjaHaslo'];
        $haslosprawdz = '/^[0-9a-zA-Ząćęłńóśźż\\-]+$/';

        if ((strlen($hasloinstytucja) < 5) || (strlen($hasloinstytucja) > 21)) {
            $wszystko_OK = false;
            $_SESSION['f_hasloinstytucji']="Hasło musi posiadać od 6 do 20 znaków!";
        }

        if (preg_match($haslosprawdz, $hasloinstytucja) == false) {
            $wszystko_OK = false;
            $_SESSION['f_hasloinstytucji']="Hasło nie może składać z polskich znaków";
        }

        $haslo_hash = password_hash($hasloinstytucja, PASSWORD_DEFAULT);

        // Sprawdź poprawność adresu email
        $emailinstytucja = $_POST['instytucjaEmail'];
        $emailB = filter_var($emailinstytucja, FILTER_SANITIZE_EMAIL);

        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $emailinstytucja)) {
            $wszystko_OK = false;
            $_SESSION['f_emailinstytucji']="Podaj poprawny adres e-mail!";
        }

        //sprawdzenie nazwy firmy
        $nazwainstytucji = $_POST['instytucjaNazwa'];
        $sprawdzin = '/^[a-zA-Ząćęłńóśźż\\ \\-]+$/';

        if (preg_match($sprawdzin, $nazwainstytucji) == false) {
            $wszystko_OK = false;
            $_SESSION['f_nazwainstytucji']="Nazwa instytucji nie może mieć znaków specjalnych lub liczb";
        }

        //sprawdzenie nip
        $nipinstytucji = $_POST['instytucjaNip'];

        if (strlen($nipinstytucji) != 13) {
            $wszystko_OK = false;
            $_SESSION['f_nipinstytucji']="NIP musi posiadać 10cyfrowy numer!";
        }

        $nipsprawdz = '/[0-9]{3}[\\-]{1}[0-9]{3}[\\-]{1}[0-9]{2}[\\-][0-9]{2}+$/';
        if (preg_match($nipsprawdz, $nipinstytucji) == false) {
            $wszystko_OK = false;
            $_SESSION['f_nipinstytucji']="NIP musi zawierać 10cyfrowy numer!";
        }

        //sprawdzenie kraju
        $krajinstytucji = $_POST['instytucjaKraj'];

        if (preg_match($sprawdzin, $krajinstytucji) == false) {
            $wszystko_OK = false;
            $_SESSION['fr_krajinstytucji']="Zła nazaw kraju";
        }

        if (ctype_alpha($krajinstytucji) == false) {
            $wszystko_OK = false;
            $_SESSION['fr_krajinstytucji']="Kraj nie powinien mieć cyfr lub znaków specjalnych!";
        }

        //sprawdzanie adresu
        $adresinstytucji = $_POST['instytucjaAdres'];
        $sprawdzadres = '/^[0-9a-zA-Ząćęłńóśźż\\-\\ ]+$/';

        if (preg_match($sprawdzadres, $adresinstytucji) == false) {
            $wszystko_OK = false;
            $_SESSION['f_adresinstytucji']="Zły adres instytucji";
        }

        //sprawdzenie nip
        $kodpocztowyinstytucji = $_POST['instytucjaKodpocztowy'];

        if (strlen($kodpocztowyinstytucji) != 6) {
            $wszystko_OK = false;
            $_SESSION['f_kodpocztowyinstytucji']="Kod pocztowy musi posiadać 5cyfrowy numer!";
        }

        $kodpocztowysprawdz = '/[0-9]{2}[\\-]{1}[0-9]{3}+$/';
        if (preg_match($kodpocztowysprawdz, $kodpocztowyinstytucji) == false) {
            $wszystko_OK = false;
            $_SESSION['f_kodpocztowyinstytucji']="Kod pocztowy musi zawierać 5cyfrowy numer!";
        }

        //sprawdzenie miasta firmy
        $miastoinstytucji = $_POST['instytucjaMiasto'];

        if (preg_match($sprawdzin, $miastoinstytucji) == false) {
            $wszystko_OK = false;
            $_SESSION['f_miastoinstytucji']="Miasto instytucji nie może mieć znaków specjalnych lub liczb";
        }

        //Czy zaakceptowano regulamin?
        if (!isset($_POST['regulamin3'])) {
            $wszystko_OK = false;
            $_SESSION['e_regulamin3'] = "Potwierdź akceptację regulaminu!";
        }

        //Zapamiętaj wprowadzone dane

        $_SESSION['fr_loginInstytucja'] = $logininstytucja;
        $_SESSION['fr_hasloInstytucja'] = $hasloinstytucja;
        $_SESSION['fr_emailInstytucja'] = $emailinstytucja;
        $_SESSION['fr_nazwaInstytucja'] = $nazwainstytucji;
        $_SESSION['fr_nipInstytucja'] = $nipinstytucji;
        $_SESSION['fr_krajInstytucja'] = $krajinstytucji;
        $_SESSION['fr_adresInstytucja'] = $adresinstytucji;
        $_SESSION['fr_kodpocztowyInstytucja'] = $kodpocztowyinstytucji;
        $_SESSION['fr_miastoInstytucja'] = $miastoinstytucji;
        $_SESSION['f_zmienna'] = $zmienna;

        if (isset($_POST['regulamin3'])) $_SESSION['fr_regulamin3'] = true;

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if ($polaczenie->connect_errno != 0) {
                throw new Exception(mysqli_connect_errno());
            } else {
                //Czy login jest już zarezerwowany?
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE login='$logininstytucja'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nickow = $rezultat->num_rows;
                if ($ile_takich_nickow > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_logininstytucji'] = "Istnieje już taki login!";
                }

                //Czy email już istnieje?
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE email='$emailinstytucja'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_maili = $rezultat->num_rows;
                if ($ile_takich_maili > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_emailinstytucji'] = "Istnieje już konto przypisane do tego adresu e-mail!";
                }

                //Czy nazwa firmy juz istnieje
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE nazwa_firmy='$nazwainstytucji'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nazwfirm = $rezultat->num_rows;
                if ($ile_takich_nazwfirm > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_nazwafirmy'] = "Istnieje już konto przypisane do nazwy firmy!";
                }

                //Czy nip juz istnieje
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE pesel_nip='$nipinstytucji'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nipfirm = $rezultat->num_rows;
                if ($ile_takich_nipfirm > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_nipfirmy'] = "Istnieje już konto przypisane do tego NIP-u!";
                }

                //Czy adres juz istnieje
                $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE adres='$adresinstytucji'");

                if (!$rezultat) throw new Exception($polaczenie->error);

                $ile_takich_nipfirm = $rezultat->num_rows;
                if ($ile_takich_nipfirm > 0) {
                    $wszystko_OK = false;
                    $_SESSION['f_nipfirmy'] = "Istnieje już konto przypisane do tego NIP-u!";
                }

                if ($wszystko_OK == true) {
                    //dodanie do bazy

                    if ($polaczenie->query("INSERT INTO uzytkownik VALUES (NULL, 0, '$logininstytucja', '$haslo_hash', '$emailinstytucja', 'Nie podano', '', '', '', '$krajinstytucji', '$miastoinstytucji', '$adresinstytucji', '$kodpocztowyinstytucji', '$nipinstytucji', '', '$nazwainstytucji', 'Instytucja','Nie podano')")) {
                        $_SESSION['udanarejestracja'] = true;
                        header('Location: login.php');
                    } else {
                        throw new Exception($polaczenie->error);
                    }
                }
                $polaczenie->close();
            }
        } catch (Exception $e) {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
            echo '<br />Informacja developerska: ' . $e;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include "css/head.php"; ?>
    <style>
        .error
        {
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
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
    <form method="post">
        <h2>Załóż Konto</h2>
        <div class="nav form-row" role="tablist">
            <div class="form-group col-sm-4">
                <input type="radio" id="uzytkownik" name="typUzytkownika" <?php if (isset($typUzytkownika) && $typUzytkownika=="uzytkownik") echo "checked";?> value="uzytkownik" <?php if(isset($_SESSION['f_zmienna']) && $_SESSION['f_zmienna']=="uzytkownik"){echo 'checked';}?> checked> Użytkownik
            </div>
            <div class="form-group col-sm-4">
                <input type="radio" id="firma" name="typUzytkownika" <?php if (isset($typUzytkownika) && $typUzytkownika=="firma") echo "checked";?> value="firma" <?php if(isset($_SESSION['f_zmienna']) && $_SESSION['f_zmienna']=="firma"){echo 'checked';}?>> Firma
            </div>
            <div class="form-group col-sm-4">
                <input type="radio" id="instytucja" name="typUzytkownika" <?php if (isset($typUzytkownika) && $typUzytkownika=="instytucja") echo "checked";?> value="instytucja" <?php if(isset($_SESSION['f_zmienna']) && $_SESSION['f_zmienna']=="instytucja"){echo 'checked';}?>> Instytucja
            </div>
        </div>

        <div id="rejestracjaUzytkownik">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Login</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Login powinien zawierać:</b> <br/> Od 6 do 20 znaków <br/> nie może składać z polskich znaków lub znaków specjalnych">
                    <input type="text" class="form-control" name="uzytkownikLogin" value="<?php
                    if (isset($_SESSION['fr_loginUzytkownik']))
                    {
                        echo $_SESSION['fr_loginUzytkownik'];
                        unset($_SESSION['fr_loginUzytkownik']);
                    }
                    ?>" id="loginUzytkownik" minlength="6" maxlength="20" onkeyup="loginUzyt(this.value)" placeholder="Login">
                    <p><span id="powiadom_uzytkownikaLogin"></span></p>
                </div>
                <div class="form-group col-md-6">
                    <label>Hasło</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Hasło powinno zawierać:</b> <br/> Od 6 do 20 znaków">
                    <input type="password" class="form-control" id="hasloUzytkownik" minlength="6" maxlength="20" name="uzytkownikHaslo" value="<?php
                    if (isset($_SESSION['fr_hasloUzytkownik']))
                    {
                        echo $_SESSION['fr_hasloUzytkownik'];
                        unset($_SESSION['fr_hasloUzytkownik']);
                    }
                    ?>" onkeyup="hasloUzyt(this.value)" placeholder="Hasło">
                    <p><span id="powiadom_uzytkownikaHaslo"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label>E-mail</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Przykładowy e-mail:</b> <br/> jankowalski@gmail.com">
                    <input type="email" class="form-control" id="emailUzytkownik" name="uzytkownikEmail" value="<?php
                    if (isset($_SESSION['fr_emailUzytkownik']))
                    {
                        echo $_SESSION['fr_emailUzytkownik'];
                        unset($_SESSION['fr_emailUzytkownik']);
                    }
                    ?>" onkeyup="emailUzyt(this.value)" placeholder="E-mail">
                    <p><span id="powiadom_uzytkownikaEmail"></span></p>
                </div>
                <div class="form-group col-md-4">
                    <label>Numer Telefonu</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Numer Telefonu powinien składać się:</b> <br/> z dziewięciu cyft">
                    <input type="text" class="form-control" minlength="11" maxlength="11" id="telefonUzytkownik" onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))" onkeyup="telefonUzyt(this.value)" name="uzytkownikTelefon" value="<?php
                    if (isset($_SESSION['fr_telefonUzytkownik']))
                    {
                        echo $_SESSION['fr_telefonUzytkownik'];
                        unset($_SESSION['fr_telefonUzytkownik']);
                    }
                    ?>" placeholder="Nr telefonu">
                    <p><span id="powiadom_uzytkownikaTelefon"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Imię</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Imię:</b> <br/> Proszę podać swoje imię">
                    <input type="text" minlength="3" id="imieUzytkownik" onkeydown="return imieUzytk(event);" onkeyup="imieUzyt(this.value)" class="form-control" name="uzytkownikImie" value="<?php
                    if (isset($_SESSION['fr_imieUzytkownik']))
                    {
                        echo $_SESSION['fr_imieUzytkownik'];
                        unset($_SESSION['fr_imieUzytkownik']);
                    }
                    ?>" placeholder="Imię">
                    <p><span id="powiadom_uzytkownikaImie"></span></p>
                </div>
                <div class="form-group col-md-6">
                    <label>Drugie Imię</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Opcjonalnie</b>">
                    <input type="text" id="drugieimieUzytkownik" class="form-control" onkeydown="return drugieimieUzytk(event);" onkeyup="drugieimieUzyt(this.value)" name="uzytkownikDrugieimie" value="<?php
                    if (isset($_SESSION['fr_drugieimieUzytkownik']))
                    {
                        echo $_SESSION['fr_drugieimieUzytkownik'];
                        unset($_SESSION['fr_drugieimieUzytkownik']);
                    }
                    ?>" placeholder="Drugie Imię">
                    <p><span id="imiedrugie"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Nazwisko</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Nazwisko:</b> <br/> Proszę podać swoje nazwisko">
                    <input type="text" minlength="3" id="nazwiskoUzytkownik" onkeydown="return nazwiskoUzytk(event);" onkeyup="nazwiskoUzyt(this.value)" class="form-control" name="uzytkownikNazwisko" value="<?php
                    if (isset($_SESSION['fr_nazwiskoUzytkownik']))
                    {
                        echo $_SESSION['fr_nazwiskoUzytkownik'];
                        unset($_SESSION['fr_nazwiskoUzytkownik']);
                    }
                    ?>" placeholder="Nazwisko">
                    <p><span id="powiadom_uzytkownikaNazwisko"></span></p>
                </div>
            </div>
            <div>
                <input type="checkbox" name="regulamin" <?php
                if (isset($_SESSION['fr_regulamin']))
                {
                    echo "checked";
                    unset($_SESSION['fr_regulamin']);
                }
                ?>/> Zapoznałem się i akceptuję <a href="rules.php">regulamin</a>
                <?php
                if (isset($_SESSION['e_regulamin']))
                {
                    echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                    unset($_SESSION['e_regulamin']);
                }
                ?>

            </div>
            <?php

            if (isset($_SESSION['u_login']))
            {
                echo '<div class="error">'.$_SESSION['u_login'].'</div>';
                unset($_SESSION['u_login']);
            }
            ?>
            <?php
            if (isset($_SESSION['u_haslo']))
            {
                echo '<div class="error">'.$_SESSION['u_haslo'].'</div>';
                unset($_SESSION['u_haslo']);
            }
            ?>
            <?php
            if (isset($_SESSION['u_email']))
            {
                echo '<div class="error">'.$_SESSION['u_email'].'</div>';
                unset($_SESSION['u_email']);
            }
            ?>
            <?php
            if (isset($_SESSION['u_nrtelefonu']))
            {
                echo '<div class="error">'.$_SESSION['u_nrtelefonu'].'</div>';
                unset($_SESSION['u_nrtelefonu']);
            }
            ?>
            <?php
            if (isset($_SESSION['u_imie']))
            {
                echo '<div class="error">'.$_SESSION['u_imie'].'</div>';
                unset($_SESSION['u_imie']);
            }
            ?>
            <?php
            if (isset($_SESSION['u_drugieimie']))
            {
                echo '<div class="error">'.$_SESSION['u_drugieimie'].'</div>';
                unset($_SESSION['u_drugieimie']);
            }
            ?>
            <?php
            if (isset($_SESSION['u_nazwisko']))
            {
                echo '<div class="error">'.$_SESSION['u_nazwisko'].'</div>';
                unset($_SESSION['u_nazwisko']);
            }
            ?>

        </div>

        <div id="rejestracjaFirma">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Login</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Login powinien zawierać:</b> <br/> Od 6 do 20 znaków <br/> nie może składać z polskich znaków lub znaków specjalnych">
                    <input type="text" minlength="6" maxlength="20" class="form-control" id="loginFirma" onkeyup="loginF(this.value)" name="firmaLogin" value="<?php
                    if (isset($_SESSION['fr_loginFirma']))
                    {
                        echo $_SESSION['fr_loginFirma'];
                        unset($_SESSION['fr_loginFirma']);
                    }
                    ?>" placeholder="Login">
                    <p><span id="powiadom_firmeLogin"></span></p>
                </div>
                <div class="form-group col-md-6">
                    <label>Hasło</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Hasło powinno zawierać:</b> <br/> Od 6 do 20 znaków <br/> Brak znaków specjalnych">
                    <input type="password" minlength="6" maxlength="20" class="form-control" id="hasloFirma" onkeyup="hasloF(this.value)" name="firmaHaslo" value="<?php
                    if (isset($_SESSION['fr_hasloFirma']))
                    {
                        echo $_SESSION['fr_hasloFirma'];
                        unset($_SESSION['fr_hasloFirma']);
                    }
                    ?>" placeholder="Hasło">
                    <p><span id="powiadom_firmeHaslo"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>E-mail</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Przykładowy e-mail:</b> <br/> jankowalski@gmail.com">
                    <input type="email" class="form-control" id="emailFirma" name="firmaEmail" value="<?php
                    if (isset($_SESSION['fr_emailFrima']))
                    {
                        echo $_SESSION['fr_emailFrima'];
                        unset($_SESSION['fr_emailFrima']);
                    }
                    ?>" onkeyup="emailF(this.value)" placeholder="E-mail">
                    <p><span id="powiadom_firmeEmail"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Nazwa Firmy</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Nazwa firmy:</b> <br/> proszę podać pełną nazwę">
                    <input type="text" minlength="3" class="form-control" id="nazwaFirma" onkeyup="nazwaF(this.value)" name="firmaNazwa" value="<?php
                    if (isset($_SESSION['fr_nazwaFirma']))
                    {
                        echo $_SESSION['fr_nazwaFirma'];
                        unset($_SESSION['fr_nazwaFirma']);
                    }
                    ?>" placeholder="Nazwa firmy">
                    <p><span id="powiadom_firmeNazwa"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>NIP</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Nip powinien zawierać:</b> <br/> dziesięć cyfr">
                    <input type="text" minlength="13" maxlength="13" class="form-control" id="nipFirma" onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))" onkeyup="nipF(this.value)" name="firmaNip" value="<?php
                    if (isset($_SESSION['fr_nipFirma']))
                    {
                        echo $_SESSION['fr_nipFirma'];
                        unset($_SESSION['fr_nipFirma']);
                    }
                    ?>" placeholder="NIP">
                    <p><span id="powiadom_firmeNIP"></span></p>
                </div>
                <div class="form-group col-md-6">
                    <label>Kraj</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Kraj:</b> <br/> proszę podać swój kraj">
                    <input type="text" minlength="3" class="form-control" id="krajFirma" onkeydown="return krajFi(event);" onkeyup="krajF(this.value)" name="firmaKraj" value="<?php
                    if (isset($_SESSION['fr_krajFirma']))
                    {
                        echo $_SESSION['fr_krajFirma'];
                        unset($_SESSION['fr_krajFirma']);
                    }
                    ?>" placeholder="Kraj">
                    <p><span id="powiadom_firmeKraj"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Adres Firmy</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Adres firmy:</b> <br/> proszę podać adres firmy">
                    <input type="text" minlength="3" class="form-control" id="adresFirma" onkeydown="return adresFi(event);" onkeyup="adresF(this.value)" name="firmaAdres" value="<?php
                    if (isset($_SESSION['fr_adresFirma']))
                    {
                        echo $_SESSION['fr_adresFirma'];
                        unset($_SESSION['fr_adresFirma']);
                    }
                    ?>" placeholder="Adres Firmy">
                    <p><span id="powiadom_firmeAdres"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Kod Pocztowy</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Kod pocztowy powinien zawierać:</b> pięć cyfr">
                    <input type="text" minlength="6" maxlength="6" class="form-control" id="kodpocztowyFirma" onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))" onkeyup="kodpocztowyF(this.value)" name="firmaKodpocztowy" value="<?php
                    if (isset($_SESSION['fr_kodpocztowyFirma']))
                    {
                        echo $_SESSION['fr_kodpocztowyFirma'];
                        unset($_SESSION['fr_kodpocztowyFirma']);
                    }
                    ?>" placeholder="Kod Pocztowy">
                    <p><span id="powiadom_firmeKodpocztowy"></span></p>
                </div>
                <div class="form-group col-md-8">
                    <label>Miasto</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Miasto:</b> <br/> proszę podać miasto">
                    <input type="text" minlength="3" class="form-control" id="miastoFirma" onkeydown="return miastoFi(event);" onkeyup="miastoF(this.value)" name="firmaMiasto" value="<?php
                    if (isset($_SESSION['fr_miastoFirma']))
                    {
                        echo $_SESSION['fr_miastoFirma'];
                        unset($_SESSION['fr_miastoFirma']);
                    }
                    ?>" placeholder="Miasto">
                    <p><span id="powiadom_firmeMiasto"></span></p>
                </div>
            </div>
            <div>
                <input type="checkbox" name="regulamin2" <?php
                if (isset($_SESSION['fr_regulamin2']))
                {
                    echo "checked";
                    unset($_SESSION['fr_regulamin2']);
                }
                ?>/> Zapoznałem się i akceptuję <a href="rules.php">regulamin</a>
                <?php
                if (isset($_SESSION['e_regulamin2']))
                {
                    echo '<div class="error">'.$_SESSION['e_regulamin2'].'</div>';
                    unset($_SESSION['e_regulamin2']);
                }
                ?>

            </div>
            <?php

            if (isset($_SESSION['f_loginfirmy']))
            {
                echo '<div class="error">'.$_SESSION['f_loginfirmy'].'</div>';
                unset($_SESSION['f_loginfirmy']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_haslofirmy']))
            {
                echo '<div class="error">'.$_SESSION['f_haslofirmy'].'</div>';
                unset($_SESSION['f_haslofirmy']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_emailfirmy']))
            {
                echo '<div class="error">'.$_SESSION['f_emailfirmy'].'</div>';
                unset($_SESSION['f_emailfirmy']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_nazwafirmy']))
            {
                echo '<div class="error">'.$_SESSION['f_nazwafirmy'].'</div>';
                unset($_SESSION['f_nazwafirmy']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_nipfirmy']))
            {
                echo '<div class="error">'.$_SESSION['f_nipfirmy'].'</div>';
                unset($_SESSION['f_nipfirmy']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_krajFirma']))
            {
                echo '<div class="error">'.$_SESSION['f_krajFirma'].'</div>';
                unset($_SESSION['f_krajFirma']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_adresfirmy']))
            {
                echo '<div class="error">'.$_SESSION['f_adresfirmy'].'</div>';
                unset($_SESSION['f_adresfirmy']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_kodpocztowyfirmy']))
            {
                echo '<div class="error">'.$_SESSION['f_kodpocztowyfirmy'].'</div>';
                unset($_SESSION['f_kodpocztowyfirmy']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_miastofirmy']))
            {
                echo '<div class="error">'.$_SESSION['f_miastofirmy'].'</div>';
                unset($_SESSION['f_miastofirmy']);
            }
            ?>
        </div>

        <div id="rejestracjaInstytucja">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Login</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Login powinien zawierać:</b> <br/> Od 6 do 20 znaków <br/> nie może składać z polskich znaków lub znaków specjalnych">
                    <input type="text" minlength="6" maxlength="20" class="form-control" id="loginInstytucja" onkeyup="loginI(this.value)" name="instytucjaLogin" value="<?php
                    if (isset($_SESSION['fr_loginInstytucja']))
                    {
                        echo $_SESSION['fr_loginInstytucja'];
                        unset($_SESSION['fr_loginInstytucja']);
                    }
                    ?>" placeholder="Login">
                    <p><span id="powiadom_instytucjeLogin"></span></p>
                </div>
                <div class="form-group col-md-6">
                    <label>Hasło</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Hasło powinno zawierać:</b> <br/> Od 6 do 20 znaków <br/> Brak znaków specjalnych">
                    <input type="password" minlength="6" maxlength="20" class="form-control" id="hasloInstytucja" onkeyup="hasloI(this.value)" name="instytucjaHaslo" value="<?php
                    if (isset($_SESSION['fr_hasloInstytucja']))
                    {
                        echo $_SESSION['fr_hasloInstytucja'];
                        unset($_SESSION['fr_hasloInstytucja']);
                    }
                    ?>" placeholder="Hasło">
                    <p><span id="powiadom_instytucjeHaslo"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>E-mail</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Przykładowy e-mail:</b> <br/> jankowalski@gmail.com">
                    <input type="email" class="form-control" id="emailInstytucja" name="instytucjaEmail" value="<?php
                    if (isset($_SESSION['fr_emailInstytucja']))
                    {
                        echo $_SESSION['fr_emailInstytucja'];
                        unset($_SESSION['fr_emailInstytucja']);
                    }
                    ?>" onkeyup="emailI(this.value)" placeholder="E-mail">
                    <p><span id="powiadom_instytucjeEmail"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Nazwa Instytucji</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Nazwa instytucji:</b> <br/> proszę podać pełną nazwę">
                    <input type="text" minlength="3" class="form-control" id="nazwaInstytucji" onkeyup="nazwaI(this.value)" name="instytucjaNazwa" value="<?php
                    if (isset($_SESSION['fr_nazwaInstytucja']))
                    {
                        echo $_SESSION['fr_nazwaInstytucja'];
                        unset($_SESSION['fr_nazwaInstytucja']);
                    }
                    ?>" placeholder="Nazwa instytucji">
                    <p><span id="powiadom_instytucjeNazwa"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>NIP</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Nip powinien zawierać:</b> <br/> dziesięć cyfr">
                    <input type="text" minlength="13" maxlength="13" class="form-control" id="nipInstytucja" onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))" onkeyup="nipI(this.value)" name="instytucjaNip" value="<?php
                    if (isset($_SESSION['fr_nipInstytucja']))
                    {
                        echo $_SESSION['fr_nipInstytucja'];
                        unset($_SESSION['fr_nipInstytucja']);
                    }
                    ?>" placeholder="NIP">
                    <p><span id="powiadom_instytucjeNIP"></span></p>
                </div>
                <div class="form-group col-md-6">
                    <label>Kraj</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Kraj:</b> <br/> proszę podać swój kraj">
                    <input type="text" minlength="3" class="form-control" id="krajInstytucja" onkeydown="return krajIn(event);" onkeyup="krajI(this.value)" name="instytucjaKraj" value="<?php
                    if (isset($_SESSION['fr_krajInstytucja']))
                    {
                        echo $_SESSION['fr_krajInstytucja'];
                        unset($_SESSION['fr_krajInstytucja']);
                    }
                    ?>" placeholder="Kraj">
                    <p><span id="powiadom_instytucjeKraj"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Adres Instytucji</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Adres instytucji:</b> <br/> proszę podać adres instytucji">
                    <input type="text" minlength="3" class="form-control" id="adresInstytucji" onkeydown="return adresIn(event);" onkeyup="adresI(this.value)" name="instytucjaAdres" value="<?php
                    if (isset($_SESSION['fr_adresInstytucja']))
                    {
                        echo $_SESSION['fr_adresInstytucja'];
                        unset($_SESSION['fr_adresInstytucja']);
                    }
                    ?>" placeholder="Adres Instytucji">
                    <p><span id="powiadom_instytucjeAdres"></span></p>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Kod Pocztowy</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Kod pocztowy powinien zawierać:</b> pięć cyfr">
                    <input type="text" minlength="6" maxlength="6" class="form-control" id="kodpocztowyInstytucja" onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))" onkeyup="kodpocztowyI(this.value)" name="instytucjaKodpocztowy" value="<?php
                    if (isset($_SESSION['fr_kodpocztowyInstytucja']))
                    {
                        echo $_SESSION['fr_kodpocztowyInstytucja'];
                        unset($_SESSION['fr_kodpocztowyInstytucja']);
                    }
                    ?>" placeholder="Kod Pocztowy">
                    <p><span id="powiadom_instytucjeKodpocztowy"></span></p>
                </div>
                <div class="form-group col-md-8">
                    <label>Miasto</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip" data-html="true" title="<b>Miasto:</b> <br/> proszę podać miasto">
                    <input type="text" minlength="3" class="form-control" id="miastoInstytucja" onkeydown="return miastoIn(event);" onkeyup="miastoI(this.value)" name="instytucjaMiasto" value="<?php
                    if (isset($_SESSION['fr_miastoInstytucja']))
                    {
                        echo $_SESSION['fr_miastoInstytucja'];
                        unset($_SESSION['fr_miastoInstytucja']);
                    }
                    ?>" placeholder="Miasto">
                    <p><span id="powiadom_instytucjeMiasto"></span></p>
                </div>
            </div>
            <div>
                <input type="checkbox" name="regulamin3" <?php
                if (isset($_SESSION['fr_regulamin3']))
                {
                    echo "checked";
                    unset($_SESSION['fr_regulamin3']);
                }
                ?>/> Zapoznałem się i akceptuję <a href="rules.php">regulamin</a>
                <?php
                if (isset($_SESSION['e_regulamin3']))
                {
                    echo '<div class="error">'.$_SESSION['e_regulamin3'].'</div>';
                    unset($_SESSION['e_regulamin3']);
                }
                ?>
            </div>
            <?php

            if (isset($_SESSION['f_logininstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_logininstytucji'].'</div>';
                unset($_SESSION['f_logininstytucji']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_hasloinstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_hasloinstytucji'].'</div>';
                unset($_SESSION['f_hasloinstytucji']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_emailinstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_emailinstytucji'].'</div>';
                unset($_SESSION['f_emailinstytucji']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_nazwainstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_nazwainstytucji'].'</div>';
                unset($_SESSION['f_nazwainstytucji']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_nipinstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_nipinstytucji'].'</div>';
                unset($_SESSION['f_nipinstytucji']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_krajinstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_krajinstytucji'].'</div>';
                unset($_SESSION['f_krajinstytucji']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_adresinstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_adresinstytucji'].'</div>';
                unset($_SESSION['f_adresinstytucji']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_kodpocztowyinstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_kodpocztowyinstytucji'].'</div>';
                unset($_SESSION['f_kodpocztowyinstytucji']);
            }
            ?>
            <?php
            if (isset($_SESSION['f_miastoinstytucji']))
            {
                echo '<div class="error">'.$_SESSION['f_miastoinstytucji'].'</div>';
                unset($_SESSION['f_miastoinstytucji']);
            }
            ?>
        </div>
        <p></p>
        <button type="submit" class="btn btn-primary">Zarejestruj się</button>
    </form>
</div>



<script>
    function loginUzytkownik(str) {
        let test = document.getElementById("loginUzytkownik");
        let low = document.getElementById("loginUzytkownik");
        let upp = document.getElementById("loginUzytkownik");
        let ret = "";
        low = str.toLowerCase();
        upp = str.toUpperCase();

        for(let i=0;i<str.length;i++){
            ret += (i===0) ? upp[i]:low[i];
            test.value = ret;
        }

        if(!str.match('^[a-zA-Ząćęłńóśźż]+$') | str.length < 6 | str.length > 20){
            if (str.length < 6 || str.length > 20) {
                document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "Login powinien mieć od 6 do 20znaków <br/>";
            }
            else {
                document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "Login nie powinien mieć znaków specjalnych lub liczb <br/>";
            }
        }
        else {
            document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "";
        }
    }
</script>


<script>
    function loginUzyt(str) {
        if(!str.match('^[a-zA-Z0-9]+$') | str.length < 6 | str.length > 20 | str.length == 0){
            if (str.length < 6 || str.length > 20 | str.length == 0) {
                if(str.length == 0){
                    document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "Pole wymagane";
                }
                else{
                    document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "Login powinien mieć od 6 do 20znaków";
                }
            }
            else {
                document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "Login nie powinien mieć znaków specjalnych";
            }
        }
        else {
            document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "";
        }
    }
</script>



<script>
    <?php
        include "js/checking_options.js";
        include "js/tooltip.js";

        include "js/user_login.js";
        include "js/user_password.js";
        include "js/user_email.js";
        include "js/user_number_phone.js";
        include "js/user_name.js";
        include "js/user_second_name.js";
        include "js/user_last_name.js";

        include "js/company_login.js";
        include "js/company_password.js";
        include "js/company_email.js";
        include "js/company_name.js";
        include "js/company_nip.js";
        include "js/company_country.js";
        include "js/company_address.js";
        include "js/company_zip_code.js";
        include "js/company_city.js";

        include "js/institution_login.js";
        include "js/institution_password.js";
        include "js/institution_email.js";
        include "js/institution_name.js";
        include "js/institution_nip.js";
        include "js/institution_country.js";
        include "js/institution_address.js";
        include "js/institution_zip_code.js";
        include "js/institution_city.js";
    ?>
</script>
</body>
</html>