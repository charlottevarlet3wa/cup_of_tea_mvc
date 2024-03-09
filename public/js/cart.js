
function hello(){
    console.log("hello");
}

function removeFromCart(){
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            console.log("removed from cart !");
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=remove-all-from-cart", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("teaId=" + teaId + "&formatId=" + formatId);
}

function changeQuantity(teaId, formatId, quantity){
    console.log("teaId : " + teaId + " _ formatId : " + formatId + " _ quantity : " + quantity);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            updateCartDisplay();
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=change-cart-quantity", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("teaId=" + teaId + "&formatId=" + formatId + "&quantity=" + quantity);
}

let cartBody = document.getElementById('cart-body');
let cartTable = document.getElementById('cart-table');
let empty = document.getElementById('empty-message');

let cartHeaderTotal = document.getElementById('cart-total');
let cartHeaderCount = document.getElementById('cart-count');



function updateCartDisplay(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText == "empty"){
                cartTable.style.display = "none";
                empty.innerHTML = "Le panier est vide";
                return;
            }
            // console.log("réponse : " + this.responseText);
            cartBody.innerHTML = this.responseText;
            // let response = JSON.parse(this.responseText);
            // cartHeaderTotal = response.total;
            // cartHeaderCount = response.count;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=display-cart", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send();
}



// function updateCartHeaderDisplay(){
//     var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             // console.log(this.responseText);
//             cartHeaderTotal.innerHTML = this.responseText;
//         }
//     };
//     xhttp.open("POST", "/cup_of_tea_php/?route=display-cart-header", true);
//     xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     xhttp.send();
// }