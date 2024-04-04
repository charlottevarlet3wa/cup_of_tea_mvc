let ordersElem = document.getElementById('past-orders');

function showDetail(elemIndex, orderId){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let detailsElem = document.getElementById('order-details');
            if(detailsElem){
                detailsElem.parentNode.removeChild(detailsElem);
            }
            console.log("row index : " + elemIndex);
            var selectedRow = document.querySelector('#past-orders tbody tr:nth-child(' + (elemIndex + 1) + ')');
            var detailRow = '<tr id="order-details"><td colspan="3">' + this.responseText + '</td><td><button class="grey-btn" onclick=removeDetails()>x</button></td></tr>';
            selectedRow.insertAdjacentHTML('afterend', detailRow);
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=account-show-detail", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("orderId=" + orderId);
}




function removeDetails(){
    let detailsElem = document.getElementById('order-details');
    if(detailsElem){
        detailsElem.parentNode.removeChild(detailsElem);
        return;
    }
}


let lastNameElem = document.getElementById('last-name');
let nameElem = document.getElementById('name');
let emailElem = document.getElementById('email');
let oldPasswordElem = document.getElementById('old-password');
let newPasswordElem = document.getElementById('new-password');

let enableBtn = document.getElementById('enable-change-btn');
let changeBtn = document.getElementById('change-btn');


function enableChange(){
    lastNameElem.disabled = false;
    nameElem.disabled = false;
    emailElem.disabled = false;
    oldPasswordElem.disabled = false;
    newPasswordElem.disabled = false;

    enableBtn.style.display = "none";
    changeBtn.style.display = "block";
}
