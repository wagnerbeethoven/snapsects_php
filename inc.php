<?php
session_start();
include "scripts/config.php";
$erros = array('index.php', 'index.html', '.html', '.php', '..');

$act = '';
if (isset($_POST["act"]))
  $act = str_replace($erros, '', $_POST["act"]);

if (strlen($act) > 0) {
  if ($act == 'del') {
    $e = 'error';
    $txt = 'no email';
    $email = '';
    if (isset($_POST["email"]))
      $email = str_replace($erros, '', $_POST["email"]);
    if (strlen($email) > 0) {
      $txt = 'no sala';
      $sala = '';
      if (isset($_POST["sala"]))
        $sala = str_replace(' ', '_', str_replace($erros, '', $_POST["sala"]));
      if (strlen($sala) > 0) {
        $txt = 'no id';
        $id = '';
        if (isset($_POST["id"]))
          $id = str_replace(' ', '_', str_replace($erros, '', $_POST["id"]));
        if (strlen($id) > 0) {
          $txt = 'no foto';
          $foto = '';
          if (isset($_POST["foto"]))
            $foto = $_POST["foto"];
          if (strlen($foto) > 0) {
            $txt = 'not found: ' . 'school/' . $email . '/' . $sala . '/exerciceos/' . $id . '/' . $foto;
            if (file_exists('school/' . $email . '/' . $sala . '/exerciceos/' . $id . '/' . $foto)) {
              $e = 'ok';
              $txt = 'success';
              unlink('school/' . $email . '/' . $sala . '/exerciceos/' . $id . '/' . $foto);
            } // removendo as fotos...
            else {
            } // erro a pasta nao existe...
          } // das fotos.
        } // do id
      } // da sala...
    } // do email
    echo JSON_encode(array('status' => $e, 'msg' => $txt));
  } // da funcao del
} // act valido
else {
  if (isset($_FILES['file'])) {
    $nome = str_replace('|', '/', $_FILES['file']["name"]);
    if (strlen($nome) > 0) {
      // $x = explode('_',$nome);
      // $n = $x[0].'/'.$x[1].'/';
      // $nome = substr($nome,strlen($n));
      // file_put_contents('teste.txt',$nome);
      if (strlen($users->log->verifyupload($_FILES['file'])) > 0) {
        move_uploaded_file($_FILES['file']["tmp_name"], 'school/' . $nome);
      }
    } // existe nome...
  } // existe arquivo...
} // act vazio...