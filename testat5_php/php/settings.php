<!DOCTYPE html>
<html>
<?php
    require 'start.php';
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
    <form>
        <fieldset>
            <legend>Base Data</legend>
            <table>
                <tr>
                    <td>
                        <label for="firstName">First Name</label>
                    </td>
                    <td>
                        <input id="firstName" type="text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="lastName">Last Name</label>
                    </td>
                    <td>
                        <input id="lastName" type="text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="coffeOrTea">Coffee or Tea?</label>
                    </td>
                    <td>
                        <select name="drink" id="drink">
                            <option value="Neither nor">Neither nor</option>
                            <option value="Coffee">Coffee</option>
                            <option value="Tea">Tea</option>
                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend>Tell Something About You</legend>
            <textarea name="Comment" id="Comment" rows="10" placeholder="Leave a comment here"></textarea>
        </fieldset>
        <fieldset>
            <legend>Preferred Chat Layout</legend>
            <p>
                <input type="radio" id="oneline" name="username" value="oneliner"> <label for="oneline">Username and
                    message in one line</label>
            </p>
            <p>
                <input type="radio" id="separated" name="username" value="separated"> <label for="separated">Username
                    and message in separated line</label>
            </p>
        </fieldset>
        <button class="formButton" type="reset"><a href="friends.php" class="buttonLink">Cancel</a></button>
        <button class="submitButton" type="submit"><a href="settings.php" class="buttonLink">Save</a></button>
    </form>
</body>

</html>