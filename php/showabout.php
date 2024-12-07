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
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
if (isset($_GET["id"]))
$id = (int)str_replace($erros, "", $_GET["id"]);

if(($id > 239 && $id < 243) || $id == 338 )
{
$file = '';
$title = 'SnapSect - [dic'.$id.']';
switch ($id) {
    case 240:
        $file = 'about-'.$_SESSION["language"].'.txt';
    break;
    case 241:
        $file = 'FAQ-'.$_SESSION["language"].'.txt';
    break;
    case 242:
        $file = 'Disclaimer-'.$_SESSION["language"].'.txt';
    break;
    case 338:
        $file = 'copyright-'.$_SESSION["language"].'.txt';
    break;
}

$tpl = new Template('templates/layout.html',false,'templates/partial/showabout.html',$title);
$texto = ''; 
if (!empty($file) && file_exists('class_text/'.$file))
$texto = file_get_contents('class_text/'.$file);

if ($_SESSION["ssstatus"] == 67) {
$tpl->block('BLOCK_ADM');
}
elseif($_SESSION['ssstatus'] == 1)
{
   $tpl->block('BLOCK_LOGADO');
}
else
{
   $tpl->block('BLOCK_DESLOGADO'); 
}

$tpl->ID = $id;
$tpl->TEXTO = $texto;
$tpl->show(0, $_SESSION["language"]);
}
else
{
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php } ?>
