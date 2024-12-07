<?php
session_start();
if(file_exists("init.php")){
require_once "init.php";
} else {
die("Arquivo de init não encontrado");
}

require_once "seguranca.php";

$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);
echo "Seja Bem-Vindo ". $dados["nome"]." ";
?>
<a href="sair.php">Sair</a>
