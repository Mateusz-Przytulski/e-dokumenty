function krajI(str) {
    let test = document.getElementById("krajInstytucja");
    let lower = document.getElementById("krajInstytucja");
    let upper = document.getElementById("krajInstytucja");
    let ret = "";
    lower = str.toLowerCase();
    upper = str.toUpperCase();
    for(let i=0;i<str.length;i++){
        ret += (i===0) ? upper[i]:lower[i];
        test.value = ret;
    }

    if(!str.match('^[a-zA-Ząćęłńóśźż]+$') | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_instytucjeKraj").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_instytucjeKraj").innerHTML = "Podaj poprawną nazwę kraju";
        }
    }
    else {
        document.getElementById("powiadom_instytucjeKraj").innerHTML = "";
    }
}

function krajIn(event) {
    let key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8 || key == 32);
}