function function1(cpt, fname, lname) {
    var ul = document.getElementById("users");
    var li = document.createElement("li");
    li.appendChild(document.createTextNode(""));
    li.setAttribute("id", "test"+cpt);
    ul.appendChild(li);
    
    var ul = document.getElementById("test"+cpt);
    ul.innerHTML = '<li><i class="far fa-hand-point-right"></i>' + fname + " " + lname + '</li>';
}

var req2 = new XMLHttpRequest();
req2.responseType = 'json';
const url2 = "http://localhost:8000/api/v1/read/list_users_conf.php?confid=" + id
req2.open('GET', url2, true);
var cpt = 1
req2.onload  = function() {
   var jsonResponse = req2.response;
   for (const property in jsonResponse["body"]) {       
        const firstname = jsonResponse["body"][property]["fName"];
        const lastname = jsonResponse["body"][property]["lName"];
        console.log(firstname, lastname);
        function1(cpt,firstname, lastname);
        cpt = cpt + 1;
   }
};
req2.send(null);