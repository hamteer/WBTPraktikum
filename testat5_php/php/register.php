<!DOCTYPE html>
<html>
<?php
    require 'start.php';
    $service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $warning = "";
    $globalUsername = "";

    //var_dump($_POST);
 

    if(validInput()) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        if($service->register($username, $password)) {
            $_SESSION['user'] = $username;
            header("Location: friends.php");
            //echo "hat geklappt";
            exit();
        } else {
            $error = "register failed";
        }
    }

    function validInput() {
        //username
        global $service;
        global $warning;
        global $globalUsername;

        if(isset($_POST["username"])) {
            if(!empty($_POST["username"])) {
                $username = $_POST["username"];
                $globalUsername = $username;
                //echo $username;
                if (strlen($username) > 2 ) {
                   //echo "valid username";
                } else { 
                    echo "Username less than 3 character";
                    $warning = "Username less than 3 character";
                    return false;
                }
                if (!($service->userExists($username))) {
                    //echo "exestiert nicht";
                } else {
                    //echo "User exists";
                    $warning = "User exists";
                    return false;
                }         
                //echo  $username;
                //echo "<br>";
            } else {
                //echo "Username ist leer";
                $warning = "Username ist leer";
                return false;
            }
        }else {
            //echo "kein usernamen übergeben";
            $warning = "no Username passed";
        }

        //password
        if(isset($_POST["password"]) && isset($_POST["confirmPassword"])) {
            if(!empty($_POST["password"])) {
                $password = $_POST["password"];
                $confirmPassword = $_POST["confirmPassword"];
                if (strlen($password)>7) {
                    //echo "valid Password <br>";
                } else {
                    //echo "invalid Password";
                    $warning = "Password too short";
                    return false;
                }
                if ($password == $confirmPassword) {
                    //echo "Passwörter stimmen überein";
                } else {
                    //echo "Passwörter stimmen nicht überein";
                    $warning = "password not equal";
                    return false;
                }
                //echo "<br>";
                //echo $password;
            } else {
                return false;
            }
        } else {
            //echo "kein oder nicht beide passwörter übergeben";
            return false;
        }


        return true;

    }



?>
<head>
    <title>Register</title>
    <meta name="viewport" charset="UTF-8"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link rel="stylesheet" type="text/css" href="../css/linkstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/format.css">
    <link rel="stylesheet" href="../css/responsive.css">

    
</head>

<body>
    <div class="centerBox">
        <img src="../images/user.png" alt="logo" width="85" height="85">
    </div>
    <h1>Register yourself</h1>
    <form method="post" action="register.php" class="logRegBox">
        <fieldset>
            <legend>Register</legend>
            <table>
                <tr>
                    <td>
                        <label for="username">Username</label>
                    </td>
                    <td>
                        <input id="username" type="text" name="username" placeholder="Username" required value="<?= $globalUsername; ?>">
                        
                        
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <label for="password">Password</label>
                    </td>
                    <td>
                        <input id="password" type="password" name="password" placeholder="Password" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="confirmPassword">Confirm Password</label>
                    </td>
                    <td>
                        <input id="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm Password" required>
                    </td>
                </tr>
                <tr>
                <td colspan="2">
                        <div>
                            <?php
                                echo '<span style="color:red;text-align:center;">'. $warning. ' </span>';
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
        <div class="centerBox">
            <button class="formButton" type="reset" value="cancel"><a href="login.php" class="buttonLink">Cancel</a></button>
            <button class="submitButton" type="submit" name="action" value="create">Create Account</button>
        </div>
    </form>
    
    
    <!--script src="../js/registerCheck.js"></script-->
</body>

</html>