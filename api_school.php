<?php
session_start();
include "scripts/config.php";
include "scripts/snapsect_class.php";
include "scripts/send_mail.php";
include "scripts/diclib.php";
include "scripts/school_func.php";
include "scripts/snapsects_alunosclass.php";

$erros = array("'", chr(34));

$act = '';
if (isset($_POST["act"]))
$act = $_POST["act"];

if ($act == "getsalas") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
echo JSON_encode(array('salas' => getsalas($email)));
} // do get sala...

if ($act == "addsala") {
$email = '';
if (isset($_POST["email"]))
$email = $_POST["email"];
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',$_POST["sala"]);
addsala($email, $sala);
} // do add sala...

if ($act == "getshow") {
$e = 0;
$email = '';
if (isset($_POST["email"]))
$email = $_POST["email"];
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
$l = array();

$ts = new snapsects_ProvasClass();

if (strlen($sala) > 0) {
$diretorio= dir('school/'.$email.'/'.$sala.'/exerciceos');
while($arquivo= $diretorio-> read()){
if (is_dir('school/'.$email.'/'.$sala.'/exerciceos/'.$arquivo)) {
if (strlen($arquivo) > 2) { 
// $l[] = str_replace('_',' ',$arquivo); 
$texto = '';
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$arquivo.'/quest.txt')) { $texto = file_get_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$arquivo.'/quest.txt'); }
$px = explode(chr(13).chr(10),$texto);
list($title, $datai, $dataf, $datag,$nota) = explode('|',$px[0]);
$show = '0';
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$arquivo.'/published.txt')) { $show = file_get_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$arquivo.'/published.txt'); }

// pegar aqui os corrigidos e nao...

$provas = array();
$corrigidas = array();

$res = $ts->Find('select * from [banco] where provaid="'.$arquivo.'" and email="'.$email.'" and sala="'.$sala.'"');
while($nn=mysqli_fetch_array($res)) {
$ts->GetRes($nn);
if (strlen($ts->correcao) > 0) {
$corrigidas[] = array('nota' => $ts->nota,'aluno' => $ts->aluno, 'nome' => $ts->nome);
} // corrigido
else {
$provas[] = array('aluno' => $ts->aluno, 'nome' => $ts->nome);
} // aguardando correcao...
} // do while...
$l[] = array('id' => $arquivo, 'title' => $title, 'visible' => $show, 'corrigidas' => $corrigidas, 'provas' => $provas);
 }
} // diretorio...
} // do while
$diretorio-> close();
// agora as leituras...
$ll = array();
$diretorio= dir('school/'.$email.'/'.$sala.'/leituras');
while($arquivo= $diretorio-> read()){
if (strlen($arquivo) > 2) { 
$ll[] = str_replace('.txt','',str_replace('_',' ',$arquivo)); 
 }
} // do while
$diretorio-> close();
// agora as provas...
for ($r = 0;$r<count($l);$r++) {
$temp = array();
$cor = array();
$diretorio= dir('school/'.$email.'/'.$sala.'/exerciceos/'.$l[$r]["id"]);
while($arquivo= $diretorio-> read()){
if (strlen($arquivo) > 2) { 
if (strpos($arquivo,'.school') > -1) {
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$l[$r]["id"].'/'.str_replace('.school','.ok',$arquivo))) {
$minitemp = file_get_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$l[$r]["id"].'/'.str_replace('.school','.ok',$arquivo));
$minil = explode(chr(13).chr(10),$minitemp);
$cor[] = array('nota' => $minil[0], 'title' => str_replace('.school','',str_replace('_',' ',$arquivo))); 
} else {
$temp[] = str_replace('.school','',str_replace('_',' ',$arquivo)); 
} // 
} // encontrou...
 }
} // do while
$diretorio-> close();
if (count($temp)+ count($cor) > 0) {
$provas[] = array('id' => $l[$r]["id"], 'title' => $l[$r]["title"], 'provas' => $temp, 'corrigidas' => $cor);
} // existe arquivos, adiciona...
} // do for...
// agora os alunos convidados...
$lll = array();
$tp = new snapsects_SalasClass();
$res = $tp->Find('select * from [banco] where email = "'.$email.'" and sala = "'.str_replace('_',' ',$sala).'"');
while($nv=mysqli_fetch_array($res)) {
$lll[] = array('nome' => $nv["nome"], 'email' => $nv["aluno"]);
} // do while
echo JSON_encode(array('exerciceos' => $l, 'leituras' => $ll, 'alunos' => $lll));
$e = 1;

} // existe sala...
} // existe e-mail...
if ($e == 0) {
$px = array();
echo JSON_encode(array('exerciceos' => $px, 'leituras' => $px));
} // nao envia nada...
} // do getshow...

if ($act == "addquest") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
if (file_exists('school/'.$email)) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 1) {
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos')) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);
if ((strlen($id) < 1) || ($id == '0')) { $id = Time(); }
if (!file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id)) { mkdir('school/'.$email.'/'.$sala.'/exerciceos/'.$id); }
$h = '';
if (isset($_POST["header"]))
$h = str_replace($erros,'',$_POST["header"]).chr(13).chr(10);
$contador = 0;
if (isset($_POST["count"]))
$contador = str_replace($erros,'',$_POST["count"]);
if ($contador < 0) { $contador = 0; }
for ($r=0;$r<$contador;$r++) {
if (isset($_POST["quest".$r]))
$h.=str_replace($erros,'',$_POST["quest".$r]).chr(13).chr(10);
} // do for...
file_put_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/quest.txt',$h);
echo JSON_encode(array('status' => 'ok', 'results' => $id));
setindex($email, $sala);
// incluir aqui o index...
} else {
echo JSON_encode(array('status' => 'error','results' => 'no email'));
} // diretorio da sala nao existe.
} else {
echo JSON_encode(array('status' => 'error','results' => 'no email'));
} // sala nao existe.
} else {
echo JSON_encode(array('status' => 'error','results' => 'no email'));
} // nao existe o diretorio
} else {
echo JSON_encode(array('status' => 'error','results' => 'no email'));
} // email vazio...
} // da funcao add quest

if ($act == "getquest") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);

$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));

$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);

$licao = getquest($email, $sala, $id, 'quest.txt');
if (strlen($licao["titulo"]) > 0) { $status = 'ok'; } else { $status = 'error'; }
echo JSON_encode(array('status' => $status, 'licao' => $licao));
} // da funcao getquest

if ($act == "getquestschool") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);

$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));

$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);

$licao = getquest($email, $sala, $id, 'quest.txt');
if (strlen($licao["titulo"]) > 0) { 
$status = 'ok'; 
$licao = clearquest($licao);
} else { $status = 'error'; }
echo JSON_encode(array('status' => $status, 'licao' => $licao));
} // da funcao getquest

if ($act == "getquestschool2") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);

$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));

$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);

if ((strlen($email) > 0) && (strlen($sala) > 0) && (strlen($id) > 0)) {
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/quest.txt')) {
$texto = file_get_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/quest.txt');
$l = explode(chr(13).chr(10), $texto);
list($title, $qtexto, $qfoto, $datai, $dataf, $datag, $nota) = explode('|',$l[0]);
$quest = array();
for ($r=1;$r<count($l);$r++) {
if (strlen($l[$r]) > 0) {
list($texto, $enunciado, $foto, $valor, $tipo, $resultado, $o, $o2) = explode('|',$l[$r]);
if ($enunciado == 'null') { $enunciado = ''; }
if (strlen($texto.$enunciado) > 0) {
$opc = explode('_',$o);
$opcoes = array();
for ($rr=0;$rr<count($opc);$rr++) {
if (strlen($opc[$rr]) > 0) {
list($optitle, $opvalue) = explode('#',$opc[$rr]);
$opcoes[] = array('title' => $optitle, 'value' => '0');
}
} // do for...
$opcoes2 = explode('_',$o2);
$quest[] = array('texto' => $texto, 'enunciado' => $enunciado, 'foto' => $foto, 'valor' => $valor, 'tipo' => $tipo, 'resultado' => $resultado, 'opcoes' => $opcoes, 'opcoes2' => $opcoes2);
} // nao está vazio...
} // l nao vazio
} // do for...
$licao = array('titulo' => $title, 'texto' => $qtexto, 'foto' => $qfoto, 'datai' => $datai, 'dataf' => $dataf, 'datag' => $datag, 'nota' => $nota, 'quest' => $quest);
echo JSON_encode(array('status' => 'ok', 'licao' => $licao));
} // arquivo existe...
} // email existe
} // da funcao getquestschool

if ($act == 'addconv') {
$profid = 0;
if (isset($_POST["profid"]))
$profid = str_replace($erros,'',$_POST["profid"]);
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
if (file_exists('school/'.$email)) {
$aluno = '';
if (isset($_POST["aluno"]))
$aluno = str_replace($erros,'',$_POST["aluno"]);
if (strlen($aluno) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace($erros,'', $_POST["sala"]);
if (strlen($sala) > 0) {
// adicionar aqui o aluno...
$tp = new snapsects_AlunosClass();
$res = $tp->Find('select * from [banco] where email = "'.$aluno.'"');
if (mysqli_num_rows($res) > 0) {
while($nv=mysqli_fetch_array($res)) {
$tp->GetRes($nv);
$nsalas = $tp->SaveSala($profid, $email, $sala, getnic($email));
} // do while...
echo JSON_encode(array('status' => 'ok', 'aluno' => $tp->id, 'sala' => $nsalas));
} else {
$tp->id = 0;
$tp->nome = '';
$tp->datacad = Time();
$tp->pws = '';
$tp->email = $aluno;
$tp->ukey = '';
$nid = $tp->Save();
$nsalas = $tp->SaveSala($profid, $email, $sala, getnic($email));
echo JSON_encode(array('status' => 'ok', 'aluno' => $nid, 'sala' => $nsalas));
} // salvando...
} else {
echo JSON_encode(array('status' => 'error', 'errorcode' => 'no email'));
} // nao tem sala...
} else {
echo JSON_encode(array('status' => 'error', 'errorcode' => 'no email'));
} // nao tem aluno
} else {
echo JSON_encode(array('status' => 'error', 'errorcode' => 'no email'));
} // diretorio nao existe...
} else {
echo JSON_encode(array('status' => 'error', 'errorcode' => 'no email'));
} // nao tem email...
} // da funcao addconv

if ($act == 'getconv') {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {

$tp = new snapsects_AlunosClass();
$ok = '';
if ($tp->OpenEmail($email) == false) {
echo JSON_encode(array('status' => 'not added'));
} else {
if (strlen($tp->pws) == 0) {
echo JSON_encode(array('status' => 'newuser'));
} else {
$token = '';
if (isset($_POST["token"]))
$token = str_replace($erros,'',$_POST["token"]);
if ($token != $tp->ukey) {
echo JSON_encode(array('status' => 'login'));
} else {
$sl = new snapsects_SalasClass();
$rr = $sl->Find('select * from [banco] where userid='.$tp->id);
$la = array();
while($nn=mysqli_fetch_array($rr)) {
$la[] = array('name' => $nn["prof"], 'sala' => $nn["sala"], 'email' => $nn["email"]);
} // do while

echo JSON_encode(array('status' => 'ok', 'results' => $la));
} // token diferente...
}

}
} else {
echo JSON_encode(array('status' => 'error'));
} // nao tem email...
} // da funcao...

if ($act == "setindex") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 0) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);
if (strlen($id) > 0) {
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id)) {
$valor = '';
if (isset($_POST["value"]))
$valor = str_replace($erros,'',$_POST["value"]);
if (strlen($valor) > 0) {
file_put_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/published.txt',$valor);
setindex($email,$sala);
echo 'ok';
} // existe valor...
} // pasta existe...
} // existe o id...
} // existe sala
} // existe email...
} // da funcao...

if ($act == "getsalasschool") {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
$aluno = '';
if (isset($_POST["userid"]))
$aluno = str_replace($erros,'',$_POST["userid"]);
$leituras = array();
if (file_exists('school/'.$email.'/'.$sala.'/leituras')) {
$d = 'school/'.$email.'/'.$sala.'/leituras/';
$diretorio= dir($d);
while($arquivo= $diretorio-> read()){
if (!is_dir($d.$arquivo)) {
if (strpos($arquivo,'.txt') > -1) { $leituras[] = $arquivo; }
} // arquivo...
} // do while
$diretorio-> close();
} // existe pasta...
// final da leitura sugerida...
$lixo = '  ';
$corrigidos = array();
$provas = array();
$tp = new snapsects_ProvasClass();
$res = $tp->Find('select * from [banco] where aluno="'.$aluno.'" and email="'.$email.'" and sala="'.$sala.'"');
while($nn=mysqli_fetch_array($res)) {
$tp->GetRes($nn);
$titulo = getnomeprova($email, $sala, $tp->provaid);
if (strlen($tp->correcao) > 0) {
$corrigidos[] = array('id' => $tp->provaid, 'title' => $titulo, 'nota' => $tp->nota);
} else {
$provas[] = array('id' => $tp->provaid, 'title' => $titulo);
}
$lixo.='|'.$tp->provaid.'|';
} // do while
// dos exercicios respondidos ou corrigidos...

// agora as provas por fazer sugeridos...
$sugeridos = array();
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos')) {
$d = 'school/'.$email.'/'.$sala.'/exerciceos/';
$diretorio= dir($d);
while($arquivo= $diretorio-> read()){
if ((is_dir($d.$arquivo)) && (strlen($arquivo) > 2)) {
if (strpos($lixo, '|'.$arquivo.'|') < 1) { 
// verificar se está visivel...
if (file_exists($d.$arquivo.'/published.txt')) {
if (file_get_contents($d.$arquivo.'/published.txt') == '1') {
$sugeridos[] = array('id' => $arquivo, 'title' => getnomeprova($email, $sala, $arquivo)); 
} // esta publicado...
} // existe o published...
} // encontrou...
} // arquivo...
} // do while
$diretorio-> close();
} // existe pasta...
// final dos sugeridos...

echo JSON_encode(array('status' => 'ok', 'leituras' => $leituras, 'corrigidos' => $corrigidos, 'provas' => $provas, 'sugeridos' => $sugeridos));

} // da funcao...

if ($act == "getschoolshow") {
$seunome = '';
if (isset($_POST["nome"]))
$seunome = str_replace(' ','_',$_POST["nome"]);
$sala = '';
if (isset($_POST["salas"]))
$sala = str_replace($erros,'',$_POST["salas"]);
if (strlen($sala) > 0) {
$l = explode('#',$sala);
$ll = array();
$leituras = array();
for ($r=0;$r<count($l);$r++) {
if (strlen($l[$r]) > 0) {
list($email,$pst) = explode('|',$l[$r]);
// pegando as leituras sugeridas...
if (file_exists('school/'.$email.'/'.$pst.'/leituras')) {
$d = 'school/'.$email.'/'.$pst.'/leituras/';
$nic = getnic($email);
$diretorio= dir($d);
while($arquivo= $diretorio-> read()){
if (!is_dir($d.$arquivo)) {
if (strpos($arquivo,'.txt') > -1) { $leituras[] = array('email' => $email,'nic' => $nic, 'sala' => $pst, 'title' => $arquivo); }
} // arquivo...
} // do while
$diretorio-> close();

} // existe pasta...
// final da leitura sugerida...
if (file_exists('school/'.$email.'/'.$pst.'/indice.txt')) {
$texto = file_get_contents('school/'.$email.'/'.$pst.'/indice.txt');
$nic = getnic($email);
$x = explode(chr(13).chr(10),$texto);
for ($rr=0;$rr<count($x);$rr++) {
$suanota = 0;
if (strlen($x[$rr]) > 0) {
list($id, $title, $datai) = explode('|',$x[$rr]);
if (file_exists('school/'.$email.'/'.$pst.'/exerciceos/'.$id.'/'.$seunome.'.school')) { 
$existe = 1; 
if (file_exists('school/'.$email.'/'.$pst.'/exerciceos/'.$id.'/'.$seunome.'.ok')) {  
$existe = 2; 
$templ = file_get_contents('school/'.$email.'/'.$pst.'/exerciceos/'.$id.'/'.$seunome.'.ok');
$templl = explode(chr(13).chr(10),$templ);
$suanota = $templl[0];
}
} else { $existe = 0; }
$ll[] = array('email' => $email, 'sala' => $pst, 'nic' => $nic, 'id' => $id, 'title' => $title, 'datai' => $datai, 'show' => $existe, 'nota' => $suanota);
} // linha nao vazia...
} // do for....
} // existe indice...
} // existe linha
} // do for...
echo JSON_encode(array('status' => 'ok', 'results' => $ll, 'leituras' => $leituras));
} // existe sala...
} // da funcao getschoolshow...

if ($act == 'delquest') {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 0) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);
if (strlen($id) > 0) {
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id)) {
deltree('school/'.$email.'/'.$sala.'/exerciceos/'.$id);
delprova($email, $sala, $id);
echo JSON_encode(array('status' => 'ok'));
} // file exists do id
} // existe id
} // existe sala
} // existe email
} // da funcao delquest...

if ($act == 'delsala') {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 0) {
if (file_exists('school/'.$email.'/'.$sala)) {
deltree('school/'.$email.'/'.$sala);
// agora removendo todos os usuarios da sala...
delalunos($email,$sala);
echo JSON_encode(array('status' => 'ok'));
} // file exists do id
} // existe sala
} // existe email
} // da funcao delsala

if ($act == "addleitura") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 0) {
$title = '';
if (isset($_POST["title"]))
$title = str_replace(' ','_',str_replace($erros,'',$_POST["title"]));
if (strlen($title) > 0) {
$text = '';
if (isset($_POST["text"]))
$text = str_replace($erros, '', $_POST["text"]);
if (file_exists('school/'.$email.'/'.$sala.'/leituras')) {
file_put_contents('school/'.$email.'/'.$sala.'/leituras/'.$title.'.txt', $text);
echo JSON_encode(array('status' => 'ok'));
} // existe pasta...
} // existe title...
} // existe sala
} // existe email...
} // da funcao...

if ($act == "getleitura") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 0) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace(' ','_',str_replace($erros,'',$_POST["id"]));
if (strlen($id) > 0) {
if (file_exists('school/'.$email.'/'.$sala.'/leituras/'.$id.'.txt')) {
$texto = getleitura($email, $sala, $id);
$l = array('titulo' => $id, 'text' => $texto);
echo JSON_encode(array('status' => 'ok', 'leitura' => $l));
} // existe arquivo...
} // do id
} // da sala
} // do email...
} // da funcao...

if ($act == "delleitura") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 0) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace(' ','_',str_replace($erros,'',$_POST["id"]));
if (strlen($id) > 0) {
if (file_exists('school/'.$email.'/'.$sala.'/leituras/'.$id.'.txt')) {
unlink('school/'.$email.'/'.$sala.'/leituras/'.$id.'.txt');
echo JSON_encode(array('status' => 'ok'));
} // existe arquivo...
} // do id
} // da sala
} // do email...
} // da funcao...

if ($act == "addquestschool") {
$userid = '';
if (isset($_POST["userid"]))
$userid = str_replace(' ','_',str_replace($erros,'',$_POST["userid"]));
$username = '';
if (isset($_POST["username"]))
$username = str_replace(' ','_',str_replace($erros,'',$_POST["username"]));

$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
if (file_exists('school/'.$email)) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 1) {
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos')) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);
if (strlen($id) < 1) { $id = Time(); }
if (!file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id)) { mkdir('school/'.$email.'/'.$sala.'/exerciceos/'.$id); }
$contador = 0;
$h='';
if (isset($_POST["count"]))
$contador = str_replace($erros,'',$_POST["count"]);
if ($contador < 0) { $contador = 0; }
for ($r=0;$r<$contador;$r++) {
if (isset($_POST["quest".$r]))
$h.=str_replace($erros,'',$_POST["quest".$r]).chr(13).chr(10);
} // do for...
$tp = new snapsects_ProvasClass();
$tp->id = 0;
$tp->provaid = $id;
$tp->email = $email;
$tp->sala = $sala;
$tp->aluno = $userid;
$tp->nome = $username;
$tp->prova = $h;
$tp->correcao = '';
$tp->nota = '';
$tp->dataprova = date('d/m/Y H:i');
$tp->datacorrecao = '';
$tp->Save();
// file_put_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$userid.'.school',$h);
echo JSON_encode(array('status' => 'ok', 'results' => $id));
// setindex($email, $sala);
// incluir aqui o index...
} else {
echo JSON_encode(array('status' => 'error','results' => 'no sala directory'));
} // diretorio da sala nao existe.
} else {
echo JSON_encode(array('status' => 'error','results' => 'no sala'));
} // sala nao existe.
} else {
echo JSON_encode(array('status' => 'error','results' => 'no directory '.$email));
} // nao existe o diretorio
} else {
echo JSON_encode(array('status' => 'error','results' => 'no email'));
} // email vazio...
} // da funcao add questschool

if ($act == "delconv") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace($erros,'',$_POST["sala"]);
if (strlen($sala) > 0) {
$aluno = '';
if (isset($_POST["aluno"]))
$aluno = str_replace($erros,'',$_POST["aluno"]);
if (strlen($aluno) > 0) {
delaluno($email,$sala,$aluno);
echo JSON_encode(array('status' => 'ok'));
} // do aluno...
} // da sala
} // do email
} // da funcao...

if ($act == "getcorrecao") {
$re = 'error';
$resultado = array();
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 0) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace(' ','_',str_replace($erros,'',$_POST["id"]));
if (strlen($id) > 0) {
$prova = '';
if (isset($_POST["prova"]))
$prova = str_replace(' ','_',str_replace($erros,'',$_POST["prova"]));
if (strlen($prova) > 0) {
$re = 'ok';
$quest = getquest($email,$sala,$id,'quest.txt');
$resp = array();
$ts = new snapsects_ProvasClass();
$res = $ts->Find('select * from [banco] where provaid='.$id.' and aluno="'.$prova.'" and sala="'.$sala.'" and email="'.$email.'"');
while($nn=mysqli_fetch_array($res)) {
$ts->GetRes($nn);
$resp = expandresp($ts->prova);
$temp = $ts->correcao;
} // do while
// $resp = getresp($email, $sala, $id, $prova.'.school');
$ok = array();
if (strlen($temp) > 0) {
$ltemp = explode(chr(13).chr(10), $temp);
$nota = $ltemp[0];
$ll = array();
for ($r=1;$r<count($ltemp);$r++) {
if (strlen($ltemp[$r]) > 0) {
list($obs, $valor) = explode('|',$ltemp[$r]);
$ll[] = array('obs' => $obs, 'nota' => $valor);
} // nao vazio...
} // do for...
$ok = array('nota' => $nota, 'quest' => $ll);
} // existe correcao...
$incompleto = 0;
if (count($quest["quest"]) == count($resp)) {
// verificando as opcoes-itens...
for ($r=0;$r<count($quest["quest"]);$r++) {
if (count($quest["quest"][$r]["opcoes"]) > count($resp[$r]["opc"])) { $incompleto = 1; }
} // do for...
$resultado = array('quest' => $quest, 'resp' => $resp, 'ok' => $ok);
} else{
$resultado = array();
$incompleto = 1;
}
if ($incompleto == 1) {
unlink('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$prova.'.school');
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$prova.'.ok')) { unlink('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$prova.'.ok'); }
$re = 'changed';
} // removendo e alterando a resposta do servidor...
} // da prova...
} // do id
} // da sala
} // do email
echo JSON_encode(array('status' => $re, 'results' => $resultado));
} // da funcao...

if ($act == "sendimage") {
if (isset($_FILES["file"])) {
file_put_contents('school/chegueiaki.txt',$_FILES['arquivo']["size"]);
} else {
file_put_contents('school/naochegueiaki.txt','nada');
}
} // da funcao...

if ($act == "setcorrecao") {
$re = 'error';
$resultado = array();
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));
if (strlen($sala) > 0) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace(' ','_',str_replace($erros,'',$_POST["id"]));
if (strlen($id) > 0) {
$prova = '';
if (isset($_POST["prova"]))
$prova = str_replace(' ','_',str_replace($erros,'',$_POST["prova"]));
if (strlen($prova) > 0) {
$re = 'ok';
$t = '';
$nota = '';
if (isset($_POST["nota"]))
$nota = $_POST["nota"];
$t=$nota.chr(13).chr(10);
$contador = 0;
if (isset($_POST["contador"]))
$contador = str_replace($erros,'',$_POST["contador"]);
for ($r=0;$r<$contador;$r++) {
$t.=$_POST['quest'.$r].chr(13).chr(10);
} // do for...
$tp = new snapsects_ProvasClass();
$res = $tp->Find('select * from [banco] where provaid='.$id.' and aluno="'.$prova.'" and sala="'.$sala.'" and email="'.$email.'"');
while($nn=mysqli_fetch_array($res)) {
$tp->GetRes($nn);
$tp->correcao = $t;
$tp->nota = str_replace($erros,'',$_POST["nota"]);
$tp->Save();
// file_put_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$prova.'.ok',$t);
} // do while
$resultado = 'ok';
} // da prova...
} // do id
} // da sala
} // do email
echo JSON_encode(array('status' => $re, 'results' => $resultado));
} // da funcao...

if ($act == "getgabarito") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);

$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace(' ','_',str_replace($erros,'',$_POST["sala"]));

$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);
$prova = '';
if (isset($_POST["prova"]))
$prova = str_replace(' ','_',str_replace($erros,'',$_POST["prova"]));

$llicao = getquestmix($email, $sala, $id, $prova);
$licao = $llicao["quest"];
if (strlen($licao["titulo"]) > 0) { 
$status = 'ok'; 
// $licao = clearquest($licao);
} else { $status = 'error'; }
echo JSON_encode(array('status' => $status, 'licao' => $llicao));
} // da funcao getquest

if ($act == "setlogin") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$tp = new snapsects_AlunosClass();
if ($tp->OpenEmail($email) == true) {
$nome = '';
if (isset($_POST["nome"]))
$nome = str_replace($erros,'',$_POST["nome"]);
$pws = '';
if (isset($_POST["pws"]))
$pws = str_replace($erros,'',$_POST["pws"]);
$tp->nome = $nome;
$tp->pws = sha1($pws);
$tp->ukey = base64_encode($tp->datacad);
$tp->Save();
$ts = new snapsects_SalasClass();
$ppx = $ts->Find('select * from [banco] where aluno="'.$email.'"');
if (mysqli_num_rows($ppx) > 0) {
while($nn=mysqli_fetch_array($ppx)) {
$ts->GetRes($nn);
$ts->nome = $nome;
$ts->Save();
} // do while
} // existem linhas...
echo JSON_encode(array('status' => 'ok', "token" => $tp->ukey));
} // existe usuario...
else {
echo JSON_encode(array('status' => 'error'));
} // nao existe usuario...
} // existe email...
else {
echo JSON_encode(array('status' => 'error'));
} // nao existe email...
} // da funcao...

if ($act == "verifyemail") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 4) {
$tp = new snapsects_AlunosClass();
if ($tp->OpenEmail($email) == true) {
if (strlen($tp->pws) > 0) {
echo JSON_encode(array('status' => 'ok'));
} else {
echo JSON_encode(array('status' => 'add'));
}
} else {
echo JSON_encode(array('status' => 'error'));
}
} else {
echo JSON_encode(array('status' => 'error'));
}
} // da funcao...

if ($act == "login") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 4) {
$tp = new snapsects_AlunosClass();
if ($tp->OpenEmail($email) == true) {
if (strlen($tp->pws) > 0) {
$pws = '';
if (isset($_POST["pws"]))
$pws = str_replace($erros,'',$_POST["pws"]);
if ($tp->pws == sha1($pws)) {
$tp->datacad = Time();
$tp->ukey = base64_encode($tp->datacad);
$tp->Save();
echo JSON_encode(array('status' => 'ok', 'nome' => $tp->nome, 'token' => $tp->ukey));
} else {
echo JSON_encode(array('status' => 'error'));
}
} else {
echo JSON_encode(array('status' => 'add'));
}
} else {
echo JSON_encode(array('status' => 'error'));
}
} else {
echo JSON_encode(array('status' => 'error'));
}
} // da funcao...

if ($act == "anulaprova") {
$email = '';
if (isset($_POST["email"]))
$email = str_replace($erros,'',$_POST["email"]);
if (strlen($email) > 0) {
$sala = '';
if (isset($_POST["sala"]))
$sala = str_replace($erros,'',$_POST["sala"]);
if (strlen($sala) > 0) {
$aluno = '';
if (isset($_POST["aluno"]))
$aluno = str_replace($erros,'',$_POST["aluno"]);
if (strlen($aluno) > 0) {
$id = '';
if (isset($_POST["id"]))
$id = str_replace($erros,'',$_POST["id"]);
if (strlen($id) > 0) {
delprovaaluno($email, $sala, $id, $aluno);
} // do id...
} // do aluno
} // da sala...
} // do email
echo JSON_encode(array('status' => 'ok'));
} // da funcao...