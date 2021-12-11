<!DOCTYPE html>
<html>
<?php
    require 'start.php';
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
    <h2>Profile of Tom</h2>
    <p>
        <a href="chat.php">&lt; Back to Chat</a> | <a href="friends.php" class="dangerLink">Remove Friend</a>
    </p>

    <div class="profile">
        <div class="profilePic">
            <img src="..\images\profile.png" alt="profile.png">
        </div>


        <fieldset class="profileBox">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                officia deserunt mollit anim id est laborum.
            </p>
            <p>
            <dl>
                <dt>Coffee or Tea?</dt>
                <dd>Tea</dd>
                <dt>Name</dt>
                <dd>Thomas</dd>
            </dl>
            </p>
        </fieldset>
    </div>

</body>

</html>