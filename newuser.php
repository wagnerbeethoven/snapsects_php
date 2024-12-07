<?php
session_start();
include "scripts/config.php";

require("scripts/Template.class.php");
include "scripts/send_mail.php";
 
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

if (isset($_POST["language"]))
$tp->lang = str_replace($erros, "", $_POST["language"]);

if (isset($_POST["school"]))
$tp->school = str_replace($erros, "", $_POST["school"]);

$id = $tp->Save();
$prof = isset($_POST["prof"])? $_POST["prof"]:'0';
$text = $dic[313].'<a href="'.$site_url.'snapsect_user_api.php?act=cuser&email='.$tp->email."&id=".$id.'&prof='.$prof.'">'.$dic[314].'</a><br><center>'.$site_url.'snapsect_user_api.php?act=cuser&email='.$tp->email."&id=".$id.'&prof='.$prof.'</center>';
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
 
$tpl = new Template("templates/layout-login.html",false,"templates/partial/newuser.html","SnapSects");
$hoje = getdate();

$ll = getlistofdic();
for ($r=0;$r<count($ll);$r++) {
$tpl->LANGID = $ll[$r]["id"];
$tpl->LANGNAME = $ll[$r]["name"];
if ($ll[$r]["id"] == $_SESSION["language"]) { $tpl->SELECIONADO = 'selected'; } else { $tpl->SELECIONADO = ''; }
$tpl->block('BLOCK_DIC');
} // do for...

$tpl->LANG = $_SESSION["language"];
$tpl->show(0,$_SESSION["language"]);
?>
