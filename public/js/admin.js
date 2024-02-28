// console.log("HELLO from admin.js ! Je sais je sais :D");

function testeMoi(){
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
    xmlhttp.open("GET", "/cup_of_tea_php/?route=phptest", true);
    xmlhttp.send();
}


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