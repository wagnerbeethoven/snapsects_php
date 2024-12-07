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
include "scripts/diclib.php";

$erros = array("'", chr(34));

$act = '';
if (isset($_POST["act"]))
$act = $_POST["act"];

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

if (($act == "gettext") && (isset($_POST["id"]))) {
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

$id = str_replace($erros, "", $_POST["id"]);
 
$ee = new snapsectClass($id);
$ee->id = $id;
$t='';
if (strlen($ee->photo) > 0) {
$t .= '<br><center><img id="grpi" src="'.$site_url.$ee->photo.'" alt="{dic219} '.$ee->commonname.' ('.$ee->scientificname.') - '.$ee->photodesc.'" width="500px" onload="redimensiona();" /></center><br>';
}
$t.='<br><center><h2>{dic220}</h2></center><br>';
$t.='{dic221}: '.$ee->author.'<br>';
if (strlen($ee->email) >0) { $t.='{dic187}: <a href="mailto:'.$ee->email.'">'.$ee->email.'</a><br>'; }
if (strlen($ee->url) >0) { $t.='{dic189}: <a href="'.$ee->url.'">'.$ee->url.'</a><br>'; }
if (strlen($ee->colaborative) >0) { $t.='{dic191}: '.$ee->colaborative.'<br>'; }
$t.='<br><center><h2>{dic222}</h2></center><br>';
$t.='{dic8}: '.$ee->commonname.'<br>';
$t.='{dic86}: '.$ee->scientificname.'<br>';
$t.='{dic88}: '.$ee->other.'<br>';
$t.='{dic89}: '.$ee->kingdom.'<br>';
$t.='{dic90}: '.$ee->phylum.'<br>';
$t.='{dic223}: '.$ee->classe.'<br>';
$t.='{dic94}: '.$ee->oorder.'<br>';
$t.='{dic19}: '.$ee->family.'<br>';
$t.='{dic97}: '.$ee->genus.'<br>';
$t.='{dic99}: '.$ee->species.'<br>';
$t.='{dic213}: '.$ee->gender.'<br>';
$t.='<br><center><h2>P{dic224}</h2></center><br>';
$t.='{dic114}: '.$ee->colors.'<br>';
$t.='{dic116}: '.$ee->bbody.'<br>';
$t.='{dic118}: '.$ee->hhead.'<br>';
$t.='{dic120}: '.$ee->thorax.'<br>';
$t.='{dic122}: '.$ee->abdomen.'<br>';
$t.='{dic198}: '.$ee->lstantennae.'<br>';
$t.='{dic126}: '.$ee->antennae.'<br>';
$t.='{dic128}: '.$ee->eyesandocelli.'<br>';
$t.='{dic199}: '.$ee->lstmouthparts.'<br>';
$t.='{dic131}: '.$ee->mouthparts.'<br>';
$t.='{dic200}: '.$ee->lstwings.'<br>';
$t.='{dic134}: '.$ee->wings.'<br>';
$t.='{dic201}: '.$ee->lsthindwings.'<br>';
$t.='{dic137}: '.$ee->hindwings.'<br>';
$t.='{dic202}: '.$ee->lstnumlegs.'<br>';
$t.='{dic203}: '.$ee->lstlegs.'<br>';
$t.='{dic204}: '.$ee->locomotive.'<br>';
$t.='{dic205}: '.$ee->tarsomere.'<br>';
$t.='{dic206}: '.$ee->cerci.'<br>';
$t.='{dic207}: '.$ee->specificcharacteristics.'<br>';
$t.='<br><center><h2>{dic225}</h2></center><br>';
$t.='{dic208}: '.$ee->development.'<br>';
$t.='{dic112}: '.$ee->metamorphosis.'<br>';
$t.='{dic153}: '.$ee->collecting.'<br>';
$t.='{dic155}: '.$ee->place.'<br>';
$t.='<br><center><h2>{dic170}</h2></center><br>';
$t.=str_replace(chr(13),'<br>',$ee->notes).'<br>';
$t.='<br><center><h2>{dic174}</h2></center><br>';
$t.=str_replace(chr(13),'<br>',$ee->audiodesc).'<br>';
$t.='<br><center><h2>{dic168}</h2></center><br>';
$t.=str_replace(chr(13),'<br>',$ee->mediation).'<br>';
 $t.='<br><center><h2>{dic177}</h2></center><br>';
$t.=texttolink(str_replace(chr(13),'<br>',$ee->water)).'<br>';
if (file_exists('class_text/'.$ee->classe.'.txt'))
 $t.='<br>'.texttolink(str_replace(chr(13),'<br>',file_get_contents('class_text/'.$ee->classe.'.txt'))).'<br>';

$l = array('userid' => $ee->userid, 'users' => $ee->ground, 'commonname' => $ee->commonname.', '.$ee->scientificname, 'text' => $t);
echo JSON_encode($l);
 
} // retornando texto

if ($act == "cmdforget") {
$language = '';
if (isset($_POST["lang"]))
$language = $_POST["lang"];
if (strlen($language) < 5) { $language='pt-br'; }
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);
$msg = '';
if (strlen($email) < 5) {
$msg = '275';
} else {
$tp = new snapsect_UserClass();
$tp->OpenEmail($email);
if ($tp->id < 1) {
$msg = '302';
} // usuario nao encontrado
else {
$temp = opendicionario($language);
$dic = $temp["dic"];

enviaremail($email,$dic[304],$dic[305].':<br>'.$tp->pws, $server_name, $server_email,$server_email);
$msg = '303';
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
// $author = str_replace(' ','_',$_POST["author"]);
// $email = $_POST["email"];
// $texto = str_replace('\\','',$_POST["texto"]);
// $logo = '<center><img src="'.$site_url.'img/logo_application.jpeg" width="150px"></center><hr>';
// $img = $_POST['photo'];
// if (strlen($img) > 0) {
// $nnomme = $email;
// $diretorio = 'temp/';
// while (file_exists($diretorio.$nnomme.".jpg")) {
// $contador++;
// $nnomme=$email.$contador;
// } // do while
// $imagem_nome = $nnomme.".jpg";

// $img = str_replace('data:image/jpeg;base64,', '', $img);
// $img = str_replace(' ', '+', $img);
// $data = base64_decode($img);
// $file = $diretorio . $imagem_nome;
// file_put_contents($file, $data);

// $texto = $logo.'<center><img src=$site_url.$file.'" width="300px"></center><br>'.$texto;
// }
// else { $texto = $logo.$texto; }
// enviaremail('limafj.us@gmail.com','SnapSects School - '.str_replace('_',' ',$author).' send arthropod...',$texto, 'SnapSect Administrator', $server_email,$email);
// $texto = '<center><img src="'.$site_url.'img/logo_application.jpeg" width="300px"></center>';
// $texto .= '<center>Thanks for your participation!!!</center><br>';
// $texto.='<p>Your audio description was successfully received.</p>';
// enviaremail($email,'SnapSects School - '.str_replace('_',' ',$author).' send arthropod...',$texto, 'SnapSect Administrator', $server_email,'limafj.us@gmail.com');
// echo strlen($texto);
} // do envio do e-mail...

if ($act == "nuser") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros, "", $_POST["email"]);
 
if (strlen($email) > 0) {
$tp = new snapsect_UserClass();
 $res = $tp->Find('select * from [banco] where email="'.$email.'"');
$contador = 0;
while($r=mysqli_fetch_array($res)) { $contador = $contador + 1; }
if ($contador < 1) {
$tp->id = 0;
$tp->email = $email;
$tp->status = 0;
 
if (isset($_POST["nome"]))
$tp->nome = str_replace($erros, "", $_POST["nome"]);
  
if (isset($_POST["pws"]))
$tp->pws = str_replace($erros, "", $_POST["pws"]);
 
if (isset($_POST["url"]))
$tp->url = str_replace($erros, "", $_POST["url"]);
 
if (isset($_POST["obs"]))
$tp->obs = str_replace($erros, "", $_POST["obs"]);
 
$tp->Save();
$lang = '';
if (isset($_POST["lang"]))
$lang = $_POST['lang'];
if (strlen($lang) < 1) { $lang = 'pt-br'; }
opendicionario($lang);
enviaremail($email,$dic[312],$dic[313].'<a href="'.$site_url.'snapsect_user_api.php?act=confemail&email='.$email.'">'.$dic[314].'</a>', $server_name, $server_email,$server_email);

$l = array("result" => "311");
$data = JSON_encode($l);
echo $data;
} // usuario novo
else {
echo JSON_encode(array('result' => '310'));
} // email ja existente...
} // campo email nao é vazio
else {
echo JSON_encode(array('result' => '308'));
} // campo email vazio...
} // do novo usuario

if ($act == "deluser") {
if (isset($_POST["id"])) {
$id = $_POST["id"];
$ee = new snapsect_UserClass();
$ee->Open($id);
if ($_POST["email"] == $ee->email) {
$ee->Delete($id);
echo JSON_encode(array('result' => 'ok'));
} // pode remover...
else {
echo JSON_encode(array('result' => 'error'));
}
} // tem o id...
else {
echo JSON_encode(array('result' => 'error'));
}

} // removendo usuario
?>