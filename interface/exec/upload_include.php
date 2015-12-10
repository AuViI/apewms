<?

?>
<style type="text/css">
    td.contain{
        min-width: 1.4em;
    }
</style>
<form enctype="multipart/form-data" action="./exec/upload_media.php" method="POST">
    <table>
        <tr>
            <td>Remote oder Upload</td>
            <td><table>
                <tr>
                    <td class="contain"><input type="radio" name="remote" value="remote" onclick="javascript:selremote()"></td>
                    <td>Remote</td>
                </tr>
                <tr>
                    <td class="contain"><input type="radio" name="remote" value="upload" onclick="javascript:selupload()"></td>
                    <td>Upload</td>
                </tr>
            </table></td>
        </tr>
        <tr>
            <td>Url Eingabe</td>
            <td><input type="text" name="url" id="remotelink" onkeyup="javascript:datein()" disabled></td>
        </tr>
        <tr>
            <td>Datei Upload</td>
            <td><input type="file" name="userfile" id="fileupload" onchange="javascript:datein()" disabled ></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Hinzufügen" name="submitbtn" id="submitbtn"></td>
        </tr>
    </table>
    <input type="hidden" name="fid" value="<?echo $_GET["fid"];?>">
    <input type="hidden" name="folder" value="<?echo substr($_GET["folder"],0,strpos($_GET["folder"]," "));?>">
</form>
<script type="text/javascript">
    var fileupload = document.getElementById("fileupload");
    var remotelink = document.getElementById("remotelink");
    var submitbtn = document.getElementById("submitbtn");
    function selremote(){
        remotelink.disabled=false;
        fileupload.disabled=true;
    }
    function selupload(){
        remotelink.disabled=true;
        fileupload.disabled=false;
    }
    function datein(){
        submitbtn.disabled=false;
    }
    submitbtn.disabled=true;
</script >
<?

?>
