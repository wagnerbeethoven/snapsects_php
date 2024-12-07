<?php
if (!isset($_SESSION["ssid"])) {
session_start();
$_session["ssid"] = 0;
$_session["ssnome"] = '';
$_session["ssemail"] = '';
$_session["ssstatus"] = '';
$_session["ssurl"] = '';
} // não está logado...

if ($_SESSION["ssid"] > 0) {
$_SESSION["ssid"] = 0;
$_SESSION["ssnome"] = '';
$_SESSION["ssemail"] = '';
$_SESSION["ssstatus"] = 0;
$_SESSION["ssurl"] = '';
?>
<script>
window.location='<?php echo $site_url.'http://www.snapsects.com/snapsect_ger.php'; ?>';
</script>
<?php
} // logout...
include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
include "scripts/snapsect_userclass.php";
include "scripts/send_mail.php";
$site = 'login.html'; 
$erros = array("'", chr(34), "<", ">");
$id = 0;

if (isset($_POST["cmdlogin"])) {

if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);

if (isset($_POST["pws"]))
$pws = str_replace($erros, "", $_POST["pws"]);

$tp = new snapsect_UserClass();
$ok = 0;
$res = $tp->Find('select * from [banco] where email="'.$email.'" and pws="'.$pws.'" and status > 0;');
while($r=mysqli_fetch_array($res)) {
$tp->GetRes($r);
$_SESSION["ssid"] = $tp->id;
$_SESSION["ssnome"] = $tp->nome;
$_SESSION["ssemail"] = $tp->email;
$_SESSION["ssstatus"] = $tp->status;
$_SESSION["ssurl"] = $tp->url;
$ok = 1;
} // do while.

if ($ok == 1) {
if ($_SESSION["ssstatus"] == 67) {
?>
<script>
alert('Wellcome...');
window.location='<?php echo $site_url.'index_adm.php'; ?>';
</script>
<?php

} else {
?>
<script>
alert('Wellcome...');
window.location='<?php echo 'snapsect_ger.php'; ?>';
</script>
<?php
} // usuario
} else {
?>
<script>
alert('Desculpa, mas o login ou senha estao errados...');
window.location='<?php echo $site_url.'login.php'; ?>';
</script>
<?php
} // nao logou...
} // do login.

if (isset($_POST["cmdnewuser"])) {
$site = 'newuser.html';
} // novo usuário 

if (isset($_POST["cmdadduser"])) {
$erros = array("'", chr(34), "<", ">");
 
$tp = new snapsect_UserClass();
if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);
$tp->OpenEmail($email);
if ($tp->id > 0) {
?>
<script>
alert('Usuário já existe, utilize outro endereço de e-mail ou solicite sua senha...');
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
?>
<script>
alert('Please, but yours passwords is error. Try again...');
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
$text = 'Please, click this link <a href="'.$site_url.'snapsect_user_api.php?act=cuser&email='.$tp->email."&id=".$id.'">Confirm e-mail</a>';
enviaremail($tp->email,'SnapSect - Confirm e-mail. - no reply',$text, 'SnapSect Administrator', $server_email,$server_email);
?>
<script>
alert('foi enviado um e-mail de confirmação para o seu endereço de e-mail, por favor clique no link para ativar seu login...');
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php 
} // senhas iguais...
} // usuario nao existe...
} // adicionando novo usuario...

if (isset($_POST["cmdforget"])) {

if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);

if (strlen($email) < 5) {
?>
<script>
alert('Write your email!');
window.location='login.php';
</script>
<?php
} else {
$tp = new snapsect_UserClass();
$tp->OpenEmail($email);
if ($tp->id < 1) {
?>
<script>
alert('User not found...');
window.location='login.php';
</script>
<?php
} // usuario nao encontrado
else {
enviaremail($email,'SnapSect - Send your login. - no reply','Your Password:<br>'.$tp->pws, 'SnapSect Administrator', $server_email,$server_email);
} // encontrou o usuario, envia email...
} // email nao vazio...
} // enviando senha por email...

 $tpl = new Template("templates/".$site);
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
$hoje = getdate();

if (file_exists('class_text/copyright.txt'))
$tpl->RODAPE = file_get_contents('class_text/copyright.txt');

$tpl->show(0);
?>
