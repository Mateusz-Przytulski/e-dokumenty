function nazwaF(str) {
    let test = document.getElementById("nazwaFirma");
    let low = document.getElementById("nazwaFirma");
    let upp = document.getElementById("nazwaFirma");
    let ret = "";
    low = str.toLowerCase();
    upp = str.toUpperCase();

    for(let i=0;i<str.length;i++){
        ret += (i===0) ? upp[i]:low[i];
        test.value = ret;
    }

    if(!str.match('^[a-zA-Ząćęłńóśźż\\ \\-]+$') | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_firmeNazwa").innerHTML = "Pole wymagane";
        }
        else {
            document.getElementById("powiadom_firmeNazwa").innerHTML = "Błędna nazwa firmy";
        }
    }
    else {
        document.getElementById("powiadom_firmeNazwa").innerHTML = "";
    }
}