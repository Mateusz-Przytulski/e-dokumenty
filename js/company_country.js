function krajF(str) {
    let test = document.getElementById("krajFirma");
    let lower = document.getElementById("krajFirma");
    let upper = document.getElementById("krajFirma");
    let ret = "";
    lower = str.toLowerCase();
    upper = str.toUpperCase();
    for(let i=0;i<str.length;i++){
        ret += (i===0) ? upper[i]:lower[i];
        test.value = ret;
    }

    if(!str.match('^[a-zA-Ząćęłńóśźż]+$') | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_firmeKraj").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_firmeKraj").innerHTML = "Podaj poprawną nazwę kraju";
        }
    }
    else {
        document.getElementById("powiadom_firmeKraj").innerHTML = "";
    }
}

function krajFi(event) {
    let key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8 || key == 32);
}