const insertTable = (row, c1, c2, c3, c4, c5) => {
    var row = table.insertRow(row);
    // Insert new cells 
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    cell1.innerHTML = "<a href='confinfos.html?id=" + c2 + "&confname=" + c1 + "'" + ">" + c1 + "</a>";
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
cellz1.innerHTML = "conference Name";
cellz2.innerHTML = "conference ID";
cellz3.innerHTML = "Lieu";
cellz4.innerHTML = "start date";
cellz5.innerHTML = "end date";



var req = new XMLHttpRequest();
req.responseType = 'json';
req.open('GET', "http://localhost:8000/api/v1/read/read_all_conf.php", true);
req.onload  = function() {
   var jsonResponse = req.response;
   // do something with jsonResponse
   var cpt = 1;
   for (const property in jsonResponse["body"]) {
        
        cpt = cpt + 1;
        const confID = jsonResponse["body"][property]["confID"];
        const confName= jsonResponse["body"][property]["confName"];
        const confLieu = jsonResponse["body"][property]["confLieu"];
        const sdate = jsonResponse["body"][property]["startDate"];
        const edate = jsonResponse["body"][property]["endDate"];
        insertTable(cpt, confName, confID, confLieu, sdate, edate);
        
   }
};
req.send(null);