let cartCount = document.getElementById('cart-count');
let cartTotal = document.getElementById('cart-total');
let formatId = document.getElementById('format-select').value;

function addToCart() {
    let teaId = document.getElementById('tea-id').value;
    let formatId = document.getElementById('format-select').value;
    console.log('format select : ' + formatId);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(this.responseText);
            // console.log("added to cart !");
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=add-to-cart", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("teaId=" + teaId + "&formatId=" + formatId);
}



let formatsJson = document.getElementById('formats').value;
let formats = JSON.parse(formatsJson);

function updatePriceFromFormat(){
    // console.log('formats : ' + formats);
    let formatId = document.getElementById('format-select').value;
    document.getElementById('format-price').innerHTML = formats[formatId].price;
}