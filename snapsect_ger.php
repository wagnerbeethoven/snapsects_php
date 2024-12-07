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

if (isset($_GET["act"])) {
$act = $_GET["act"];

if ($act == 'remover') {
if (isset($_GET["id"])) {
$id = $_GET["id"];
$lang = $_SESSION["language"];
if (isset($_GET["lang"]))
$lang = $_GET["lang"];
if (strlen($lang) > 0) {
$_SESSION["language"] = $lang;
$s = new snapsectClass($id,$lang);
$s->Open($id);
$s->Delete($id);
} // existe lang...
} // existe id e remove...
} // removendo...
} // existe act
$ee = new snapsectClass(0,$_SESSION["language"]);
 
$tpl = new Template("templates/layout.html",false,'templates/partial/snapsect_ger.html','SnapSects');
include "scripts/header.php";
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

if ($_SESSION["ssstatus"] > 0) {
$tpl->block('BLOCK_ADD');
} // está logado.

 if (isset($_GET["lang"]))
$_SESSION["language"] = $_GET["lang"];

$ll = getlistofdic();
for ($r=0;$r<count($ll);$r++) {
$tpl->LANGID = $ll[$r]["id"];
$tpl->LANGNAME = $ll[$r]["name"];
if ($ll[$r]["id"] == $_SESSION["language"]) { $tpl->SELECIONADO = 'selected'; } else { $tpl->SELECIONADO = ''; }
$tpl->block('BLOCK_DIC');
$tpl->block('BLOCK_DIC2');
} // do for...
$tpl->LANG = $_SESSION["language"];

$tpl->show(0,$_SESSION["language"]);
?>
