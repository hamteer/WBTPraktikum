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

    // Load current user:
    $currentUser = $service->loadUser($_SESSION["user"]);

    // process form inputs:
    if(isset($_POST["firstName"])) { $currentUser->setFirstName($_POST["firstName"]); }

    if(isset($_POST["lastName"])) { $currentUser->setLastName($_POST["lastName"]); }

    if(isset($_POST["coffeeOrTea"])) { $currentUser->setCoffeeOrTea($_POST["coffeeOrTea"]); }

    if(isset($_POST["description"])) { $currentUser->setDescription($_POST["description"]); }

    if(isset($_POST["layout"])) { $currentUser->setLayout($_POST["layout"]); }

    // save user
    $service->saveUser($currentUser);
?>

<head>
    <title>Settings</title>
    <meta name="viewport" charset="UTF-8"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" type="text/css" href="../css/linkstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <link rel="stylesheet" type="text/css" href="../css/format.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">
</head>

<body>
    <h1>Profile Settings</h1>
    <form action="settings.php" method="POST">
        <fieldset>
            <legend>Base Data</legend>
            <table>
                <tr>
                    <td>
                        <label for="firstName">First Name</label>
                    </td>
                    <td>
                        <input name="firstName" id="firstName" type="text" value="<?= $currentUser->getFirstName(); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="lastName">Last Name</label>
                    </td>
                    <td>
                        <input name="lastName" id="lastName" type="text" value="<?= $currentUser->getLastName(); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="coffeOrTea">Coffee or Tea?</label>
                    </td>
                    <td>
                        <select name="coffeeOrTea" id="drink">
                            <option value="1" <?php if ($currentUser->getCoffeeOrTea() == '1') echo ' selected="selected"'; ?>>Neither nor</option>
                            <option value="2" <?php if ($currentUser->getCoffeeOrTea() == '2') echo ' selected="selected"'; ?>>Coffee</option>
                            <option value="3" <?php if ($currentUser->getCoffeeOrTea() == '3') echo ' selected="selected"'; ?>>Tea</option>
                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend>Tell Something About You</legend>
            <textarea name="description" id="Comment" rows="10"><?= $currentUser->getDescription(); ?></textarea>
        </fieldset>
        <fieldset name="layout">
            <legend>Preferred Chat Layout</legend>
            <p>
                <input type="radio" id="1" name="layout" value="1" <?php if ($currentUser->getLayout() == '1') echo ' checked '; ?>> 
                    <label for="1">Username and message in one line</label>
            </p>
            <p>
                <input type="radio" id="2" name="layout" value="2" <?php if ($currentUser->getLayout() == '2') echo ' checked '; ?>> 
                    <label for="2">Username and message in separated line</label>
            </p>
        </fieldset>
        <button class="formButton" type="reset"><a href="friends.php" class="buttonLink">Cancel</a></button>
        <button class="submitButton" type="submit">Save</button>
    </form>
</body>

</html>