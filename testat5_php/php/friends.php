<?php
    require 'start.php';
    
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
        exit();
    }


    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    
    
    // prüfe ob der aktuelle User eine Freundschaftsanfrage gesendet hat
    $errFriendRequest = "";
    if(isset($_POST['addFriend'])) {
        $errFriendRequest = "";
        $newFriend = $service->loadUser($_POST['addFriend']);
        if($service->friendRequest($newFriend)) {
            unset($_POST['addFriend']);
            $errFriendRequest = "";
        } else {
            unset($_POST['addFriend']);
            $errFriendRequest = "Friend request failed!";
        } 
    }

    
    // Accept/Dismiss handling
    $errMsg = "";
    if(isset($_POST['actionRequest'])) {
        // speichert auf [0] den Username und auf [1] die Aktion
        $control = explode(':', $_POST['actionRequest']);

        $action = $control[1];
        $targetUser = $service->loadUser($control[0]);
        if($action === "accept") {
            // accept friend
            $targetUser->setAccepted();
            $service->friendAccept($targetUser);
        } else if ($action ===  "dismiss"){
            // dismiss friend
            $targetUser->setDismissed();
            $service->friendDismiss($targetUser);
        }
    }
    
    // sortiere aus der Friendslist requests in $userRequest und Freunde in $friends
    $userList = $service->loadFriends();
    
    $userRequests = array();
    $friends = array(); 
    foreach($userList as $user) {
        if($user->{'status'} === 'accepted') {
            $friends[] = $user;
        } else if ($user->{'status'} === 'requested') {
            $userRequests[] = $user;
        }
    }


?>
<!DOCTYPE html>
<html>
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
        window.chatToken = "<?=$_SESSION['chat_token']?>";
        window.chatCollectionId = "<?=CHAT_SERVER_ID?>";
        window.chatServer = "<?=CHAT_SERVER_URL?>";
    </script>
</head>

<body>
    <h1>Friends</h1>
    <p>
        <a href="logout.php">&lt; Logout</a> | <a href="settings.php">Settings</a>
    </p>
    <hr>
    <div class="containerBox">
        <ul class="friendsList"  id="chatList">
<?php
    // erstelle die Liste wenn Freunde vorhanden sind
    if(sizeof($friends) != 0) {
        foreach($friends as $friend) {
            if($friend->{'status'} === "accepted") {
?>
                <li class="friend">
                    <!--eventhandler wenn ein chat Partner angeklickt wird-->
                    <p class="friendContainer" onclick="selectChat('<?=$friend->getUsername()?>')">
                        <span class="friendName">
                            <?= $friend->getUsername()?>
                        </span>
                        <span class="newMessages">
                            <?=$service->getUnread($friend->getUsername())?>
                        </span>
                    </p>
                </li>
<?php
            }
        }
    // wenn keine Freunde in $friends vorhanden sind gib folgendes aus
    } else {
?>
                <li class="friend">
<?php
                    echo "You have no friends :'(";
?>
                </li>
<?php
    }
?>
        </ul>
    </div>

<?php
    // wenn Freundschaftsanfragen vorhanden sind gib die Liste aus
    if(sizeof($userRequests) != 0) {
?>
        <hr>
        <h2>New Requests</h2>
        <div><?=$errMsg?></div>
        <form action="friends.php" method="post">
            <ol>
<?php
        foreach($userRequests as $friend) {
            if($friend->{'status'} === 'requested') {
?>
                <li>
                    <p class="requestContainer">
                        <span class="request">
                            Friend request from <strong><?=$friend->getUsername()?></strong>
                        </span>
                        <button name="actionRequest" type="submit" value="<?=$friend->getUsername()?>:dismiss" class="formButton requestBtn">Dismiss</button>
                        <button name="actionRequest" type="submit" value="<?=$friend->getUsername()?>:accept" class="submitButton requestBtn">Accept</button>
                    </p>
                </li>
<?php
            }
        }
?>
            </ol>
        </form>
<?php        
    }
?>

    <hr>
    <div class="dangerLink"><?=$errFriendRequest?></div>
    <form action="friends.php" method="POST" class="singleTextForm">
        <input  name="addFriend" type="text" id="addFriendFeld" placeholder="Add Friend to List" 
                list="userList" class="formText" autocomplete="off">
        <button name="action" type="submit" class="submitButton">Add</button>
        <datalist id="userList"></datalist>
    </form>

    <script>
        function selectChat(username) {
            const li = document.getElementById("chatList");
            const form = document.createElement("form");
            form.setAttribute("action", "chat.php");
            form.setAttribute("method", "get");
            const input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("value", username);
            input.setAttribute("name", "chatpartner");
            form.appendChild(input);
            li.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>
