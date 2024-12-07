<?php
require_once("scripts/Template.class.php");

session_start();

if(isset($_GET['lang']))
{
    $langs = array('it-it', 'fr-fr','en-us','es-es','pt-br');
    if(in_array($_GET['lang'], $langs))
    {
        $_SESSION["language"] = $_GET['lang'];
    }
}

//header("location: ./snapsect_ger.php"); 
$tpl = new Template("templates/layout.html",false,'templates/partial/index.html','SnapSects');

if (isset($_SESSION["ssid"]) && $_SESSION["ssid"] > 0) {
if (isset($_SESSION["ssstatus"]) && $_SESSION["ssstatus"] == 67) {
$tpl->block('BLOCK_ADM');
} else {
$tpl->block('BLOCK_LOGADO');
}
} // está logado.
else {
$tpl->block('BLOCK_DESLOGADO');
} // deslogado

$tpl->show(0,$_SESSION["language"]);