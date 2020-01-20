function emailUzyt(str) {
    let email = /^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*@([a-zA-Z0-9_-]+)(\.[a-zA-Z0-9_-]+)*(\.[a-zA-Z]{2,4})$/i;
    if(!str.match(email) | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_uzytkownikaEmail").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_uzytkownikaEmail").innerHTML = "Podaj poprawny adress e-mail np. jkowalski@gmail.com";
        }
    }
    else {
        document.getElementById("powiadom_uzytkownikaEmail").innerHTML = "";
    }
}