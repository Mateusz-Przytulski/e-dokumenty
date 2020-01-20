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
            document.getElementById("powiadom_uzytkownikaNazwisko").innerHTML = "Pole wymagane";
        }
        else {
            document.getElementById("powiadom_uzytkownikaNazwisko").innerHTML = "Nazwisko nie powinno mieć znaków specjalnych lub liczb";
        }
    }
    else {
        document.getElementById("powiadom_uzytkownikaNazwisko").innerHTML = "";
    }
}

function nazwiskoUzytk(event) {
    let key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8);

}