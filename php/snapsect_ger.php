<?php
session_start();
if(!isset($_SESSION["language"]) || empty($_SESSION["language"]))
{
    $_SESSION["language"] = 'pt-BR';
}
if (!isset($_SESSION["ssid"])) {
$_SESSION["ssid"] = 0;
$_SESSION["ssnome"] = '';
$_SESSION["ssemail"] = '';
$_SESSION["ssstatus"] = '';
$_SESSION["ssurl"] = '';
} // nao esta logado...

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";

if (isset($_GET["act"])) {
$act = $_GET["act"];

if ($act == 'remover') {
if (isset($_GET["id"])) {
$id = $_GET["id"];
$s = new snapsectClass;
$s->Open($id);
$s->Delete($id);
} // existe id e remove...
} // removendo...
} // existe act
$ee = new snapsectClass;
 
$tpl = new Template("templates/layout.html",false,'templates/partial/snapsect_ger.html','SnapSects');

$res = $ee->Find("select distinct(oorder) from [banco] order by oorder");
while($r=mysqli_fetch_array($res)) {
if (strlen($r["oorder"]) > 0) {
$tpl->CC = $r["oorder"];
$tpl->block('BLOCK_ORDER');
} // nao esta vazio...
} // do while.

$res = $ee->Find("select distinct(other) from [banco] order by other");
while($r=mysqli_fetch_array($res)) {
if (strlen($r["other"]) > 0) {
$tpl->CC = $r["other"];
$tpl->block('BLOCK_OTHER');
} // nao esta vazio.
} // do while.

if (isset($_SESSION["ssid"]) && $_SESSION["ssid"] > 0) {
if (isset($_SESSION["ssstatus"]) && $_SESSION["ssstatus"] == 67) {
$tpl->block('BLOCK_MENU_ARTROPOD_ADM');
$tpl->block('BLOCK_ADM');
} else {
$tpl->block('BLOCK_MENU_ARTROPOD');
$tpl->block('BLOCK_LOGADO');
}
} // está logado.
else {
$tpl->block('BLOCK_DESLOGADO');
} // deslogado

// if (file_exists('class_text/Arthropoda.txt'))
// $tpl->ARTHROPODA = str_replace(chr(13).chr(10),'<br>',file_get_contents('class_text/Arthropoda.txt'));

// if (file_exists('class_text/copyright.txt'))
// $tpl->RODAPE = str_replace('\\','',file_get_contents('class_text/copyright.txt'));

$tpl->show(0,$_SESSION["language"]);
?>