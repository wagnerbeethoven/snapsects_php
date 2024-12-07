<?php
if (!isset($_SESSION["ssid"])) {
session_start();
$_session["ssid"] = 0;
$_session["ssnome"] = '';
$_session["ssemail"] = '';
$_session["ssstatus"] = '';
$_session["ssurl"] = '';
} // não está logado...

if ($_SESSION["ssstatus"] == 67) {

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_userclass.php";
include "scripts/send_mail.php";

$ee = new snapsect_UserClass;

$act = '';
if (isset($_GET["act"]))
$act = $_GET["act"]; 

if ($act == "sendpassword") {
if (isset($_GET["id"])) {
$id = $_GET["id"];
$ee->Open($id);
if ($ee->id > 0) {
enviaremail($ee->email,'SnapSect - Send your password.',$ee->pws, 'SnapSect Administrator', $server_email,$server_email);
} // encontrou
} // existe id
} // enviando password

if ($act == "remover") {
if (isset($_GET["id"])) {
$ee->Open($_GET["id"]);
$ee->Delete($id);
} // tem o id...
} // removendo...
$tpl = new Template("templates/snapsect_user_ger.html");
$tpl->P = @$ee;
$res = $ee->Find("select * from [banco]");
while ($nv=mysqli_fetch_array($res)) {
$ee->GetRes($nv);
$tpl->STATUS = $lst_type[$ee->status];
$tpl->block("BLOCK_CAMPOS");
} // do while...

if (file_exists('class_text/copyright.txt'))
$tpl->RODAPE = file_get_contents('class_text/copyright.txt');

$tpl->show(0);
} // adm
else {
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // not adm
?>
