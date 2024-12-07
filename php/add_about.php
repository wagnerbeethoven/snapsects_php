<?php
session_start();
include "scripts/config.php";

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

if (isset($_SESSION["ssstatus"]) && $_SESSION["ssstatus"] == 67) {
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";

 $erros = array("'", chr(34));

$lang = $_SESSION["language"];

if(isset($_REQUEST['lang']))
{
    $lang = $_REQUEST['lang'];
}
 
if (isset($_POST["act"])) {

if (isset($_POST['t0']))
file_put_contents('class_text/about-'.$lang.'.txt',str_replace('\\','',$_POST["t0"]));

if (isset($_POST['t1']))
file_put_contents('class_text/copyright-'.$lang.'.txt',str_replace('\\','',$_POST["t1"]));

if (isset($_POST['t2']))
file_put_contents('class_text/Disclaimer-'.$lang.'.txt',str_replace('\\','',$_POST["t2"]));

if (isset($_POST['t3']))
file_put_contents('class_text/FAQ-'.$lang.'.txt',str_replace('\\','',$_POST["t3"]));

?>
 <script>
 window.location='snapsect_ger.php';
 </script>
<?php
} // salvando...

 $tpl = new Template('templates/layout.html',false,'templates/partial/add_about.html','SnapSects');
$hoje = getdate();

if (file_exists('class_text/about-'.$lang.'.txt'))
$tpl->T0 = str_replace('\\','',file_get_contents('class_text/about-'.$lang.'.txt'));

if (file_exists('class_text/copyright-'.$lang.'.txt'))
$tpl->T1 = str_replace('\\','',file_get_contents('class_text/copyright-'.$lang.'.txt'));

if (file_exists('class_text/Disclaimer-'.$lang.'.txt'))
$tpl->T2 = str_replace('\\','',file_get_contents('class_text/Disclaimer-'.$lang.'.txt'));

if (file_exists('class_text/FAQ-'.$lang.'.txt'))
$tpl->T3 = str_replace('\\','',file_get_contents('class_text/FAQ-'.$lang.'.txt'));

$tpl->block('BLOCK_ADM');
$tpl->LANG = $lang;
$tpl->show(0, $_SESSION["language"]);

} // administrador...
else {
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // sem login ou nao administrador...
?>
