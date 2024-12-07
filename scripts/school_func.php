<?php
if(!function_exists('getdic2')) {
include "scripts/diclib.php";
}

function deltree($d) {
$pasta = $d;
if ($pasta[strlen($pasta)-1] <> '/') { $pasta.='/'; }
$diretorio= dir($d);
while($arquivo= $diretorio-> read()){
if (is_dir($pasta.$arquivo)) {
if (strlen($arquivo) > 2) { 
deltree($pasta . $arquivo);
 }
} // diretorio...
else {
unlink($pasta . $arquivo);
} // arquivo...
} // do while
$diretorio-> close();
rmdir($pasta);
} // da funcao...

function getnic($e) {
if (strlen($e) < 1) { return ''; }
else {
if (!file_exists('school/'.$e.'/nic.txt')) { return ''; }
else {
return file_get_contents('school/'.$e.'/nic.txt');
} // existe diretorio...
} // existe email...
} // da funcao...

function setindex($e,$s) {
$pasta = 'school/'.$e.'/'.$s;
if (file_exists($pasta.'/exerciceos')) {
$l = '';
$diretorio= dir($pasta.'/exerciceos');
while($arquivo= $diretorio-> read()){
if (is_dir($pasta.'/exerciceos/'.$arquivo)) {
if (strlen($arquivo) > 2) { 
if (file_exists($pasta.'/exerciceos/'.$arquivo.'/published.txt')) {
if (file_get_contents($pasta.'/exerciceos/'.$arquivo.'/published.txt') == '1') {
$texto = file_get_contents($pasta.'/exerciceos/'.$arquivo.'/quest.txt');
$ll = explode(chr(13).chr(10),$texto);
list($title, $datai,$dataf,$datag,$nota) = explode('|',$ll[0]);
$l.= $arquivo.'|'.$title.'|'.$datai.chr(13).chr(10);
} // ok, pode inserir...
} // arquivo published.txt...
 }
} // diretorio...
} // do while
$diretorio-> close();
file_put_contents($pasta.'/indice.txt',$l);
} // existe a pasta...
} // da funcao...

function getsalas($email) {
$l = array();
if (strlen($email) > 3) {
if (file_exists('school/'.$email)) {
$diretorio= dir('school/'.$email);
while($arquivo= $diretorio-> read()){
if (is_dir('school/'.$email.'/'.$arquivo)) {
if (strlen($arquivo) > 2) { 
$l[] = str_replace('_',' ',$arquivo); 
 }
} // diretorio...
} // do while
$diretorio-> close();
} // diretorio existe...
} // email existe...
sort($l);
return $l;
} // do get sala...

function addsala($email, $sala) {
if (strlen($email) > 1) {
if (file_exists('school/'.$email)) {
if (strlen($sala) > 0) {
mkdir('school/'.$email.'/'.$sala);
mkdir('school/'.$email.'/'.$sala.'/leituras');
mkdir('school/'.$email.'/'.$sala.'/exerciceos');
} // sala nao vazia...
} // existe pasta...

} // existe email...
} // da funcao do add sala...

function getquest($email, $sala, $id, $nome) {
$licao = array('titulo' => '', 'datai' => '', 'dataf' => '', 'datag' => '', 'nota' => '', 'quest' => array());
if ((strlen($email) > 0) && (strlen($sala) > 0) && (strlen($id) > 0)) {
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$nome)) {
$texto = file_get_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$nome);
$l = explode(chr(13).chr(10), $texto);
list($title, $qtexto, $qfoto, $datai, $dataf, $datag, $nota) = explode('|',$l[0]);
// if (strlen($qfoto) > 0) {
// if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$qfoto)) { } else { $qfoto = ''; }
// } // resolvendo as fotos...
$quest = array();
for ($r=1;$r<count($l);$r++) {
if (strlen($l[$r]) > 0) {
list($texto, $enunciado,$foto, $valor, $tipo, $resultado, $o, $o2) = explode('|',$l[$r]);
// if (strlen($foto) > 0) {
// if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$foto)) { } else { $foto = ''; }
// } // resolvendo as fotos...
if ($enunciado == 'null') { $enunciado = ''; }
if (strlen($texto.$enunciado) > 0) {
$opc = explode('_',$o);
$opcoes = array();
for ($rr=0;$rr<count($opc);$rr++) {
if (strlen($opc[$rr]) > 0) {
list($optitle, $opvalue) = explode('#',$opc[$rr]);
$opcoes[] = array('title' => $optitle, 'value' => $opvalue);
}
} // do for...
$opcoes2 = explode('_',$o2);
$quest[] = array('texto' => $texto, 'enunciado' => $enunciado, 'foto' => $foto, 'valor' => $valor, 'nota' => 0, 'tipo' => $tipo, 'resultado' => $resultado, 'resposta' => '', 'opcoes' => $opcoes, 'opcoes2' => $opcoes2);
} // nao está vazio...
} // l nao vazio
} // do for...
$licao = array('titulo' => $title, 'texto' => $qtexto, 'foto' => $qfoto, 'datai' => $datai, 'dataf' => $dataf, 'datag' => $datag, 'nota' => $nota, 'quest' => $quest);
} // arquivo existe...
} // email existe
return $licao;
} // da funcao getquest

function clearquest($licao) {
for ($r=0;$r<count($licao["quest"]);$r++) {
$quest = $licao["quest"][$r];
$quest["resultado"] = '';
for ($t=0;$t<count($quest["opcoes"]);$t++) {
$temp = $quest["opcoes"][$t];
$temp["value"] = '0';
$quest["opcoes"][$t] = $temp;
} // do t.
$licao["quest"][$r] = $quest;
} // do for r...
return $licao;
} // da funcao...

function getleitura($email, $sala, $id) {
$texto = '';
if (file_exists(str_replace(' ','_','school/'.$email.'/'.$sala.'/leituras/'.$id.'.txt'))) {
$texto = file_get_contents(str_replace(' ','_','school/'.$email.'/'.$sala.'/leituras/'.$id.'.txt'));
} // existe arquivo...
return $texto;
} // da funcao...

function getresp($email,$sala,$id,$prova) {
$l = array();
$pasta = 'school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$prova;
if (file_exists($pasta)) {
$texto = file_get_contents($pasta);
$ll = explode(chr(13).chr(10), $texto);
for ($r=0;$r<count($ll);$r++) {
if (strlen($ll[$r]) > 0) {
list($resposta, $opcoes) = explode('|',$ll[$r]);
$opc = explode('_',$opcoes);
$l[] = array('resposta' => $resposta, 'opc' => $opc);
} // nao está vazia...
} // do for...

} // existe o arquivo.
return $l;
} // da funcao...

function expandresp($texto) {
$l = array();
if (strlen($texto) > 0) {
$ll = explode(chr(13).chr(10), $texto);
for ($r=0;$r<count($ll);$r++) {
if (strlen($ll[$r]) > 0) {
list($resposta, $opcoes) = explode('|',$ll[$r]);
$opc = explode('_',$opcoes);
$l[] = array('resposta' => $resposta, 'opc' => $opc);
} // nao está vazia...
} // do for...

} // existe o arquivo.
return $l;
} // da funcao...

function getcorrecao($email, $sala, $id, $prova) {
$l = array();
$quest = getquest($email,$sala,$id,'quest.txt');
$resp = getresp($email,$sala,$id,$prova.'.school');
$ja = 0;
if (file_exists('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$prova.'.ok')) {
$ja = 1;
$jatxt = file_get_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$prova.'.ok');
$jalines = explode(chr(13).chr(10), $jatxt);
$janota = $jalines[0];
} // existe correcao...
$valor = $quest["nota"] / count($quest["quest"]);
for ($r = 0;$r<count($quest["quest"]);$r++) {
$quest2 = $quest["quest"][$r];
$resp2 = $resp[$r];
if ($quest["quest"][$r]["tipo"] > 0) {
$subvalor = $quest2["valor"] / count($quest2["opcoes"]);
} else {
$subvalor = $quest2["valor"];
}
$subnota = 0;
$err = array();
if ($quest["quest"][$r]["tipo"] == 0) {
$err[] = array('title' => '', 'errado' => $resp[$r]["resposta"], 'correto' => $quest["quest"][$r]["resultado"]);
} else {

for ($rr=0;$rr<count($quest2["opcoes"]);$rr++) {
if (($quest["quest"][$r]["opcoes"][$rr]["value"] == $resp[$r]["opc"][$rr]) && ($quest["quest"][$r]["opcoes"][$rr]["value"] != '0')) { $subnota = $subnota + $subvalor; }
else {
if ($quest["quest"][$r]["tipo"] == '1') {
if (($quest["quest"][$r]["opcoes"][$rr]["value"] == '1') || ($resp[$r]["opc"][$rr] == '1')) {
$err[] = array('title' => $quest["quest"][$r]["opcoes"][$rr]["title"], 'errado' => $resp[$r]["opc"][$rr], 'correto' => $quest["quest"][$r]["opcoes"][$rr]["value"]);
} // mostra...
} else {
$err[] = array('title' => $quest["quest"][$r]["opcoes"][$rr]["title"], 'errado' => $resp[$r]["opc"][$rr], 'correto' => $quest["quest"][$r]["opcoes"][$rr]["value"]);
} // tipo diferente de 1
}
} // do for rr...
} // tipo diferente de 0
if ($ja == 0) {
$l[] = array('total' => $valor, 'nota' => $subnota, 'obs' => '', 'valor' => $subvalor,'title' => $quest["quest"][$r]["enunciado"], 'erros' => $err);
} else {
list($jjc, $jjv) = explode('|',$jalines[$r+1]);
$l[] = array('total' => $valor, 'nota' => $jjv, 'obs' => $jjc, 'valor' => $subvalor,'title' => $quest["quest"][$r]["enunciado"], 'erros' => $err);
} // já com valores
} // do for...
return array('valor' => $valor, 'quest' => $l);
} // da funcao...


function getquestmix($email, $sala, $id, $prova) {
$l = array();
$quest = getquest($email,$sala,$id,'quest.txt');
$ga = 0;
$correcao = [];
$tmp = '';
$ttmp = '';
$ts = new snapsects_ProvasClass();
$res = $ts->Find('select * from [banco] where provaid="'.$id.'" and email="'.$email.'" and sala="'.$sala.'" and aluno="'.$prova.'"');
if (mysqli_num_rows($res) > 0) {
while($nn=mysqli_fetch_array($res)) {
$ts->GetRes($nn);
$tmp = $ts->correcao;
$ttmp = $ts->prova;
} // do while...
}
if (strlen($tmp) < 1) { $quest = clearquest($quest); }
else {
$ga = 1;
// $tmp = file_get_contents('school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/'.$prova.'.ok');
$ltmp = explode(chr(13).chr(10), $tmp);
$quest["nota"] = $ltmp[0];
for ($rr=1;$rr<count($ltmp);$rr++) {
if (strlen($ltmp[$rr]) > 0) {
list($comentario, $valor) = explode('|',$ltmp[$rr]);
$correcao[] = array('comentario' => $comentario, 'valor' => $valor);
} // linha cheia
} // do for...
} // existe a correcao
$resp = expandresp($ttmp);
for ($r=0;$r<count($quest["quest"]);$r++) {
$quest2 = $quest["quest"][$r];
if ($r < count($resp)) {
$quest["quest"][$r]["resposta"] = $resp[$r]["resposta"];
$quest["quest"][$r]["opcoes2"] = $resp[$r]["opc"];
} // existem respostas...
if ($ga > 0) {
$quest["quest"][$r]["nota"] = $correcao[$r]["valor"];
} // existe correcao...
} // do for...
return array('quest' => $quest, 'correcao' => $correcao);
} // da funcao...

function getnomeprova($email, $sala, $id) {
$d = 'school/'.$email.'/'.$sala.'/exerciceos/'.$id.'/quest.txt';
if (file_exists($d)) {
$texto = file_get_contents($d);
$lista = explode(chr(13).chr(10), $texto);
list($tit,$text) = explode('|',$lista[0]);
return $tit;
} else {
return '';
}
} // da funcao...

function delaluno($email,$sala,$aluno) {
$tp = new snapsects_SalasClass();
$res = $tp->Find('delete from [banco] where aluno="'.$aluno.'" and sala="'.$sala.'" and email="'.$email.'"');
$ts = new snapsects_ProvasClass();
$res = $ts->Find('delete from [banco] where aluno="'.$aluno.'" and sala="'.$sala.'" and email="'.$email.'"');

} // da funcao...

function delalunos($email,$sala) {
$tp = new snapsects_SalasClass();
$res = $tp->Find('delete from [banco] where email="'.$email.'" and sala="'.$sala.'"');
$ts = new snapsects_ProvasClass();
$res = $ts->Find('delete from [banco] where email="'.$email.'" and sala="'.$sala.'"');

} // da funcao...

function delprovaaluno($email,$sala,$id,$aluno) {
$tp = new snapsects_ProvasClass();
$res = $tp->Find('delete from [banco] where provaid="'.$id.'" and aluno="'.$aluno.'" and email="'.$email.'" and sala="'.$sala.'"');

} // da funcao...

function delprova($email, $sala, $id) {
$tp = new snapsects_ProvasClass();
$res = $tp->Find('delete from [banco] where provaid="'.$id.'" and email="'.$email.'" and sala="'.$sala.'"');
} // da funcao...
