<?php
session_start();
if (!isset($_SESSION["ssid"]) == true) {
$_SESSION["ssid"] = 0;
$_SESSION["ssnome"] = '';
$_SESSION["ssemail"] = '';
$_SESSION["ssstatus"] = 0;
$_SESSION["ssurl"] = '';
$_SESSION["language"] = 'pt-BR';
}

// ini_set('upload_max_filesize','80M');
// ini_set('post_max_size', '80M');

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
// include "scripts/diclib.php";

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

$lang = $_SESSION["language"];
if (isset($_POST["lang"]))
$lang = $_POST["lang"];
if (strlen($lang) < 1) { $lang = 'pt-br'; }
$_SESSION["language"] = $lang;
$erros = array("'", chr(34));
 
if (isset($_POST["id"]))
$id = str_replace($erros, "", $_POST["id"]);
$tp = new snapsectClass($id,$lang);
$tp->id = $id;

if (isset($_POST["userid"]))
$tp->userid = str_replace($erros, "", $_POST["userid"]);

if ($tp->userid == 0) {
$tp->userid = $_SESSION["ssid"];
} // userid vazio...

if (isset($_POST["status"]))
$tp->status = str_replace($erros, "", $_POST["status"]);

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

// if (isset($_POST["photodesc"]))
// $tp->photodesc = str_replace($erros, "", $_POST["photodesc"]);

if ($tp->id == 0) { $mcd = 0; } else { $mcd = $tp->id; }
// if (isset($_POST["salvafoto"]))
// $salvafoto = $_POST["salvafoto"];
//  if ($salvafoto == "1") {
// if (isset($_FILES["grpfoto"])) {
// if (strlen($tp->photo) > 0) {
// if (file_exists($tp->photo)) { unlink($tp->photo); }
// } // removendo a imagem antiga...
// $nome = str_replace(' ','_',$tp->commonname.'('.$tp->scientificname.')');
// $ft = $_FILES["grpfoto"];
// $tp->photo = 'pictures/'.UpLoad('pictures/', $ft, $nome);
// } // salvando as fotos...
// } // pode salvar as fotos...
$novoid = $tp->Save();
// $tp->Open($novoid);
if (isset($_POST["photodesc"]))
file_put_contents('photos/'.$lang[0].$lang[1].'/'.$novoid.'/logo.txt',str_replace($erros, "", $_POST["photodesc"]));

if (!empty($_FILES["grpfoto"]["name"])) {
if (strlen($users->log->verifyupload($_FILES["grpfoto"])) > 0) { $tp->photos->add_logo($novoid,$_FILES["grpfoto"],$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"]); }
} // salvando...

if (isset($_POST["saveandview"])) { 
?>
<script>
document.location.href='show_snapsect.php?id=<?php echo $novoid.'&lang='.$lang; ?>';
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
$tpl = new Template("templates/layout_base.html",false,"templates/partial/add_snapsect.html","SnapSects");
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
$lang = $_SESSION["language"];
if (isset($_GET["lang"]))
$lang = $_GET["lang"];
if (strlen($lang) < 1) { $lang = 'pt-br'; }
$_SESSION["language"] = $lang; 
$ee = new snapsectClass($id,$lang);
$tpl->P = @$ee;
if (isset($_GET["pag"])) {
$pag = $_GET["pag"];
} else { $pag = 'dvprincipal'; }
$tpl->DVINIT = $pag;
$hoje = getdate();
$tpl->LANG = $lang;
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

$ddic = opendicionario($_SESSION["language"]);
$dic = $ddic["dic"];
$texto = 'var dic = [];'.chr(13).chr(10);
foreach($dic as $d) {
$texto .="dic.push('".$d."');".chr(13).chr(10);
} // do for...
$tpl->TEXTDIC = $texto;
if (strlen($ee->photo) > 0) { $tpl->PPHOTO = ''; }
else { $tpl->PPHOTO = SITE_URL.$ee->photos->pasta.$ee->id.'/'.$ee->photo; }
if ($ee->status == 1) { $tpl->SSTATUS = ' checked'; } else { $tpl->SSTATUS = ''; }
$tpl->show(0,$_SESSION["language"]);
} else {
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // nao esta logado...
?>
