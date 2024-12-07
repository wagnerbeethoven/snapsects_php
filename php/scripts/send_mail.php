<?php
function converte($v) {
if (mb_detect_encoding($v, 'UTF-8, ISO-8859-1, ASCII') !== 'UTF-8') { return utf8_encode($v); } else { return $v; }
} // da funcao...

function envservidor($destinatario, $assunto, $mensagem, $nome, $de,$responder){

	$email_remetente = $de;

$email_destinatario = $destinatario;
	$email_reply = $responder;
	$email_assunto = utf8_encode($assunto);

	$email_conteudo = converte($mensagem);

	$email_headers = implode ( "\n",array ( "From: $email_remetente", "Reply-To: $email_reply", "Subject: $email_assunto","Return-Path:  $email_remetente","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );
	if (mail ($email_destinatario, $email_assunto, nl2br($email_conteudo), $email_headers)){
return 0;
	}
  	else {
return 1;
	} // do if
} // da function

	function enviaremail($destinatario,$assunto,$mensagem, $nome, $de,$responder){
return envservidor($destinatario,$assunto,$mensagem, $nome, $de,$responder);
} // da function
?>
