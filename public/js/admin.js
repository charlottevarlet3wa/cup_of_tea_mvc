/* ORDERS */

// TODO : which one to keep ? toggleStatus(orderIndex) or toggleStatus(status) ?
// function toggleStatus(status){
//     const xmlhttp = new XMLHttpRequest();
//     xmlhttp.onload = function() {
//         console.log(this.responseText);
//     }
//     xmlhttp.open("POST", "/cup_of_tea_php/?route=order-status");
//     xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xmlhttp.send("status="+status);
// }

// function updateStatus(orderIndex){
//     this.addEventListener('change', function() {
//         if(this.checked){
//             console.log("checked");
//             toggleStatus(orderIndex, 1);
//         } else {
//             console.log("unchecked");
//             toggleStatus(orderIndex, 0);
//         }
//     });
// }

function updateStatus(orderId){
    let checkbox = this;
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        console.log(this.responseText);
    }
    xmlhttp.open("POST", "/cup_of_tea_php/?route=order-status");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("orderId="+orderId);
}



document.getElementById('filter-select').addEventListener('change', function() {
    var filterValue = this.value;
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('orders-list').innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=order-filter", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("filter=" + filterValue);
});


function sayHello(){
    console.log("Hello dear");
}

let ordersElem = document.getElementById('orders');
let orderDetailsElem = document.getElementById('order-details');
let teasElem = document.getElementById('teas');
let addTeaElem = document.getElementById('add-tea');

function showDetails(orderId){
    console.log(orderId);

    ordersElem.style.display = 'none';
    orderDetailsElem.style.display = 'block';
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('order-details').innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=show-details", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("orderId=" + orderId);
}

function showList(){
    ordersElem.style.display = 'block';
    orderDetailsElem.style.display = 'none';
}

const sections = [ordersElem, orderDetailsElem, teasElem, addTeaElem];

function displaySection(sectionIndex){
    for(let i=0; i<sections.length; i++){
        sections[i].style.display = 'none';
    }
    sections[sectionIndex].style.display = 'block';
}




/* ADD TEA */

function addTea() {
    let formData = new FormData();
    let image = document.getElementById('image').files[0];
    let isFavorite = document.getElementById('favorite').checked ? 1 : 0;

    formData.append('ref', document.getElementById('ref').value);
    formData.append('name', document.getElementById('name').value);
    formData.append('subtitle', document.getElementById('subtitle').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('image', image);
    formData.append('cat', document.getElementById('cat').value);
    formData.append('isFavorite', isFavorite);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=add-tea", true);
    xhttp.send(formData);
}