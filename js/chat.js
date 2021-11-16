    
    
        
window.chatToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2NjU0MzMwfQ.t0AIqQIzxGgIqhPMPUCIFZiiTQE1BpPJEkEe8YsmxSY";
window.chatCollectionId = "b5eb31e8-e269-4c8a-9c86-e99c3a992f51";
window.chatServer = "https://online-lectures-cs.thi.de/chat";


var xmlhttp = new XMLHttpRequest();

// Daten holen und in list einfügen
xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        let data = JSON.parse(xmlhttp.responseText);
        console.log(data);
        const l = data.length - 1;
        console.log(data[l].msg);

        let msg = data[l].msg;
        //document.getElementById('test').innerHTML = (data[l - 2].from) + ': ' + (data[l - 2].msg) + '<br>' + (data[l - 1].msg) + '<br>' + (data[l].msg);
        document.getElementById('firstFrom').innerHTML = data[l].from + ': ';
        document.getElementById('firstTxt').innerHTML = data[l].msg;
        var fTimestamp = data[l].time;
        var fDate = new Date(fTimestamp); 
        document.getElementById('firstTime').innerHTML = " "+fDate.getHours() + ":" + fDate.getMinutes() + ":" + fDate.getSeconds();

        document.getElementById('secondFrom').innerHTML = data[l - 1].from + ': ';
        document.getElementById('secondTxt').innerHTML = data[l - 1].msg;
        var sTimestamp = data[l - 1].time;
        var sDate = new Date(sTimestamp); 
        document.getElementById('secondTime').innerHTML = " "+sDate.getHours() + ":" + sDate.getMinutes() + ":" + sDate.getSeconds();

        document.getElementById('thirdFrom').innerHTML = data[l - 2].from + ': ';
        document.getElementById('thirdTxt').innerHTML = data[l - 2].msg;
        var tTimestamp = data[l - 2].time;
        var tDate = new Date(tTimestamp); 
        document.getElementById('thirdTime').innerHTML = " "+tDate.getHours() + ":" + tDate.getMinutes() + ":" + tDate.getSeconds();

        
    }
};


//Daten senden mit onclick auf Button
function handleKnopf() {

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
            console.log("done...");
            //console.log(data);
        } else {
            //console.log("request fehlgeschlagen");
        }
    };


    xmlhttp.open("POST", "https://online-lectures-cs.thi.de/chat/b5eb31e8-e269-4c8a-9c86-e99c3a992f51/message", true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    // Add token, e. g., from Tom
    xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2NjU0MzMwfQ.t0AIqQIzxGgIqhPMPUCIFZiiTQE1BpPJEkEe8YsmxSY');
    // Create request data with message and receiver


    var eingabe = document.getElementById('eg').value;
    //console.log(eingabe);

    let data = {
        message: document.getElementById('eg').value,
        to: "Jerry"
    };
    console.log(data);

    let jsonString = JSON.stringify(data); // Serialize as JSON
    console.log(jsonString);
    xmlhttp.send(jsonString); // Send JSON-data to server

}

//Zeitschleife um Daten zu aktualisieren
window.setInterval(function () {

    xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/b5eb31e8-e269-4c8a-9c86-e99c3a992f51/message/Jerry", true);
    xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2NjU0MzMwfQ.t0AIqQIzxGgIqhPMPUCIFZiiTQE1BpPJEkEe8YsmxSY');
    xmlhttp.send();

}, 1000)


