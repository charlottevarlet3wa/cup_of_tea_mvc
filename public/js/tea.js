let cartCount = document.getElementById('cart-count');
let cartTotal = document.getElementById('cart-total');
let formatId = document.getElementById('format-select').value;

function addToCart() {
    let teaId = document.getElementById('tea-id').value;
    let formatId = document.getElementById('format-select').value;
    console.log('teaId : ' + teaId + 'format select : ' + formatId);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            updateCartHeader();
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=add-to-cart", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("teaId=" + teaId + "&formatId=" + formatId);
}

function updateCartHeader(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            cartTotal.innerHTML = response.total + " €";
            cartCount.innerHTML = response.count;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=display-cart-header", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send();
}



let formatsJson = document.getElementById('formats').value;
let formats = JSON.parse(formatsJson);

function updatePriceFromFormat(){
    let formatId = document.getElementById('format-select').value;
    document.getElementById('format-price').innerHTML = formats[formatId].price + "€";
}