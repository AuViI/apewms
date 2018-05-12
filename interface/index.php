<?php
include("./exec/pulllib.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>WMS-Interface</title>
    <?php echo file_get_contents("./html/head.html"); ?>
</head>
<body>
    <div id="holder">
        <div id="menu"><br><br>Zum Bearbeiten einloggen<br><br><br><br><br></div>
        <div id="page"><h2>WMS-Login</h2><form method="post" action="panel.php"><table>
            <tr>
                <td>Benutzer</td>
                <td><input type="text" placeholder="Benutzername" name="username"></td>
            </tr>
            <tr>
                <td>Passwort</td>
                <td><input type="password" placeholder="Passwort" name="password"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Absenden"></td>
            </tr>
        </table></form></div>
    </div>
</body>
</html>
