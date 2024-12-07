<?php
session_start();
if (!isset($_SESSION["teste"])) {
echo 'nao existe o teste.<br>';
$_SESSION["teste"] = "Testelino";
echo "Ok, criei o teste com o texto: ".$_SESSION["teste"].'<br>';
} else {
echo 'existe o teste. '.$_SESSION["teste"].'<br>';
$_SESSION["teste"] = null;
session_destroy();
echo 'Ok, removi o teste...<br>';
}

if (!isset($_COOKIE["teste"])) {
echo 'nao existe cookie.<br>';
setcookie("teste", serialize('apenas um texto...'), time()+60*60*24*365);			
$teste = unserialize($_COOKIE["teste"]);
echo 'ok, adicionei o cookie: '.$teste.'<br>';
} else {
$teste = unserialize($_COOKIE["teste"]);
echo 'existe cookie.'.$teste.'<br>';
setcookie("teste", "", time()-60*60*24*365);
echo 'ok, removi o cookie.<br>';
}

if ((!isset($_COOKIE["teste"]) and (!isset($_SESSION["teste"])))) {
echo 'nenhum está com valor...<br>';
} else {
echo 'alguem esta com valor...<br>';
} // algum esta ok...
?>