<!DOCTYPE html>
<html>
<?php
    require 'start.php';
?>
<head>
    <title>Friends</title>
    <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" type="text/css" href="../css/linkstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <link rel="stylesheet" type="text/css" href="../css/format.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">

    <script src="..\js\prefix-search.js"></script>
    <script>
        window.chatToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNjM2NjU0MzMwfQ.t0AIqQIzxGgIqhPMPUCIFZiiTQE1BpPJEkEe8YsmxSY";
        window.chatCollectionId = "b5eb31e8-e269-4c8a-9c86-e99c3a992f51";
        window.chatServer = "https://online-lectures-cs.thi.de/chat";
    </script>
</head>

<body onload="loadUsers()">
    <h1>Friends</h1>
    <p>
        <a href="logout.php">&lt; Logout</a> | <a href="settings.php">Settings</a>
    </p>
    <hr>
    <div class="containerBox">
        <ul class="friendsList">
            <li class="friend">
                <p class="friendContainer">
                    <span class="friendName">
                        Tom
                    </span>
                    <span class="newMessages">
                        3
                    </span>
                </p>
            </li>

            <li class="friend">
                <p class="friendContainer">
                    <span class="friendName">
                        Marvin
                    </span>
                    <span class="newMessages">
                        1
                    </span>
                </p>
            </li>

            <li class="friend">
                <p class="friendContainer">
                    <span class="friendName">
                        Tick
                    </span>
                    <span class="newMessages">
                        
                    </span>
                </p>
            </li>

            <li class="friend">
                <p class="friendContainer">
                    <span class="friendName">
                        Trick
                    </span>
                    <span class="newMessages">
                        
                    </span>
                </p>
            </li>
        </ul>
    </div>
    <hr>
    <h2>New Requests</h2>
    <ol>
        <li><a href="chat.php">Friend request from <strong>Track</strong></a></li>
    </ol>
    <hr>
    <form class="singleTextForm">
        <input type="text" id="addFriendFeld" placeholder="Add Friend to List" list="userList" class="formText" autocomplete="off">
        <button type="submit" class="formButton">Add</button>
        <datalist id="userList"></datalist>
    </form>
</body>

</html>