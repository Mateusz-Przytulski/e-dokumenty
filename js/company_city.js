function miastoF(str) {
    let test = document.getElementById("miastoFirma");
    let lower = document.getElementById("miastoFirma");
    let upper = document.getElementById("miastoFirma");
    let ret = "";
    lower = str.toLowerCase();
    upper = str.toUpperCase();
    for(let i=0;i<str.length;i++){
        ret += (i===0) ? upper[i]:lower[i];
        test.value = ret;
    }
    if(!str.match('^[a-zA-Ząćęłńóśźż\\-\\ ]+$') | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_firmeMiasto").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_firmeMiasto").innerHTML = "Podaj poprawne miasto";
        }
    }
    else {
        document.getElementById("powiadom_firmeMiasto").innerHTML = "";
    }
}
function miastoFi(event) {
    let key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8 || key == 32 || key == 109);
}