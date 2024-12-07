<?php
session_start();
include "scripts/config.php";

if ($users->verifylogin() == true) {
$users->logout();
// header('location:index.php');
?>
<script>
window.location='index.php';
</script>
<?php
} // logout...
else {
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
include "scripts/send_mail.php";
// include "scripts/diclib.php";

$ddic = opendicionario($_SESSION["language"]);
$dic = $ddic["dic"];

$site = 'login.html'; 
$erros = array("'", chr(34), "<", ">");
$id = 0;

if (isset($_POST["cmdlogin"])) {

$tp = new snapsect_UserClass();
if ($tp->login() == true) {

// 282
?>
<script>
alert('<?php echo $dic[282]; ?>...');
window.location='<?php echo $site_url.'index.php'; ?>';
</script>
<?php

} else {
// 283
?>
<script>
alert('<?php echo $dic[283]; ?>...');
window.location='<?php echo $site_url.'login.php'; ?>';
</script>
<?php
} // nao logou...
} // do login.

if (isset($_POST["cmdadduser"])) {
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
window.location='<?php echo 'login.php'; ?>';
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
window.location='<?php echo $site_url.'login.php'; ?>';
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
} // adicionando novo usuario...

if (isset($_POST["cmdforget"])) {

if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);

if (strlen($email) < 5) {
//  280
?>
<script>
alert('<?php echo $dic[280]; ?>');
window.location='login.php';
</script>
<?php
} else {
$tp = new snapsect_UserClass();
$tp->OpenEmail($email);
if ($tp->id < 1) {
// 302
?>
<script>
alert('<?php echo $dic[302]; ?>');
window.location='login.php';
</script>
<?php
} // usuario nao encontrado
else {
enviaremail($email,$dic[304],$dic[305].': '.$tp->pws, 'SnapSect Administrator', $server_email,$server_email);
?>
<script>
alert('<?php echo $dic[303]; ?>');
window.location='login.php';
</script>
<?php
} // encontrou o usuario, envia email...
} // email nao vazio...
} // enviando senha por email...

 $tpl = new Template("templates/layout-login.html",false,"templates/partial/login.html","SnapSects");
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
$hoje = getdate();
$tpl->LANG = $_SESSION["language"];

$tpl->show(0,$_SESSION["language"]);
}
?>
