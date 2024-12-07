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
include "scripts/send_mail.php";
include "scripts/diclib.php";

$erros = array("'", chr(34));

$act = '';
if (isset($_POST["act"]))
$act = $_POST["act"];

if ($act == "login") {
if ($users->login() == true) {
if (file_exists('school/'.$_SESSION["ssemail"].'/nic.txt')) {
echo JSON_encode(array('status' => $_SESSION["ssstatus"], 'id' => $_SESSION["ssid"], 'nome' => $_SESSION["ssnome"], 'token' => $_SESSION["token"], 'nic' => file_get_contents('school/'.$_SESSION["ssemail"].'/nic.txt')));
} else {
echo JSON_encode(array('status' => $_SESSION["ssstatus"], 'id' => $_SESSION["ssid"], 'nome' => $_SESSION["ssnome"], 'token' => $_SESSION["token"]));
} // demais....
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
$id = str_replace($erros, "", $_POST["id"]);
 
$lang = $_SESSION["language"];
if (isset($_POST["lang"]))
$lang = str_replace($erros, "", $_POST["lang"]);
if (strlen($lang) < 1) { $lang='pt-br'; }
$_SESSION["language"] = $lang;
$ddic = opendicionario($lang);
$dic = $ddic["dic"];
$uid = 0;
if (isset($_POST["uid"]))
$uid = $_POST["uid"];
$ust = 0;
if ($uid > 0) {
$tp = new snapsect_UserClass($uid);
$ust = $tp->status;
} // existe usuário...
$ll = gettextfunction($id,$dic,$lang,$uid,$ust);
echo JSON_encode($ll);
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
$ddic = opendicionario($lang);
$dic = $ddic["dic"];
$prof=isset($_POST["prof"])? $_POST["prof"]:'0';
enviaremail($email,$dic[312],$dic[313].'<a href="'.$site_url.'snapsect_user_api.php?act=confemail&email='.$email.'&prof='.$prof.'">'.$dic[314].'</a>', $server_name, $server_email,$server_email);

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

if ($act == "getphotodesc") {
$id = 0;
if (isset($_POST["id"]))
$id = $_POST["id"];
if ($id > 0) {
$nome = '';
if (isset($_POST["foto"]))
$nome = $_POST["foto"];
if (strlen($nome) > 0) {
$lang = 'pt-br';
if (isset($_POST["lang"]))
$lang = $_POST["lang"];

$x = explode('.',$nome);
$xx = $x[0].'.txt';
$p = 'photos/'.$lang[0].$lang[1].'/'.$id.'/'.$xx;
if (file_exists($p)) echo JSON_encode(array('alt' => file_get_contents($p)));
else echo JSON_encode(array('alt' => ''));
} // existe nome da imagem...
} // existe id...
} // da funcao...

if ($act == "addphotodesc") {
$id = 0;
if (isset($_POST["id"]))
$id = $_POST["id"];
if ($id > 0) {
$nome = '';
if (isset($_POST["foto"]))
$nome = $_POST["foto"];
if (strlen($nome) > 0) {
$lang = 'pt-br';
if (isset($_POST["lang"]))
$lang = $_POST["lang"];
$text = '';
if (isset($_POST["text"]))
$text = $_POST["text"];
$x = explode('.',$nome);
$xx = $x[0].'.txt';
$p = 'photos/'.$lang[0].$lang[1].'/'.$id.'/'.$xx;
file_put_contents($p,$text);
echo 'ok';
} // existe nome da imagem...
} // existe id...
} // da funcao...

?>