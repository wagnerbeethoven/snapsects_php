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
 
 $tpl = new Template('templates/layout.html',false,'templates/partial/school.html','SnapSects');
$email = $_SESSION["ssemail"];
// if (isset($_GET["email"]))
// $email = str_replace($erros, "", $_GET["email"]);


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


$tpl->EMAIL = $email;
$tpl->TITULO = getnic($email);
$l = getsalas($email);
for ($r=0;$r<count($l);$r++) {
$tpl->SALA = $l[$r];
$tpl->block('BLOCK_SALAS');
} // do for...
$tpl->show(0, $_SESSION["language"]);
?>
