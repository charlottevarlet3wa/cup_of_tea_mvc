
function removeFromCart(){
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=remove-all-from-cart", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("teaId=" + teaId + "&formatId=" + formatId);
}

function changeQuantity(teaId, formatId, quantity){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            
            updateCartDisplay();
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=change-cart-quantity", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("teaId=" + teaId + "&formatId=" + formatId + "&quantity=" + quantity);
}

let cartTable = document.getElementById('cart-table');
let empty = document.getElementById('empty-message');

let cartHeaderTotal = document.getElementById('cart-total');
let cartHeaderCount = document.getElementById('cart-count');


/*
function updateCartDisplay(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText == "empty"){
                cartTable.style.display = "none";
                empty.innerHTML = "Le panier est vide";
                return;
            }

            cartTable.innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=display-cart", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send();
}*/

function updateCartDisplay(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText == "empty"){
                cartTable.style.display = "none";
                document.getElementById('next-btn').style.display = "none";
                document.getElementById('empty-message').innerHTML = "Le panier est vide";
                document.getElementById('next-btn').style.color = "red";
                return;
            }
            
            cartTable.innerHTML = this.responseText;
            document.getElementById('empty-message').innerHTML = "";

            document.getElementById('next-btn').style.color = "red";
            document.getElementById('next-btn').style.display = "inline-block";
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=display-cart", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send();
}




