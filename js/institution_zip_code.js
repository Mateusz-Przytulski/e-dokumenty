let kodpocztowyi = document.getElementById('kodpocztowyInstytucja');
let tempom1 = false;
kodpocztowyi.addEventListener("keydown", () => {
    if (kodpocztowyi.value.length == 2 && !tempom1) {
        kodpocztowyi.value += "-";
        tempom1 = true;
    }
    if (kodpocztowyi.value.length <= 2) {
        tempom1 = false;
    }
    if (!kodpocztowyi.value.indexOf('-')) {
        kodpocztowyi.value.splice(2, 0, "-");
    }

})
function kodpocztowyI(str) {
    if (!str.match('[0-9]{2}\\-[0-9]{3}') | str.length == 0) {
        if(str.length == 0){
            document.getElementById("powiadom_instytucjeKodpocztowy").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_instytucjeKodpocztowy").innerHTML = "Zły numer kodu pocztowego XX-XXX";
        }
    } else {
        document.getElementById("powiadom_instytucjeKodpocztowy").innerHTML = "";
    }
}