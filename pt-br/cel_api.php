<?php
if (!isset($_SESSION["ssid"])) {
session_start();
$_session["ssid"] = 0;
$_session["ssnome"] = '';
$_session["ssemail"] = '';
$_session["ssstatus"] = '';
$_session["ssurl"] = '';
} // não está logado...

include "scripts/config.php";
include "scripts/snapsect_class.php";
include "scripts/snapsect_userclass.php";
include "scripts/send_mail.php";

$erros = array("'", chr(34));

if (isset($_POST["act"]))
$act = $_POST["act"];

if ($act == "getger") {

$ee = new snapsectClass;

$other = array();
$res = $ee->Find("select distinct(other) from [banco] order by other");
while($r=mysqli_fetch_array($res)) {
if (strlen($r["other"]) > 0) {
$other[] = $r["other"];
} // nao esta vazio.
} // do while.

$order = array();
$res = $ee->Find("select distinct(oorder) from [banco] order by oorder");
while($r=mysqli_fetch_array($res)) {
if (strlen($r["oorder"]) > 0) {
$order[] = $r["oorder"];
} // nao esta vazio...
} // do while.

echo JSON_encode(array('other' => $other, 'order' => $order));
} // da funcao - pega combobox do index... (snapsect_ger)

if ($act == "login") {

if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);

if (isset($_POST["pws"]))
$pws = str_replace($erros, "", $_POST["pws"]);

$tp = new snapsect_UserClass();
$ok = 0;
$uid = 0;
$unome = '';
$res = $tp->Find('select * from [banco] where email="'.$email.'" and pws="'.$pws.'" and status > 0;');
while($r=mysqli_fetch_array($res)) {
$tp->GetRes($r);
$_SESSION["ssid"] = $tp->id;
$_SESSION["ssnome"] = $tp->nome;
$_SESSION["ssemail"] = $tp->email;
$_SESSION["ssstatus"] = $tp->status;
$_SESSION["ssurl"] = $tp->url;
$uid = $tp->id;
$unome = $tp->nome;
$ok = $tp->status;
} // do while.

if ($ok > 0) {
echo JSON_encode(array('status' => $ok, 'id' => $uid, 'nome' => $unome));
} else {
echo JSON_encode(array('status' => -1));
} // nao logou...
} // do login.

if (($act == "gettext") && (isset($_GET["id"]))) {
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

$id = str_replace($erros, "", $_GET["id"]);
 
$ee = new snapsectClass($id);
$ee->id = $id;
$t='';
if (strlen($ee->photo) > 0) {
$t .= '<br><center><img id="grpi" src="'.$site_url.$ee->photo.'" alt="Picture of '.$ee->commonname.' ('.$ee->scientificname.') - '.$ee->photodesc.'" width="500px" onload="redimensiona();" /></center><br>';
}
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
$t.='Development: '.$ee->development.'<br>';
$t.='Metamorphosis: '.$ee->metamorphosis.'<br>';
$t.='Collecting method: '.$ee->collecting.'<br>';
$t.='Habitat (Place of collection): '.$ee->place.'<br>';
$t.='<br><center><h2>Proemial notes</h2></center><br>';
$t.=str_replace(chr(13),'<br>',$ee->notes).'<br>';
$t.='<br><center><h2>Audio description</h2></center><br>';
$t.=str_replace(chr(13),'<br>',$ee->audiodesc).'<br>';
$t.='<br><center><h2>Mediation text</h2></center><br>';
$t.=str_replace(chr(13),'<br>',$ee->mediation).'<br>';
 $t.='<br><center><h2>Bibliography</h2></center><br>';
$t.=texttolink(str_replace(chr(13),'<br>',$ee->water)).'<br>';
if (file_exists('class_text/'.$ee->classe.'.txt'))
 $t.='<br>'.texttolink(str_replace(chr(13),'<br>',file_get_contents('class_text/'.$ee->classe.'.txt'))).'<br>';

$l = array('userid' => $ee->userid, 'users' => $ee->ground, 'text' => $t);
echo JSON_encode($l);
 
} // retornando texto

if ($act == "cmdforget") {

if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);
$msg = '';
if (strlen($email) < 5) {
$msg = 'Write your email!';
} else {
$tp = new snapsect_UserClass();
$tp->OpenEmail($email);
if ($tp->id < 1) {
$msg = 'User not found...';
} // usuario nao encontrado
else {
enviaremail($email,'SnapSect - Send your login. - no reply','Your Password:<br>'.$tp->pws, $server_name, $server_email,$server_email);
$msg = 'Sending your password for your email address...';
} // encontrou o usuario, envia email...
} // email nao vazio...
echo $msg;
} // enviando senha por email...

if ($act == "logout") {
if ($_SESSION["ssid"] > 0) {
$_SESSION["ssid"] = 0;
$_SESSION["ssnome"] = '';
$_SESSION["ssemail"] = '';
$_SESSION["ssstatus"] = 0;
$_SESSION["ssurl"] = '';
echo 'ok';
} // logout...
} // logout

if ($act == "download") {
$arq = $_POST["arq"];
if (file_exists('class_text/'.$arq.'.txt')) {
echo str_replace('\\','',str_replace(chr(13),'<br>',file_get_contents('class_text/'.$arq.'.txt')));
} // encontrou...

} // do download

if ($act == "sendemail") {
$author = str_replace(' ','_',$_POST["author"]);
$email = $_POST["email"];
$texto = str_replace('\\','',$_POST["texto"]);
$logo = '<center><img src="'.$site_url.'img/logo_application.jpeg" width="150px"></center><hr>';
$img = $_POST['photo'];
if (strlen($img) > 0) {
$nnomme = $email;
$diretorio = 'temp/';
while (file_exists($diretorio.$nnomme.".jpg")) {
$contador++;
$nnomme=$email.$contador;
} // do while
$imagem_nome = $nnomme.".jpg";

$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $diretorio . $imagem_nome;
file_put_contents($file, $data);

$texto = $logo.'<center><img src=$site_url.$file.'" width="300px"></center><br>'.$texto;
}
else { $texto = $logo.$texto; }
enviaremail('limafj.us@gmail.com','SnapSects School - '.str_replace('_',' ',$author).' send arthropod...',$texto, 'SnapSect Administrator', $server_email,$email);
$texto = '<center><img src="'.$site_url.'img/logo_application.jpeg" width="300px"></center>';
$texto .= '<center>Thanks for your participation!!!</center><br>';
$texto.='<p>Your audio description was successfully received.</p>';
enviaremail($email,'SnapSects School - '.str_replace('_',' ',$author).' send arthropod...',$texto, 'SnapSect Administrator', $server_email,'limafj.us@gmail.com');
// file_put_contents('resultado.txt',$texto);
echo strlen($texto);
} // do envio do e-mail...
?>