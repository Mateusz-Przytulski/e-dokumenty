let telefon = document.getElementById('telefonUzytkownik');
let temp1 = false;
let temp2 = false;
telefon.addEventListener("keydown", () => {
    if (telefon.value.length == 3 && !temp1) {
        telefon.value += "-"
        temp1 = true;
    }
    if (telefon.value.length <= 3) {
        temp1 = false;
    }
    if (!telefon.value.indexOf('-')) {
        telefon.value.splice(3, 1, "-")
    }

    if (telefon.value.length == 7 && !temp2) {
        telefon.value += "-"
        temp2 = true;
    }
    if (telefon.value.length <= 7) {
        temp2 = false;
    }
    if (!telefon.value.indexOf('-')) {
        telefon.value.splice(7, 0, "-")
    }
})
function telefonUzyt(str) {
    if (!str.match('[0-9]{3}\\-[0-9]{3}\\-[0-9]{3}') | str.length == 0) {
        if(str.length == 0){
            document.getElementById("powiadom_uzytkownikaTelefon").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_uzytkownikaTelefon").innerHTML = "Zły numer telefonu XXX-XXX-XXX";
        }
    } else {
        document.getElementById("powiadom_uzytkownikaTelefon").innerHTML = "";
    }
}