<?php

function addupload($diretorio, $foto, $nome) {
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


function removeacento($txt) {
$a = 'áàãâéèêíìîóòõôúùûçÁÀÃÂÉÈÊÍÌÎÓÒÕÔÚÙÛÇ +=-,/*()[]?';
$s = 'aaaaeeeiiioooouuucAAAAEEEIIIOOOOUUUC____________';
$len = strlen($txt);
$resp = '';
for ($r=0;$r<$len;$r++) {
$c = strpos($a,$txt[$r]);
if ($c > -1) { $resp.=$s[$c]; } else { $resp.=$txt[$r]; }
} // do for...
return $resp;
} // da funcao.

class PhotoClass {
public $pasta = '';

public function addlog($id, $txt = '') {
$texto = '';
if (file_exists($this->pasta.$id.'/log.txt')) $texto = file_get_contents($this->pasta.$id.'/log.txt');
$d = date('Y/m/d H:i');
$texto .= $d.chr(9).$txt.chr(13).chr(10);
file_put_contents($this->pasta.$id.'/log.txt',$texto);
} // da funcao

public function deletefile($id,$arquivo,$log) {
if (strlen($arquivo) > 0) {
unlink($this->pasta.$id.'/'.$arquivo);
$this->addlog($id,'del '.$arquivo.chr(9).$log);
} else {
$this->addlog($id,'delete error: no file name'.chr(9).$log);
} // arquivo sem nome
} // da funcao...

public function deletefiles($id,$arquivo,$log) {
$this->deletefile($id,$arquivo,$log);
$x = explode('.',$arquivo);
if (file_exists($this->pasta.$id.'/'.$x[0].'.txt')) unlink($this->pasta.$id.'/'.$x[0].'.txt');
} // da funcao...

public function addfile($id,$grp,$nome,$user) {
$x = $nome;
$z = explode('.',$grp["name"]);
if (strlen($x) < 1) $x = $z[0];
$x = str_replace(' ','_',$x);
move_uploaded_file($grp["tmp_name"], $this->pasta.$id.'/'.removeacento($x.'.'.$z[1]));
$texto = 'add '.$x.'.'.$z[1].chr(9).$user;
$this->addlog($id,$texto);
} // da funcao...

public function addfilebase64($id,$img,$nome,$user) {
$nome = removeacento($nome);
$file = $this->pasta.$id.'/'.$nome;
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
file_put_contents($file, $data);
$this->addlog($id, 'add '.$nome.chr(9).$user);
} // da funcao

public function addfiles($id,$grp,$nome,$user,$txt) {
$this->addfile($id,$grp,$nome,$user);
$x = $nome;
$z = explode('.',$grp["name"]);
if (strlen($x) < 1) $x = $z[0];
$x = str_replace(' ','_',$x);
file_put_contents($this->pasta.$id.'/'.removeacento($x).'.txt',$txt);
} // da funcao...

public function addfilesbase64($id,$img,$nome,$texto,$user) {
$this->addfilebase64($id,$img,$nome,$user);
$nome = removeacento($nome);
$n = explode('.',$nome);
file_put_contents($this->pasta.$id.'/'.$n[0].'.txt',$texto);
} // da funcao...

public function getdir($pst, $exe = '') {
$diretorio= dir($pst);
$l = array();
if (strlen($exe) > 0) {
$exe = strtoupper($exe);
$base = explode(';',$exe);
while($arquivo= $diretorio-> read()){
foreach($base as $r) {
if (strpos(strtoupper($arquivo),$r) > -1) {
$l[] = $arquivo;
break;
}
}
} // do while
} // com mascara...
else {
while($arquivo= $diretorio-> read()){
$l[] = $arquivo;
} // do while
} // sem mascara...
$diretorio-> close();
return $l;
} // da funcao.

public function getlist($id, $filtro = 0) {
$ls = $this->getdir($this->pasta.$id,'.jpg;.jpeg;.bmp;.png;.gif;.tif');
$ll = array();
foreach($ls as $r) {
$x = explode('.',$r);
$nome = $x[0];
if ((($filtro == 1) and (strpos(' '.$nome,'logo') < 1)) or ($filtro == 0)) {
$texto = '';
if (file_exists($this->pasta.$id.'/'.$nome.'.txt')) 
$texto = file_get_contents($this->pasta.$id.'/'.$nome.'.txt');
$ll[] = array('url' => $r, 'text' => $texto);
} // passou pelo filtro do logo...
} // do for...
return $ll;
} // da funcao.

public function getlistvideo($id, $filtro = 0) {
$ls = $this->getdir($this->pasta.$id,'.MOV;.mp4;.avi;.wmv;.mov;.rnvb');
$ll = array();
foreach($ls as $r) {
$x = explode('.',$r);
$nome = $x[0];
if ((($filtro == 1) and (strpos(' '.$nome,'logo') < 1)) or ($filtro == 0)) {
$texto = '';
if (file_exists($this->pasta.$id.'/'.$nome.'.txt')) 
$texto = file_get_contents($this->pasta.$id.'/'.$nome.'.txt');
$ll[] = array('url' => $r, 'text' => $texto);
} // passou pelo filtro do logo...
} // do for...
return $ll;
} // da funcao.

public function getlistaudio($id, $filtro = 0) {
$ls = $this->getdir($this->pasta.$id,'.WAV;.mp3;.m4a;.wav');
$ll = array();
foreach($ls as $r) {
$x = explode('.',$r);
$nome = $x[0];
if ((($filtro == 1) and (strpos(' '.$nome,'logo') < 1)) or ($filtro == 0)) {
$texto = '';
if (file_exists($this->pasta.$id.'/'.$nome.'.txt')) 
$texto = file_get_contents($this->pasta.$id.'/'.$nome.'.txt');
$ll[] = array('url' => $r, 'text' => $texto);
} // passou pelo filtro do logo...
} // do for...
return $ll;
} // da funcao.

public function getlogo($id) {
$ls = $this->getdir($this->pasta.$id,'logo.jpg;logo.jpeg;logo.bmp;logo.png;logo.gif;logo.tif');
foreach($ls as $r) {
$x = explode('.',$r);
if ($x[1] <> '.txt') {
$nome = $x[0];
$texto = '';
if (file_exists($this->pasta.$id.'/'.$nome.'.txt')) 
$texto = file_get_contents($this->pasta.$id.'/'.$nome.'.txt');
return array('url' => $r, 'text' => $texto);
} // encontrou...
} // do for...
return array('url' => '', 'text' => '');
} // da funcao.

public function add_logo($id,$grpfoto,$user) {
// removendo os logos antigos...
$ls = $this->getdir($this->pasta.$id,'logo.jpg;logo.jpeg;logo.bmp;logo.png;logo.gif;logo.tif');
foreach($ls as $r) {
$this->deletefile($id,$r,$user);
} // do for...

$this->addfile($id,$grpfoto,'logo',$user);
} // da funcao...

public function deleteall($id) {
$l = $this->getdir($this->pasta.$id,'');
foreach($l as $r) {
if (($r <> '.') and ($r <> '..')) {
if (strlen($r) > 2) { unlink($this->pasta.$id.'/'.$r); }
} // encontrou...
} // do for...
rmdir($this->pasta.$id);
} // da funcao...

public function __construct($p) {
$this->pasta = $p;
} // do construct
} // da classe photo.

class snapsect_PhotoClass {
public $nomebanco="snapsect_photo";
public $mycon;
public $id = 0;
public $userid = 0;
public $codid = 0;
public $datacad;
public $url;
public $title;
public $obs;
 
public function getid() {
return intval($this->id);
} // da funcao getid
public function getuserid() {
return intval($this->userid);
} // da funcao getuserid
public function getcodid() {
return intval($this->codid);
} // da funcao getcodid
public function getdatacad() {
return $this->datacad;
} // da funcao getdatacad
public function geturl() {
return $this->url;
} // da funcao geturl
public function gettitle() {
return $this->title;
} // da funcao gettitle
public function getobs() {
return $this->obs;
} // da funcao getobs
public function GetRes($nv) {
$this->id = $nv["id"];
$this->userid = $nv["userid"];
$this->codid = $nv["codid"];
$this->datacad = $nv["datacad"];
$this->url = $nv["url"];
$this->title = $nv["title"];
$this->obs = $nv["obs"];
} // da funcao GetRes
 
public function ClearAll() {
$this->id = 0;
$this->userid = 0;
$this->codid = 0;
$this->datacad="";
$this->url="";
$this->title="";
$this->obs="";
} // da funcao clearall
 
public function Open($n) {
$sql = "select * from ".$this->nomebanco." where id = $n";
$res=mysqli_query($this->mycon,$sql);
$this->GetRes(mysqli_fetch_array($res));
} // da funcao open...
 
public function Save() {
// verificando se a chave já existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update ".$this->nomebanco." set userid=".$this->userid.",codid=".$this->codid.",datacad='".$this->datacad."', url='".$this->url."', title='".$this->title."', obs='".$this->obs."' where id = $this->id";
else
$sql = "insert into ".$this->nomebanco."(userid,codid,datacad,url,title,obs)  values(".$this->userid.",".$this->codid.",'".$this->datacad."', '".$this->url."', '".$this->title."', '".$this->obs."')";
$res=mysqli_query($this->mycon,$sql);
} // da funcao save
 
public function Create_Table() {
$sql="DROP TABLE IF EXISTS ".$this->nomebanco.";";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE ".$this->nomebanco."(id INT AUTO_INCREMENT PRIMARY KEY, userid INT, codid INT, datacad TEXT, url TEXT, title TEXT, obs TEXT );";
$res=mysqli_query($this->mycon,$sql);
} // da criacao da tabela
 
public function Delete($n) {
$this->Open($n);
if ($this->id > 0) {
if (strlen($this->url) > 0) {
if (file_exists($this->url)) {
unlink($this->url);
} // existe o arquivo de foto.
} // existe url...
$sql = "delete from ".$this->nomebanco." where id=$n";
$res=mysqli_query($this->mycon,$sql);
} // id > 0...
} // da function delete...
 
public function Deleteall($codid) {
$res = $this->Find('select * from [banco] where codid='.$codid);
while($r=mysqli_fetch_array($res)) {
$this->Delete($r["id"]);
} // do while...
} // da funcao...

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
 
} // da classe snapsect_photoClass

 class snapsectClass {
public $nomebanco="snapsect";
public $lang = '';
public $mycon;
public $id = 0;
public $status = 0;
public $userid = 0;
public $author;
public $email;
public $url;
public $colaborative;
public $commonname;
public $scientificname;
public $kingdom;
public $phylum;
public $classe;
public $oorder;
public $family;
public $genus;
public $species;
public $gender;
public $colors;
public $bbody;
public $hhead;
public $thorax;
public $abdomen;
public $lstantennae;
public $antennae;
public $eyesandocelli;
public $lstmouthparts;
public $mouthparts;
public $lstwings;
public $wings;
public $lstnumlegs;
public $lsthindwings;
public $hindwings;
public $lstlegs;
public $cerci;
public $tarsomere;
public $locomotive;
public $specificcharacteristics;
public $development;
public $metamorphosis;
public $collecting;
public $place;
public $water; // using to bibliography
public $ground; // using to list contributors = lstcontributors
public $other; // using to author and date.
public $mediation;
public $notes;
public $audiodesc;
public $datacad;
public $lat;
public $lng;
public $city;
public $country;
public $uf;
public $address;
public $photo;
public $photodesc;
public $win;
public $temperature;
public $photos;

 public function getid() {
return intval($this->id);
} // da funcao getid
public function getstatus() {
return intval($this->status);
} // da funcao getstatus
public function getuserid() {
return intval($this->userid);
} // da funcao getuserid
public function getauthor() {
return $this->author;
} // da funcao getauthor
public function getemail() {
return $this->email;
} // da funcao getemail
public function geturl() {
return $this->url;
} // da funcao geturl
public function getcolaborative() {
return $this->colaborative;
} // da funcao getcolaborative
public function getcommonname() {
return $this->commonname;
} // da funcao getcommonname
public function getscientificname() {
return $this->scientificname;
} // da funcao getscientificname
public function getkingdom() {
return $this->kingdom;
} // da funcao getkingdom
public function getphylum() {
return $this->phylum;
} // da funcao getphylum
public function getclasse() {
return $this->classe;
} // da funcao getclasse
public function getoorder() {
return $this->oorder;
} // da funcao getoorder
public function getfamily() {
return $this->family;
} // da funcao getfamily
public function getgenus() {
return $this->genus;
} // da funcao getgenus
public function getspecies() {
return $this->species;
} // da funcao getspecies
public function getgender() {
return $this->gender;
} // da funcao getgender
public function getcolors() {
return $this->colors;
} // da funcao getcolors
public function getbbody() {
return $this->bbody;
} // da funcao getbbody
public function gethhead() {
return $this->hhead;
} // da funcao gethhead
public function getthorax() {
return $this->thorax;
} // da funcao getthorax
public function getabdomen() {
return $this->abdomen;
} // da funcao getabdomen
public function getlstantennae() {
return $this->lstantennae;
} // da funcao getlstantennae
public function getantennae() {
return $this->antennae;
} // da funcao getantennae
public function geteyesandocelli() {
return $this->eyesandocelli;
} // da funcao geteyesandocelli
public function getlstmouthparts() {
return $this->lstmouthparts;
} // da funcao getlstmouthparts
public function getmouthparts() {
return $this->mouthparts;
} // da funcao getmouthparts
public function getlstwings() {
return $this->lstwings;
} // da funcao getlstwings
public function getwings() {
return $this->wings;
} // da funcao getwings
public function getlstnumlegs() {
return $this->lstnumlegs;
} // da funcao getlstnumlegs
public function getlsthindwings() {
return $this->lsthindwings;
} // da funcao getlsthindwings
public function gethindwings() {
return $this->hindwings;
} // da funcao gethindwings
public function getlstlegs() {
return $this->lstlegs;
} // da funcao getlstlegs
public function getcerci() {
return $this->cerci;
} // da funcao getcerci
public function gettarsomere() {
return $this->tarsomere;
} // da funcao gettarsomere
public function getlocomotive() {
return $this->locomotive;
} // da funcao getlocomotive
public function getspecificcharacteristics() {
return $this->specificcharacteristics;
} // da funcao getspecificcharacteristics
public function getdevelopment() {
return $this->development;
} // da funcao getdevelopment
public function getmetamorphosis() {
return $this->metamorphosis;
} // da funcao getmetamorphosis
public function getcollecting() {
return $this->collecting;
} // da funcao getcollecting
public function getplace() {
return $this->place;
} // da funcao getplace
public function getwater() {
return $this->water;
} // da funcao getwater
public function getground() {
return $this->ground;
} // da funcao getground
public function getother() {
return $this->other;
} // da funcao getother
public function getmediation() {
return $this->mediation;
} // da funcao getmediation
public function getnotes() {
return $this->notes;
} // da funcao getnotes
public function getaudiodesc() {
return $this->audiodesc;
} // da funcao getaudiodesc
public function getdatacad() {
return $this->datacad;
} // da funcao getdatacad
public function getlat() {
return $this->lat;
} // da funcao getlat
public function getlng() {
return $this->lng;
} // da funcao getlng
public function getcity() {
return $this->city;
} // da funcao getcity
public function getcountry() {
return $this->country;
} // da funcao getcountry
public function getuf() {
return $this->uf;
} // da funcao getuf
public function getaddress() {
return $this->address;
} // da funcao getaddress
public function getphoto() {
return $this->photo;
} // da funcao getphoto
public function getphotodesc() {
return $this->photodesc;
} // da funcao getphotodesc
public function getwin() {
return $this->win;
} // da funcao getwin
public function gettemperature() {
return $this->temperature;
} // da funcao gettemperature
public function GetRes($nv) {
$this->id = $nv["id"];
$this->status = $nv["status"];
$this->userid = $nv["userid"];
$this->author = $nv["author"];
$this->email = $nv["email"];
$this->url = $nv["url"];
$this->colaborative = $nv["colaborative"];
$this->commonname = $nv["commonname"];
$this->scientificname = $nv["scientificname"];
$this->kingdom = $nv["kingdom"];
$this->phylum = $nv["phylum"];
$this->classe = $nv["classe"];
$this->oorder = $nv["oorder"];
$this->family = $nv["family"];
$this->genus = $nv["genus"];
$this->species = $nv["species"];
$this->gender = $nv["gender"];
$this->colors = $nv["colors"];
$this->bbody = $nv["bbody"];
$this->hhead = $nv["hhead"];
$this->thorax = $nv["thorax"];
$this->abdomen = $nv["abdomen"];
$this->lstantennae = $nv["lstantennae"];
$this->antennae = $nv["antennae"];
$this->eyesandocelli = $nv["eyesandocelli"];
$this->lstmouthparts = $nv["lstmouthparts"];
$this->mouthparts = $nv["mouthparts"];
$this->lstwings = $nv["lstwings"];
$this->wings = $nv["wings"];
$this->lstnumlegs = $nv["lstnumlegs"];
$this->lsthindwings = $nv["lsthindwings"];
$this->hindwings = $nv["hindwings"];
$this->lstlegs = $nv["lstlegs"];
$this->cerci = $nv["cerci"];
$this->tarsomere = $nv["tarsomere"];
$this->locomotive = $nv["locomotive"];
$this->specificcharacteristics = $nv["specificcharacteristics"];
$this->development = $nv["development"];
$this->metamorphosis = $nv["metamorphosis"];
$this->collecting = $nv["collecting"];
$this->place = $nv["place"];
$this->water = $nv["water"];
$this->ground = $nv["ground"];
$this->other = $nv["other"];
$this->mediation = $nv["mediation"];
$this->notes = $nv["notes"];
$this->audiodesc = $nv["audiodesc"];
$this->datacad = $nv["datacad"];
$this->lat = $nv["lat"];
$this->lng = $nv["lng"];
$this->city = $nv["city"];
$this->country = $nv["country"];
$this->uf = $nv["uf"];
$this->address = $nv["address"];
$temp = $this->photos->getlogo($this->id);
$this->photo = $temp["url"];
// $this->photo = $nv["photo"];
$this->photodesc = $temp["text"];
// $this->photodesc = $nv["photodesc"];
$this->win = $nv["win"];
$this->temperature = $nv["temperature"];
} // da funcao GetRes
 
public function ClearAll() {
$this->id = 0;
$this->status = 0;
$this->userid = 0;
$this->author="";
$this->email="";
$this->url="";
$this->colaborative="";
$this->commonname="";
$this->scientificname="";
$this->kingdom="";
$this->phylum="";
$this->classe="";
$this->oorder="";
$this->family="";
$this->genus="";
$this->species="";
$this->gender="";
$this->colors="";
$this->bbody="";
$this->hhead="";
$this->thorax="";
$this->abdomen="";
$this->lstantennae="";
$this->antennae="";
$this->eyesandocelli="";
$this->lstmouthparts="";
$this->mouthparts="";
$this->lstwings="";
$this->wings="";
$this->lstnumlegs="";
$this->lsthindwings="";
$this->hindwings="";
$this->lstlegs="";
$this->cerci="";
$this->tarsomere="";
$this->locomotive="";
$this->specificcharacteristics="";
$this->development="";
$this->metamorphosis="";
$this->collecting="";
$this->place="";
$this->water="";
$this->ground="";
$this->other="";
$this->mediation="";
$this->notes="";
$this->audiodesc="";
$this->datacad="";
$this->lat="";
$this->lng="";
$this->city="";
$this->country="";
$this->uf="";
$this->address="";
$this->photo="";
$this->photodesc="";
$this->win="";
$this->temperature="";
} // da funcao clearall
 
public function Open($n) {
$sql = "select * from ".$this->nomebanco." where id = $n";
$res=mysqli_query($this->mycon,$sql);
$this->GetRes(mysqli_fetch_array($res));
if (file_exists('photos/'.$this->lang.'/'.$n)) { } else { mkdir('photos/'.$this->lang.'/'.$n); }
} // da funcao open...
 
public function Save() {
// verificando a data do cadastro...
if (strlen($this->datacad) < 1) { $this->datacad = date("Y-m-d H:i:s"); }
// verificando se a chave já existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update ".$this->nomebanco." set status=".$this->status.",userid=".$this->userid.",author='".$this->author."', email='".$this->email."', url='".$this->url."', colaborative='".$this->colaborative."', commonname='".$this->commonname."', scientificname='".$this->scientificname."', kingdom='".$this->kingdom."', phylum='".$this->phylum."', classe='".$this->classe."', oorder='".$this->oorder."', family='".$this->family."', genus='".$this->genus."', species='".$this->species."', gender='".$this->gender."', colors='".$this->colors."', bbody='".$this->bbody."', hhead='".$this->hhead."', thorax='".$this->thorax."', abdomen='".$this->abdomen."', lstantennae='".$this->lstantennae."', antennae='".$this->antennae."', eyesandocelli='".$this->eyesandocelli."', lstmouthparts='".$this->lstmouthparts."', mouthparts='".$this->mouthparts."', lstwings='".$this->lstwings."', wings='".$this->wings."', lstnumlegs='".$this->lstnumlegs."', lsthindwings='".$this->lsthindwings."', hindwings='".$this->hindwings."', lstlegs='".$this->lstlegs."', cerci='".$this->cerci."', tarsomere='".$this->tarsomere."', locomotive='".$this->locomotive."', specificcharacteristics='".$this->specificcharacteristics."', development='".$this->development."', metamorphosis='".$this->metamorphosis."', collecting='".$this->collecting."', place='".$this->place."', water='".$this->water."', ground='".$this->ground."', other='".$this->other."', mediation='".$this->mediation."', notes='".$this->notes."', audiodesc='".$this->audiodesc."', datacad='".$this->datacad."', lat='".$this->lat."', lng='".$this->lng."', city='".$this->city."', country='".$this->country."', uf='".$this->uf."', address='".$this->address."', photo='".$this->photo."', photodesc='".$this->photodesc."', win='".$this->win."', temperature='".$this->temperature."' where id = $this->id";
else
$sql = "insert into ".$this->nomebanco."(status,userid,author,email,url,colaborative,commonname,scientificname,kingdom,phylum,classe,oorder,family,genus,species,gender,colors,bbody,hhead,thorax,abdomen,lstantennae,antennae,eyesandocelli,lstmouthparts,mouthparts,lstwings,wings,lstnumlegs,lsthindwings,hindwings,lstlegs,cerci,tarsomere,locomotive,specificcharacteristics,development,metamorphosis,collecting,place,water,ground,other,mediation,notes,audiodesc,datacad,lat,lng,city,country,uf,address,photo,photodesc,win,temperature)  values(".$this->status.",".$this->userid.",'".$this->author."', '".$this->email."', '".$this->url."', '".$this->colaborative."', '".$this->commonname."', '".$this->scientificname."', '".$this->kingdom."', '".$this->phylum."', '".$this->classe."', '".$this->oorder."', '".$this->family."', '".$this->genus."', '".$this->species."', '".$this->gender."', '".$this->colors."', '".$this->bbody."', '".$this->hhead."', '".$this->thorax."', '".$this->abdomen."', '".$this->lstantennae."', '".$this->antennae."', '".$this->eyesandocelli."', '".$this->lstmouthparts."', '".$this->mouthparts."', '".$this->lstwings."', '".$this->wings."', '".$this->lstnumlegs."', '".$this->lsthindwings."', '".$this->hindwings."', '".$this->lstlegs."', '".$this->cerci."', '".$this->tarsomere."', '".$this->locomotive."', '".$this->specificcharacteristics."', '".$this->development."', '".$this->metamorphosis."', '".$this->collecting."', '".$this->place."', '".$this->water."', '".$this->ground."', '".$this->other."', '".$this->mediation."', '".$this->notes."', '".$this->audiodesc."', '".$this->datacad."', '".$this->lat."', '".$this->lng."', '".$this->city."', '".$this->country."', '".$this->uf."', '".$this->address."', '".$this->photo."', '".$this->photodesc."', '".$this->win."', '".$this->temperature."')";
$res=mysqli_query($this->mycon, $sql);
// recuperando o id
if ($this->id < 1) {
$sql = "select * from ".$this->nomebanco." where datacad ='".$this->datacad."' and commonname = '".$this->commonname."' and scientificname = '".$this->scientificname."'";
$res = mysqli_query($this->mycon, $sql);
while($r=mysqli_fetch_array($res)) {
if (file_exists('photos/'.$this->lang.'/'.$r["id"])) { } else { mkdir('photos/'.$this->lang.'/'.$r["id"]); }
return $r["id"];
} // do while
} else { return $this->id; }
} // da funcao save
 
public function Create_Table() {
$sql="DROP TABLE IF EXISTS ".$this->nomebanco.";";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE ".$this->nomebanco."(id INT AUTO_INCREMENT PRIMARY KEY, status INT, userid INT, author TEXT, email TEXT, url TEXT, colaborative TEXT, commonname TEXT, scientificname TEXT, kingdom TEXT, phylum TEXT, classe TEXT, oorder TEXT, family TEXT, genus TEXT, species TEXT, gender TEXT, colors TEXT, bbody TEXT, hhead TEXT, thorax TEXT, abdomen TEXT, lstantennae TEXT, antennae TEXT, eyesandocelli TEXT, lstmouthparts TEXT, mouthparts TEXT, lstwings TEXT, wings TEXT, lstnumlegs TEXT, lsthindwings TEXT, hindwings TEXT, lstlegs TEXT, cerci TEXT, tarsomere TEXT, locomotive TEXT, specificcharacteristics TEXT, development TEXT, metamorphosis TEXT, collecting TEXT, place TEXT, water TEXT, ground TEXT, other TEXT, mediation TEXT, notes TEXT, audiodesc TEXT, datacad TEXT, lat TEXT, lng TEXT, city TEXT, country TEXT, uf TEXT, address TEXT, photo TEXT, photodesc TEXT, win TEXT, temperature TEXT );";
$res=mysqli_query($this->mycon, $sql);
} // da criacao da tabela
 
public function Delete($n) {
$this->photos->deleteall($n);
$tp = new snapsect_PhotoClass();
$tp->Deleteall($n);
$sql = "delete from ".$this->nomebanco." where id=$n";
$res=mysqli_query($this->mycon, $sql);
} // da function delete...
 
public function Find($sql) {
$sql=str_replace("[banco]", $this->nomebanco, $sql);
$res = mysqli_query($this->mycon, $sql);
return $res;
} // da funcao find...
 
public function __construct($id = 0, $lng = "pt-br") {
$this->mycon = mysqli_connect(DBSERV, DBUSER, DBPASS,DBDB);  
$this->lang = $lng[0].$lng[1];
if (file_exists('photos/'.$this->lang)) { } else { mkdir('photos/'.$this->lang); }
$this->photos = new PhotoClass('photos/'.$this->lang.'/');
$this->nomebanco = $lng[0].$lng[1].'_snapsects';
$sql = "CREATE TABLE IF NOT EXISTS ".$this->nomebanco."(id INT AUTO_INCREMENT PRIMARY KEY, status INT, userid INT, author TEXT, email TEXT, url TEXT, colaborative TEXT, commonname TEXT, scientificname TEXT, kingdom TEXT, phylum TEXT, classe TEXT, oorder TEXT, family TEXT, genus TEXT, species TEXT, gender TEXT, colors TEXT, bbody TEXT, hhead TEXT, thorax TEXT, abdomen TEXT, lstantennae TEXT, antennae TEXT, eyesandocelli TEXT, lstmouthparts TEXT, mouthparts TEXT, lstwings TEXT, wings TEXT, lstnumlegs TEXT, lsthindwings TEXT, hindwings TEXT, lstlegs TEXT, cerci TEXT, tarsomere TEXT, locomotive TEXT, specificcharacteristics TEXT, development TEXT, metamorphosis TEXT, collecting TEXT, place TEXT, water TEXT, ground TEXT, other TEXT, mediation TEXT, notes TEXT, audiodesc TEXT, datacad TEXT, lat TEXT, lng TEXT, city TEXT, country TEXT, uf TEXT, address TEXT, photo TEXT, photodesc TEXT, win TEXT, temperature TEXT );";
$res=mysqli_query($this->mycon, $sql);

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
 
} // da classe snapsectClass

// funcao do snapsects gettext

function texttolink($texto) { 
$i = strpos($texto,'<link=');
while($i > -1) {
$t = 0;
$link = '';
$base = '';
for ($r=$i;$r<strlen($texto);$r++) {
$base .=$texto[$r];
if ($t == 1) {
if ($texto[$r] == '>') {
$t = 2;
break;
} else {
$link .= $texto[$r];
}
} // adicionando link
if (($t == 0) && ($texto[$r] == '=')) $t = 1;
} // do for...
if (strlen($link) > 0) {
$texto = str_replace($base,'<a href="'.$link.'" target="new_window">'.$link.'</a>',$texto);
} // alterando o texto...
$i = strpos($texto,'<link=');
} // do while...
return $texto;
} // da function 

function gettextfunc($id, $dic, $lang,$uid,$ustatus) {
$ee = new snapsectClass($id,$lang);
$ee->id = $id;
// recuperando as fotos...
$l = $ee->photos->getlist($id,1);
$phtxt = '';
if (count($l) > 0) {
if (count($l) == 1) {
$phtxt = '<center><img src="'.SITE_URL.$ee->photos->pasta.$id.'/'.$l[0]["url"].'" width="300px" ';
$phtxt.=(strlen($l[0]["text"]) > 0)?'alt="'.$l[0]["text"].'"':'alt="Image"';
$phtxt.=' onclick="showimg('.$id.", '".$l[0]["url"]."');".'"></center>';
// $phtxt.='<center>'.$l[0][""].'</center>';
} // apenas uma foto...
else {
$phtxt .='<table border="0" width="100%"><tr>';
$pht = 1;
for ($r=0;$r<count($l);$r++) {
$phtxt .= '<td width="33%"><center><img src="'.SITE_URL.$ee->photos->pasta.$id.'/'.$l[$r]["url"].'" width="300px" ';
$phtxt .=(strlen($l[$r]["text"]) > 0)?'alt="'.$l[$r]["text"].'"':'alt="Image"';
$phtxt .=' onclick="showimg('.$id.", '".$l[$r]["url"]."');".'"></center>';
// $phtxt.='<center>'.$lstph[$r]["obs"].'</center></td>';
$phtxt .='</td>';
$pht = $pht + 1;
if ($pht > 3) {
$pht = 1;
$phtxt.='</tr><tr>';
} // do pht >3
} // do for...
$phtxt.='</tr></table>';
} // mais que uma foto...
} // existem imagens...
// final das fotos...

// recuperando os videos...

$l = $ee->photos->getlistvideo($id,0);
$phtxt.='<div id="dvvideo">';
if (count($l) > 0) {
$phtxt.='<ul>';
foreach($l as $r) {
$phtxt .= '<li><button onclick="javascript: showvideo('."'".SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"]."');".'" >'.$r["text"].'</button>';
if (($ustatus > 49) || ($uid.'' == $ee->userid.'')) {
$phtxt .= '   <button onclick="javascript: delvideo('.$id.', '."'".SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"]."');".'" >** '.$r["text"].' **</button>';
} // mostrando o botao de remover
$phtxt .= '</li>';
} // do for...
$phtxt.='</ul>';
} // existem videos.
$phtxt.='</div>';

// recuperando os audios...

$l = $ee->photos->getlistaudio($id,0);
$phtxt.='<div id="dvshowaudio">';
if (count($l) > 0) {
// $phtxt.='<audio id="sndaudio" controls></audio>';
$phtxt.='<ul>';
$ccc = 0;
foreach($l as $r) {
$ccc = $ccc + 1;
$phtxt .= '<li><input type="button" id="cmdaudio'.$ccc.'" onclick="javascript:showaudio('."'".SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"]."');".'" value="'.$r["text"].'">';
// $phtxt.='<audio controls>';
// $pxurl = explode('.',$r["url"]);
// $audiourl = $pxurl[count($pxurl)-1];
// $phtxt.='<source src="'.SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"].'" type="audio/'.$audiourl.'">';
// $phtxt.='<embed height="60" type="audio/midi" width="144" src="'.SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"].'" loop="false" autostart="false" />';
// $phtxt.='</audio>';
// $phtxt.='<embed height="60" type="audio/midi" width="144" src="'.SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"].'" loop="false" autostart="false" />';
if (($ustatus > 49) || ($uid.'' == $ee->userid.'')) {
$phtxt .= '   <button onclick="javascript: delvideo('.$id.', '."'".SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"]."');".'" >** '.$r["text"].' **</button>';
} // mostrando o botao de remover
$phtxt .= '</li>';
} // do for...
$phtxt.='</ul>';
} // existem videos.
$phtxt.='</div>';

$t = '';
if (strlen($ee->photo) > 0) {
global $site_url;
$t .= '<br><center><img id="grpi" src="'.$site_url.$ee->photos->pasta.$id.'/'.$ee->photo.'" alt="'.$dic[219].' '.$ee->commonname.' ('.$ee->scientificname.') - '.$ee->photodesc.'" width="500px" onload="redimensiona();" onclick="showimg('.$id.", '".$ee->photo."');".'" /></center><br>';
}
$t.=$phtxt;
$t.='<br><center><h2>'.$dic[220].'</h2></center><br><dl>';
$t.='<dt>'.$dic[221].': </dt><dd>'.$ee->author.'</dd>';
if (strlen($ee->email) >0) { $t.='<dt>'.$dic[187].': </dt><dd><a href="mailto:'.$ee->email.'">'.$ee->email.'</a></dd>'; }
if (strlen($ee->url) >0) { $t.='<dt>'.$dic[189].': </dt><dd><a href="'.$ee->url.'">'.$ee->url.'</a></dd>'; }
if (strlen($ee->colaborative) >0) { $t.='<dt>'.$dic[191].': </dt><dd>'.$ee->colaborative.'</dd>'; }
$t.='</dl>';
$t.='<div id="dvidentificacao">';
$t.='<br><center><h2>'.$dic[222].'</h2></center><br><dl>';
$t.='<dt>'.$dic[8].': </dt><dd>'.$ee->commonname.'</dd>';
$t.='<dt>'.$dic[86].': </dt><dd>'.$ee->scientificname.'</dd>';
$t.='<dt>'.$dic[88].': </dt><dd>'.$ee->other.'</dd>';
$t.='<dt>'.$dic[89].': </dt><dd>'.$ee->kingdom.'</dd>';
$t.='<dt>'.$dic[90].': </dt><dd>'.$ee->phylum.'</dd>';
$t.=($ee->classe == '')?'<dt>'.$dic[211].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[211].': </dt><dd>'.$dic[$ee->classe].'</dd>';
$t.='<dt>'.$dic[94].': </dt><dd>'.$ee->oorder.'</dd>';
$t.='<dt>'.$dic[19].': </dt><dd>'.$ee->family.'</dd>';
$t.='<dt>'.$dic[97].': </dt><dd>'.$ee->genus.'</dd>';
$t.='<dt>'.$dic[99].': </dt><dd>'.$ee->species.'</dd>';
$t.=($ee->gender == '')?'<dt>'.$dic[213].': </dt><dd>'.$dic[92].'<dd>':'<dt>'.$dic[213].': </dt><dd>'.$dic[$ee->gender].'</dd>';
$t.=($ee->development == '')?'<dt>'.$dic[208].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[208].': </dt><dd>'.$dic[$ee->development].'</dd>';
$t.='<dt>'.$dic[112].': </dt><dd>'.$ee->metamorphosis.'</dd>';
$t.='</dl>';
$t.='</div>';
$t.='<div id="dvdescricao">';
$t.='<br><center><h2>'.$dic[224].'</h2></center><br><dl>';
$t.='<dt>'.$dic[114].': </dt><dd>'.$ee->colors.'</dd>';
$t.='<dt>'.$dic[116].': </dt><dd>'.$ee->bbody.'</dd>';
if ($ee->classe == "16") {
$t.='<dt>'.$dic[118].': </dt><dd>'.$ee->hhead.'</dd>';
$t.='<dt>'.$dic[120].': </dt><dd>'.$ee->thorax.'</dd>';
$t.='<dt>'.$dic[122].': </dt><dd>'.$ee->abdomen.'</dd>';
} // insetos
else {
if (($ee->classe == "13") or ($ee->classe == "17")) {
$t.='<dt>'.$dic[320].': </dt><dd>'.$ee->hhead.'</dd>';
$t.='<dt>'.$dic[122].': </dt><dd>'.$ee->abdomen.'</dd>';
} // aranhas...
else {
$t.='<dt>'.$dic[118].': </dt><dd>'.$ee->hhead.'</dd>';
$t.='<dt>'.$dic[321].': </dt><dd>'.$ee->thorax.'</dd>';
} // nao aranhas.
} // nao insetos
if ($ee->classe <> "13") {
$t.=($ee->lstantennae == '')?'<dt>'.$dic[198].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[198].': </dt><dd>'.$dic[$ee->lstantennae].'</dd>';
$t.='<dt>'.$dic[126].': </dt><dd>'.$ee->antennae.'</dd>';
} // nao e aranha...
$t.='<dt>'.$dic[128].': </dt><dd>'.$ee->eyesandocelli.'</dd>';
$t.=($ee->lstmouthparts == '')?'<dt>'.$dic[199].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[199].': </dt><dd>'.$dic[$ee->lstmouthparts].'</dd>';
$t.='<dt>'.$dic[131].': </dt><dd>'.$ee->mouthparts.'</dd>';
if ($ee->classe == "16") {
$t.=($ee->lstwings == '')?'<dt>'.$dic[200].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[200].': </dt><dd>'.$dic[$ee->lstwings].'</dd>';
$t.='<dt>'.$dic[134].': </dt><dd>'.$ee->wings.'</dd>';
$t.=($ee->lsthindwings == '')?'<dt>'.$dic[201].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[201].': </dt><dd>'.$dic[$ee->lsthindwings].'</dd>';
$t.='<dt>'.$dic[137].': </dt><dd>'.$ee->hindwings.'</dd>';
}
$t.=($ee->lstnumlegs == '')?'<dt>'.$dic[202].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[202].': </dt><dd>'.$dic[$ee->lstnumlegs].'</dd>';
$t.=($ee->lstlegs == '')?'<dt>'.$dic[203].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[203].': </dt><dd>'.$dic[$ee->lstlegs].'</dd>';
$t.='<dt>'.$dic[204].': </dt><dd>'.$ee->locomotive.'</dd>';
$t.=($ee->tarsomere == '')?'<dt>'.$dic[205].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[205].': </dt><dd>'.$dic[$ee->tarsomere].'</dd>';
$t.=($ee->cerci == '')?'<dt>'.$dic[206].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[206].': </dt><dd>'.$dic[$ee->cerci].'</dd>';
$t.='<dt>'.$dic[207].': </dt><dd>'.$ee->specificcharacteristics.'</dd>';
$t.='</dl>';
$t.='</div>';
$t.='<div id="dvcolecao">';
$t.='<br><center><h2>'.$dic[225].'</h2></center><br><dl>';
$t.='<dt>'.$dic[153].': </dt><dd>'.$ee->collecting.'</dd>';
$t.='<dt>'.$dic[155].': </dt><dd>'.$ee->place.'</dd>';
$t.='<dt>'.$dic[157].': </dt><dd>'.$ee->win.'</dd>';
$t.='<dt>'.$dic[159].': </dt><dd>'.$ee->address.'</dd>';
$t.='<dt>'.$dic[160].': </dt><dd>'.$ee->lat.'</dd>'; 
$t.='<dt>'.$dic[161].': </dt><dd>'.$ee->lng.'</dd>';
$t.='<dt>'.$dic[162].': </dt><dd>'.$ee->city.'</dd>';
$t.='<dt>'.$dic[163].': </dt><dd>'.$ee->uf.'</dd>';
$t.='<dt>'.$dic[164].': </dt><dd>'.$ee->country.'</dd>';
$t.='<dt>'.$dic[165].': </dt><dd>'.$ee->datacad.'</dd>';
$t.='<dt>'.$dic[166].': </dt><dd>'.$ee->temperature.'</dd>';
$t.='</dl>';
$t.='</div>';
$t.='<div id="dvnotes">';
if (strlen($ee->notes) > 0) {
$t.='<br><center><h2>'.$dic[170].'</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->notes).'</p><br>';
}
$t.='</div>';
$t.='<div id="dvaudio">';
if (strlen($ee->audiodesc) > 0) {
$t.='<br><center><h2>'.$dic[174].'</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->audiodesc).'</p><br>';
}
$t.='</div>';
$t.='<div id="dvtext">';
if (strlen($ee->mediation) > 0) {
$t.='<br><center><h2>'.$dic[168].'</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->mediation).'</p><br>';
}
$t.='</div>';
$t.='<div id="dvbibliografia">';
if (strlen($ee->water) > 0) {
 $t.='<br><center><h2>'.$dic[177].'</h2></center><br>';
$t.='<p align="justify">'.texttolink(str_replace(chr(13),'<br>',$ee->water)).'</p><br>';
} 
$t.='</div>';
$t.='<div id="dvartropode">';
if (($ee->classe != '') and ($ee->classe != '92')) { $t.=$dic[$ee->classe+217]; }
$t.='</div>';
$t.='<br>';

$l = array('userid' => $ee->userid, 'users' => $ee->ground, 'commonname' => $ee->commonname.', '.$ee->scientificname, 'text' => $t);
return $l;
 } // da funcao...

function gettextfunction($id, $dic, $lang,$uid,$ustatus) {
$ee = new snapsectClass($id,$lang);
$ee->id = $id;
// recuperando as fotos...
$l = $ee->photos->getlist($id,1);
$fotos = $l;

// recuperando os videos...

$l = $ee->photos->getlistvideo($id,0);
$videos = $l;

// recuperando os audios...

$l = $ee->photos->getlistaudio($id,0);
$audios = $l;

$t = '';
$t.='<br><center><h2>'.$dic[220].'</h2></center><br><dl>';
$t.='<dt>'.$dic[221].': </dt><dd>'.$ee->author.'</dd>';
if (strlen($ee->email) >0) { $t.='<dt>'.$dic[187].': </dt><dd><a href="mailto:'.$ee->email.'">'.$ee->email.'</a></dd>'; }
if (strlen($ee->url) >0) { $t.='<dt>'.$dic[189].': </dt><dd><a href="'.$ee->url.'">'.$ee->url.'</a></dd>'; }
if (strlen($ee->colaborative) >0) { $t.='<dt>'.$dic[191].': </dt><dd>'.$ee->colaborative.'</dd>'; }
$t.='</dl>';
$t.='<div id="dvidentificacao">';
$t.='<br><center><h2>'.$dic[222].'</h2></center><br><dl>';
$t.='<dt>'.$dic[8].': </dt><dd>'.$ee->commonname.'</dd>';
$t.='<dt>'.$dic[86].': </dt><dd>'.$ee->scientificname.'</dd>';
$t.='<dt>'.$dic[88].': </dt><dd>'.$ee->other.'</dd>';
$t.='<dt>'.$dic[89].': </dt><dd>'.$ee->kingdom.'</dd>';
$t.='<dt>'.$dic[90].': </dt><dd>'.$ee->phylum.'</dd>';
$t.=($ee->classe == '')?'<dt>'.$dic[211].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[211].': </dt><dd>'.$dic[$ee->classe].'</dd>';
$t.='<dt>'.$dic[94].': </dt><dd>'.$ee->oorder.'</dd>';
$t.='<dt>'.$dic[19].': </dt><dd>'.$ee->family.'</dd>';
$t.='<dt>'.$dic[97].': </dt><dd>'.$ee->genus.'</dd>';
$t.='<dt>'.$dic[99].': </dt><dd>'.$ee->species.'</dd>';
$t.=($ee->gender == '')?'<dt>'.$dic[213].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[213].': </dt><dd>'.$dic[$ee->gender].'</dd>';
$t.=($ee->development == '')?'<dt>'.$dic[208].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[208].': </dt><dd>'.$dic[$ee->development].'</dd>';
$t.='<dt>'.$dic[112].': </dt><dd>'.$ee->metamorphosis.'</dd>';
$t.='</dl></div>';
$t.='<div id="dvdescricao">';
$t.='<br><center><h2>'.$dic[224].'</h2></center><br><dl>';
$t.='<dt>'.$dic[114].': </dt><dd>'.$ee->colors.'</dd>';
$t.='<dt>'.$dic[116].': </dt><dd>'.$ee->bbody.'</dd>';
if ($ee->classe == "16") {
$t.='<dt>'.$dic[118].': </dt><dd>'.$ee->hhead.'</dd>';
$t.='<dt>'.$dic[120].': </dt><dd>'.$ee->thorax.'</dd>';
$t.='<dt>'.$dic[122].': </dt><dd>'.$ee->abdomen.'</dd>';
} // insetos
else {
if (($ee->classe == "13") or ($ee->classe == "17")) {
$t.='<dt>'.$dic[320].': </dt><dd>'.$ee->hhead.'</dd>';
$t.='<dt>'.$dic[122].': </dt><dd>'.$ee->abdomen.'</dd>';
} // aranhas...
else {
$t.='<dt>'.$dic[118].': </dt><dd>'.$ee->hhead.'</dd>';
$t.='<dt>'.$dic[321].': </dt><dd>'.$ee->thorax.'</dd>';
} // nao aranhas.
} // nao insetos
if ($ee->classe <> "13") {
$t.=($ee->lstantennae == '')?'<dt>'.$dic[198].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[198].': </dt><dd>'.$dic[$ee->lstantennae].'</dd>';
$t.='<dt>'.$dic[126].': </dt><dd>'.$ee->antennae.'</dd>';
} // nao e aranha...
$t.='<dt>'.$dic[128].': </dt><dd>'.$ee->eyesandocelli.'</dd>';
$t.=($ee->lstmouthparts == '')?'<dt>'.$dic[199].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[199].': </dt><dd>'.$dic[$ee->lstmouthparts].'</dd>';
$t.='<dt>'.$dic[131].': </dt><dd>'.$ee->mouthparts.'</dd>';
if ($ee->classe == "16") {
$t.=($ee->lstwings == '')?'<dt>'.$dic[200].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[200].': </dt><dd>'.$dic[$ee->lstwings].'</dd>';
$t.='<dt>'.$dic[134].': </dt><dd>'.$ee->wings.'</dd>';
$t.=($ee->lsthindwings == '')?'<dt>'.$dic[201].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[201].': </dt><dd>'.$dic[$ee->lsthindwings].'</dd>';
$t.='<dt>'.$dic[137].': </dt><dd>'.$ee->hindwings.'</dd>';
}
$t.=($ee->lstnumlegs == '')?'<dt>'.$dic[202].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[202].': </dt><dd>'.$dic[$ee->lstnumlegs].'</dd>';
$t.=($ee->lstlegs == '')?'<dt>'.$dic[203].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[203].': </dt><dd>'.$dic[$ee->lstlegs].'</dd>';
$t.='<dt>'.$dic[204].': </dt><dd>'.$ee->locomotive.'</dd>';
$t.=($ee->tarsomere == '')?'<dt>'.$dic[205].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[205].': </dt><dd>'.$dic[$ee->tarsomere].'</dd>';
$t.=($ee->cerci == '')?'<dt>'.$dic[206].': </dt><dd>'.$dic[92].'</dd>':'<dt>'.$dic[206].': </dt><dd>'.$dic[$ee->cerci].'</dd>';
$t.='<dt>'.$dic[207].': </dt><dd>'.$ee->specificcharacteristics.'</dd>';
$t.='</dl>';
$t.='</div>';
$t.='<div id="dvcolecao">';
$t.='<br><center><h2>'.$dic[225].'</h2></center><br><dl>';
$t.='<dt>'.$dic[153].': </dt><dd>'.$ee->collecting.'</dd>';
$t.='<dt>'.$dic[155].': </dt><dd>'.$ee->place.'</dd>';
$t.='<dt>'.$dic[157].': </dt><dd>'.$ee->win.'</dd>';
$t.='<dt>'.$dic[159].': </dt><dd>'.$ee->address.'</dd>';
$t.='<dt>'.$dic[160].': </dt><dd>'.$ee->lat.'</dd>'; 
$t.='<dt>'.$dic[161].': </dt><dd>'.$ee->lng.'</dd>';
$t.='<dt>'.$dic[162].': </dt><dd>'.$ee->city.'</dd>';
$t.='<dt>'.$dic[163].': </dt><dd>'.$ee->uf.'</dd>';
$t.='<dt>'.$dic[164].': </dt><dd>'.$ee->country.'</dd>';
$t.='<dt>'.$dic[165].': </dt><dd>'.$ee->datacad.'</dd>';
$t.='<dt>'.$dic[166].': </dt><dd>'.$ee->temperature.'</dd>';
$t.='</dl>';
$t.='</div>';
$t.='<div id="dvnotes">';
if (strlen($ee->notes) > 0) {
$t.='<br><center><h2>'.$dic[170].'</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->notes).'</p><br>';
}
$t.='</div>';
$t.='<div id="dvaudio">';
if (strlen($ee->audiodesc) > 0) {
$t.='<br><center><h2>'.$dic[174].'</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->audiodesc).'</p><br>';
}
$t.='</div>';
$t.='<div id="dvtext">';
if (strlen($ee->mediation) > 0) {
$t.='<br><center><h2>'.$dic[168].'</h2></center><br>';
$t.='<p align="justify">'.str_replace(chr(13),'<br>',$ee->mediation).'</p><br>';
}
$t.='</div>';
$t.='<div id="dvbibliografia">';
if (strlen($ee->water) > 0) {
 $t.='<br><center><h2>'.$dic[177].'</h2></center><br>';
$t.='<p align="justify">'.texttolink(str_replace(chr(13),'<br>',$ee->water)).'</p><br>';
} 
$t.='</div>';
$t.='<div id="dvartropode">';
if (($ee->classe != '') and ($ee->classe != '92')) { $t.=$dic[$ee->classe+217]; }
$t.='</div>';
$t.='<br>';

$l = array('id' => $ee->id, 'userid' => $ee->userid, 'users' => $ee->ground, 'commonname' => $ee->commonname.', '.$ee->scientificname, 'photos' => $fotos, 'videos' => $videos, 'audios' => $audios, 'data' => $ee, 'text' => $t);
return $l;
 } // da funcao...
