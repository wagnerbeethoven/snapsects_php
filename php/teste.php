﻿<?php
ini_set('upload_max_filesize','50M');
ini_set('post_max_size', '50M');

$erros = array('index.php','index.html','.html','.php','..');
if (isset($_FILES['file'])) {
$nome = str_replace($erros,'',$_FILES['file']["name"]);
if (strlen($nome) > 0) {
$x = explode('_',$nome);
$n = $x[0].'/'.$x[1].'/';
$nome = substr($nome,strlen($n));
// file_put_contents('log.txt',$nome);
move_uploaded_file($_FILES['file']["tmp_name"], 'photos/'.$n.$nome);
} // existe nome...
} // existe arquivo...