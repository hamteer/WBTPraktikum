
function loadUsers() {
    var xmlhttp = new XMLHttpRequest();
    var datalist = document.getElementById("userList");
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let data = JSON.parse(xmlhttp.responseText);
            console.log(data);

            for (let datum of data) {
                let listOption = document.createElement("option");
                listOption.innerText = datum;
                datalist.appendChild(listOption);
                
            }
            document.body.appendChild(datalist);
        }
    };
    xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/f997c300-84dc-4ff7-b3ab-b134ffb2c1ba/user", true);
    // Add token, e. g., from Tom
    xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2OTg5NTQxfQ.FwGRT0yDDEQWnAf_QpOgqgLVqXwi64q95aazXrab2c4');
    xmlhttp.send();
};