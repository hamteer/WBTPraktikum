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

<body  onload="loadPage('<?=$chatPartner?>', '<?=$token?>')">
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
        <button class="formButton" id="sendBtn" onclick="send('<?=$chatPartner?>', '<?=$token?>')">Send</button> <br>
    <!--/form-->
    
    <script type="text/javascript" src="../js/chat.js"></script>

    
</body>
</html>