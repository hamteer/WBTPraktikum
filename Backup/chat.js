const sendBtn = document.getElementById("sendBtn");
// get ul element for append
const ul = document.getElementById("chatList");
// get message from text input
const msgInput = document.getElementById("inputMsg");

//
// create all necessary elements for one Message
//
function createMessageElementinChat(msgTxt, sender, time) {
    // create single message elements: li whole message
    const li = document.createElement("li");
    li.classList.add("message");
    // create single message elements: p message container
    const p = document.createElement("p");
    p.classList.add("messageContainer");
    // create single message elements: span chatName name of sender
    const spName = document.createElement("span");
    spName.classList.add("chatName");
    spName.textContent = sender + ": ";
    // create single message elements: span chatMessage
    const spMsg = document.createElement("span");
    spMsg.classList.add("chatMessage");
    spMsg.textContent = msgTxt;
    // create single message elements: span timestamp
    const spTime = document.createElement("span");
    spTime.classList.add("chatTimestamp");
    spTime.textContent = time;
    // p append children chatName, chatMessage, timestamp
    p.appendChild(spName);
    p.appendChild(spMsg);
    p.appendChild(spTime);
    // li append p
    li.appendChild(p);
    // ul append complete Message
    ul.appendChild(li);
}



//
// Data-section: get, process and send data
//
function getAndProcessData() {
    var xmlhttp = new XMLHttpRequest();
    // Daten holen und in list einfügen
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            let data = JSON.parse(xmlhttp.responseText);
            let length = data.length;
            clearList();
            processData(data, length);
        }
    }
    xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/b5eb31e8-e269-4c8a-9c86-e99c3a992f51/message/Jerry", true);
    xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2NjU0MzMwfQ.t0AIqQIzxGgIqhPMPUCIFZiiTQE1BpPJEkEe8YsmxSY');
    xmlhttp.send();
}

// process incoming data and create message-elements
function processData(data, length) {
    for(let i = 0; i < length; i++) {
        const timestamp = formatTime(data[i].time);
        createMessageElementinChat(data[i].msg, data[i].from, timestamp);
    }
}

// clear ul list 
function clearList(){
    while (ul.firstChild) {
        ul.removeChild(ul.lastChild);
      }
}

// format ms to hh:mm:ss
function formatTime(time) {
    const fDate = new Date(time);
    let hours = fDate.getHours();
    let minutes = fDate.getMinutes();
    if(Number(minutes) < 10) {
        minutes = "0" + fDate.getMinutes();
    }
    let seconds = fDate.getSeconds();
    if(Number(seconds) < 10) {
        seconds = "0" + fDate.getSeconds();
    }
    return hours + ":" + minutes + ":" + seconds;
}

// bind and send new messages
function sendMessage() {
    // if msgInput is not empty send Message else do nothing
    if (msgInput.value.length !== 0) {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
                console.log("message sending successful");
            } else {
                console.log("message sending failed");
            }
        };
    
        xmlhttp.open("POST", "https://online-lectures-cs.thi.de/chat/b5eb31e8-e269-4c8a-9c86-e99c3a992f51/message", true);
        xmlhttp.setRequestHeader('Content-type', 'application/json');
        // Add token, e. g., from Jerry because we are sending it to Tom
        xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiSmVycnkiLCJpYXQiOjE2MzY2NTQzMzB9.4bbvYgnUfMbmMSyk50LlgVR-2mNPF5db9khiP_SZ5hM');

        //prepare message-package
        let data = {
            // get message value from msg-element declarated at the top of the file
            message: msgInput.value,
            to: "Tom"
        };

        // create a JSON-String
        const jsonString = JSON.stringify(data); 

        // Send JSON-data to server
        xmlhttp.send(jsonString);
    } 
}

//
//  event handling
//
// handling button click event
sendBtn.addEventListener("click", function () {
        sendMessage();
        updateWindow();
        msgInput.value = "";
});
// handling 'enter'-pressed in message input
msgInput.addEventListener("keypress", function(e) {
    if (e.key == 'Enter') {
        sendMessage();
        updateWindow();
        msgInput.value = "";
    }
});

//
//  update window
//
window.setInterval(function() {
    updateWindow();
}, 1000);

function updateWindow(){
    getAndProcessData();
}

updateWindow();


















































