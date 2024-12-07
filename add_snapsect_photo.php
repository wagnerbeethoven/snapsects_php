<?php
session_start();
include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
if (isset($_POST["voltar"]))   
header("location: index.php");

if (isset($_POST["save"])) {

$erros = array("'", chr(34), "<", ">");
 
$lang = $_SESSION["language"];
if (isset($_POST["lang"]))
$lang = $_POST["lang"];
if (strlen($lang) < 1) $lang = 'pt-br';
$_SESSION["language"] = $lang;

if (isset($_POST["codid"]))
$codid = str_replace($erros, "", $_POST["codid"]);
if (strlen($codid) < 1) { $codid=0; }

$obs = '';
if (isset($_POST["obs"]))
$obs = str_replace($erros, "", $_POST["obs"]);
$act = '';
if (isset($_POST["act"]))
$act = $_POST["act"];

$arquivo = '';
if (isset($_POST["arquivo"]))
$arquivo = $_POST["arquivo"];

if (strlen($arquivo) < 1) {
if ((!empty($_FILES["grpfoto"]["name"])) and ($codid > 0)) {
$ee = new snapsectClass($codid,$lang);
// $ee->photos->addfiles($codid,$_FILES["grpfoto"],'',$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"],$obs);
$arquivo_tmp= $_FILES['grpfoto']['tmp_name'];
$novoNome = $users->log->verifyupload($_FILES['grpfoto']);
if (strlen($novoNome) > 0) {
$destino= 'photos/'.$lang[0].$lang[1].'/'.$codid.'/'.$novoNome;
if ( @move_uploaded_file ($arquivo_tmp, $destino) ) {
$extensao= '.'.strtolower(pathinfo( $destino, PATHINFO_EXTENSION));
$nome = str_replace($extensao,'.txt',$destino);
file_put_contents($nome,$obs);
} // moveu o arquivo...
} // extensão aceita.
} // existe o files...
} //
else {
$p = 'photos/'.$lang[0].$lang[1].'/'.$codid.'/';
if (file_exists($p.$arquivo)) {
$x = explode('.',$arquivo);
file_put_contents($p.$x[0].'.txt',$obs);
} // existe, salva o obs...
} // modo editar obs... 

?>
<script>
window.location='show_snapsect.php?id=<?php echo $codid.'&lang='.$_SESSION["language"]; ?>';
</script>
<?php
} // salvando...
 
$tpl = new Template("templates/layout_base.html",false,"templates/partial/add_snapsect_photo.html","SnapSects");
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
$ee = new snapsect_PhotoClass($id);
$tpl->P = @$ee;
$hoje = getdate();
$lang = $_SESSION["language"];
if (isset($_GET["codid"]))
$codid = str_replace($erros, "", $_GET["codid"]);
else $codid = 0;
if ($codid > 1) {
if ($ee->id == 0) { $ee->codid = $codid; }
if ($ee->codid == $codid) {
$tpl->LANG = $_SESSION["language"];
$pasta = '';
if (isset($_GET["pasta"]))
$pasta = $_GET["pasta"];
$tpl->URL = '';
$tpl->OBS = '';
if (strlen($pasta) > 0) {
$tpl->URL = 'photos/'.$lang[0].$lang[1].'/'.$codid.'/'.$pasta;
$x = explode('.',$pasta);
$p = 'photos/'.$lang[0].$lang[1].'/'.$codid.'/'.$x[0].'.txt';
if (file_exists($p)) $tpl->OBS = file_get_contents($p);
$tpl->ACT = "edit";
$tpl->ARQUIVO = $pasta;
} else {
$tpl->block('BLOCK_IMG');
$tpl->ACT = 'add';
$tpl->ARQUIVO = '';
} // adiciona...
$tpl->show(0,$_SESSION["language"]);
} // codid = ee->codid
else {
?>
<script>
window.location='snapsect_ger.php';
</script>
<?php
} // codid diferente ao ee-codid
} // codid com valor...
else {
?>
<script>
window.location='snapsect_ger.php';
</script>
<?php
} // codid com valor de 0
// } // esta logado.
// else {
// 
// <script>
// window.location='snapsect_ger.php';
// </script>
// 
// } // retorna ao local de origem...
?>
