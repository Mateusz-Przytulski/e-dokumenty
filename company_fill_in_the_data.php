<?php

session_start();
require_once "connect.php";
$zmiennaliterka=$_GET['literka'];

$sprawdz = 'Firma';
$sprawdz1 = $_SESSION['rodzaj_uzytkownika'];
if (($sprawdz1 != $sprawdz) | (!isset($_SESSION['zalogowany'])) | $_SESSION['admin']==1)
{
    header('Location: user_home.php');
    exit();
}
$zmieniono = false;

if (isset($_POST['telefon']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $nr_telefonu = $_POST['telefon'];

    if(!empty($nr_telefonu))
    {

        //sprawdzenie dlugosci telefonu
        if (strlen($nr_telefonu)!=11)
        {
            $wszystko_ok=false;
            $_SESSION['e_nr_telefonu']="Telefon musi posiadać 9cyfrowy numer!";
        }

        $telefonsprawdz = '/[0-9]{3}[\\-]{1}[0-9]{3}[\\-]{1}[0-9]{3}+$/';
        if (preg_match($telefonsprawdz, $nr_telefonu) == false) {
            $wszystko_OK = false;
            $_SESSION['e_nr_telefonu'] = "Numer telefonu musi zawierać 9cyfrowy numer!";
        }
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            //Czy nr już istnieje?
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE telefon='$nr_telefonu'");
        }
        if (!$rezultat) throw new Exception($polaczenie->error);

        $ile_takich_nr = $rezultat->num_rows;
        if($ile_takich_nr>0)
        {
            $wszystko_ok=false;
            $_SESSION['e_nr_telefonu']="Istnieje już konto przypisane do tego numeru!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET telefon='$nr_telefonu' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['email']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $email = $_POST['email'];

    if(!empty($email))
    {
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $wszystko_ok=false;
            $_SESSION['e_email']="Podaj poprawny adres e-mail!";
        }

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            //Czy email już istnieje?
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE email='$email'");
        }
        if (!$rezultat) throw new Exception($polaczenie->error);

        $ile_takich_maili = $rezultat->num_rows;
        if($ile_takich_maili>0)
        {
            $wszystko_ok=false;
            $_SESSION['e_email']="Istnieje już konto przypisane do tego numeru!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET email='$email' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['nipuzytk']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $pesel = $_POST['nipuzytk'];

    if(!empty($pesel))
    {
        if (strlen($pesel)!=11)
        {
            $wszystko_ok=false;
            $_SESSION['e_pesel']="Pesel musi posiadać 11cyfrowy numer!";
        }


        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            //Czy nr już istnieje?
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE pesel_nip='$pesel'");
        }
        if (!$rezultat) throw new Exception($polaczenie->error);

        $ile_takich_nr = $rezultat->num_rows;
        if($ile_takich_nr>0)
        {
            $wszystko_ok=false;
            $_SESSION['e_pesel']="Istnieje już konto przypisane do tego peselu!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET pesel_nip ='$pesel' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['nipuzytk']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $nip = $_POST['nipuzytk'];

    if(!empty($nip))
    {
        if (strlen($nip) != 13) {
            $wszystko_OK = false;
            $_SESSION['e_nip']="NIP musi posiadać 10cyfrowy numer!";
        }

        $nipsprawdz = '/[0-9]{3}[\\-]{1}[0-9]{3}[\\-]{1}[0-9]{2}[\\-][0-9]{2}+$/';
        if (preg_match($nipsprawdz, $nip) == false) {
            $wszystko_OK = false;
            $_SESSION['e_nip']="NIP musi zawierać 10cyfrowy numer!";
        }

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            //Czy nr już istnieje?
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE pesel_nip ='$nip'");
        }
        if (!$rezultat) throw new Exception($polaczenie->error);

        $ile_takich_nr = $rezultat->num_rows;
        if($ile_takich_nr>0)
        {
            $wszystko_ok=false;
            $_SESSION['e_nip']="Istnieje już konto przypisane do tego regonu!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET pesel_nip ='$nip' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['regonn']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $regon = $_POST['regonn'];

    if(!empty($regon))
    {
        if (strlen($regon)!=14)
        {
            $wszystko_ok=false;
            $_SESSION['e_regon']="Regon musi posiadać 14cyfrowy numer!";
        }


        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            //Czy nr już istnieje?
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE regon='$regon'");
        }
        if (!$rezultat) throw new Exception($polaczenie->error);

        $ile_takich_nr = $rezultat->num_rows;
        if($ile_takich_nr>0)
        {
            $wszystko_ok=false;
            $_SESSION['e_regon']="Istnieje już konto przypisane do tego regonu!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET regon ='$regon' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['kraj']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $kraj = $_POST['kraj'];

    if(!empty($kraj))
    {
        $sprawdz = '/^[a-zA-Ząćęłńóśźż\\-]+$/';

        if (preg_match($sprawdz, $kraj) == false) {
            $wszystko_OK = false;
            $_SESSION['e_kraj']="Zła nazaw kraju";
        }

        if (ctype_alpha($kraj) == false) {
            $wszystko_OK = false;
            $_SESSION['e_kraj']="Kraj nie powinien mieć cyfr lub znaków specjalnych!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET kraj='$kraj' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}


if (isset($_POST['nazwafirmy']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $nazwafirmy = $_POST['nazwafirmy'];

    if(!empty($nazwafirmy))
    {
        $sprawdzin = '/^[a-zA-Ząćęłńóśźż\\ \\-]+$/';

        if (preg_match($sprawdzin, $nazwafirmy) == false) {
            $wszystko_OK = false;
            $_SESSION['e_nazwafirmy']="Nazwa firmy nie może mieć znaków specjalnych lub liczb";
        }

        if (ctype_alpha($nazwafirmy) == false) {
            $wszystko_OK = false;
            $_SESSION['e_nazwafirmy']="Nazwa firmy nie może mieć znaków specjalnych lub liczb";
        }

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            $rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownik WHERE nazwa_firmy='$nazwafirmy'");
        }
        if (!$rezultat) throw new Exception($polaczenie->error);

        $ile_takich_nr = $rezultat->num_rows;
        if($ile_takich_nr>0)
        {
            $wszystko_ok=false;
            $_SESSION['e_nazwafirmy']="Istnieje już konto przypisane do tej nazwy firmy";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET nazwa_firmy='$nazwafirmy' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['miasto']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $miasto = $_POST['miasto'];

    if(!empty($miasto))
    {
        $sprawdz = '/^[a-zA-Ząćęłńóśźż\\ \\-]+$/';

        if (preg_match($sprawdz, $miasto) == false) {
            $wszystko_OK = false;
            $_SESSION['e_miasto']="Miasto nie może mieć znaków specjalnych lub liczb";
        }

        if (ctype_alpha($miasto) == false) {
            $wszystko_OK = false;
            $_SESSION['e_miasto']="Miasto nie może mieć znaków specjalnych lub liczb";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET miasto='$miasto' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['adres']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $adres = $_POST['adres'];

    if(!empty($adres))
    {
        $sprawdz = '/^[a-zA-Ząćęłńóśźż0-9\\ \\-]+$/';

        if (preg_match($sprawdz, $adres) == false) {
            $wszystko_OK = false;
            $_SESSION['e_adres']="Zły adres";
        }

        if (ctype_alpha($adres) == false) {
            $wszystko_OK = false;
            $_SESSION['e_adres']="Zły adres";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET adres='$adres' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['kodpocztowy']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $kodpocztowy = $_POST['kodpocztowy'];

    if(!empty($kodpocztowy))
    {
        if (strlen($kodpocztowy) != 6) {
            $wszystko_OK = false;
            $_SESSION['e_kod_pocztowy']="Kod pocztowy musi posiadać 5cyfrowy numer!";
        }

        $kodpocztowysprawdz = '/[0-9]{2}[\\-]{1}[0-9]{3}+$/';
        if (preg_match($kodpocztowysprawdz, $kodpocztowy) == false) {
            $wszystko_OK = false;
            $_SESSION['e_kod_pocztowy']="Kod pocztowy musi zawierać 5cyfrowy numer!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET kod_pocztowy='$kodpocztowy' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if ($zmieniono==true)
{
    header('Location: ' . $zmiennaliterka. '.php');
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
<?php include "css/navbarCompany.php"; ?>

<?php
require_once "connect.php";
$dbh = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
$licz = $_SESSION['id_uzytkownika'];
?>
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
        <h2>Edytuj Dane<img src="css/img/question-mark.png" alt="" width="25" data-toggle="tooltip" data-html="true" title="<b>Prosimy zostawic puste pole w miejscu gdzie nie chcemy edytować danych</b>"></h2>

        <div class="form-row">
            <?php
            foreach ($dbh->query("SELECT * FROM dokument WHERE id = $zmiennaliterka") as $row){
                $uzupelnij_imie = $_SESSION['imie'];
                $uzupelnij_email = $_SESSION['email'];
                $uzupelnij_telefon = $_SESSION['telefon'];
                $uzupelnij_drugie_imie = $_SESSION['drugie_imie'];
                $uzupelnij_nazwisko = $_SESSION['nazwisko'];
                $uzupelnij_kraj = $_SESSION['kraj'];
                $uzupelnij_miasto = $_SESSION['miasto'];
                $uzupelnij_adres = $_SESSION['adres'];
                $uzupelnij_kod_pocztowy = $_SESSION['kod_pocztowy'];
                $uzupelnij_pesel_nip = $_SESSION['pesel_nip'];
                $uzupelnij_data_urodzenia = $_SESSION['data_urodzenia'];
                $uzupelnij_nazwa_firmy = $_SESSION['nazwa_firmy'];
                $uzupelnij_regon = $_SESSION['regon'];
            }
            ?>
            <?php
            if($row['nazwa_firmy'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Nazwa firmy</label><img src="css/img/question-mark.png" alt="" width="15"
                                                   data-toggle="tooltip" data-html="true"
                                                   title="<b>Nazwa firmy:</b> <br/> Proszę podać nazwę firmy">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_nazwa_firmy; ?>" id="nazwafirm" onkeyup="nazwafir(this.value)" onkeydown="return nazwafirma(event);"
                           name="nazwafirmy" placeholder="Nazwa Firmy"/>
                    <p><span id="powiadom_uzytkownikaHaslo"></span></p>
                    <?php
                    if (isset($_SESSION['e_nazwafirmy'])) {
                        echo '<div class="error">' . $_SESSION['e_nazwafirmy'] . '</div>';
                        unset($_SESSION['e_nazwafirmy']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="form-row">
            <?php
            if($row['email_uzytkownik_firma'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>E-mail</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                              data-html="true"
                                              title="<b>Przykładowy e-mail:</b> <br/> jankowalski@gmail.com">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_email; ?>" onkeyup="emailUzyt(this.value)" name="email" placeholder="Email"/>
                    <p><span id="edytujemail"></span></p>
                    <?php
                    if (isset($_SESSION['e_email'])) {
                        echo '<div class="error">' . $_SESSION['e_email'] . '</div>';
                        unset($_SESSION['e_email']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            if($row['telefon'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Numer telefonu</label><img src="css/img/question-mark.png" alt="" width="15"
                                                      data-toggle="tooltip" data-html="true"
                                                      title="<b>Numer Telefonu powinien składać się:</b> <br/> z dziewięciu cyft">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_telefon; ?>" maxlength="11" id="telefon"
                           onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))"
                           onkeyup="telefonUzyt(this.value)" name="telefon" placeholder="Nr telefonu"/>
                    <p><span id="edytujnumertelefonu"></span></p>
                    <?php
                    if (isset($_SESSION['e_nr_telefonu'])) {
                        echo '<div class="error">' . $_SESSION['e_nr_telefonu'] . '</div>';
                        unset($_SESSION['e_nr_telefonu']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="form-row">
            <?php
            if($row['pesel_nip'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>NIP</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                           data-html="true"
                                           title="<b>Regon powinien składać się:</b> <br/> z trzynastu cyft">
                    <input type="text" maxlength="13" class="form-control" value="<?php print $uzupelnij_pesel_nip; ?>" id="nipFirma"
                           onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))"
                           onkeyup="nipUzyt(this.value)" name="nipuzytk" placeholder="NIP"/>
                    <p><span id="powiadom_firmeNIP"></span></p>
                    <?php
                    if (isset($_SESSION['e_nip'])) {
                        echo '<div class="error">' . $_SESSION['e_nip'] . '</div>';
                        unset($_SESSION['e_nip']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="form-row">
            <?php
            if($row['regon'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Regon</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                             data-html="true"
                                             title="<b>Regon powinien składać się:</b> <br/> z czternastu cyft">
                    <input type="text" maxlength="14" class="form-control" value="<?php print $uzupelnij_regon; ?>" id="regonFirma"
                           onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))"
                           onkeyup="regonUzyt(this.value)" name="regonn" placeholder="Regon"/>
                    <p><span id="powiadom_uzytkownikaLogin"></span></p>
                    <?php
                    if (isset($_SESSION['e_regon'])) {
                        echo '<div class="error">' . $_SESSION['e_regon'] . '</div>';
                        unset($_SESSION['e_regon']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="form-row">
            <?php
            if($row['kraj'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Kraj</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                            data-html="true" title="<b>Kraj:</b> <br/> proszę podać swój kraj">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_kraj; ?>" id="krajUzytkownikk" onkeydown="return krajUz(event);" onkeyup="krajUzytkownik(this.value)"
                           name="kraj" placeholder="Kraj"/>
                    <p><span id="edytujkraj"></span></p>
                    <?php
                    if (isset($_SESSION['e_kraj'])) {
                        echo '<div class="error">' . $_SESSION['e_kraj'] . '</div>';
                        unset($_SESSION['e_kraj']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            if($row['miasto'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Miasto</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                              data-html="true" title="<b>Miasto:</b> <br/> proszę podać miasto">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_miasto; ?>" id="miastoUzytkownikk" onkeydown="return miastoUz(event);" onkeyup="miastoUzyt(this.value)"
                           name="miasto" placeholder="Miasto"/>
                    <p><span id="edytujmiasto"></span></p>
                    <?php
                    if (isset($_SESSION['e_miasto'])) {
                        echo '<div class="error">' . $_SESSION['e_miasto'] . '</div>';
                        unset($_SESSION['e_miasto']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="form-row">
            <?php
            if($row['adres'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Adres</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                             data-html="true"
                                             title="<b>Adres instytucji:</b> <br/> proszę podać adres zamieszkania">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_adres; ?>" onkeydown="return adresUz(event);" onkeyup="adresUzyt(this.value)" name="adres"
                           placeholder="Adres zamieszkania"/>
                    <p><span id="edytujadres"></span></p>
                    <?php
                    if (isset($_SESSION['e_adres'])) {
                        echo '<div class="error">' . $_SESSION['e_adres'] . '</div>';
                        unset($_SESSION['e_adres']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            if($row['kod_pocztowy'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Kod pocztowy</label><img src="css/img/question-mark.png" alt="" width="15"
                                                    data-toggle="tooltip" data-html="true"
                                                    title="<b>Kod pocztowy powinien zawierać:</b> pięć cyfr">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_kod_pocztowy; ?>" maxlength="6" id="kodpocztowyUzytkownikk"
                           onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))"
                           onkeyup="kodpocztowyUzytkownik(this.value)" name="kodpocztowy" placeholder="Kod pocztowy"/>
                    <p><span id="edytujkodpocztowy"></span></p>
                    <?php
                    if (isset($_SESSION['e_kod_pocztowy'])) {
                        echo '<div class="error">' . $_SESSION['e_kod_pocztowy'] . '</div>';
                        unset($_SESSION['e_kod_pocztowy']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>

        <br />

        <input type="submit" value="Przejdź do dokumentu" onclick="return confirm('Czy jesteś pewien, że chcesz edytować dane?')" class="btn btn-primary" />

    </form>
</div>


<script>
    function nazwiskoUzyt(str) {
        let test = document.getElementById("nazwiskoUzytkownik");
        let lower = document.getElementById("nazwiskoUzytkownik");
        let upper = document.getElementById("nazwiskoUzytkownik");
        let ret = "";
        lower = str.toLowerCase();
        upper = str.toUpperCase();
        for(let i=0;i<str.length;i++){
            ret += (i===0) ? upper[i]:lower[i];
            test.value = ret;
        }
        if(!str.match('^[a-zA-Ząćęłńóśźż]+$') | str.length == 0){
            if (str.length == 0){
                document.getElementById("edytujnazwisko").innerHTML = "Pole jest wymagane";
            }
            else {
                document.getElementById("edytujnazwisko").innerHTML = "Nazwisko nie powinno mieć znaków specjalnych lub liczb";
            }
        }
        else {
            document.getElementById("edytujnazwisko").innerHTML = "";
        }
    }

    function nazwiskoUzytk(event) {
        let key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32 || key == 109);
    }
</script>

<script>
    function emailUzyt(str) {
        let email = /^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*@([a-zA-Z0-9_-]+)(\.[a-zA-Z0-9_-]+)*(\.[a-zA-Z]{2,4})$/i;
        if(!str.match(email) | str.length == 0){
            if(str.length == 0){
                document.getElementById("edytujemail").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("edytujemail").innerHTML = "Podaj poprawny adress e-mail np. jkowalski@gmail.com";
            }
        }
        else {
            document.getElementById("edytujemail").innerHTML = "";
        }
    }
</script>

<script>
    let telefon = document.getElementById('telefon');
    let temp1 = false;
    let temp2 = false;
    telefon.addEventListener("keydown", () => {
        if (telefon.value.length == 3 && !temp1) {
            telefon.value += "-"
            temp1 = true;
        }
        if (telefon.value.length <= 3) {
            temp1 = false;
        }
        if (!telefon.value.indexOf('-')) {
            telefon.value.splice(3, 0, "-")
        }

        if (telefon.value.length == 7 && !temp2) {
            telefon.value += "-"
            temp2 = true;
        }
        if (telefon.value.length <= 7) {
            temp2 = false;
        }
        if (!telefon.value.indexOf('-')) {
            telefon.value.splice(7, 0, "-")
        }
    })
    function telefonUzyt(str) {
        if (!str.match('[0-9]{3}\\-[0-9]{3}\\-[0-9]{3}') | str.length == 0) {
            if(str.length == 0){
                document.getElementById("edytujnumertelefonu").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("edytujnumertelefonu").innerHTML = "Zły numer telefonu XXX-XXX-XXX";
            }
        } else {
            document.getElementById("edytujnumertelefonu").innerHTML = "";
        }
    }
</script>

<script>
    let nip = document.getElementById('nipFirma');
    let tem1 = false;
    let tem2 = false;
    let tem3 = false;
    nip.addEventListener("keydown", () => {
        if (nip.value.length == 3 && !tem1) {
            nip.value += "-"
            tem1 = true;
        }
        if (nip.value.length <= 3) {
            tem1 = false;
        }
        if (!nip.value.indexOf('-')) {
            nip.value.splice(3, 0, "-")
        }

        if (nip.value.length == 7 && !tem2) {
            nip.value += "-"
            tem2 = true;
        }
        if (nip.value.length <= 7) {
            tem2 = false;
        }
        if (!nip.value.indexOf('-')) {
            nip.value.splice(7, 0, "-")
        }

        if (nip.value.length == 10 && !tem3) {
            nip.value += "-"
            tem3 = true;
        }
        if (nip.value.length <= 10) {
            tem3 = false;
        }
        if (!nip.value.indexOf('-')) {
            nip.value.splice(10, 0, "-")
        }
    })
    function nipUzyt(str) {
        if (!str.match('[0-9]{3}\\-[0-9]{3}\\-[0-9]{2}\\-[0-9]{2}') | str.length == 0) {
            if(str.length == 0){
                document.getElementById("powiadom_firmeNIP").innerHTML = "Pole wymagane";
            }
            else{
                document.getElementById("powiadom_firmeNIP").innerHTML = "Zły numer NIP XXX-XXX-XX-XX";
            }
        } else {
            document.getElementById("powiadom_firmeNIP").innerHTML = "";
        }
    }
</script>

<script>
    function krajUzytkownik(str) {
        let test = document.getElementById("krajUzytkownikk");
        let lower = document.getElementById("krajUzytkownikk");
        let upper = document.getElementById("krajUzytkownikk");
        let ret = "";
        lower = str.toLowerCase();
        upper = str.toUpperCase();
        for(let i=0;i<str.length;i++){
            ret += (i===0) ? upper[i]:lower[i];
            test.value = ret;
        }

        if(!str.match('^[a-zA-Ząćęłńóśźż\\ ]+$') | str.length == 0){
            if(str.length == 0){
                document.getElementById("edytujkraj").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("edytujkraj").innerHTML = "Podaj poprawną nazwę kraju";
            }
        }
        else {
            document.getElementById("edytujkraj").innerHTML = "";
        }
    }

    function krajUz(event) {
        let key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32);
    }
</script>

<script>
    function miastoUzyt(str) {
        let test = document.getElementById("miastoUzytkownikk");
        let lower = document.getElementById("miastoUzytkownikk");
        let upper = document.getElementById("miastoUzytkownikk");
        let ret = "";
        lower = str.toLowerCase();
        upper = str.toUpperCase();
        for(let i=0;i<str.length;i++){
            ret += (i===0) ? upper[i]:lower[i];
            test.value = ret;
        }
        if(!str.match('^[a-zA-Ząćęłńóśźż\\-\\ ]+$') | str.length == 0){
            if(str.length == 0){
                document.getElementById("edytujmiasto").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("edytujmiasto").innerHTML = "Podaj poprawne miasto";
            }
        }
        else {
            document.getElementById("edytujmiasto").innerHTML = "";
        }
    }
    function miastoUz(event) {
        let key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32 || key == 109);
    }
</script>

<script>
    function adresUzyt(str) {
        if(!str.match('^[0-9a-zA-Ząćęłńóśźż\\-\\ \\.]+$') | str.length == 0){
            if(str.length == 0){
                document.getElementById("edytujadres").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("edytujadres").innerHTML = "Podaj poprawny adres";
            }
        }
        else {
            document.getElementById("edytujadres").innerHTML = "";
        }
    }

    function adresUz(event) {
        let key = event.keyCode;
        return ((key >= 48 && key <= 90) || key == 8 || key == 32 || key == 109 || key == 190);
    }
</script>

<script>
    let kodpocztowy = document.getElementById('kodpocztowyUzytkownikk');
    let tempom1 = false;
    kodpocztowy.addEventListener("keydown", () => {
        if (kodpocztowy.value.length == 2 && !tempom1) {
            kodpocztowy.value += "-";
            tempom1 = true;
        }
        if (kodpocztowy.value.length <= 2) {
            tempom1 = false;
        }
        if (!kodpocztowy.value.indexOf('-')) {
            kodpocztowy.value.splice(2, 0, "-");
        }

    })
    function kodpocztowyUzytkownik(str) {
        if (!str.match('[0-9]{2}\\-[0-9]{3}') | str.length == 0) {
            if(str.length == 0){
                document.getElementById("edytujkodpocztowy").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("edytujkodpocztowy").innerHTML = "Zły numer kodu pocztowego XX-XXX";
            }
        } else {
            document.getElementById("edytujkodpocztowy").innerHTML = "";
        }
    }
</script>


<script>
    function regonUzyt(str) {
        if (!str.match("^[0-9]{14}") | str.length == 0) {
            if(str.length == 0){
                document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "Zły numer regon";
            }
        } else {
            document.getElementById("powiadom_uzytkownikaLogin").innerHTML = "";
        }
    }
</script>

<script>
    function nazwafir(str) {
        if(!str.match('^[a-zA-Ząćęłńóśźż\\ ]+$') | str.length == 0){
            if(str.length == 0){
                document.getElementById("powiadom_uzytkownikaHaslo").innerHTML = "Pole" +
                    " jest wymagane";
            }
            else{
                document.getElementById("powiadom_uzytkownikaHaslo").innerHTML = "Podaj poprawną nazwę firmy";
            }
        }
        else {
            document.getElementById("powiadom_uzytkownikaHaslo").innerHTML = "";
        }
    }

    function nazwafirma(event) {
        let key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32);
    }
</script>

<script>
    <?php
    include "js/tooltip.js";

    ?>
</script>
</body>
</html>
