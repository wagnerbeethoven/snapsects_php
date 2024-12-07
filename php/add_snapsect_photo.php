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

if ($_SESSION["ssid"] > 0) {
include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
if (isset($_POST["voltar"]))   
header("location: index.php");

if (isset($_POST["save"])) {

function UpLoad($diretorio, $foto, $nome) {
if (!isset($foto)) 
return '';

$nome = str_replace(' ','_',$nome);
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
$imagem_nome = str_replace(" ", "_", $foto["name"]);
$contador=0;
$xp = explode(".", $imagem_nome);
if (strlen($nome) < 1) $tempnome = $xp[0];
else $tempnome = $nome;
$nnomme = $tempnome;
while (file_exists($diretorio.$nnomme.".".$xp[1])) {
$contador++;
$nnomme=$tempnome.$contador;
} // do while
$imagem_nome = $nnomme.".".$xp[1];
$imagem_dir = $diretorio. $imagem_nome;
move_uploaded_file($foto["tmp_name"], $imagem_dir);

return $imagem_nome;
} // upload.

$erros = array("'", chr(34), "<", ">");
 
if (isset($_POST["id"]))
$id = str_replace($erros, "", $_POST["id"]);
$tp = new snapsect_PhotoClass($id);
$tp->id = $id;

$tp->userid = $_SESSION["ssid"];

if (isset($_POST["codid"]))
$tp->codid = str_replace($erros, "", $_POST["codid"]);
if (strlen($tp->codid) < 1) { $tp->codid="0"; }
if (isset($_POST["datacad"]))
$tp->datacad = str_replace($erros, "", $_POST["datacad"]);
if (isset($_POST["url"]))
$tp->url = str_replace($erros, "", $_POST["url"]);
if (isset($_POST["title"]))
$tp->title = str_replace($erros, "", $_POST["title"]);
if (isset($_POST["obs"]))
$tp->obs = str_replace($erros, "", $_POST["obs"]);

if ((isset($_FILES["grpfoto"])) || ($tp->codid > 0)) {
$ee = new snapsectClass($tp->codid);
if (strlen($_FILES["grpfoto"]["name"]) > 0) {
if (strlen($tp->url) > 0) {
if (file_exists('photos/'.$tp->url)) { unlink('photos/'.$tp->url); }
} // removendo o arquivo antigo...
$tp->url = upload('photos/',$_FILES["grpfoto"],$ee->commonname);
} // adicionando a foto...
} // existe o files...
$tp->Save();
 
?>
<script>
window.location='show_snapsect.php?id=<?php echo $tp->codid; ?>';
</script>
<?php
} // salvando...
 
$tpl = new Template("templates/layout.html",false,'templates/partial/add_snapsect_photo.html','SnapSects');
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
$ee = new snapsect_PhotoClass($id);
$tpl->P = @$ee;
$hoje = getdate();
if (isset($_GET["codid"]))
$codid = str_replace($erros, "", $_GET["codid"]);
else $codid = 0;
if ($codid > 1) {
if ($ee->id == 0) { $ee->codid = $codid; }
if ($ee->codid == $codid) {
$tpl->show(0, $_SESSION["language"]);
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
} // esta logado.
else {
?>
<script>
window.location='snapsect_ger.php';
</script>
<?php
} // retorna ao local de origem...
?>
