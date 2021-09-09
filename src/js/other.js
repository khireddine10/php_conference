function clicked(){
    if (confirm('Are you sure you want to delete this conference?')) {
        // Save it!
        var req = new XMLHttpRequest();
        req.responseType = 'json';
        const url = "http://localhost:8000/api/v1/delete/deleteconf.php?confid=" + id
        req.open('GET', url, true);
        req.onload  = function() {
            window.location.replace("http://localhost:8000");
        };
        req.send(null);
    } else {
        // Do nothing!
        
    }
}

// add id to update url
var element = document.getElementById("updatehref");
element.href = "updateconf.html?confid=" + id;

var element1 = document.getElementById("createsession");
element1.href = "createsession.html?confid=" + id;
console.log(element1)