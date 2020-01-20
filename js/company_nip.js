let nip = document.getElementById('nipFirma');
let tem1 = false;
let tem2 = false;
let tem3 = false;
nip.addEventListener("keydown", () => {
    if (nip.value.length == 3 && !tem1) {
        nip.value += "-"
        tem1 = true;
    }
    if (nip.value.length <= 3) {
        tem1 = false;
    }
    if (!nip.value.indexOf('-')) {
        nip.value.splice(3, 0, "-")
    }

    if (nip.value.length == 7 && !tem2) {
        nip.value += "-"
        tem2 = true;
    }
    if (nip.value.length <= 7) {
        tem2 = false;
    }
    if (!nip.value.indexOf('-')) {
        nip.value.splice(7, 0, "-")
    }

    if (nip.value.length == 10 && !tem3) {
        nip.value += "-"
        tem3 = true;
    }
    if (nip.value.length <= 10) {
        tem3 = false;
    }
    if (!nip.value.indexOf('-')) {
        nip.value.splice(10, 0, "-")
    }
})
function nipF(str) {
    if (!str.match('[0-9]{3}\\-[0-9]{3}\\-[0-9]{2}\\-[0-9]{2}') | str.length == 0) {
        if(str.length == 0){
            document.getElementById("powiadom_firmeNIP").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_firmeNIP").innerHTML = "Zły numer NIP XXX-XXX-XX-XX";
        }
    } else {
        document.getElementById("powiadom_firmeNIP").innerHTML = "";
    }
}