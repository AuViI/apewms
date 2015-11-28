<?

?>
<!DOCTYPE html>
<html>
<head>
    <title>Error Handling</title>
</head>
<style type="text/css">
td input{
    box-sizing:border-box;
    width: 100%;
    margin: 0 0;
}
table.one{
    background-color: #D2D2D2;
    border-radius: .3em;
}
</style>
<body>
    <h2>Fehlerbehebung</h2>
    <p>Die meisten Fehlerursachen kann man beheben indem mach sich erneut einloggt. Der Encrypt-Schlüssel kann beim Systemadministrator erfragt werden.</p>
    <table>
        <tr>
            <th>Login mit "normalen" Benutzerdaten</th>
            <th>Login über "encrypted" Schlüssel</th>
        </tr>
        <tr>
            <td><form action="../interface/panel.php" method="post">
                <table class="one">
                    <tr>
                        <td>Benutzer</td>
                        <td><input type="text" name="username" placeholder="Benutzername"></td>
                    </tr>
                    <tr>
                        <td>Passwort</td>
                        <td><input type="password" name="password" placeholder="Passwort"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Einloggen"></td>
                    </tr>
                </table>
            </form></td>

            <td><form action="../login.php" method="GET">
                <table class="one">
                    <tr>
                        <td>Benutzer</td>
                        <td><input type="text" name="username" placeholder="Benutzername"></td>
                    </tr>
                    <tr>
                        <td>Encrypt</td>
                        <td><input type="text" name="encrypt" placeholder="16Char Key"></td>
                    </tr>
                    <tr>
                        <td>FID</td>
                        <td><input type="text" name="fid" placeholder="Target-FID"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Weiterleitung"></td>
                    </tr>
                </table>
            </form></td>
        </tr>
    </table>
</body>
</html>
