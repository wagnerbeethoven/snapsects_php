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

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
// include "scripts/diclib.php";
 
$erros = array("'", chr(34), "<", ">");
$id = '';
 
 $tpl = new Template("templates/layout.html",false,"templates/partial/show_about.html","SnapSects");

include "scripts/header.php";

if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);

$ddic = opendicionario($_SESSION["language"]);
$dic = $ddic["dic"];

$texto = $dic[$id];
$tpl->TEXTO = $texto;
$tpl->show(0,$_SESSION["language"]);
?>
