<?php
include "scripts/seguranca.php";

$lst_type = array();
$lst_type["0"] = 286;
$lst_type["1"] = 287;
$lst_type["5"] = 288;
$lst_type["50"] = 289;
$lst_type["67"] = 290;

class snapsect_UserClass {
public $log;
public $nomebanco="snapsect_user";
public $mycon;
public $id = 0;
public $status = 0;
public $datacad = '';
public $nome;
public $email;
public $pws;
public $url;
public $obs;
public $lang = 'pt-br';
public $token = '';
public $school = '';
 
public function getid() {
return intval($this->id);
} // da funcao getid
public function getstatus() {
return intval($this->status);
} // da funcao getstatus
public function getdatacad() {
return $this->datacad;
} // da funcao getdatacad
public function getnome() {
return $this->nome;
} // da funcao getnome
public function getemail() {
return $this->email;
} // da funcao getemail
public function getpws() {
return $this->pws;
} // da funcao getpws
public function geturl() {
return $this->url;
} // da funcao geturl
public function getobs() {
return $this->obs;
} // da funcao getobs

public function getlang() {
return $this->lang;
} // da funcao getlang

public function getschool() {
return $this->school;
} // da funcao getschool

public function gettoken() {
return $this->token;
} // da funcao gettoken

public function GetRes($nv) {
$this->id = $nv["id"];
$this->status = $nv["status"];
$this->datacad = $nv["datacad"];
$this->nome = $nv["nome"];
$this->email = $nv["email"];
$this->pws = $nv["pws"];
$this->url = $nv["url"];
$this->obs = $nv["obs"];
$this->lang = $nv["lang"];
$this->school = $nv["school"];
$this->token = $nv["token"];
} // da funcao GetRes
 
public function ClearAll() {
$this->id = 0;
$this->status = 0;
$this->datacad="";
$this->nome="";
$this->email="";
$this->pws="";
$this->url="";
$this->obs="";
$this->lang="";
$this->school="";
$this->token='';
} // da funcao clearall
 
public function Open($n) {
$sql = "select * from snapsect_user where id = $n";
$res=mysqli_query($this->mycon, $sql);
$this->GetRes(mysqli_fetch_array($res));
} // da funcao open...
 
public function OpenEmail($n) {
$sql = "select * from snapsect_user where email = '$n'";
$res=mysqli_query($this->mycon, $sql);
$this->GetRes(mysqli_fetch_array($res));
} // da funcao open email...

public function Save() {
// ajustando a data...
if (strlen($this->datacad) < 1) { $this->datacad = date("Y-m-d H:i:s"); }
// verificando se a chave já existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update snapsect_user set status=".$this->status.",datacad='".$this->datacad."', nome='".$this->nome."', email='".$this->email."', pws='".$this->pws."', url='".$this->url."', obs='".$this->obs."', lang='".$this->lang."', school='".$this->school."', token='".$this->token."' where id = $this->id";
else
$sql = "insert into snapsect_user(status,datacad,nome,email,pws,url,obs,lang,school,token) values(".$this->status.",'".$this->datacad."', '".$this->nome."', '".$this->email."', '".md5($this->pws)."', '".$this->url."', '".$this->obs."', '".$this->lang."', '".$this->school."', '".$this->token."')";
$res=mysqli_query($this->mycon, $sql);
$this->OpenEmail($this->email);
return $this->id;
} // da funcao save
 
public function Create_Table() {
$sql="DROP TABLE IF EXISTS snapsect_user;";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE snapsect_user(id INT AUTO_INCREMENT PRIMARY KEY, status INT, datacad TEXT, nome TEXT, email TEXT, pws TEXT, url TEXT, obs TEXT, lang TEXT, school TEXT, token TEXT );";
$res=mysqli_query($this->mycon, $sql);
} // da criacao da tabela
 
public function Delete($n) {
$sql = "delete from ".$this->nomebanco." where id=$n";
$res=mysqli_query($this->mycon, $sql);
} // da function delete...
 
public function Find($sql) {
$sql=str_replace("[banco]", $this->nomebanco, $sql);
$res = mysqli_query($this->mycon, $sql);
return $res;
} // da funcao find...
 
public function __construct($id = 0) {
$this->log = new segurancaClass();
$this->mycon = mysqli_connect(DBSERV, DBUSER, DBPASS,DBDB);  
if(0!=$id) $this->Open($id);

$this->verifylogin();
} // do create...

public function geratoken() {
$l = array($this->id,$this->status);
$t = '';
while(strlen($t) < 32) {
$t.=rand(0,9);
}
$p = 0;
for ($rr=0;$rr<count($l);$rr++) {
$v=rand(1,9);
$t[$p]=$v;
$id = $l[$rr];
$t[$v+$p]=strlen($id);
for ($r=0;$r<strlen($id);$r++) {
$t[$p+$v+1+$r]=$id[$r];
} // do for...
$p=($p+$v+strlen($id)+1);
if ($rr == count($l)-1) {
$t[$p]='0';
$p=$p+1;
} // ultimo valor...
if (strlen($t) <= ($p+3)) { 
for ($x=0;$x<16;$x++) {
$t.=rand(0,9); 
} // do for...
} // do if
} // do for...
$this->token = $t;
return $t;
} // da funcao

public function gettokenid($t) {
$l = array();
$err = 1;
$p = 0;
$ok=1;
while($ok == 1) {
$p=$p+$t[$p];
$c = $t[$p];
if ($c == '0') { 
$err = 0;
$ok = 0; 
}
else {
if (($p+$c+1) > strlen($t)) { return -1; }
$v = '';
for ($rr=1;$rr<=$c;$rr++) {
$v.=$t[$p+$rr];
} // do for...
$l[]=$v;
$p=$p+$c+1;
if ($p < strlen($t)) { $ok = 1; } else { $ok = 0; }
}
} // do while...
if ($err == 1) return -1;
// if ($x >= count($l)) return '';
// return $l[$x];
return $l;
} // da funcao...

public function login() {
$email = (isset($_POST["email"]))?$_POST["email"]:'';
$pws = (isset($_POST["pws"]))?md5($_POST["pws"]):'';
$ret = true;
if (($email == '') or ($pws == '')) $ret = false;
else {
$ok = 0;
$res = $this->Find('select * from [banco] where email="'.$email.'" and pws="'.$pws.'" and status > 0;');
if (mysqli_num_rows($res) < 1) $ret = false;
else {
while($r=mysqli_fetch_array($res)) {
$this->GetRes($r);
$_SESSION["ssid"] = $this->id;
$_SESSION["ssnome"] = $this->nome;
$_SESSION["ssemail"] = $this->email;
$_SESSION["ssstatus"] = $this->status;
$_SESSION["ssurl"] = $this->url;
if (strlen($this->token) < 1) {
$this->token = $this->geratoken();
$this->Save();
} // cria o token e salva o cadastro...
$_SESSION["token"]=$this->token;
// file_put_contents('nada.txt',$_SESSION["ssid"]);
$dados = array();
$dados["nome"] = $this->nome;
$dados["token"] = $this->token;
$dados["id"] = $this->id;

if (strlen($this->lang) > 0) $_SESSION["language"]=$this->lang;
setcookie("dados", serialize($dados), time()+60*60*24*365);
$ok = 1;
} // do while.
if (($this->status == 5) or ($this->status == 67)) {
if (file_exists('school/'.$this->email)) { } else { 
mkdir('school/'.$this->email); 
file_put_contents('school/'.$this->email.'/name.txt',$this->nome);
file_put_contents('school/'.$this->email.'/nic.txt',$this->nome);
} // nao existe o diretorio...
} // adm ou prof
$_SESSION["lgerr"] = null;
} // nao encontrou o usuario ou senha.
} // campos vazios...

if ($ret == false) {
if (!isset($_SESSION["lgerr"])) { $_SESSION["lgerr"] = 1; }
else {
$_SESSION["lgerr"] = $_SESSION["lgerr"] + 1;
if ($_SESSION["lgerr"] > 3) {
$this->log->add();
} // bloqueando por hoje...
} // adicionando...

} // senha incorreta...

return $ret;
} // da funcao... 

public function Logout() {
if ($this->verifylogin() == true) {
$this->Open($_SESSION["ssid"]);
$this->token = '';
$this->Save();
// $dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);
// $l = $this->gettokenid($dados["token"]);
// $this->Open($l[0]);
// $this->token = '';
// $this->Save();
$_SESSION["ssid"] = null;
// session_destroy();
$dados = array();
setcookie("dados", "", time()-60*60*24*365);
} // ok deslogando...
} // da funcao...

public function verifylogin() {
if(!isset($_COOKIE["dados"]) and !isset($_SESSION["ssid"])){
$_SESSION["ssid"] = 0;
$_SESSION["ssnome"] = '';
$_SESSION["ssemail"] = '';
$_SESSION["ssstatus"] = 0;
$_SESSION["ssurl"] = '';
$_SESSION["token"] = '';
return false;
} else {
if (isset($_SESSION["ssid"])) {
if ($_SESSION["ssid"] > 0) return true;
else {
if (!isset($_COOKIE["dados"])) return false;
$dados = unserialize($_COOKIE["dados"]);
$this->Open($dados["id"]);
$_SESSION["ssid"] = $this->id;
$_SESSION["ssnome"] = $this->nome;
$_SESSION["ssemail"] = $this->email;
$_SESSION["ssstatus"] = $this->status;
$_SESSION["ssurl"] = $this->url;
return true;
} // pegando do cookie...
} // existe o ssid...
}
} // da funcao...

 } // da classe UserClass

$users = new snapsect_UserClass();