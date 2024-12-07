<?php
session_start();
if(!isset($_SESSION["language"]) || empty($_SESSION["language"]))
{
    $_SESSION["language"] = 'pt-BR';
}

if (!isset($_SESSION["ssid"])) {
session_register("ssid");
session_register("ssnome");
session_register("ssemail");
session_register("ssstatus");
session_register("ssurl");
} // nao esta logado...

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_userclass.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
if (isset($_POST["voltar"]))   
header("location: index.php");
if (isset($_POST["save"])) {
$erros = array("'", chr(34), "<", ">");
 
if (isset($_POST["id"]))
$id = str_replace($erros, "", $_POST["id"]);
$tp = new snapsect_UserClass($id);
$tp->id = $id;
if (isset($_POST["status"]))
$tp->status = str_replace($erros, "", $_POST["status"]);
if (strlen($tp->status) < 1) { $tp->status="0"; }
if (isset($_POST["datacad"]))
$tp->datacad = str_replace($erros, "", $_POST["datacad"]);
if (isset($_POST["nome"]))
$tp->nome = str_replace($erros, "", $_POST["nome"]);
if (isset($_POST["email"]))
$tp->email = str_replace($erros, "", $_POST["email"]);
if (isset($_POST["pws"]))
$tp->pws = str_replace($erros, "", $_POST["pws"]);
if (isset($_POST["url"]))
$tp->url = str_replace($erros, "", $_POST["url"]);
if (isset($_POST["obs"]))
$tp->obs = str_replace($erros, "", $_POST["obs"]);
$tp->Save();
 
?>
<script>
document.location.href='snapsect_user_ger.php';
</script>
<?php
} // salvando...
 
$tpl = new Template("templates/layout.html",false,'templates/partial/add_snapsect_user.html','SnapSects');
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
$ee = new snapsect_UserClass($id);
$tpl->P = @$ee;
$hoje = getdate();

if (file_exists('class_text/copyright.txt'))
$tpl->RODAPE = file_get_contents('class_text/copyright.txt');

$tpl->show(0, $_SESSION["language"]);
?>
