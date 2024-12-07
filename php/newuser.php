<?php
session_start();

if(!isset($_SESSION["language"]) || empty($_SESSION["language"]))
{
    $_SESSION["language"] = 'pt-BR';
}

if (!isset($_SESSION["ssid"]) == true) {
$_SESSION["ssid"] = 0;
$_SESSION["ssnome"] = '';
$_SESSION["ssemail"] = '';
$_SESSION["ssstatus"] = 0;
$_SESSION["ssurl"] = '';
}

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/send_mail.php";
include "scripts/snapsect_userclass.php";
include "scripts/diclib.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
if (isset($_POST["save"])) {
$ddic = opendicionario($_SESSION["language"]);
$dic = $ddic["dic"];
$erros = array("'", chr(34), "<", ">");
$tp = new snapsect_UserClass();
if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);
$tp->OpenEmail($email);
if ($tp->id > 0) {
// 310
?>
<script>
alert('<?php echo $dic[310]; ?>');
window.location='<?php echo 'newuser.php'; ?>';
</script>
<?php
}
else {
$tp->email = $email;
$tp->id = 0;
if (isset($_POST["status"]))
$tp->status = str_replace($erros, "", $_POST["status"]);
else $tp->status = 0;

if (isset($_POST["nome"]))
$tp->nome = str_replace($erros, "", $_POST["nome"]);

if (isset($_POST["pws"]))
$tp->pws = str_replace($erros, "", $_POST["pws"]);
if (isset($_POST["pws2"]))
$pws2 = str_replace($erros, "", $_POST["pws2"]);
if ($tp->pws != $pws2) {
// 306
?>
<script>
alert('<?php echo $dic[306]; ?>');
window.location='<?php echo $site_url.'newuser.php'; ?>';
</script>
<?php
} // senhas incorretas...
else {
if (isset($_POST["url"]))
$tp->url = str_replace($erros, "", $_POST["url"]);
if (isset($_POST["obs"]))
$tp->obs = str_replace($erros, "", $_POST["obs"]);
$id = $tp->Save();
$text = $dic[313].'<a href="'.$site_url.'snapsect_user_api.php?act=cuser&email='.$tp->email."&id=".$id.'">'.$dic[314].'</a>';
enviaremail($tp->email,$dic[312],$text, 'SnapSect Administrator', $server_email,$server_email);
//  311
?>
<script>
alert('<?php echo $dic[311]; ?>');
window.location='<?php echo $site_url.'index.php'; ?>';
</script>
<?php 
} // senhas iguais...
} // usuario nao existe...

} // salvando...
 
$tpl = new Template("templates/layout.html",false,'templates/partial/newuser.html','SnapSects');
$hoje = getdate();


$tpl->show(0,$_SESSION["language"]);
?>
