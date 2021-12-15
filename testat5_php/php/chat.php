<!DOCTYPE html>
<html>
<?php
    require 'start.php';
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    //require '../js/chat.php';
    
    $chatPartner = "";
    $url = CHAT_SERVER_URL;
    $id = CHAT_SERVER_ID;
    $token = $_SESSION['chat_token'];


    if(!(isset($_SESSION['user']))) {
        header("Location: login.php");
        exit();
    }

    
    if(isset($_GET['chatpartner'])) {
        $chatPartner = $_GET['chatpartner'];
        //echo $chatPartner;
    } else {
        //echo "Load username failed";
        header("Location: friends.php");
        exit();
    }

?>
<head>
    <title>Chat</title>
    <meta name="viewport" charset="UTF-8"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" type="text/css" href="../css/linkstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/format.css">
    <link rel="stylesheet" href="../css/responsive.css">

</head>

<body>
    <h1>Chat with <?php echo $chatPartner; ?></h1>
    <a href="friends.php"> &lt; Back </a> |
    <span type="submit" onclick="goProfile('<?=$chatPartner?>')"><a> Profile</a></span> |
    <span type="submit" onclick="removeFriend('<?=$chatPartner?>')"><a class="dangerLink"> Remove Friend</a></span>

    <!--Nachrichten-->
    <hr>
    <fieldset class="containerBox chatContainer">
        <ul class="chat" id="chatList">
        </ul>
    </fieldset>
    <hr>
    <!--form class="singleTextForm"-->
        <input type="text" placeholder="New Message" class="formText" id="inputMsg">
        <button class="formButton" id="sendBtn">Send</button> <br>
    <!--/form-->
    <!--script type="text/javascript" src="../js/chat.js"></script-->


    <script>
        const sendBtn = document.getElementById("sendBtn");
        // get ul element for append
        const ul = document.getElementById("chatList");
        // get message from text input
        const msgInput = document.getElementById("inputMsg");


        //Remove Friend
        function removeFriend(chatpartner) {
            const li = document.getElementById("chatList");
            const form = document.createElement("form");
            form.setAttribute("action", "friends.php");
            form.setAttribute("method", "get");
            const input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("value", chatpartner);
            input.setAttribute("name", "removeFriend");
            form.appendChild(input);
            li.appendChild(form);
            form.submit();
        }

        function goProfile(chatpartner) {
            const li = document.getElementById("chatList");
            const form = document.createElement("form");
            form.setAttribute("action", "profile.php");
            form.setAttribute("method", "get");
            const input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("value", chatpartner);
            input.setAttribute("name", "username");
            form.appendChild(input);
            li.appendChild(form);
            form.submit();
        }


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
            let xmlhttp = new XMLHttpRequest();
            // get data
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    let data = JSON.parse(xmlhttp.responseText);
                    console.log(data);
                    let length = data.length;
                    clearList();
                    processData(data, length);
                }
            }
            xmlhttp.open("GET", "https://online-lectures-cs.thi.de/chat/56ce2af0-ee84-4e78-85bc-6bba6c51c739/message/" + "<?php echo $_SESSION['user']; ?>", true);
            xmlhttp.setRequestHeader('Authorization', 'Bearer ' + '<?php echo $token; ?>');
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
            
                xmlhttp.open("POST", "https://online-lectures-cs.thi.de/chat/56ce2af0-ee84-4e78-85bc-6bba6c51c739/message", true);
                xmlhttp.setRequestHeader('Content-type', 'application/json');
                // Add token, e. g., from Jerry because we are sending it to Tom
                xmlhttp.setRequestHeader('Authorization', 'Bearer ' + '<?php echo $token; ?>');

                //prepare message-package
                let data = {
                    // get message value from msg-element declarated at the top of the file
                    message: msgInput.value,
                    to: "'<?php echo $chatPartner; ?>'"
                };

                // create a JSON-String
                const jsonString = JSON.stringify(data); 

                console.log(jsonString);

                // Send JSON-data to server
                xmlhttp.send(jsonString);
            } 
        }

            //
            //  event handling
            //
            // handling button click event
            sendBtn.addEventListener("click", function () {
                
            //Test ob php konstante in js verarbeitet werden kann
            /*
            var newDiv = document.createElement("div");
            var test = document.createElement("label");
            test.innerText = "<!--?php echo $test; ?-->";
            var newContent = document.createTextNode("Hi there and greetings!");
            newDiv.appendChild(newContent); // füge den Textknoten zum neu erstellten div hinzu.
            newDiv.appendChild(test);

            // füge das neu erstellte Element und seinen Inhalt ins DOM ein
            var currentDiv = document.getElementById("div1");
            document.body.insertBefore(newDiv, currentDiv);
            */


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
        window.setInterval(updateWindow, 1000);

        function updateWindow(){
            getAndProcessData();
        }

        updateWindow();
    </script>
</body>

</html>