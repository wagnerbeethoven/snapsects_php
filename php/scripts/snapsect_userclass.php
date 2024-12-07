<?php
require_once 'DB_CONFIG.php';
$lst_type = array();
$lst_type["0"] = 'Waitting confirmation'; 
$lst_type["1"] = 'User';
$lst_type["10"] = 'Writter';
$lst_type["67"] = 'Administrator';

class snapsect_UserClass {
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
public function GetRes($nv) {
$this->id = $nv["id"];
$this->status = $nv["status"];
$this->datacad = $nv["datacad"];
$this->nome = $nv["nome"];
$this->email = $nv["email"];
$this->pws = $nv["pws"];
$this->url = $nv["url"];
$this->obs = $nv["obs"];
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
// verificando se a chave j� existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update snapsect_user set status=".$this->status.",datacad='".$this->datacad."', nome='".$this->nome."', email='".$this->email."', pws='".$this->pws."', url='".$this->url."', obs='".$this->obs."' where id = $this->id";
else
$sql = "insert into snapsect_user(status,datacad,nome,email,pws,url,obs)  values(".$this->status.",'".$this->datacad."', '".$this->nome."', '".$this->email."', '".$this->pws."', '".$this->url."', '".$this->obs."')";
$res=mysqli_query($this->mycon, $sql);
$res = $this->Find("select * from [banco] where email='".$this->email."' and pws = '".$this->pws."'");
while($r=mysqli_fetch_array($res)) {
$this->GetRes($r);
return $this->id;
} // do while...
} // da funcao save
 
public function Create_Table() {
$sql="DROP TABLE IF EXISTS snapsect_user;";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE snapsect_user(id INT AUTO_INCREMENT PRIMARY KEY, status INT, datacad TEXT, nome TEXT, email TEXT, pws TEXT, url TEXT, obs TEXT );";
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
$this->mycon = mysqli_connect(HOST, USER, PASS,DB_NAME);  
if(0!=$id) $this->Open($id);
} // do create...
 
public function datetoamd($dia) {
$x = explode("/", $dia);
if (strlen($x[0]) < 4) {
$d = $x[0];
$m = $x[1];
$a = $x[2];
} // realmente � date.
else {
$a = $x[0];
$m = $x[1];
$d = $x[2];
} // n�o � date...
$res = $a."-";
if (strlen($m) < 2) $res.="0";
$res.=$m."-";
if (strlen($d) < 2) $res.="0";
$res.=$d;
return $res;
} // da function
 
public function amdtodate($dia) {
$x = explode("-", $dia);
if (strlen($x[0]) < 4) {
$d = $x[0];
$m = $x[1];
$a = $x[2];
} // realmente � date.
else {
$a = $x[0];
$m = $x[1];
$d = $x[2];
} // n�o � date...
if (strlen($d) < 2) $res="0".$d."/";
else $res=$d."/";
if (strlen($m) < 2) $res.="0";
$res.=$m."/".$a;
return $res;
} // da function
 
public function datetobanco($d) {
$x = $this->datetoamd($d["data"]);
$x.=" ".$d["hora"];
return $x;
} // da funcao
 
} // da classe UserClass
?>
