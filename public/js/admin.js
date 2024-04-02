/* ORDERS */

// Test
function updateStatus(orderId){
    var filterValue = document.getElementById('filter-select').value;
    const xttp = new XMLHttpRequest();
    xttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("update status");
            document.getElementById('orders-list').innerHTML = this.responseText;
        }
    };
    xttp.open("POST", "/cup_of_tea_php/?route=order-status");
    xttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xttp.send("orderId="+ orderId + "&filter=" + filterValue);
}

function filterOrders() {
    var filterValue = document.getElementById('filter-select').value;
    console.log("filter value : " + filterValue);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("filter orders  : ");
            document.getElementById('orders-list').innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=order-filter", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("filter=" + filterValue);
}



let ordersElem = document.getElementById('orders');
let teasElem = document.getElementById('teas');
let addTeaElem = document.getElementById('add-tea');

function showDetails(orderId){
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

const sections = [ordersElem, teasElem, addTeaElem];

function displaySection(sectionIndex){
    for(let i=0; i<sections.length; i++){
        sections[i].style.display = 'none';
    }
    sections[sectionIndex].style.display = 'block';
}


function updateFileName(input) {
    var fileName = input.value.split('\\').pop();
    document.getElementById('file-name').textContent = fileName ? fileName : 'Aucun fichier choisi';
}


/* ADD TEA */

function addTea() {
    let formData = new FormData(document.getElementById('add'));
    let isFavorite = document.getElementById('favorite').checked ? 1 : 0;
    formData.append('isFavorite', isFavorite);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("response!");
            console.log(this.responseText);
            document.getElementById("message").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "/cup_of_tea_php/?route=add-tea", true);
    xhttp.send(formData);
}


let formatCount = 1; // Keep track of how many formats have been added

function addFormat() {
    formatCount++;
    const container = document.getElementById('formats-container');
    
    const formatDiv = document.createElement('div');
    formatDiv.className = 'format';
    formatDiv.innerHTML = `
        <br>
        <div>
            <label for="format-price-${formatCount}">Prix</label>
            <input type="number" id="format-price-${formatCount}" name="formatPrice[]" placeholder="10.99" step="0.01" />
        </div>
        <div>
            <label for="format-conditioning-${formatCount}">Conditionnement</label>
            <input type="text" id="format-conditioning-${formatCount}" name="formatConditioning[]" placeholder="Sachet, Boîte, etc." />
        </div>
        `;

    container.appendChild(formatDiv);
}