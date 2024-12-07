<?php
session_start();
if(file_exists("init.php")){
require_once "init.php";
} else {
die("Arquivo de init não encontrado");
}

function limpa($string){
$var = trim($string);
$var = addslashes($var);	
return $var;
}

if(getenv("REQUEST_METHOD") == "POST"){
$nome  = isset($_POST["nome"]) ? limpa($_POST["nome"]) : "";
$senha = isset($_POST["senha"]) ? limpa($_POST["senha"]) : "";

// $sql = sprintf("select count(*) from petchopp_users where login = '%s' and senha = md5('%s')", $nome, $senha);
$sql = "select count(*) from snapsect_user where email = '".$nome."' and pws = '".$senha."'";
mysql_connect(SERVIDOR, USUARIO, SENHA) or die(mysql_error());
mysql_select_db(BANCO) or die(mysql_error());

$re = mysql_query($sql) or die(mysql_error());
if(mysql_result($re, 0)){
	$re 	   = mysql_query("select * from snapsect_user where email = '$nome' and pws = '$senha';");
	$resultado = mysql_fetch_array($re);

	if($resultado["status"] > 0){
		$dados			 = array();
		$dados["nome"]	 = $nome;
		$dados["senha"]	= $senha;			
		$_SESSION["dados"] = $dados;			

		if(isset($_POST["cookie"])){			
			setcookie("dados", serialize($dados), time()+60*60*24*365);			
		}
		header("Location: index.php");
	} else {
		header("Location: login.html");
	}		
} else {
	header("Location: login.html");
}
}
?>
