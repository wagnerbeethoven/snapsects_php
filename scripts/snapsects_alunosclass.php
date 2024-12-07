<?php

class snapsects_ProvasClass {
public $nomebanco="snapsects_provas";
public $mycon;
public $id = 0;
public $provaid;
public $nome;
public $sala;
public $email;
public $aluno;
public $prova;
public $correcao;
public $nota;
public $dataprova;
public $datacorrecao;
 
public function getid() {
return intval($this->id);
} // da funcao getid
public function getprovaid() {
return $this->provaid;
} // da funcao getprovaid
public function getnome() {
return $this->nome;
} // da funcao getnome
public function getsala() {
return $this->sala;
} // da funcao getsala
public function getemail() {
return $this->email;
} // da funcao getemail
public function getaluno() {
return $this->aluno;
} // da funcao getaluno
public function getprova() {
return $this->prova;
} // da funcao getprova
public function getcorrecao() {
return $this->correcao;
} // da funcao getcorrecao
public function getnota() {
return $this->nota;
} // da funcao getnota
public function getdataprova() {
return $this->dataprova;
} // da funcao getdataprova
public function getdatacorrecao() {
return $this->datacorrecao;
} // da funcao getdatacorrecao
public function GetRes($nv) {
$this->id = $nv["id"];
$this->provaid = $nv["provaid"];
$this->nome = $nv["nome"];
$this->sala = $nv["sala"];
$this->email = $nv["email"];
$this->aluno = $nv["aluno"];
$this->prova = $nv["prova"];
$this->correcao = $nv["correcao"];
$this->nota = $nv["nota"];
$this->dataprova = $nv["dataprova"];
$this->datacorrecao = $nv["datacorrecao"];
} // da funcao GetRes
 
public function ClearAll() {
$this->id = 0;
$this->provaid="";
$this->nome="";
$this->sala="";
$this->email="";
$this->aluno="";
$this->prova="";
$this->correcao="";
$this->nota="";
$this->dataprova="";
$this->datacorrecao="";
} // da funcao clearall
 
public function Open($n) {
$sql = "select * from snapsects_provas where id = $n";
$res=mysqli_query($this->mycon, $sql);
$this->GetRes(mysqli_fetch_array($res));
} // da funcao open...
 
public function Save() {
// verificando se a chave já existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update snapsects_provas set provaid='".$this->provaid."', nome='".$this->nome."', sala='".$this->sala."', email='".$this->email."', aluno='".$this->aluno."', prova='".$this->prova."', correcao='".$this->correcao."', nota='".$this->nota."', dataprova='".$this->dataprova."', datacorrecao='".$this->datacorrecao."' where id = $this->id";
else
$sql = "insert into snapsects_provas(provaid,nome,sala,email,aluno,prova,correcao,nota,dataprova,datacorrecao)  values('".$this->provaid."', '".$this->nome."', '".$this->sala."', '".$this->email."', '".$this->aluno."', '".$this->prova."', '".$this->correcao."', '".$this->nota."', '".$this->dataprova."', '".$this->datacorrecao."')";
$res=mysqli_query($this->mycon, $sql);
} // da funcao save
 
public function Create_Table() {
$sql="DROP TABLE IF EXISTS snapsects_provas;";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE snapsects_provas(id INT AUTO_INCREMENT PRIMARY KEY, provaid TEXT, nome TEXT, sala TEXT, email TEXT, aluno TEXT, prova TEXT, correcao TEXT, nota TEXT, dataprova TEXT, datacorrecao TEXT );";
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
$this->mycon = mysqli_connect(DBSERV, DBUSER, DBPASS,DBDB);  
if(0!=$id) $this->Open($id);
} // do create...
 
public function datetoamd($dia) {
$x = explode("/", $dia);
if (strlen($x[0]) < 4) {
$d = $x[0];
$m = $x[1];
$a = $x[2];
} // realmente é date.
else {
$a = $x[0];
$m = $x[1];
$d = $x[2];
} // não é date...
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
} // realmente é date.
else {
$a = $x[0];
$m = $x[1];
$d = $x[2];
} // não é date...
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


class snapsects_SalasClass {
public $nomebanco="snapsects_salas";
public $mycon;
public $id = 0;
public $userid = 0;
public $profid = 0;
public $prof;
public $nome;
public $sala;
public $email;
public $aluno;
 
public function getid() {
return intval($this->id);
} // da funcao getid
public function getuserid() {
return intval($this->userid);
} // da funcao getuserid
public function getprofid() {
return intval($this->profid);
} // da funcao getprofid
public function getprof() {
return $this->prof;
} // da funcao getprof
public function getnome() {
return $this->nome;
} // da funcao getnome
public function getsala() {
return $this->sala;
} // da funcao getsala
public function getemail() {
return $this->email;
} // da funcao getemail
public function getaluno() {
return $this->aluno;
} // da funcao getaluno
public function GetRes($nv) {
$this->id = $nv["id"];
$this->userid = $nv["userid"];
$this->profid = $nv["profid"];
$this->prof = $nv["prof"];
$this->nome = $nv["nome"];
$this->sala = $nv["sala"];
$this->email = $nv["email"];
$this->aluno = $nv["aluno"];
} // da funcao GetRes
 
public function ClearAll() {
$this->id = 0;
$this->userid = 0;
$this->profid = 0;
$this->prof="";
$this->nome="";
$this->sala="";
$this->email="";
$this->aluno="";
} // da funcao clearall
 
public function Open($n) {
$sql = "select * from snapsects_salas where id = $n";
$res=mysqli_query($this->mycon, $sql);
$this->GetRes(mysqli_fetch_array($res));
} // da funcao open...
 
public function Save() {
// verificando se a chave já existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update snapsects_salas set userid=".$this->userid.",profid=".$this->profid.",prof='".$this->prof."', nome='".$this->nome."', sala='".$this->sala."', email='".$this->email."', aluno='".$this->aluno."' where id = $this->id";
else
$sql = "insert into snapsects_salas(userid,profid,prof,nome,sala,email,aluno)  values(".$this->userid.",".$this->profid.",'".$this->prof."', '".$this->nome."', '".$this->sala."', '".$this->email."', '".$this->aluno."')";
$res=mysqli_query($this->mycon, $sql);
} // da funcao save
 
public function Create_Table() {
$sql="DROP TABLE IF EXISTS snapsects_salas;";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE snapsects_salas(id INT AUTO_INCREMENT PRIMARY KEY, userid INT, profid INT, prof TEXT, nome TEXT, sala TEXT, email TEXT, aluno TEXT );";
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
$this->mycon = mysqli_connect(DBSERV, DBUSER, DBPASS,DBDB);  
if(0!=$id) $this->Open($id);
} // do create...
 
public function datetoamd($dia) {
$x = explode("/", $dia);
if (strlen($x[0]) < 4) {
$d = $x[0];
$m = $x[1];
$a = $x[2];
} // realmente é date.
else {
$a = $x[0];
$m = $x[1];
$d = $x[2];
} // não é date...
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
} // realmente é date.
else {
$a = $x[0];
$m = $x[1];
$d = $x[2];
} // não é date...
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

class snapsects_AlunosClass {
public $nomebanco="snapsects_alunos";
public $mycon;
public $id = 0;
public $datacad;
public $nome;
public $email;
public $pws;
public $ukey;
public $salas = array();
 
public function getid() {
return intval($this->id);
} // da funcao getid
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
public function getukey() {
return $this->ukey;
} // da funcao getukey
public function GetRes($nv) {
$this->id = $nv["id"];
$this->datacad = $nv["datacad"];
$this->nome = $nv["nome"];
$this->email = $nv["email"];
$this->pws = $nv["pws"];
$this->ukey = $nv["ukey"];
} // da funcao GetRes
 
public function ClearAll() {
$this->id = 0;
$this->datacad="";
$this->nome="";
$this->email="";
$this->pws="";
$this->ukey="";
$salas = array();
} // da funcao clearall
 
public function Open($n) {
$sql = "select * from snapsects_alunos where id = $n";
$res=mysqli_query($this->mycon, $sql);
$this->GetRes(mysqli_fetch_array($res));
} // da funcao open...
 
public function OpenEmail($n) {
$sql = "select * from snapsects_alunos where email = '$n'";
$res=mysqli_query($this->mycon, $sql);
if (mysqli_num_rows($res) > 0) {
$this->GetRes(mysqli_fetch_array($res));
return true;
} else {
return false;
}
} // da funcao open email...

public function Save() {
// verificando se a chave já existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update snapsects_alunos set datacad='".$this->datacad."', nome='".$this->nome."', email='".$this->email."', pws='".$this->pws."', ukey='".$this->ukey."' where id = $this->id";
else
$sql = "insert into snapsects_alunos(datacad,nome,email,pws,ukey)  values('".$this->datacad."', '".$this->nome."', '".$this->email."', '".$this->pws."', '".$this->ukey."')";
$res=mysqli_query($this->mycon, $sql);
$res = $this->Find("select * from [banco] where email='".$this->email."' and pws = '".$this->pws."'");
while($r=mysqli_fetch_array($res)) {
$this->GetRes($r);
return $this->id;
} // do while...
} // da funcao save
 
public function SaveSala($profid,$email,$sala,$prof) {
$tp = new snapsects_SalasClass();
$res = $tp->Find('select * from [banco] where userid = '.$this->id.' and profid = '.$profid.' and email = "'.$email.'" and sala = "'.$sala.'"');
if (mysqli_num_rows($res) > 0) {
return 0;
} else {
$tp->id = 0;
$tp->userid = $this->id;
$tp->profid = $profid;
$tp->sala = $sala;
$tp->email = $email;
$tp->nome = $this->nome;
$tp->aluno = $this->email;
$tp->prof = $prof;
$tp->Save();
return 1;
} // adicionou...
} // da funcao...

public function Create_Table() {
$sql="DROP TABLE IF EXISTS snapsects_alunos;";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE snapsects_alunos(id INT AUTO_INCREMENT PRIMARY KEY, datacad TEXT, nome TEXT, email TEXT, pws TEXT, ukey TEXT );";
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
$this->mycon = mysqli_connect(DBSERV, DBUSER, DBPASS,DBDB);  
if(0!=$id) $this->Open($id);
} // do create...
 
public function datetoamd($dia) {
$x = explode("/", $dia);
if (strlen($x[0]) < 4) {
$d = $x[0];
$m = $x[1];
$a = $x[2];
} // realmente é date.
else {
$a = $x[0];
$m = $x[1];
$d = $x[2];
} // não é date...
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
} // realmente é date.
else {
$a = $x[0];
$m = $x[1];
$d = $x[2];
} // não é date...
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
