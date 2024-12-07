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

include "scripts/config.php";
include "scripts/snapsect_class.php";
include "scripts/diclib.php";

 $erros = array("'", chr(34), "<", ">");

$act = '';
if (isset($_POST["act"]))
$act = str_replace($erros, "", $_POST["act"]);
else {
if (isset($_GET["act"]))
$act = str_replace($erros, "", $_GET["act"]);
 } // do get...
if ($act == "add") {

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
$lang = $_SESSION["language"];
if (isset($_POST["lang"]))
$lang = str_replace($erros, "", $_POST["lang"]);
 
if (isset($_POST["id"]))
$id = str_replace($erros, "", $_POST["id"]);
if ($id < 0) {
$id = 0;
}
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

if (isset($_POST["photodesc"]))
$tp->photodesc = str_replace($erros, "", $_POST["photodesc"]);

if ($tp->id == 0) { $mcd = 0; } else { $mcd = $tp->id; }
if (isset($_POST["salvafoto"]))
$salvafoto = $_POST["salvafoto"];
// if ($salvafoto == "1") {
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
$sendimage = '';
 if (isset($_POST["sendimage"]))
$sendimage = $_POST["sendimage"];
if (strlen($sendimage) > 0) {
// proteger upload...
$tp->photos->addfilesbase64($novoid,$sendimage,'logo.jpg',$_POST["photodesc"],$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"]);
// $file = $tp->photos->pasta.$novoid.'/logo.jpg';
// $img = $_POST['sendimage'];
// $img = str_replace('data:image/jpeg;base64,', '', $img);
// $img = str_replace(' ', '+', $img);
// $data = base64_decode($img);
// file_put_contents($file, $data);
} // pode salvar a imagem...
$l = array("result" => "OK", "id" => $novoid);
$data = JSON_encode($l);
echo $data;
} // salvando...
 
if (($act == "get") && (isset($_GET["id"]))) {
$lang = $_SESSION["language"];
if (isset($_GET["lang"]))
$lang = $_GET["lang"];

$id = str_replace($erros, "", $_GET["id"]);
 
$tp = new snapsectClass($id,$lang);
$tp->id = $id;
 
// $l = array("id" => $tp->id,"commonname" => $tp->commonname,"scientificname" => $tp->scientificname,"kingdom" => $tp->kingdom,"phylum" => $tp->phylum,"classe" => $tp->classe,"oorder" => $tp->oorder,"family" => $tp->family,"genus" => $tp->genus,"species" => $tp->species,"colors" => $tp->colors,"bbody" => $tp->bbody,"hhead" => $tp->hhead,"thorax" => $tp->thorax,"abdomen" => $tp->abdomen,"lstantennae" => $tp->lstantennae,"antennae" => $tp->antennae,"eyesandocelli" => $tp->eyesandocelli,"lstmouthparts" => $tp->lstmouthparts,"mouthparts" => $tp->mouthparts,"lstwings" => $tp->lstwings,"wings" => $tp->wings,"lstnumlegs" => $tp->lstnumlegs,"lstlegs" => $tp->lstlegs,"locomotive" => $tp->locomotive,"specificcharacteristics" => $tp->specificcharacteristics,"development" => $tp->development,"metamorphosis" => $tp->metamorphosis,"collecting" => $tp->collecting,"place" => $tp->place,"water" => $tp->water,"ground" => $tp->ground,"other" => $tp->other,"datacad" => $tp->datacad,"lat" => $tp->lat,"lng" => $tp->lng,"city" => // $tp->city,"country" => $tp->country,"uf" => $tp->uf,"address" => $tp->address,"photo" => $tp->photo, "photodesc" => $tp->photodesc,"win" => $tp->win,"temperature" => $tp->temperature);
$res=$tp->Find("select * from [banco] where id=".$id); 
while($r=mysqli_fetch_array($res)) {
$l = $r;
} // do while
// agora a lista dos usuarios...
$contador = 0;
$uu = array();

$u = new snapsect_UserClass();
$res = $u->Find("select * from [banco] where status > 0 order by nome");
while($r=mysqli_fetch_array($res)) {
$u->GetRes($r);
if ($l["userid"] !== $u->id) {
$contador++;
$uu[] = array('numero' => $contador, 'uid' => $u->id, 'nome' => $u->nome.', '.$u->email);
// if (strpos(' |'.$ee->ground.'|','|'.$u->id.'|') > 0) { $tpl->MARCADO = 'checked'; } else { $tpl->MARCADO = ''; }
// $tpl->block("BLOCK_USER");
} // pode mostrar...
} // do while

$data = JSON_encode(array('snapsect' => $l, 'users' => $uu));
echo $data;
 
} // recuperando os dados.
if ($act == "loc") {
 
$tp = new snapsectClass();
$res = $tp->Find("select * from [banco]");
$l = array();
while($rs=mysqli_fetch_array($res)) {
$tp->GetRes($rs);
$l[count($l)] = array("id" => $tp->id, "commonname" => $tp->commonname, "scientificname" => $tp->scientificname, "kingdom" => $tp->kingdom, "phylum" => $tp->phylum, "classe" => $tp->classe, "oorder" => $tp->oorder, "family" => $tp->family, "genus" => $tp->genus, "species" => $tp->species, "colors" => $tp->colors, "bbody" => $tp->bbody, "hhead" => $tp->hhead, "thorax" => $tp->thorax, "abdomen" => $tp->abdomen, "lstantennae" => $tp->lstantennae, "antennae" => $tp->antennae, "eyesandocelli" => $tp->eyesandocelli, "lstmouthparts" => $tp->lstmouthparts, "mouthparts" => $tp->mouthparts, "lstwings" => $tp->lstwings, "wings" => $tp->wings, "lstlegs" => $tp->lstlegs, "locomotive" => $tp->locomotive, "specificcharacteristics" => $tp->specificcharacteristics, "development" => $tp->development, "metamorphosis" => $tp->metamorphosis, "collecting" => $tp->collecting, "place" => $tp->place, "water" => $tp->water, "ground" => $tp->ground, "other" => $tp->other, "datacad" => $tp->datacad, "lat" => $tp->lat, "lng" => $tp->lng, "city" => $tp->city, "country" => $tp->country, "uf" => $tp->uf, "address" => $tp->address, "photo" => $tp->photo, "photodesc" => $tp->photodesc, "win" => $tp->win, "temperature" => $tp->temperature );
} // do while...
$data = JSON_encode($l);
echo $data;
} // enviando os dados para o gerfile...

if ($act == "find") {
if (isset($_GET["antennae"]))
$antennae = str_replace($erros, "", $_GET["antennae"]);
else $antennae = "";
if (isset($_GET["mouthparts"]))
$mouthparts = str_replace($erros, "", $_GET["mouthparts"]);
else $mouthparts = "";

if (isset($_GET["wings"]))
$wings = str_replace($erros, "", $_GET["wings"]);
else $wings = "";

if (isset($_GET["legs"]))
$legs = str_replace($erros, "", $_GET["legs"]);
else $legs = "";

if (isset($_GET["commonname"]))
$commonname = str_replace($erros, "", $_GET["commonname"]);

if (isset($_GET["oorder"]))
$oorder = str_replace($erros, "", $_GET["oorder"]);

if (isset($_GET["lstother"]))
$other = str_replace($erros, "", $_GET["lstother"]);

if (isset($_GET["lstnumlegs"]))
$lstnumlegs = str_replace($erros, "", $_GET["lstnumlegs"]);

if (isset($_GET["classe"]))
$classe = str_replace($erros, "", $_GET["classe"]);

if (isset($_GET["family"]))
$family = str_replace($erros, "", $_GET["family"]);

$find = "";
if (strlen($antennae) > 0) $find = " where lstantennae = '$antennae'";

if (strlen($mouthparts) > 0) {
if (strlen($find) > 0) { $find .= " and lstmouthparts = '$mouthparts'"; }
else $find = " where lstmouthparts = '$mouthparts'";
} // existe mouthparts

if (strlen($wings) > 0) {
if (strlen($find) > 0) { $find .= " and lstwings = '$wings'"; }
else $find = " where lstwings = '$wings'";
} // existe wings

if (strlen($legs) > 0) {
if (strlen($find) > 0) { $find .= " and lstlegs = '$legs'"; }
else $find = " where lstlegs = '$legs'";
} // existe legs

if (strlen($other) > 0) {
if (strlen($find) > 0) { $find .= " and other = '$other'"; }
else $find = " where other = '$other'";
} // existe other

if (strlen($commonname) > 0) {
if (strlen($find) > 0) { $find .= " and commonname like'%$commonname%'"; }
else $find = " where commonname like'%$commonname%'";
} // existe common name

if (strlen($oorder) > 0) {
if (strlen($find) > 0) { $find .= " and oorder like'%$oorder%'"; }
else $find = " where oorder like'%$oorder%'";
} // existe oorder

if (strlen($lstnumlegs) > 0) {
if (strlen($find) > 0) { $find .= " and lstnumlegs ='$lstnumlegs'"; }
else $find = " where lstnumlegs ='$lstnumlegs'";
} // existe lstnumlegs

if (strlen($classe) > 0) {
if (strlen($find) > 0) { $find .= " and classe ='$classe'"; }
else $find = " where classe ='$classe'";
} // existe classe

if (strlen($family) > 0) {
if (strlen($find) > 0) { $find .= " and family like'%$family%'"; }
else $find = " where family like'%$family%'";
} // existe oorder

if (isset($_GET["lang"]))
$lang = $_GET["lang"];
else $lang = 'pt-br';
$ddic = opendicionario($lang);
$dic = $ddic["dic"];

$t = '<center><table border="0">';
$t .= '<tr>';
$t .='<th TEXT-ALIGN="CENTER" width="33%">'.$dic[8].' ('.$dic[86].'): </th>';
$t .='<th TEXT-ALIGN="CENTER" width="33%">'.$dic[221].': </th>';
$t .='<th TEXT-ALIGN="CENTER" width="33%">'.$dic[191].': </th>';
$t.='</tr>';
$tp = new snapsectClass(0,$_SESSION["language"]);
$res = $tp->Find("select * from [banco] ".$find.' order by commonname');
$contador = 0;
$ok = 0;
$ff = '';
while($r=mysqli_fetch_array($res)) {
$ff = '';
$tp->GetRes($r);
if ($tp->status == 1) { $ok = 1; }
else {
$ok = 0;
$ff = '*';
if ($_SESSION["ssstatus"] > 49) { $ok = 1; }
else {
if ($tp->userid == $_SESSION["ssid"]) { $ok = 1; }
else {

} // nao é o id...
} // ainda nao mostra...
}
if ($ok == 1) {
$contador = $contador + 1;
$t.='<Tr>';
$t.='<Td align="center"><a href="javascript:document.location.href='."'show_snapsect.php?id=".$tp->id."&lang=".$lang."';".'">'.$ff.$tp->commonname.' ('.$tp->scientificname.')';
if (strlen($tp->photo) > 0) {
$t .= '<br><center><img src="'.$site_url.$tp->photos->pasta.$tp->id.'/'.$tp->photo.'" alt="'.$tp->photodesc.'" width="240px" onload="redimensiona();" /></center>';
} // tem photo
$t.='</a></td>';
$t.='<Td align="center">'.$tp->author.'</td>';
$t.='<Td align="center">'.$tp->colaborative.'</td>';
$t.='</Tr>';
} // pode mostrar...
} // do while
$t.='</table></center>';
if ($contador > 0) {
echo $t;
} else { echo "<center><b>".$dic[556]."</b></center>"; }

} // do find...

if ($act == "mobilefind") {
$lang = $_SESSION["language"];
if (isset($_GET["lang"]))
$lang = $_GET["lang"];

$userid = 0;
if (isset($_GET["userid"]))
$userid = $_GET["userid"];
if ($userid < 1) {
$lgi=0;
$lgs = 0;
} else {
$uid = new snapsect_UserClass($userid);
$lgi = $uid->id;
$lgs = $uid->status;
} // logado...

$antennae = '';
if (isset($_GET["antennae"]))
$antennae = str_replace($erros, "", $_GET["antennae"]);
else $antennae = "";
if (isset($_GET["mouthparts"]))
$mouthparts = str_replace($erros, "", $_GET["mouthparts"]);
else $mouthparts = "";

if (isset($_GET["wings"]))
$wings = str_replace($erros, "", $_GET["wings"]);
else $wings = "";

if (isset($_GET["legs"]))
$legs = str_replace($erros, "", $_GET["legs"]);
else $legs = "";

$commonname = '';
if (isset($_GET["commonname"]))
$commonname = str_replace($erros, "", $_GET["commonname"]);

$oorder = '';
if (isset($_GET["oorder"]))
$oorder = str_replace($erros, "", $_GET["oorder"]);

$other = '';
if (isset($_GET["lstother"]))
$other = str_replace($erros, "", $_GET["lstother"]);

$lstnumlegs = '';
if (isset($_GET["lstnumlegs"]))
$lstnumlegs = str_replace($erros, "", $_GET["lstnumlegs"]);

$classe = '';
if (isset($_GET["classe"]))
$classe = str_replace($erros, "", $_GET["classe"]);

$family = '';
if (isset($_GET["family"]))
$family = str_replace($erros, "", $_GET["family"]);

$find = "";
if (strlen($antennae) > 0) $find = " where lstantennae = '$antennae'";

if (strlen($mouthparts) > 0) {
if (strlen($find) > 0) { $find .= " and lstmouthparts = '$mouthparts'"; }
else $find = " where lstmouthparts = '$mouthparts'";
} // existe mouthparts

if (strlen($wings) > 0) {
if (strlen($find) > 0) { $find .= " and lstwings = '$wings'"; }
else $find = " where lstwings = '$wings'";
} // existe wings

if (strlen($legs) > 0) {
if (strlen($find) > 0) { $find .= " and lstlegs = '$legs'"; }
else $find = " where lstlegs = '$legs'";
} // existe legs

if (strlen($other) > 0) {
if (strlen($find) > 0) { $find .= " and other = '$other'"; }
else $find = " where other = '$other'";
} // existe other

if (strlen($commonname) > 0) {
if (strlen($find) > 0) { $find .= " and commonname like'%$commonname%'"; }
else $find = " where commonname like'%$commonname%'";
} // existe common name

if (strlen($oorder) > 0) {
if (strlen($find) > 0) { $find .= " and oorder like'%$oorder%'"; }
else $find = " where oorder like'%$oorder%'";
} // existe oorder

if (strlen($lstnumlegs) > 0) {
if (strlen($find) > 0) { $find .= " and lstnumlegs ='$lstnumlegs'"; }
else $find = " where lstnumlegs ='$lstnumlegs'";
} // existe lstnumlegs

if (strlen($classe) > 0) {
if (strlen($find) > 0) { $find .= " and classe ='$classe'"; }
else $find = " where classe ='$classe'";
} // existe classe

if (strlen($family) > 0) {
if (strlen($find) > 0) { $find .= " and family like'%$family%'"; }
else $find = " where family like'%$family%'";
} 
$t = '';
$tp = new snapsectClass(0,$lang);
$res = $tp->Find("select * from [banco] ".$find.' order by commonname');
$contador = 0;
$ok=0;
$ff = '';
while($r=mysqli_fetch_array($res)) {
$ff='';
$tp->GetRes($r);

if ($tp->status == 1) { $ok = 1; }
else {
$ok = 0;
$ff = '*';
if ($lgs > 49) { $ok = 1; }
else {
if ($tp->userid.'' == $lgi.'') { $ok = 1; }
else {

} // nao é o id...
} // ainda nao mostra...
}
if ($ok == 1) {
$contador = $contador + 1;
$t.='<Tr>';
// if (strlen($tp->photo) > 0) {
// $t.='<td<img src="'.SITE_URL.$tp->photo.'" width="125px" alt="'.$tp->commonname.'"></td>';
// } else {
// $t.='<td>No Picture</td>';
// }
$t.='<Td align="center"><a href="javascript:document.location.href='."'show_snapsect.html?id=".$tp->id."';".'">'.$ff.$tp->commonname.' ('.$tp->scientificname.')';
if (strlen($tp->photo) > 0) {
$t .= '<br><center><img src="'.$site_url.$tp->photos->pasta.$tp->id.'/'.$tp->photo.'" alt="'.$tp->photodesc.'" width="120px" onload="redimensiona();" /></center>';
} // tem photo
$t.='</a></td>';
$t.='<Td align="center">'.$tp->author.'</td>';
$t.='<Td align="center">'.$tp->colaborative.'</td>';
$t.='</Tr>';
} // do ok...
} // do while
$t.='</table></center>';
echo JSON_encode(array('count' => $contador, 'result' => $t));
} // do mobilefind...

if (($act == "gettext") && (isset($_GET["id"]))) {
$id = str_replace($erros, "", $_GET["id"]);
 
$lang = $_SESSION["language"];
if (isset($_GET["lang"]))
$lang = str_replace($erros, "", $_GET["lang"]);
if (strlen($lang) < 1) { $lang='pt-br'; }
$_SESSION["language"] = $lang;
$ddic = opendicionario($lang);
$dic = $ddic["dic"];
$ll = gettextfunc($id,$dic,$lang,$_GET["uid"],$_GET["ust"]);
$t = $ll["text"];
echo $t;
 } // retornando texto

if ($act == "findmobile") {
$l = array();
$tp = new snapsectClass();
$res = $tp->Find("select * from [banco] order by commonname");
while($r=mysqli_fetch_array($res)) {
$tp->GetRes($r);
$l[] = array('id' => $tp->id, 'title' => $tp->commonname, 'text' => $tp->scientificname);
} // do while
echo json_encode($l);
} // do find...

if ($act == "delimage") {

$lang = $_SESSION["language"];
if (isset($_POST["lang"]))
$lang = $_POST["lang"];
$_SESSION["language"] = $lang;

if (isset($_POST["id"])) {
$id = $_POST["id"];
$ee = new snapsectClass($id,$lang);
if (isset($_POST["arquivo"]))
$arq = $_POST["arquivo"];
$ee->photos->deletefiles($id,$arq,$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"]);
echo 'ok';
} // existe id.
} // removendo a imagem e o text

if ($act == "addimage") {
$lang = $_SESSION["language"];
if (isset($_POST["lang"]))
$lang = $_POST["lang"];
if (strlen($lang) < 1) $lang = $_SESSION["language"]; 
$id = 0;
if (isset($_POST["id"]))
$id = $_POST["id"];
if ($id > 0) {
$nm = '';
if (isset($_POST["arquivo"]))
$nm = $_POST["arquivo"];
if (strlen($nm) > 0) {
$px = explode('.',$nm);
$px2 = Time();
if (count($px) < 2) { $px[] = '.jpg'; }
if (strlen($px[0]) < 0) { $px[0] = $px2; }
$nome = $px[0].'.'.$px[1];
} else {
$px = Time();
$nome = $px.'.jpg';
} // nm vazio
$text = '';
if (isset($_POST["text"]))
$text = $_POST["text"];
$img = '';
if (isset($_POST["img"]))
$img = $_POST["img"];
if (strlen($img) > 0) {
$tp = new snapsectClass($id,$lang);
$tp->photos->addfilesbase64($id,$img,$nome,$text,$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"]);
} // existe imagem...
} // existe id...
} // adicionando a imagem.

if ($act == "addvideo") {
$erros = array("'", chr(34), "<", ">");
 
$lang = $_SESSION["language"];
if (isset($_POST["lang"]))
$lang = $_POST["lang"];
if (strlen($lang) < 1) $lang = 'pt-br';
$_SESSION["language"] = $lang;

if (isset($_POST["id"]))
$id = str_replace($erros, "", $_POST["id"]);
if (strlen($id) < 1) { $id=0; }

$obs = '';
if (isset($_POST["text"]))
$obs = str_replace($erros, "", $_POST["text"]);

$arq = '';
if (isset($_POST["arquivo"]))
$arq = str_replace($erros, "", $_POST["arquivo"]);

$a = 'photos/'.$lang[0].$lang[1].'/'.$id.'/'.$arquivo;
if (file_exists($a)) {
$x = explode('.',$arquivo);
$b = 'photos/'.$lang[0].$lang[1].'/'.$id.'/'.$x[0].'.txt';
file_put_contents($b,$obs);
$ee = new snapsectClass($id,$lang);
$ee->photos->addlog($id,'Add '.$arquivo.chr(9).$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"]);
echo JSON_encode(array('results' => 'ok'));
} // existe o arquivo...
else {
echo JSON_encode(array('results' => 'error'));
} // o arquivo nao foi encontrado

} // adicionando vidio...

if ($act == "addmedia") {
$erros = array("'", chr(34), "<", ">");
 
$lang = $_SESSION["language"];
if (isset($_POST["lang"]))
$lang = $_POST["lang"];
if (strlen($lang) < 1) $lang = 'pt-br';
$_SESSION["language"] = $lang;

if (isset($_POST["id"]))
$id = str_replace($erros, "", $_POST["id"]);
if (strlen($id) < 1) { $id=0; }

$obs = '';
if (isset($_POST["obs"]))
$obs = str_replace($erros, "", $_POST["obs"]);
$mudar = isset($_POST["mudar"]) ? $_POST["mudar"] : 0;
if ($mudar == 0) {
$media = isset( $_FILES['arquivo'] ) ? $_FILES['arquivo'] : null;
if ( empty( $media ) ) {
// sem imagem...
} else {
$arquivo = $users->log->verifyupload($media);
if (strlen($arquivo) > 0) {
$a = 'photos/'.$lang[0].$lang[1].'/'.$id.'/'.$arquivo;
if (strlen($users->log->verifyupload($_FILES['file'])) > 0) if (move_uploaded_file( $media['tmp_name'], $a ) ) {

$x = explode('.',$arquivo);
$b = 'photos/'.$lang[0].$lang[1].'/'.$id.'/'.$x[0].'.txt';
file_put_contents($b,$obs);
$ee = new snapsectClass($id,$lang);
$ee->photos->addlog($id,'Add '.$arquivo.chr(9).$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"]);
echo JSON_encode(array('results' => 'ok'));
} // existe o arquivo...
else {
echo JSON_encode(array('results' => 'error'));
} // o arquivo nao foi encontrado
} // do bloqueio...
} // existe a media...
} else {
$nome = isset($_POST["nome"]) ? str_replace(' ','_',str_replace($erros,'', $_POST["nome"])) : '';
if (strlen($nome) > 0) {
$x = explode('.',$nome);
$b = 'photos/'.$lang[0].$lang[1].'/'.$id.'/'.$x[0].'.txt';
file_put_contents($b,$obs);
$ee = new snapsectClass($id,$lang);
$ee->photos->addlog($id,'Add '.$arquivo.chr(9).$_SESSION["ssid"].chr(9).$_SESSION["ssnome"].chr(9).$_SESSION["ssemail"]);
echo JSON_encode(array('results' => 'ok'));

} // nome nao vazio
} // nao existe midea...
} // adicionando vidio...

?>
