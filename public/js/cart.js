
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

function updateCartDisplay(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            cartBody.innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=display-cart", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send();
}


// let cartHeaderTotal = document.getElementById('cart-total');

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