<!DOCTYPE html>
<html>

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
    <h1>Chat with Tom</h1>
    <a href="friends.php"> &lt; Back </a> |
    <a href="profile.php"> Profile </a>|
    <a href="friends.php" class="dangerLink"> Remove Friend </a>

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
    <script type="text/javascript" src="../js/chat.js"></script>
</body>

</html>
