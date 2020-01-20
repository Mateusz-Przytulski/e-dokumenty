function loginF(str) {
    if(!str.match('^[a-zA-Z0-9]+$') | str.length < 6 | str.length > 20 | str.length == 0){
        if (str.length < 6 || str.length > 20 | str.length == 0) {
            if(str.length == 0){
                document.getElementById("powiadom_firmeLogin").innerHTML = "Pole wymagane";
            }
            else{
                document.getElementById("powiadom_firmeLogin").innerHTML = "Login powinien mieć od 6 do 20znaków";
            }
        }
        else {
            document.getElementById("powiadom_firmeLogin").innerHTML = "Login nie powinien mieć znaków specjalnych";
        }
    }
    else {
        document.getElementById("powiadom_firmeLogin").innerHTML = "";
    }
}