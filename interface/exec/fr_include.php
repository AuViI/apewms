<?php

// array(array(id, content, src, created))
$fileInfo = getInfoFilesInFolderSQL($_GET["fid"]);
?>
<style type="text/css">
table#filelist td{
    text-align: center;
}
</style>
Hinweis: Aus Securitygründen funktionieren die Links auf fremde Ressources nicht durch einfach "draufklicken". Wenn man sich den Inhalt des Links anschauen will muss man den Text in die Adresszeile manuell kopieren.
<form>
<table id="filelist" border="1">
    <tr>
        <th>ID</th>
        <th>Datei</th>
        <th>Hinzugefügt</th>
        <th>Löschen</th>
    </tr>
    <?php
    foreach ($fileInfo as $num => $info) {
        print("<tr>");
        print("<td>".$info[0]."</td>");
        print("<td><a href=\"../".$info[2]."\">".$info[2]."</a></td>");
        print("<td>".$info[3]."</td>");
        print("<td><a href=\"exec/deletefile.php?fid=$info[0]&back=".$_GET['fid']."&f=".$_GET['folder']."\">Eintrag löschen</a></td>");
        print("</tr>");
    }
     ?>
</table>
</form>
<?php


?>
