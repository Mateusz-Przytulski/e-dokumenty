function hasloF(str) {
    if(!str.match("^[0-9a-zA-Ząćęłńóśźż]+$") | str.length < 6 | str.length > 20 | str.length == 0){
        if (str.length < 6 | str.length > 20 | str.length == 0) {
            if(str.length == 0) {
                document.getElementById("powiadom_firmeHaslo").innerHTML = "Pole wymagane";
            }
            else {
                document.getElementById("powiadom_firmeHaslo").innerHTML = "Hasło powinien mieć od 6 do 20znaków";
            }
        }
        else {
            document.getElementById("powiadom_firmeHaslo").innerHTML = "Hasło nie powinien mieć znaków specjalnych";
        }
    }
    else {
        document.getElementById("powiadom_firmeHaslo").innerHTML = "";
    }
}