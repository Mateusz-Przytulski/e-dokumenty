<?php

session_start();
require_once "connect.php";
$zmiennaliterka=$_GET['literka'];

$sprawdz = 'Użytkownik';
$sprawdz1 = $_SESSION['rodzaj_uzytkownika'];
if (($sprawdz1 != $sprawdz) | (!isset($_SESSION['zalogowany'])) | $_SESSION['admin']==1)
{
    header('Location: index.php');
    exit();
}
$zmieniono = false;
if (isset($_POST['imie']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $imie = $_POST['imie'];

    if(!empty($imie))
    {

        $sprawdz = '/^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        //sprawdzamy czy imie ma wielkie i male litery
        if (preg_match($sprawdz, $imie)==false)
        {
            $wszystko_ok=false;
            $_SESSION['e_imie']="Imię musi zaczynać się z wielkiej litery a następnie z małych np Jan!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET imie='$imie' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['drugieimie']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $drugieimie = $_POST['drugieimie'];

    if(!empty($drugieimie))
    {

        $sprawdz = '/^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';
        //sprawdzamy czy imie ma wielkie i male litery
        if (preg_match($sprawdz, $drugieimie)==false)
        {
            $wszystko_ok=false;
            $_SESSION['e_imie']="Imię musi zaczynać się z wielkiej litery a następnie z małych np Jan!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET drugie_imie='$drugieimie' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

if (isset($_POST['nazwisko']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $nazwisko = $_POST['nazwisko'];

    if(!empty($nazwisko))
    {
        $sprawdz = '/^[A-ZŁŚ]{1}+[a-ząęółśżźćń]+$/';

        if (preg_match($sprawdz, $nazwisko)==false)
        {
            $wszystko_ok=false;
            $_SESSION['e_nazwisko']="Nazwisko musi zaczynać się z wielkiej litery a następnie z małych np Kowalski!";

        }

        if (ctype_alpha($nazwisko)==false)
        {
            $wszystko_ok=false;
            $_SESSION['e_nazwisko']="Nazwisko nie powinno mieć cyfr!";
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET nazwisko='$nazwisko' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}

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

if (isset($_POST['dataurodzenia']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $dataurodzenia = $_POST['dataurodzenia'];

    if(!empty($dataurodzenia))
    {
        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }

        if($wszystko_ok==true)
        {
            $pdo = new PDO('mysql:host='.$host.'; dbname='.$db_name.'', $db_user, $db_password);
            $sth = $pdo->prepare("UPDATE uzytkownik SET data_urodzenia='$dataurodzenia' WHERE id_uzytkownika=$zmienna");
            $sth->execute();
            $zmieniono = true;
        }
    }
}


if (isset($_POST['pesell']))
{
    $wszystko_ok = true;
    $zmienna=$_SESSION['id_uzytkownika'];

    $pesel = $_POST['pesell'];

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
        $sprawdz = '/^[a-zA-Z0-9\\ \\-]+$/';

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
<?php include "css/navbarUser.php"; ?>

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
        <h2>Edytuj Wymagane Dane Do Dokumentu<img src="css/img/question-mark.png" alt="" width="25" data-toggle="tooltip" data-html="true" title="<b>Prosimy zostawic puste pole w miejscu gdzie nie chcemy edytować danych</b>"></h2>
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
                if($row['imie'] == 1) {
                    ?>
                    <div class="form-group col-md-12">
                        <label>Imię</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                                data-html="true" title="<b>Imię:</b> <br/> Proszę podać swoje imię">
                        <input type="text" class="form-control" value="<?php print $uzupelnij_imie; ?>" name="imie" id="imie" onkeydown="return imieUzytk(event);" onkeyup="imieUzyt(this.value)"
                               placeholder="Imię"/>
                        <p><span id="edytujimie"></span></p>

                        <?php
                        if (isset($_SESSION['e_imie'])) {
                            echo '<div class="error">' . $_SESSION['e_imie'] . '</div>';
                            unset($_SESSION['e_imie']);
                        }
                        ?>
                    </div>
                    <?php
                }
            ?>
            <?php
            if($row['drugie_imie'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Drugie imię</label><img src="css/img/question-mark.png" alt="" width="15"
                                                   data-toggle="tooltip" data-html="true" title="<b>Opcjonalnie</b>">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_drugie_imie; ?>" id="drugieimie" onkeydown="return drugieimieUzytk(event);" onkeyup="drugieimieUzyt(this.value)"
                           name="drugieimie" placeholder="Drugie imię"/>
                    <p><span id="edytujdrugieimie"></span></p>
                    <?php
                    if (isset($_SESSION['e_drugieimie'])) {
                        echo '<div class="error">' . $_SESSION['e_drugieimie'] . '</div>';
                        unset($_SESSION['e_drugieimie']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="form-row">
            <?php
            if($row['nazwisko'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Nazwisko</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                                data-html="true"
                                                title="<b>Nazwisko:</b> <br/> Proszę podać swoje nazwisko">
                    <input type="text" class="form-control" value="<?php print $uzupelnij_nazwisko; ?>" id="nazwisko" onkeydown="return nazwiskoUzytk(event);" onkeyup="nazwiskoUzyt(this.value)"
                           name="nazwisko" placeholder="Nazwisko"/>
                    <p><span id="edytujnazwisko"></span></p>
                    <?php
                    if (isset($_SESSION['e_nazwisko'])) {
                        echo '<div class="error">' . $_SESSION['e_nazwisko'] . '</div>';
                        unset($_SESSION['e_nazwisko']);
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
                    <label>Pesel</label><img src="css/img/question-mark.png" alt="" width="15" data-toggle="tooltip"
                                             data-html="true"
                                             title="<b>Pesel powinien składać się:</b> <br/> z jedynastu cyft">
                    <input type="text" maxlength="11" class="form-control" value="<?php print $uzupelnij_pesel_nip; ?>" id="pesel"
                           onkeydown="return (event.ctrlKey||event.altKey||(47<event.keyCode&&event.keyCode<58&&event.shiftKey==false)||(95<event.keyCode&&event.keyCode<106)||(event.keyCode==8)||(event.keyCode==9)||(event.keyCode>34&&event.keyCode<40)||(event.keyCode==46))"
                           onkeyup="peselUzyt(this.value)" name="pesell" placeholder="Pesel"/>
                    <p><span id="edytujpesel"></span></p>
                    <?php
                    if (isset($_SESSION['e_pesel'])) {
                        echo '<div class="error">' . $_SESSION['e_pesel'] . '</div>';
                        unset($_SESSION['e_pesel']);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <?php
            if($row['data_urodzenia'] == 1) {
                ?>
                <div class="form-group col-md-12">
                    <label>Data urodzenia</label><img src="css/img/question-mark.png" alt="" width="15"
                                                      data-toggle="tooltip" data-html="true"
                                                      title="<b>Data urodzenia:</b> <br/> Podaj swoją datę urodzenia">
                    <input type="date" class="form-control" value="<?php print $uzupelnij_data_urodzenia; ?>" name="dataurodzenia"/>
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
                    <label>Adres zamieszkania</label><img src="css/img/question-mark.png" alt="" width="15"
                                                          data-toggle="tooltip" data-html="true"
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
    function imieUzyt(str) {
        let test = document.getElementById("imie");
        let lower = document.getElementById("imie");
        let upper = document.getElementById("imie");
        let ret = "";
        lower = str.toLowerCase();
        upper = str.toUpperCase();
        for(let i=0;i<str.length;i++){
            ret += (i===0) ? upper[i]:lower[i];
            test.value = ret;
        }
        if(!str.match('^[a-zA-Ząćęłńóśźż]+$') | str.length == 0){
            if(str.length == 0){
                document.getElementById("edytujimie").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("edytujimie").innerHTML = "Imię nie powinien mieć znaków specjalnych lub liczb";
            }
        }
        else {
            document.getElementById("edytujimie").innerHTML = "";
        }
    }
    function imieUzytk(event) {
        let key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8);
    }
</script>

<script>
    function drugieimieUzyt(str) {
        let test = document.getElementById("drugieimie");
        let lower = document.getElementById("drugieimie");
        let upper = document.getElementById("drugieimie");
        let ret = "";
        lower = str.toLowerCase();
        upper = str.toUpperCase();
        for(let i=0;i<str.length;i++){
            ret += (i===0) ? upper[i]:lower[i];
            test.value = ret;
        }
        if(!str.match('^[a-zA-Ząćęłńóśźż]+$') | str.length == 0){
            if(str.length == 0){
                document.getElementById("edytujdrugieimie").innerHTML = "Pole jest wymagane";
            }
            else {
                document.getElementById("edytujdrugieimie").innerHTML = "Imię nie powinien mieć znaków specjalnych lub liczb";
            }
        }
        else {
            document.getElementById("edytujdrugieimie").innerHTML = "";
        }
    }

    function drugieimieUzytk(event) {
        let key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8);
    }
</script>

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
        return ((key >= 65 && key <= 90) || key == 8);

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
    function peselUzyt(str) {
        if (!str.match("^[0-9]{11}") | str.length == 0) {
            if(str.length == 0){
                document.getElementById("edytujpesel").innerHTML = "Pole jest wymagane";
            }
            else{
                document.getElementById("edytujpesel").innerHTML = "Zły numer pesel";
            }
        } else {
            document.getElementById("edytujpesel").innerHTML = "";
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
    <?php
        include "js/tooltip.js";
    ?>
</script>
</body>
</html>
