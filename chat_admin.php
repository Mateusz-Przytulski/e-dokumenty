<?php
session_start();
if ($_SESSION['admin']==0 | (!isset($_SESSION['zalogowany'])))
{
    header('Location: institution_home.php');
    exit();
}
if(isset($_SESSION['imie'])){
    $user=$_SESSION['imie'];
}
else{
    $user="Konto Anonimowe";
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <?php include "css/head.php"; ?>

    <style type="text/css">
        body {
            font-family: 'Open Sans';
        }
        * {
            box-sizing: border-box;
        }
        .chatContainer {
            width: 100%;
            height: 550px;
            border: 3px solid #eee;
        }
        .chatContainer > .chatHeader {
            width: 100%;
            background: #fff;
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        .chatContainer > .chatHeader h3 {
            font-weight: 400;
            color: #666;
        }
        .chatContainer > .chatMessages {
            height: 470px;
            border-bottom: 1px solid #ddd;
            overflow-y: scroll;
        }
        .chatContainer > .chatBottom form input[type="submit"] {
            padding: 6px;
            background: #fff;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .chatContainer > .chatBottom form input[type="text"] {
            width: 85%;
            padding: 8px;
            padding-left: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 5px;
            height: 30px;
        }
        .chatMessages li:nth-child(2n) {
            background: #eeeeee;
        }
        .msg {
            list-style: none;
            border-bottom: 1px solid #ddd;
            padding: 5px;
            color: #222222;
        }
    </style>
</head>

<body>
<?php include "css/navbarAdmin.php"; ?>
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
    <div class="chatContainer">
        <div class="chatHeader">
            <h5>Witaj <?php echo ucwords($user); ?></h5>
        </div>
        <div class="chatMessages"></div>
        <div class="chatBottom">
            <form action="#" onSubmit='return false;' id="chatForm">
                <input type="hidden" id="name" value="<?php echo $user; ?>"/>
                <input type="text" name="text" id="text" value="" placeholder="Napisz wiadomość" />
                <input type="submit" name="submit" value="Wyślij" />
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(document).on('submit', '#chatForm', function(){
                var text = $.trim($("#text").val());
                var name = $.trim($("#name").val());

                if(text != "" && name != "") {
                    $.post('admin_ChatPoster.php', {text: text, name: name}, function(data){
                        $(".chatMessages").append(data);

                        $(".chatMessages").scrollTop($(".chatMessages")[0].scrollHeight);
                        $("#text").val('');
                    });
                } else {
                    alert("Musisz wpisac wiadomość!");
                }
            });

            function getMessages() {
                $.get('admin_GetMessages.php', function(data){
                    var amount = $(".chatMessages li:last-child").attr('id');
                    $(".chatMessages").html(data);
                    var countMsg = data.split('<li').length - 1;
                    array = [countMsg, amount];
                });
                return array;
            }

            setInterval(function(){
                var num = getMessages();
                if(num[0] > num[1]) {
                    $(".chatMessages").scrollTop($(".chatMessages")[0].scrollHeight);
                }
            },1000);
        });
    </script>
</div>


</body>
</html>
