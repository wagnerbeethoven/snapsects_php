<?php

if(!function_exists('getdic2'))
{
function getdic2($text) {
$lista = array();
$linha = explode(chr(13).chr(10),$text);
$comando = 0;
$old = '';
$nome = '';
$controle = '';
foreach($linha as $l) {
if (strpos(' '.$l,'[name]') > 0) {
$comando = 1;
} else {
if ($comando == 1) {
$nome = $l; 
$comando = 0;
} else {
if (strpos(' '.$l,'[controler]') > 0) {
$comando = 2;
} else {
if ($comando == 2) {
$controle = $l;
$comando = 3;
} else {
if ($l[0] <> '[') {
$lista[$old] = $l;
} // adiciona...
else {
$old = str_replace('[','',$l);
$old = str_replace(']','',$old);
} // identifica o valor do numero
}
}
}
}
} // do for...
$r = array('name' => $nome, 'controler' => $controle, 'dic' => $lista);
return $r;
} // da funcao
}
if(!function_exists('getdic'))
{
function getdic($text) {
$lista = array();
$linha = explode(chr(13).chr(10),$text);
$comando = 0;
foreach($linha as $l) {
if (strpos(' '.$l,'[name]') > 0) {
$comando = 1;
} else {
if ($comando == 1) {
$nome = $l; 
$comando = 0;
} else {
if (strpos(' '.$l,'[controler]') > 0) {
$comando = 2;
} else {
if ($comando == 2) {
$controle = $l;
$comando = 3;
} else {
if ($l[0] <> '[') $lista[] = $l;
}
}
}
}
} // do for...
$r = array('name' => $nome, 'controler' => $controle, 'dic' => $lista);
return $r;
} // da funcao
}

if(!function_exists('opendicionario'))
{
function opendicionario($lang) {
if (file_exists('dic/'.$lang.'.lang')) {
$text = file_get_contents('dic/'.$lang.'.lang');
return getdic($text);
} else {
$text = file_get_contents('dic/pt-br.lang');
return getdic($text);
} 
}// da funcao
}

if(!function_exists('convertpage'))
{
function convertpage($texto, $lang) {
$ddic = opendicionario($lang);
$dic = $ddic["dic"];
$len = count($dic);
for ($r=0;$r<$len;$r++) {
$texto = str_replace('{dic'.$r.'}',$dic[$r],$texto);
} // do for...
return $texto;
} // da funcao.
}
?>