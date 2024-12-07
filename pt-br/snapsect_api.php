<?php
include "scripts/config.php";
include "scripts/snapsect_class.php";
include "scripts/snapsect_userclass.php";

function texttolink($texto) { 
$i = strpos($texto,'<link=');
while($i > -1) {
$t = 0;
$link = '';
$base = '';
for ($r=$i;$r<strlen($texto);$r++) {
$base .=$texto[$r];
if ($t == 1) {
if ($texto[$r] == '>') {
$t = 2;
break;
} else {
$link .= $texto[$r];
}
} // adicionando link
if (($t == 0) && ($texto[$r] == '=')) $t = 1;
} // do for...
if (strlen($link) > 0) {
$texto = str_replace($base,'<a href="'.$link.'" target="new_window">'.$link.'</a>',$texto);
} // alterando o texto...
$i = strpos($texto,'<link=');
} // do while...
return $texto;
} // da function 
 
$erros = array("'", chr(34), "<", ">");
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
 
$l = array("result" => "OK", "id" => $novoid);
$data = JSON_encode($l);
echo $data;
} // salvando...
 
if (($act == "get") && (isset($_GET["id"]))) {
$id = str_replace($erros, "", $_GET["id"]);
 
$tp = new snapsectClass();
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

$t = '<center><table border="0">';
$t .= '<tr>';
$t .='<th TEXT-ALIGN="CENTER" width="33%">Common name (Scientific name): </th>';
$t .='<th TEXT-ALIGN="CENTER" width="33%">Described by: </th>';
$t .='<th TEXT-ALIGN="CENTER" width="33%">Collaborators: </th>';
$t.='</tr>';
$tp = new snapsectClass($id);
$res = $tp->Find("select * from [banco] ".$find.' order by commonname');
$contador = 0;
while($r=mysqli_fetch_array($res)) {
$contador++;
$tp->GetRes($r);
$T.='<Tr>';
// if (strlen($tp->photo) > 0) {
// $t.='<td<img src="http://www.snapsects.com/'.$tp->photo.'" width="125px" alt="'.$tp->commonname.'"></td>';
// } else {
// $t.='<td>No Picture</td>';
// }
$t.='<Td align="center"><a href="javascript:document.location.href='."'show_snapsect.php?id=".$tp->id."';".'">'.$tp->commonname.' ('.$tp->scientificname.')</a></td>';
$t.='<Td align="center">'.$tp->author.'</td>';
$t.='<Td align="center">'.$tp->colaborative.'</td>';
$t.='</Tr>';
} // do while
$t.='</table></center>';
if ($contador > 0) {
echo $t;
} else { echo "<center><b>Arthropoda not found...</b></center>"; }

} // do find...

if (($act == "gettext") && (isset($_GET["id"]))) {
$id = str_replace($erros, "", $_GET["id"]);
 
$ee = new snapsectClass($id);
$ee->id = $id;
// recuperando as fotos...
$ph = new snapsect_PhotoClass();
$res = $ph->Find("select * from [banco] where codid = ".$ee->id);
$lstph = array();
while($phres=mysqli_fetch_array($res)) {
$ph->GetRes($phres);
if (file_exists('photos/'.$ph->url)) {
$lstph[] = $phres;

} // encontrou...
} // do while...
$phtxt = '';
if (count($lstph) > 0) {
if (count($lstph) == 1) {
$phtxt = '<center><img src="photos/'.$lstph[0]["url"].'" width="300px" alt="'.$lstph[0]["title"].'"></center>';
$phtxt.='<center>'.$lstph[0]["obs"].'</center>';
} // apenas uma foto...
else {
$phtxt .='<table border="0" width="100%"><tr>';
$pht = 1;
for ($r=0;$r<count($lstph);$r++) {
$phtxt .= '<td width="33%"><center><img src="photos/'.$lstph[$r]["url"].'" width="300px" alt="'.$lstph[$r]["title"].'"></center>';
$phtxt.='<center>'.$lstph[$r]["obs"].'</center></td>';
$pht = $pht + 1;
if ($pht > 3) {
$pht = 1;
$phtxt.='</tr><tr>';
} // do pht >3
} // do for...
$phtxt.='</tr></table>';
} // mais que uma foto...
} // existem imagens...
// final das fotos...
$t = '';
if (strlen($ee->photo) > 0) {
$t .= '<br><center><img id="grpi" src="'.$site_url.$ee->photo.'" alt="Picture of '.$ee->commonname.' ('.$ee->scientificname.') - '.$ee->photodesc.'" width="500px" onload="redimensiona();" /></center><br>';
}
$t.=$phtxt;
$t.='<br><center><h2>Credits</h2></center><br>';
$t.='Described by: '.$ee->author.'<br>';
if (strlen($ee->email) >0) { $t.='Email: <a href="mailto:'.$ee->email.'">'.$ee->email.'</a><br>'; }
if (strlen($ee->url) >0) { $t.='Home Page: <a href="'.$ee->url.'">'.$ee->url.'</a><br>'; }
if (strlen($ee->colaborative) >0) { $t.='Collaborators: '.$ee->colaborative.'<br>'; }
$t.='<br><center><h2>Identification</h2></center><br>';
$t.='Common name: '.$ee->commonname.'<br>';
$t.='Scientific name: '.$ee->scientificname.'<br>';
$t.='Author and Date: '.$ee->other.'<br>';
$t.='Kingdom: '.$ee->kingdom.'<br>';
$t.='Phylum: '.$ee->phylum.'<br>';
$t.='Class: '.$ee->classe.'<br>';
$t.='Order: '.$ee->oorder.'<br>';
$t.='Family: '.$ee->family.'<br>';
$t.='Genus: '.$ee->genus.'<br>';
$t.='Species: '.$ee->species.'<br>';
$t.='Sex: '.$ee->gender.'<br>';
$t.='Development: '.$ee->development.'<br>';
$t.='Metamorphosis: '.$ee->metamorphosis.'<br>';
$t.='<br><center><h2>Partial Description</h2></center><br>';
$t.='Visual attributes: '.$ee->colors.'<br>';
$t.='Body: '.$ee->bbody.'<br>';
$t.='Head: '.$ee->hhead.'<br>';
$t.='Thorax: '.$ee->thorax.'<br>';
$t.='Abdomen: '.$ee->abdomen.'<br>';
$t.='Type of antennae: '.$ee->lstantennae.'<br>';
$t.='Antennae: '.$ee->antennae.'<br>';
$t.='Eyes and ocelli: '.$ee->eyesandocelli.'<br>';
$t.='Type of mouth parts: '.$ee->lstmouthparts.'<br>';
$t.='Mouth parts: '.$ee->mouthparts.'<br>';
$t.='Type of forewings: '.$ee->lstwings.'<br>';
$t.='Forewings: '.$ee->wings.'<br>';
$t.='Type of hind wings: '.$ee->lsthindwings.'<br>';
$t.='Hind wings: '.$ee->hindwings.'<br>';
$t.='Number of legs: '.$ee->lstnumlegs.'<br>';
$t.='Type of legs: '.$ee->lstlegs.'<br>';
$t.='Legs: '.$ee->locomotive.'<br>';
$t.='Tarsomere: '.$ee->tarsomere.'<br>';
$t.='Cerci: '.$ee->cerci.'<br>';
$t.='Specific characteristics: '.$ee->specificcharacteristics.'<br>';
$t.='<br><center><h2>Collection</h2></center><br>';
$t.='Collecting method: '.$ee->collecting.'<br>';
$t.='Habitat (Place of collection): '.$ee->place.'<br>';
$t.='<br><center><h2>Proemial notes</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->notes).'</p><br>';
$t.='<br><center><h2>Audio description</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->audiodesc).'</p><br>';
$t.='<br><center><h2>Mediation text</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->mediation).'</p><br>';
 $t.='<br><center><h2>Bibliography</h2></center><br>';
$t.='<p align="justify">'.texttolink(str_replace(chr(13),'<br>',$ee->water)).'</p><br>';
if (file_exists('class_text/'.$ee->classe.'.txt'))
 $t.='<br>'.str_replace('\\','',texttolink(str_replace(chr(13),'<br>',file_get_contents('class_text/'.$ee->classe.'.txt')))).'<br>';
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

if (isset($_POST["id"])) {
$id = $_POST["id"];
$ee = new snapsectClass($id);
if ($ee->id == $id) {
if (strlen($ee->photo) > 0) {
if (file_exists($ee->photo)) {
unlink($ee->photo);
} // existe a imagem da foto no servidor...
$ee->photo = '';
} // tem imagem no banco...
$ee->photodesc = '';
$ee->Save();
echo 'ok';
} // encontrou...
} // existe id.
} // removendo a imagem e o text
?>
