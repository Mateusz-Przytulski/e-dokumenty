let kodpocztowyf = document.getElementById('kodpocztowyFirma');
let te1 = false;
kodpocztowyf.addEventListener("keydown", () => {
    if (kodpocztowyf.value.length == 2 && !te1) {
        kodpocztowyf.value += "-";
        te1 = true;
    }
    if (kodpocztowyf.value.length <= 2) {
        te1 = false;
    }
    if (!kodpocztowyf.value.indexOf('-')) {
        kodpocztowyf.value.splice(2, 0, "-");
    }

})
function kodpocztowyF(str) {
    if (!str.match('[0-9]{2}\\-[0-9]{3}') | str.length == 0) {
        if(str.length == 0){
            document.getElementById("powiadom_firmeKodpocztowy").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_firmeKodpocztowy").innerHTML = "Zły numer kodu pocztowego XX-XXX";
        }
    } else {
        document.getElementById("powiadom_firmeKodpocztowy").innerHTML = "";
    }
}