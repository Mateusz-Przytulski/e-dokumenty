function adresF(str) {
    if(!str.match('^[0-9a-zA-Ząćęłńóśźż\\-\\ \\.]+$') | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_firmeAdres").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_firmeAdres").innerHTML = "Podaj poprawny adres";
        }
    }
    else {
        document.getElementById("powiadom_firmeAdres").innerHTML = "";
    }
}

function adresFi(event) {
    let key = event.keyCode;
    return ((key >= 48 && key <= 90) || key == 8 || key == 32 || key == 109 || key == 190);
}