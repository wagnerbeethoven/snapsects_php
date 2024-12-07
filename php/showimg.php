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

if (isset($_POST["obs"]))
$obs = str_replace($erros, "", $_POST["obs"]);

if ((!empty($_FILES["grpfoto"]["name"])) and ($codid > 0)) {
$ee = new snapsectClass($codid,$lang);
$ee->photos->addfiles($codid,$_FILES["grpfoto"],'',$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"],$obs);
// if (strlen($_FILES["grpfoto"]["name"]) > 0) {
// if (strlen($tp->url) > 0) {
// if (file_exists('photos/'.$tp->url)) { unlink('photos/'.$tp->url); }
// } // removendo o arquivo antigo...
// // $tp->url = upload('photos/',$_FILES["grpfoto"],$ee->commonname);
// } // adicionando a foto...
} // existe o files...
 
?>
<script>
window.location='show_snapsect.php?id=<?php echo $codid.'&lang='.$_SESSION["language"]; ?>';
</script>
<?php
} // salvando...
 
$tpl = new Template('templates/layout.html',false,'templates/partial/showimg.html',$title);

$lang = $_SESSION["language"];
if (isset($_GET["lang"]))
$lang = $_GET["lang"];
$_SESSION["language"] = $lang;

if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);

$photo = '';
if (isset($_GET["photo"]))
$photo = $_GET["photo"]; 

$ee = new snapsectClass($id,$lang);
// $tpl->P = @$ee;
$hoje = getdate();
$x = explode('.',$photo);
$tpl->URL = '<img src="'.$ee->photos->pasta.$id.'/'.$photo.'" width="600px" id="imgfoto">';
if (file_exists($ee->photos->pasta.$id.'/'.$x[0].'.txt')) $tpl->TEXTO = file_get_contents($ee->photos->pasta.$id.'/'.$x[0].'.txt');
$tpl->CODID = $id;
$tpl->LANG = $_SESSION["language"];
$tpl->show(0,$_SESSION["language"]);

?>