<!DOCTYPE html>
<html>
<?php
    require 'start.php';
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

    // test if session variable user is set
    // if not, back to login!

    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    // is a username specified in query?
    if(!isset($_GET["username"])) {
        // no -> back to friend list!
        header("Location: friends.php");
    } else {
        // yes _> load user according to query parameter
        $lookedAtUser = $service->loadUser($_GET["username"]);
    }
?>
<head>
    <title>Profile</title>
    <meta name="viewport" charset="UTF-8"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" type="text/css" href="../css/linkstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <link rel="stylesheet" type="text/css" href="../css/format.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">
</head>

<body>
    <h2>Profile of <?php echo $lookedAtUser->getUsername() ?></h2>
    <p>
        <a href="chat.php">&lt; Back to Chat</a> | <a href="friends.php" class="dangerLink">Remove Friend</a>
    </p>

    <div class="profile">
        <div class="profilePic">
            <img src="..\images\profile.png" alt="profile.png">
        </div>


        <fieldset class="profileBox">
            <p>
                <?php echo $lookedAtUser->getDescription() ?>
            </p>
            <p>
            <dl>
                <dt>Coffee or Tea?</dt>
                <dd>
                    <?php
                    switch($lookedAtUser->getCoffeeOrTea()) {
                        case "1":
                            echo "Neither nor";
                            break;
                        case "2":
                            echo "Coffee";
                            break;
                        case "3":
                            echo "Tea";
                            break;        
                    }?>
                </dd>
                <dt>Name</dt>
                <dd><?php echo $lookedAtUser->getFirstName() . " " . $lookedAtUser->getLastName()?></dd>
            </dl>
            </p>
        </fieldset>
    </div>

</body>

</html>