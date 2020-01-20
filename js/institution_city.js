function miastoI(str) {
    let test = document.getElementById("miastoInstytucja");
    let lower = document.getElementById("miastoInstytucja");
    let upper = document.getElementById("miastoInstytucja");
    let ret = "";
    lower = str.toLowerCase();
    upper = str.toUpperCase();
    for(let i=0;i<str.length;i++){
        ret += (i===0) ? upper[i]:lower[i];
        test.value = ret;
    }
    if(!str.match('^[a-zA-Ząćęłńóśźż\\-\\ ]+$') | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_instytucjeMiasto").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_instytucjeMiasto").innerHTML = "Podaj poprawne miasto";
        }
    }
    else {
        document.getElementById("powiadom_instytucjeMiasto").innerHTML = "";
    }
}
function miastoIn(event) {
    let key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8 || key == 32 || key == 109);
}