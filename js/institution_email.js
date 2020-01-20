function emailI(str) {
    let emailfi = /^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*@([a-zA-Z0-9_-]+)(\.[a-zA-Z0-9_-]+)*(\.[a-zA-Z]{2,4})$/i;
    if(!str.match(emailfi) | str.length == 0){
        if(str.length == 0){
            document.getElementById("powiadom_instytucjeEmail").innerHTML = "Pole wymagane";
        }
        else{
            document.getElementById("powiadom_instytucjeEmail").innerHTML = "Podaj poprawny adress e-mail np. jkowalski@gmail.com";
        }
    }
    else {
        document.getElementById("powiadom_instytucjeEmail").innerHTML = "";
    }
}