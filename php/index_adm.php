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
} // não está logado...

if ($_SESSION["ssstatus"] == 67) {
include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
 $tpl = new Template('templates/layout.html',false,'templates/partial/index_adm.html','SnapSect - Administrator');
 $tpl->block('BLOCK_ADM');
 
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
$hoje = getdate();
/*
if (file_exists('class_text/copyright.txt'))
$tpl->RODAPE = file_get_contents('class_text/copyright.txt');
*/
$tpl->show(0, $_SESSION["language"]);
} // adm
else {
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // not adm
?>
