<?php
session_start();
if(!isset($_SESSION["language"]) || empty($_SESSION["language"]))
{
    $_SESSION["language"] = 'pt-BR';
}
if (!isset($_SESSION["ssid"])) {
$_session["ssid"] = 0;
$_session["ssnome"] = '';
$_session["ssemail"] = '';
$_session["ssstatus"] = '';
$_session["ssurl"] = '';
} // nao esta logado...

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
$tpl = new Template("templates/layout.html",false,'templates/partial/show_snapsect.html','SnapSects');
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
$logado = false;
if ($id > 0) {
$tp = new snapsectClass($id);
$logado = ($_SESSION["ssid"] == $tp->userid) || (strpos(' '.$tp->ground,'|'.$_SESSION["ssid"].'|') > 0) || ($_SESSION["ssstatus"] == 67) || ($tp->userid == 0);
} // existe...
$hoje = getdate();
$tpl->ID = $id;
$tpl->CODID = $id;
$tpl->TEXTO = file_get_contents($site_url.'snapsect_api.php?act=gettext&id='.$id);

if ($logado) {
$tpl->block("BLOCK_EDIT");
} // logado
else {
$tpl->block("BLOCK_NOEDIT");
} // not user...

if (file_exists('class_text/copyright.txt'))
$tpl->RODAPE = str_replace('\\','',file_get_contents('class_text/copyright.txt'));

$tpl->show(0, $_SESSION["language"]);
?>
