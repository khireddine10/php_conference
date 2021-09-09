const insertTable = (row, c1, c2, c3, c4, c5) => {
    var row = table.insertRow(row);
    // Insert new cells 
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    cell1.innerHTML = "<a href='confinfos.html?id=" + c2 + + "&confname=" + c1 + "'" + ">" + c1 + "</a>";
    cell2.innerHTML = c2;
    cell3.innerHTML = c3;
    cell4.innerHTML = c4;
    cell5.innerHTML = c5;
}

const insertContact = (row, c1, c2, c3, c4, c5) => {
    var row = table1.insertRow(row);
    // Insert new cells 
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    cell1.innerHTML = "<a href='confinfos.html?id=" + c2 + + "&confname=" + c1 + "'" + ">" + c1 + "</a>";
    cell2.innerHTML = c2;
    cell3.innerHTML = c3;
    cell4.innerHTML = c4;
    cell5.innerHTML = c5;
}

var table = document.getElementById("mytable");
var row_z = table.insertRow(1);
var cellz1 = row_z.insertCell(0);
var cellz2 = row_z.insertCell(1);
var cellz3 = row_z.insertCell(2);
var cellz4 = row_z.insertCell(3);
var cellz5 = row_z.insertCell(4);
cellz1.innerHTML = "conference ID";
cellz2.innerHTML = "session name";
cellz3.innerHTML = "session ID";
cellz4.innerHTML = "start date";
cellz5.innerHTML = "end date";

var table1 = document.getElementById("contact_table");
var row_c = table1.insertRow(1);
var cellc1 = row_c.insertCell(0);
var cellc2 = row_c.insertCell(1);
var cellc3 = row_c.insertCell(2);
var cellc4 = row_c.insertCell(3);
var cellc5 = row_c.insertCell(4);
cellc1.innerHTML = "email";
cellc2.innerHTML = "twitter";
cellc3.innerHTML = "facebook";
cellc4.innerHTML = "telegram";
cellc5.innerHTML = "instagram";


const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');
const confname = urlParams.get('confname');
var conftitle= document.getElementById("conftitle");
var conftitle1= document.getElementById("sconftitle");
conftitle.innerHTML = confname;
conftitle1.innerHTML = confname;

var req = new XMLHttpRequest();
req.responseType = 'json';
const url = "http://localhost:8000/api/v1/read/list_sessions_conf.php?confid=" + id
req.open('GET', url, true);
req.onload  = function() {
   var jsonResponse = req.response;
   var cpt = 1;
   for (const property in jsonResponse["body"]) {
        
    cpt = cpt + 1;
    const confID = jsonResponse["body"][property]["confID"];
    const confName= jsonResponse["body"][property]["sessionID"];
    const confLieu = jsonResponse["body"][property]["sessionName"];
    const sdate = jsonResponse["body"][property]["sDate"];
    const edate = jsonResponse["body"][property]["eDate"];
    insertTable(cpt, confName, confID, confLieu, sdate, edate);
    
   }
};
req.send(null);

var req1 = new XMLHttpRequest();
req1.responseType = 'json';
const url1 = "http://localhost:8000/api/v1/read/readconf.php?confid=" + id
req1.open('GET', url1, true);
req1.onload  = function() {
   var jsonResponse = req1.response;
   insertContact(2,  jsonResponse["email"], jsonResponse["twitter"], jsonResponse["facebook"], 
              jsonResponse["telegram"], jsonResponse["instagram"]);

}
req1.send(null);