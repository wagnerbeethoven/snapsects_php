<?php
if (!isset($_SESSION["ssid"])) {
session_start();
$_session["ssid"] = 0;
$_session["ssnome"] = '';
$_session["ssemail"] = '';
$_session["ssstatus"] = '';
$_session["ssurl"] = '';
} // n�o est� logado...

// if ($_SESSION["ssstatus"] == 67) {
include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
 
$erros = array("'", chr(34), "<", ">");

if (isset($_POST["enviar"])) {
// $nada = 'nada';
// file_put_contents('confirmacao.txt',$nada);

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

if (isset($_POST["lst"]))
$lst = $_POST["lst"];
$nome = str_replace(' ','_',$lst);
if (isset($_FILES["grpfoto"])) {
if (file_exists('img/'.$nome.'.jpg')) { unlink('img/'.$nome.'.jpg'); }
$ft = $_FILES["grpfoto"];
UpLoad('img/', $ft, $nome);
} // grphoto...
} // act
$id = 0;
 
 $tpl = new Template("templates/add_imagem.html");
$hoje = getdate();

if (file_exists('class_text/copyright.txt'))
$tpl->RODAPE = file_get_contents('class_text/copyright.txt');

$tpl->show(0);
// } // adm
// else {
//
// <script>
// window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
// </script>
//
// } // not adm
?>
