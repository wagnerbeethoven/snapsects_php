<?php
session_start();
if (!isset($_SESSION["ssid"]) == true) {
$_SESSION["ssid"] = 0;
$_SESSION["ssnome"] = '';
$_SESSION["ssemail"] = '';
$_SESSION["ssstatus"] = 0;
$_SESSION["ssurl"] = '';
$_SESSION["language"] = 'pt-BR';
}

if ($_SESSION["ssstatus"] == 67) {

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/send_mail.php";
// include "scripts/diclib.php";

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
$ee->Delete($_GET["id"]);
} // tem o id...
} // removendo...
$ddic = opendicionario($_SESSION["language"]);
$dic = $ddic["dic"];
$tpl = new Template("templates/layout.html",false,"templates/partial/snapsect_user_ger.html","SnapSects");
include "scripts/header.php";
$tpl->P = @$ee;
$g = (isset($_GET["find"]))?$_GET["find"]:'all';
if (strlen($g) == 0) $g='all';
$tpl->CHAVE = 'all';
$tpl->BASE = '11';
$ok = 0;
if ($g == 'all') {
$tpl->BB = 'selected';
$ok = 1;
} else $tpl->BB = '';
$tpl->block('BLOCK_FIND');
foreach($lst_type as $k => $c) {
$tpl->CHAVE = $k;
$tpl->BASE = $c;
$tpl->BB = '';
$tpl->BB = (($k == $g) and ($ok == 0))?"selected":'';
$tpl->block('BLOCK_FIND');
} // do for...

$find = ($g == 'all')?' order by nome':' where status='.$g.' order by nome';
$res = $ee->Find("select * from [banco] ".$find);
while ($nv=mysqli_fetch_array($res)) {
$ee->GetRes($nv);
foreach($lst_type as $k => $c) {
$tpl->CHAVE = $k;
$tpl->BASE = $c;
if ($k == $ee->status) $tpl->BB = "selected"; else $tpl->BB = '';
$tpl->block('BLOCK_FIND2');
} // do for...

// $tpl->STATUS = $dic[$lst_type[$ee->status]];
$tpl->block("BLOCK_CAMPOS");
} // do while...


$tpl->show(0,$_SESSION["language"]);
} // adm
else {
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // not adm
?>
