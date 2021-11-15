const collectionId = "b5eb31e8-e269-4c8a-9c86-e99c3a992f51";
var users = [];

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        let data = JSON.parse(xmlhttp.responseText);
        users = data;
    }
};
xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/b5eb31e8-e269-4c8a-9c86-e99c3a992f51/user", true);
xmlhttp.setRequestHeader('Authorization', 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2NjU0MzMwfQ.t0AIqQIzxGgIqhPMPUCIFZiiTQE1BpPJEkEe8YsmxSY');
xmlhttp.send();

const usernameIn = document.getElementById("username");
const passwordIn = document.getElementById("password");
const conPasswordIn = document.getElementById("confirmPassword");


usernameIn.addEventListener("keyup", function() {
    if (usernameIn.value.length === 0){
        usernameIn.classList.remove("inputIncorrect");
        usernameIn.classList.remove("inputCorrect");
    } else if(usernameIn.value.length < 3) {
        usernameIn.classList.add("inputIncorrect");
    } else {
        for(let user of users) {
            if(user === usernameIn.value) {
                usernameIn.classList.add("inputIncorrect");
                break;
            } else {
                usernameIn.classList.remove("inputIncorrect");
                usernameIn.classList.add("inputCorrect");
            }
        }
    }
});

passwordIn.addEventListener("keyup", function() {
    checkPW();
    checkCPW();
});

conPasswordIn.addEventListener("keyup", function() {
    checkCPW();
});

function checkPW() {
    if (passwordIn.value.length === 0){
        passwordIn.classList.remove("inputIncorrect");
        passwordIn.classList.remove("inputCorrect");
    } else if(passwordIn.value.length < 8) {
        passwordIn.classList.add("inputIncorrect");
    } else {
        passwordIn.classList.remove("inputIncorrect");
        passwordIn.classList.add("inputCorrect");
    }
}

function checkCPW() {
    if (passwordIn.value === conPasswordIn.value && conPasswordIn.value.length !== 0){
        conPasswordIn.classList.remove("inputIncorrect");
        conPasswordIn.classList.add("inputCorrect");
    } else if(passwordIn.value.length === 0 && conPasswordIn.value.length === 0) {
        conPasswordIn.classList.remove("inputIncorrect");
        conPasswordIn.classList.remove("inputCorrect");
    } else {
        conPasswordIn.classList.remove("inputCorrect");
        conPasswordIn.classList.add("inputIncorrect");
    }
}