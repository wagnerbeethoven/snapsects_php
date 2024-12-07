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

 $erros = array("'", chr(34),'\\');

if (isset($_POST["act"])) {

if (isset($_POST['t0']))
file_put_contents('class_text/Arthropoda.txt',str_replace('\\','',$_POST["t0"]));

if (isset($_POST['t1']))
file_put_contents('class_text/Arachinida.txt',str_replace('\\','',$_POST["t1"]));
if (isset($_POST['t2']))
file_put_contents('class_text/Chilopoda.txt',str_replace('\\','',$_POST["t2"]));
if (isset($_POST['t3']))
file_put_contents('class_text/Diplopoda.txt',str_replace('\\','',$_POST["t3"]));
if (isset($_POST['t4']))
file_put_contents('class_text/Insecta.txt',str_replace('\\','',$_POST["t4"]));
if (isset($_POST['t5']))
file_put_contents('class_text/Malacostraca.txt',str_replace('\\','',$_POST["t5"]));
?>
 <script>
 window.location='snapsect_ger.php';
 </script>
<?php
} // salvando...

 $tpl = new Template("templates/snapsect_adm.html");
$hoje = getdate();
if (file_exists('class_text/Arthropoda.txt'))
$tpl->T0 = str_replace('\\','',file_get_contents('class_text/Arthropoda.txt'));

if (file_exists('class_text/Arachinida.txt'))
$tpl->T1 = str_replace('\\','',file_get_contents('class_text/Arachinida.txt'));

if (file_exists('class_text/Chilopoda.txt'))
$tpl->T2 = str_replace('\\','',file_get_contents('class_text/Chilopoda.txt'));

if (file_exists('class_text/Diplopoda.txt'))
$tpl->T3 = str_replace('\\','',file_get_contents('class_text/Diplopoda.txt'));

if (file_exists('class_text/Insecta.txt'))
$tpl->T4 = str_replace('\\','',file_get_contents('class_text/Insecta.txt'));

if (file_exists('class_text/Malacostraca.txt'))
$tpl->T5 = str_replace('\\','',file_get_contents('class_text/Malacostraca.txt'));

if (file_exists('class_text/copyright.txt'))
$tpl->RODAPE = str_replace('\\','',file_get_contents('class_text/copyright.txt'));

$tpl->show(0);

} // administrador...
else {
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // sem login ou nao administrador...
?>
