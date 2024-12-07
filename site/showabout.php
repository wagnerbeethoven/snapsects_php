<?php
if (!isset($_SESSION["ssid"])) {
session_start();
$_session["ssid"] = 0;
$_session["ssnome"] = '';
$_session["ssemail"] = '';
$_session["ssstatus"] = '';
$_session["ssurl"] = '';
} // não está logado...

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
 
$erros = array("'", chr(34), "<", ">");
$id = '';
 
 $tpl = new Template("templates/show_about.html");
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
$texto = ''; 
if (strlen($id) > 0) {
if (file_exists('class_text/'.$id.'.txt'))
$texto = file_get_contents('class_text/'.$id.'.txt');
} // len maior que 0
$tpl->ID = $id;
$tpl->TEXTO = $texto;
$tpl->show(0);
?>
