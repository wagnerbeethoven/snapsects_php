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
include "scripts/snapsect_class.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
 $tpl = new Template("templates/layout.html",false,'templates/partial/snapsect_print.html','SnapSects');
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
if ($id > 0) {
$tp = new snapsectClass($id);
} // existe...
$hoje = getdate();
if (isset($_GET["lang"]))
$_SESSION["language"] = $_GET["lang"];

$tpl->ID = $id;
// $tpl->CODID = $id;
$tpl->TEXTO = file_get_contents($site_url.'snapsect_api.php?act=gettext&id='.$id.'&lang='.$_SESSION["language"].'&uid='.$_SESSION["ssid"].'&ust='.$_SESSION["ssstatus"]);
$tpl->LANG = $_SESSION["language"];
// $tpl->LANGUAGE = $_SESSION["language"];
$tpl->show(0,$_SESSION["language"]);
?>
