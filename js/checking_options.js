$(document).ready(function(){
    let uzytkownik = document.getElementById("uzytkownik").checked;
    let firma = document.getElementById("firma").checked;
    let instytucja = document.getElementById("instytucja").checked;
    if (uzytkownik == true ) {
        $("#rejestracjaUzytkownik").show();
        $("#rejestracjaFirma").hide();
        $("#rejestracjaInstytucja").hide();
    }
    if (firma == true ) {
        $("#rejestracjaUzytkownik").hide();
        $("#rejestracjaFirma").show();
        $("#rejestracjaInstytucja").hide();
    }
    if (instytucja == true ) {
        $("#rejestracjaUzytkownik").hide();
        $("#rejestracjaFirma").hide();
        $("#rejestracjaInstytucja").show();
    }
    $("#uzytkownik").click(function(){
        $("#rejestracjaUzytkownik").show();
        $("#rejestracjaFirma").hide();
        $("#rejestracjaInstytucja").hide();
    });

    $("#firma").click(function(){
        $("#rejestracjaFirma").show();
        $("#rejestracjaUzytkownik").hide();
        $("#rejestracjaInstytucja").hide();
    });
    $("#instytucja").click(function(){
        $("#rejestracjaInstytucja").show();
        $("#rejestracjaUzytkownik").hide();
        $("#rejestracjaFirma").hide();
    });
});