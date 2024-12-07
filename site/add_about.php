<?php
if (!isset($_SESSION["ssid"])) {
session_start();
$_session["ssid"] = 0;
$_session["ssnome"] = '';
$_session["ssemail"] = '';
$_session["ssstatus"] = '';
$_session["ssurl"] = '';
} // não está logado...

if ($_SESSION["ssstatus"] == 67) {
include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";

 $erros = array("'", chr(34));

if (isset($_POST["act"])) {

if (isset($_POST['t0']))
file_put_contents('class_text/about.txt',str_replace('\\','',$_POST["t0"]));

if (isset($_POST['t1']))
file_put_contents('class_text/copyright.txt',str_replace('\\','',$_POST["t1"]));

if (isset($_POST['t2']))
file_put_contents('class_text/Disclaimer.txt',str_replace('\\','',$_POST["t2"]));

if (isset($_POST['t3']))
file_put_contents('class_text/FAQ.txt',str_replace('\\','',$_POST["t3"]));

?>
 <script>
 window.location='snapsect_ger.php';
 </script>
<?php
} // salvando...

 $tpl = new Template("templates/add_about.html");
$hoje = getdate();

if (file_exists('class_text/about.txt'))
$tpl->T0 = str_replace('\\','',file_get_contents('class_text/about.txt'));

if (file_exists('class_text/copyright.txt'))
$tpl->T1 = str_replace('\\','',file_get_contents('class_text/copyright.txt'));

if (file_exists('class_text/Disclaimer.txt'))
$tpl->T2 = str_replace('\\','',file_get_contents('class_text/Disclaimer.txt'));

if (file_exists('class_text/FAQ.txt'))
$tpl->T3 = str_replace('\\','',file_get_contents('class_text/FAQ.txt'));

$tpl->show(0);

} // administrador...
else {
?>
<script>
window.location='>?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // sem login ou nao administrador...
?>
