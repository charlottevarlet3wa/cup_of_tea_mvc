let detailElem = document.getElementById('order-detail');

function showDetail(orderId){
    console.log("order id js : " + orderId);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(this.responseText);
            detailElem.innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=account-show-detail", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("orderId=" + orderId);
}

let enableBtn = document.getElementById('enable-change-btn');
let changeBtn = document.getElementById('change-btn');

let lastNameElem = document.getElementById('last_name');
let nameElem = document.getElementById('name');
let emailElem = document.getElementById('name');

function enableChange(){
    lastNameElem.disabled = false;
    console.log("enabled !");
}


// TODO : à faire directement en PHP avec un formulaire ? dans MyAccountController ? voir comment signup et/ou login ont été faits
function changeInfo(){

}