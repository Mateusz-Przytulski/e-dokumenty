function nazwaI(str) {
    let test = document.getElementById("nazwaInstytucji");
    let low = document.getElementById("nazwaInstytucji");
    let upp = document.getElementById("nazwaInstytucji");
    let ret = "";
    low = str.toLowerCase();
    upp = str.toUpperCase();

    for(let i=0;i<str.length;i++){
        ret += (i===0) ? upp[i]:low[i];
        test.value = ret;
    }

    if(!str.match('^[a-zA-Ząćęłńóśźż\\ \\-]+$') | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_instytucjeNazwa").innerHTML = "Pole wymagane";
        }
        else {
            document.getElementById("powiadom_instytucjeNazwa").innerHTML = "Błędna nazwa Instytucji";
        }
    }
    else {
        document.getElementById("powiadom_instytucjeNazwa").innerHTML = "";
    }
}