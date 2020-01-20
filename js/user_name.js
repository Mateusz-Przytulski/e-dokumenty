function imieUzyt(str) {
    let test = document.getElementById("imieUzytkownik");
    let lower = document.getElementById("imieUzytkownik");
    let upper = document.getElementById("imieUzytkownik");
    let ret = "";
    lower = str.toLowerCase();
    upper = str.toUpperCase();
    for(let i=0;i<str.length;i++){
        ret += (i===0) ? upper[i]:lower[i];
        test.value = ret;
    }
    if(!str.match('^[a-zA-Ząćęłńóśźż]+$') | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_uzytkownikaImie").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_uzytkownikaImie").innerHTML = "Imię nie powinien mieć znaków specjalnych lub liczb";
        }
    }
    else {
        document.getElementById("powiadom_uzytkownikaImie").innerHTML = "";
    }
}

function imieUzytk(event) {
    let key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8);
}