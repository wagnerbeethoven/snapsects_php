<?php
 function MacAdressByWindows(){

  $ipAddress = getRealIPAddress();

  #run the external command, break output into lines
  exec("arp -a $ipAddress", $output);
  $IpMac = explode(" ", trim($output[3]));
  return $IpMac[11];

 }
 function getRealIPAddress(){  

  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
   //check ip from share internet
   $ip = $_SERVER['HTTP_CLIENT_IP'];
  }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
   //to check ip is pass from proxy
   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
   $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;

 }
class segurancaClass {
public $nomearq;
public $badarq;
public $ip;
public $log = '';
public $badlog = '';

public function verifyupload($f) {
$nome= $f['name'];
$extensao= strtolower(pathinfo( $nome, PATHINFO_EXTENSION));
if( strstr( '.jpg;.jpeg;.gif;.png;.wav;.m4a;.mp3;.mov;.avi;.mp4;.3gpp', $extensao) ) {
$novoNome= uniqid ( time () ) . '.'.$extensao;
return $novoNome;
} else {
if( strstr( '.htm;.html;.php;.exe;.com;.js;.asp;.aspx', $extensao) ) {
$this->addbad(date('d/m/Y H:i').' - Tentativa de inject file: '.$nome);
} // tentativa de invasao...
return '';
} // extensao proibidas
} // da funcao...

public function executa() {
header("location: 'http://www.google.com.br';");
?>
<script>
var a="71324sdwq23plksz";
window.location='http://www.google.com.br';
</script>
<?php
} // executa a acao de bloqueio...

public function add() {
$this->log.='|'.$this->ip.'|';
file_put_contents($this->nomearq, $this->log);
$this->executa();
} // da funcao...

public function addbad($text) {
$this->badlog.='|'.$this->ip.'|'.chr(13).chr(10).$text.chr(13).chr(10);
file_put_contents($this->badarq, $this->badlog);
// $this->executa();
} // da funcao...

public function __construct() {
$this->ip = $_SERVER['REMOTE_ADDR'].':'.$_SESSION["ssid"]; // gethostbyaddr($_SERVER['REMOTE_ADDR']);
$this->nomearq = 'log/bloqueio/'.date('Y-m-d').'.txt';
$this->badarq = 'log/bloqueio/badip.txt';
if (!file_exists('log')) { mkdir('log'); }
if (!file_exists('log/bloqueio')) { mkdir('log/bloqueio'); }
if (file_exists($this->badarq)) { $this->badlog = file_get_contents($this->badarq); }
if (file_exists($this->nomearq)) { $this->log = file_get_contents($this->nomearq); }
if ((strpos(' '.$this->log, '|'.$this->ip.'|') > 0) or (strpos(' '.$this->badlog, '|'.$this->ip.'|') > 0)) {
$this->executa();
} // sai do site...
} // da funcao...

} // da classe...
