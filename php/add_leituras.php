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
include "scripts/diclib.php";
include "scripts/school_func.php";
 
$erros = array("'", chr(34), "<", ">");
$id = '';
 $tpl = new Template("templates/layout.html",false,'templates/partial/add_leituras.html','SnapSects');
$email = '';
if (isset($_GET["email"]))
$email = str_replace($erros, "", $_GET["email"]);

$sala = '';
if (isset($_GET["sala"]))
$sala = str_replace($erros,'',$_GET["sala"]);

$id = '';
if (isset($_GET["id"]))
$id = str_replace($erros,'',$_GET["id"]);

$tpl->EMAIL = $email;
$tpl->SALA = $sala;
$tpl->ID = $id;
$tpl->TEXTO = getleitura($email, str_replace(' ','_',$sala), $id);
$tpl->show(0, $_SESSION["language"]);
?>
