<?php
session_start();
if (!isset($_SESSION["ssid"])) {
$_session["ssid"] = 0;
$_session["ssnome"] = '';
$_session["ssemail"] = '';
$_session["ssstatus"] = '';
$_session["ssurl"] = '';
} // não está logado...

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
include "scripts/snapsect_userclass.php"; 

$erros = array("'", chr(34));
$id = 0;
 
if (isset($_POST["voltar"]))   
header("location: index.php");

if ((isset($_POST["save"])) || (isset($_POST["saveandview"]))) {

function UpLoad($diretorio, $foto, $nome) {
if (!isset($foto)) 
return '';

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

$erros = array("'", chr(34));
 
if (isset($_POST["id"]))
$id = str_replace($erros, "", $_POST["id"]);
$tp = new snapsectClass($id);
$tp->id = $id;

if (isset($_POST["userid"]))
$tp->userid = str_replace($erros, "", $_POST["userid"]);

if ($tp->userid == 0) {
$tp->userid = $_SESSION["ssid"];
} // userid vazio...

if (isset($_POST["author"]))
$tp->author = str_replace($erros, "", $_POST["author"]);

if (isset($_POST["email"]))
$tp->email = str_replace($erros, "", $_POST["email"]);

if (isset($_POST["url"]))
$tp->url = str_replace($erros, "", $_POST["url"]);

if (isset($_POST["colaborative"]))
$tp->colaborative = str_replace($erros, "", $_POST["colaborative"]);

if (isset($_POST["commonname"]))
$tp->commonname = str_replace($erros, "", $_POST["commonname"]);
if (isset($_POST["scientificname"]))
$tp->scientificname = str_replace($erros, "", $_POST["scientificname"]);
if (isset($_POST["other"]))
$tp->other = str_replace($erros, "", $_POST["other"]);

if (isset($_POST["kingdom"]))
$tp->kingdom = str_replace($erros, "", $_POST["kingdom"]);
if (isset($_POST["phylum"]))
$tp->phylum = str_replace($erros, "", $_POST["phylum"]);
if (isset($_POST["classe"]))
$tp->classe = str_replace($erros, "", $_POST["classe"]);
if (isset($_POST["oorder"]))
$tp->oorder = str_replace($erros, "", $_POST["oorder"]);
if (isset($_POST["family"]))
$tp->family = str_replace($erros, "", $_POST["family"]);
if (isset($_POST["genus"]))
$tp->genus = str_replace($erros, "", $_POST["genus"]);
if (isset($_POST["species"]))
$tp->species = str_replace($erros, "", $_POST["species"]);

if (isset($_POST["gender"]))
$tp->gender = str_replace($erros, "", $_POST["gender"]);

if (isset($_POST["colors"]))
$tp->colors = str_replace($erros, "", $_POST["colors"]);
if (isset($_POST["bbody"]))
$tp->bbody = str_replace($erros, "", $_POST["bbody"]);
if (isset($_POST["hhead"]))
$tp->hhead = str_replace($erros, "", $_POST["hhead"]);
if (isset($_POST["thorax"]))
$tp->thorax = str_replace($erros, "", $_POST["thorax"]);
if (isset($_POST["abdomen"]))
$tp->abdomen = str_replace($erros, "", $_POST["abdomen"]);
if (isset($_POST["lstantennae"]))
$tp->lstantennae = str_replace($erros, "", $_POST["lstantennae"]);
if (isset($_POST["antennae"]))
$tp->antennae = str_replace($erros, "", $_POST["antennae"]);
if (isset($_POST["eyesandocelli"]))
$tp->eyesandocelli = str_replace($erros, "", $_POST["eyesandocelli"]);
if (isset($_POST["lstmouthparts"]))
$tp->lstmouthparts = str_replace($erros, "", $_POST["lstmouthparts"]);
if (isset($_POST["mouthparts"]))
$tp->mouthparts = str_replace($erros, "", $_POST["mouthparts"]);
if (isset($_POST["lstwings"]))
$tp->lstwings = str_replace($erros, "", $_POST["lstwings"]);
if (isset($_POST["wings"]))
$tp->wings = str_replace($erros, "", $_POST["wings"]);

if (isset($_POST["lsthindwings"]))
$tp->lsthindwings = str_replace($erros, "", $_POST["lsthindwings"]);
if (isset($_POST["hindwings"]))
$tp->hindwings = str_replace($erros, "", $_POST["hindwings"]);

if (isset($_POST["lstnumlegs"]))
$tp->lstnumlegs = str_replace($erros, "", $_POST["lstnumlegs"]);

if (isset($_POST["lstlegs"]))
$tp->lstlegs = str_replace($erros, "", $_POST["lstlegs"]);

if (isset($_POST["cerci"]))
$tp->cerci = str_replace($erros, "", $_POST["cerci"]);

if (isset($_POST["tarsomere"]))
$tp->tarsomere = str_replace($erros, "", $_POST["tarsomere"]);

if (isset($_POST["locomotive"]))
$tp->locomotive = str_replace($erros, "", $_POST["locomotive"]);
if (isset($_POST["specificcharacteristics"]))
$tp->specificcharacteristics = str_replace($erros, "", $_POST["specificcharacteristics"]);
if (isset($_POST["development"]))
$tp->development = str_replace($erros, "", $_POST["development"]);
if (isset($_POST["metamorphosis"]))
$tp->metamorphosis = str_replace($erros, "", $_POST["metamorphosis"]);
if (isset($_POST["collecting"]))
$tp->collecting = str_replace($erros, "", $_POST["collecting"]);
if (isset($_POST["place"]))
$tp->place = str_replace($erros, "", $_POST["place"]);

if (isset($_POST["datacad"]))
$tp->datacad = str_replace($erros, "", $_POST["datacad"]);
if (isset($_POST["lat"]))
$tp->lat = str_replace($erros, "", $_POST["lat"]);
if (isset($_POST["lng"]))
$tp->lng = str_replace($erros, "", $_POST["lng"]);
if (isset($_POST["city"]))
$tp->city = str_replace($erros, "", $_POST["city"]);
if (isset($_POST["country"]))
$tp->country = str_replace($erros, "", $_POST["country"]);
if (isset($_POST["uf"]))
$tp->uf = str_replace($erros, "", $_POST["uf"]);
if (isset($_POST["address"]))
$tp->address = str_replace($erros, "", $_POST["address"]);
if (isset($_POST["photo"]))
$tp->photo = str_replace($erros, "", $_POST["photo"]);
if (isset($_POST["win"]))
$tp->win = str_replace($erros, "", $_POST["win"]);
if (isset($_POST["temperature"]))
$tp->temperature = str_replace($erros, "", $_POST["temperature"]);

if (isset($_POST["mediation"]))
$tp->mediation = str_replace($erros, "", $_POST["mediation"]);

if (isset($_POST["notes"]))
$tp->notes = str_replace($erros, "", $_POST["notes"]);

if (isset($_POST["audiodesc"]))
$tp->audiodesc = str_replace($erros, "", $_POST["audiodesc"]);
if (isset($_POST["water"]))
$tp->water = str_replace($erros, "", $_POST["water"]);

if (isset($_POST["ground"]))
$tp->ground = str_replace($erros, "", $_POST["ground"]);

if (isset($_POST["photodesc"]))
$tp->photodesc = str_replace($erros, "", $_POST["photodesc"]);

if ($tp->id == 0) { $mcd = 0; } else { $mcd = $tp->id; }
if (isset($_POST["salvafoto"]))
$salvafoto = $_POST["salvafoto"];
if ($salvafoto == "1") {
if (isset($_FILES["grpfoto"])) {
if (strlen($tp->photo) > 0) {
if (file_exists($tp->photo)) { unlink($tp->photo); }
} // removendo a imagem antiga...
$nome = str_replace(' ','_',$tp->commonname.'('.$tp->scientificname.')');
$ft = $_FILES["grpfoto"];
$tp->photo = 'pictures/'.UpLoad('pictures/', $ft, $nome);
} // salvando as fotos...
} // pode salvar as fotos...
$novoid = $tp->Save();
if (isset($_POST["saveandview"])) { 
?>
<script>
document.location.href='show_snapsect.php?id=<?php echo $novoid; ?>';
</script>
<?php
} // modo save and view
else {
?>
<script>
document.location.href='snapsect_ger.php';
</script>
<?php
} // modo save...
} // salvando...

if ($_SESSION["ssid"] > 0) { 
$tpl = new Template("templates/add_snapsect.html");
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
$ee = new snapsectClass($id);
$tpl->P = @$ee;
if (isset($_GET["pag"])) {
$pag = $_GET["pag"];
} else { $pag = 'dvprincipal'; }
$tpl->DVINIT = $pag;
$hoje = getdate();
if (($_SESSION["ssid"] == $ee->userid) || ($_SESSION["ssstatus"] == 67)) {
$tpl->block("BLOCK_TAB");
}
// agora a lista dos usuarios...
$contador = 0;
$u = new snapsect_UserClass($id);
$res = $u->Find("select * from [banco] where status > 0 order by nome");
while($r=mysqli_fetch_array($res)) {
$u->GetRes($r);
if ($ee->userid !== $u->id) {
$contador++;
$tpl->NUMERO = $contador;
$tpl->UID = $u->id;
$tpl->UNOME = $u->nome.', '.$u->email;
if (strpos(' |'.$ee->ground.'|','|'.$u->id.'|') > 0) { $tpl->MARCADO = 'checked'; } else { $tpl->MARCADO = ''; }
$tpl->block("BLOCK_USER");
} // pode mostrar...
} // do while

if (file_exists('class_text/copyright.txt'))
$tpl->RODAPE = file_get_contents('class_text/copyright.txt');

$tpl->show(0);
} else {
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // nao esta logado...
?>
