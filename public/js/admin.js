
function toggleStatus(status){
    // console.log("lalalaalla priscilla");
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        // document.getElementById("txtHint").innerHTML = this.responseText;
        // document.getElementById("txtHint").innerHTML = str;
        // console.log("I GOT IT BABY ! AJAX BRUZZA !");
        console.log(this.responseText);
    }
    // xmlhttp.open("GET", "gethint.php?q=" + str);
    // xmlhttp.open("GET", "/AJAX_exo/?route=suggest&q=" + encodeURIComponent(str), true);
    // xmlhttp.open("GET", "/cup_of_tea_php/?route=test", true);
    // xmlhttp.open("POST", "/cup_of_tea_php/?route=phptest", true);
    // xmlhttp.send();
    xmlhttp.open("POST", "/cup_of_tea_php/?route=order-status");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("status="+status);
}
/*
document.getElementById("checkbox").addEventListener('change', function() {
    // console.log("YOUHOU");
    if(this.checked){
        console.log("checked");
        toggleStatus(1);
    } else {
        console.log("unchecked");
        toggleStatus(0);
    }
});
*/

// TODO test without addeventlistener
// TODO tester après avoir créé la liste des orders
// const checkboxes = document.getElementsByClassName('order-status');
// for(let i = 0; i < checkboxes.length; i++){
// function toggleStatus(){
//     checkboxes[i].addEventListener('change', function() {
//         // console.log("YOUHOU");
//         if(this.checked){
//             console.log("checked");
//             toggleStatus(i, 1);
//         } else {
//             console.log("unchecked");
//             toggleStatus(i, 0);
//         }
//     });
// }
function toggleStatus(orderIndex){
    this.addEventListener('change', function() {
        // console.log("YOUHOU");
        if(this.checked){
            console.log("checked");
            toggleStatus(orderIndex, 1);
        } else {
            console.log("unchecked");
            toggleStatus(orderIndex, 0);
        }
    });
}

document.getElementById('filter-select').addEventListener('change', function() {
    var filterValue = this.value;
    // console.log(this.value);
    
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

// function showHint(str) {
//     if (str.length == 0) {
//       document.getElementById("txtHint").innerHTML = "";
//       return;
//     } else {
//         console.log(str);
//       const xmlhttp = new XMLHttpRequest();
//       xmlhttp.onload = function() {
//         document.getElementById("txtHint").innerHTML = this.responseText;
//         // document.getElementById("txtHint").innerHTML = str;
//       }
//     // xmlhttp.open("GET", "gethint.php?q=" + str);
//     xmlhttp.open("GET", "/AJAX_exo/?route=suggest&q=" + encodeURIComponent(str), true);
//     xmlhttp.send();
//     }
//   }

const sections = [ordersElem, orderDetailsElem, teasElem, addTeaElem];
console.log(sections);

function displaySection(sectionIndex){
    for(let i=0; i<sections.length; i++){
        sections[i].style.display = 'none';
    }
    sections[sectionIndex].style.display = 'block';
}