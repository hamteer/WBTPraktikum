<?php
    
    require 'start.php';
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $username = "";
    $password = "";
    $errMsg = "";
    if (isset($_SESSION['user'])) {
        header('location: friends.php');
        exit();
    }
    

    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($service->login($username, $password)) {
            $errMsg = "";
            $_SESSION['user'] = $username;
            header('location: friends.php');
            exit();
        } else {
            $errMsg = "Authentication failed!";
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" charset="UTF-8"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/linkstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <link rel="stylesheet" type="text/css" href="../css/format.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">


</head>

<body>
    <div class="centerBox">
        <img src="..\images\chat.png" alt="chat.png" width='90' height='90'>
    </div>
    <h1>Please sign in</h1>
    <div class="dangerLink centerBox"><?=$errMsg?></div>
    <form action="login.php" method="POST" class="dottedForm logRegBox">
        <fieldset>
            <legend>Login</legend>
            <table>
                <tr>
                    <td>
                        <label for="usernameFeld">Username</label>
                    </td>
                    <td>
                        <input  name="username" 
                                type="text" id="usernameFeld" placeholder="Username"  
                                required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="passwordFeld">Password</label>
                    </td>
                    <td>
                        <input  name="password"
                                type="password" id="passwordFeld" placeholder="Password" 
                                required>
                    </td>
                </tr>
            </table>
        </fieldset>
        <div class="centerBox">
            <button class="formButton">
                <a href="register.php" class="buttonLink">Register</a>
            </button>
            <button class="submitButton" type="submit">Login</button>
        </div>
    </form>

</body>

</html>