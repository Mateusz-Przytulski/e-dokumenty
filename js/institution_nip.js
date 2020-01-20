let nipinstytucja = document.getElementById('nipInstytucja');
let tempo1 = false;
let tempo2 = false;
let tempo3 = false;
nipinstytucja.addEventListener("keydown", () => {
    if (nipinstytucja.value.length == 3 && !tempo1) {
        nipinstytucja.value += "-"
        tempo1 = true;
    }
    if (nipinstytucja.value.length <= 3) {
        tempo1 = false;
    }
    if (!nipinstytucja.value.indexOf('-')) {
        nipinstytucja.value.splice(3, 0, "-")
    }

    if (nipinstytucja.value.length == 7 && !tempo2) {
        nipinstytucja.value += "-"
        tempo2 = true;
    }
    if (nipinstytucja.value.length <= 7) {
        tempo2 = false;
    }
    if (!nipinstytucja.value.indexOf('-')) {
        nipinstytucja.value.splice(7, 0, "-")
    }

    if (nipinstytucja.value.length == 10 && !tempo3) {
        nipinstytucja.value += "-"
        tempo3 = true;
    }
    if (nipinstytucja.value.length <= 10) {
        tempo3 = false;
    }
    if (!nipinstytucja.value.indexOf('-')) {
        nipinstytucja.value.splice(10, 0, "-")
    }
})
function nipI(str) {
    if (!str.match('[0-9]{3}\\-[0-9]{3}\\-[0-9]{2}\\-[0-9]{2}') | str.length == 0) {
        if(str.length == 0){
            document.getElementById("powiadom_instytucjeNIP").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_instytucjeNIP").innerHTML = "Zły numer NIP XXX-XXX-XX-XX";
        }
    } else {
        document.getElementById("powiadom_instytucjeNIP").innerHTML = "";
    }
}