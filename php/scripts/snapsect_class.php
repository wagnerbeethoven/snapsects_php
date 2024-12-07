<?php
require_once 'DB_CONFIG.php';

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
$sql = "select * from snapsect_photo where id = $n";
$res=mysqli_query($this->mycon,$sql);
$this->GetRes(mysqli_fetch_array($res));
} // da funcao open...
 
public function Save() {
// verificando se a chave já existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update snapsect_photo set userid=".$this->userid.",codid=".$this->codid.",datacad='".$this->datacad."', url='".$this->url."', title='".$this->title."', obs='".$this->obs."' where id = $this->id";
else
$sql = "insert into snapsect_photo(userid,codid,datacad,url,title,obs)  values(".$this->userid.",".$this->codid.",'".$this->datacad."', '".$this->url."', '".$this->title."', '".$this->obs."')";
$res=mysqli_query($this->mycon,$sql);
} // da funcao save
 
public function Create_Table() {
$sql="DROP TABLE IF EXISTS snapsect_photo;";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE snapsect_photo(id INT AUTO_INCREMENT PRIMARY KEY, userid INT, codid INT, datacad TEXT, url TEXT, title TEXT, obs TEXT );";
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
$this->mycon = mysqli_connect(HOST, USER,PASS,DB_NAME);  
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
$this->photo = $nv["photo"];
$this->photodesc = $nv["photodesc"];
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
$sql = "select * from snapsect where id = $n";
$res=mysqli_query($this->mycon,$sql);
$this->GetRes(mysqli_fetch_array($res));
} // da funcao open...
 
public function Save() {
// verificando a data do cadastro...
if (strlen($this->datacad) < 1) { $this->datacad = date("Y-m-d H:i:s"); }
// verificando se a chave já existe...
$tp="";
if ($this->id > 0) $tp="edt";
if ($tp == "edt")
$sql = "update snapsect set status=".$this->status.",userid=".$this->userid.",author='".$this->author."', email='".$this->email."', url='".$this->url."', colaborative='".$this->colaborative."', commonname='".$this->commonname."', scientificname='".$this->scientificname."', kingdom='".$this->kingdom."', phylum='".$this->phylum."', classe='".$this->classe."', oorder='".$this->oorder."', family='".$this->family."', genus='".$this->genus."', species='".$this->species."', gender='".$this->gender."', colors='".$this->colors."', bbody='".$this->bbody."', hhead='".$this->hhead."', thorax='".$this->thorax."', abdomen='".$this->abdomen."', lstantennae='".$this->lstantennae."', antennae='".$this->antennae."', eyesandocelli='".$this->eyesandocelli."', lstmouthparts='".$this->lstmouthparts."', mouthparts='".$this->mouthparts."', lstwings='".$this->lstwings."', wings='".$this->wings."', lstnumlegs='".$this->lstnumlegs."', lsthindwings='".$this->lsthindwings."', hindwings='".$this->hindwings."', lstlegs='".$this->lstlegs."', cerci='".$this->cerci."', tarsomere='".$this->tarsomere."', locomotive='".$this->locomotive."', specificcharacteristics='".$this->specificcharacteristics."', development='".$this->development."', metamorphosis='".$this->metamorphosis."', collecting='".$this->collecting."', place='".$this->place."', water='".$this->water."', ground='".$this->ground."', other='".$this->other."', mediation='".$this->mediation."', notes='".$this->notes."', audiodesc='".$this->audiodesc."', datacad='".$this->datacad."', lat='".$this->lat."', lng='".$this->lng."', city='".$this->city."', country='".$this->country."', uf='".$this->uf."', address='".$this->address."', photo='".$this->photo."', photodesc='".$this->photodesc."', win='".$this->win."', temperature='".$this->temperature."' where id = $this->id";
else
$sql = "insert into snapsect(status,userid,author,email,url,colaborative,commonname,scientificname,kingdom,phylum,classe,oorder,family,genus,species,gender,colors,bbody,hhead,thorax,abdomen,lstantennae,antennae,eyesandocelli,lstmouthparts,mouthparts,lstwings,wings,lstnumlegs,lsthindwings,hindwings,lstlegs,cerci,tarsomere,locomotive,specificcharacteristics,development,metamorphosis,collecting,place,water,ground,other,mediation,notes,audiodesc,datacad,lat,lng,city,country,uf,address,photo,photodesc,win,temperature)  values(".$this->status.",".$this->userid.",'".$this->author."', '".$this->email."', '".$this->url."', '".$this->colaborative."', '".$this->commonname."', '".$this->scientificname."', '".$this->kingdom."', '".$this->phylum."', '".$this->classe."', '".$this->oorder."', '".$this->family."', '".$this->genus."', '".$this->species."', '".$this->gender."', '".$this->colors."', '".$this->bbody."', '".$this->hhead."', '".$this->thorax."', '".$this->abdomen."', '".$this->lstantennae."', '".$this->antennae."', '".$this->eyesandocelli."', '".$this->lstmouthparts."', '".$this->mouthparts."', '".$this->lstwings."', '".$this->wings."', '".$this->lstnumlegs."', '".$this->lsthindwings."', '".$this->hindwings."', '".$this->lstlegs."', '".$this->cerci."', '".$this->tarsomere."', '".$this->locomotive."', '".$this->specificcharacteristics."', '".$this->development."', '".$this->metamorphosis."', '".$this->collecting."', '".$this->place."', '".$this->water."', '".$this->ground."', '".$this->other."', '".$this->mediation."', '".$this->notes."', '".$this->audiodesc."', '".$this->datacad."', '".$this->lat."', '".$this->lng."', '".$this->city."', '".$this->country."', '".$this->uf."', '".$this->address."', '".$this->photo."', '".$this->photodesc."', '".$this->win."', '".$this->temperature."')";
$res=mysqli_query($this->mycon, $sql);
// recuperando o id
if ($this->id < 1) {
$sql = "select * from snapsect where datacad ='".$this->datacad."' and commonname = '".$this->commonname."' and scientificname = '".$this->scientificname."'";
$res = mysqli_query($this->mycon, $sql);
while($r=mysqli_fetch_array($res)) {
return $r["id"];
} // do while
} else { return $this->id; }
} // da funcao save
 
public function Create_Table() {
$sql="DROP TABLE IF EXISTS snapsect;";
$res=mysqli_query($this->mycon, $sql);
$sql = "CREATE TABLE snapsect(id INT AUTO_INCREMENT PRIMARY KEY, status INT, userid INT, author TEXT, email TEXT, url TEXT, colaborative TEXT, commonname TEXT, scientificname TEXT, kingdom TEXT, phylum TEXT, classe TEXT, oorder TEXT, family TEXT, genus TEXT, species TEXT, gender TEXT, colors TEXT, bbody TEXT, hhead TEXT, thorax TEXT, abdomen TEXT, lstantennae TEXT, antennae TEXT, eyesandocelli TEXT, lstmouthparts TEXT, mouthparts TEXT, lstwings TEXT, wings TEXT, lstnumlegs TEXT, lsthindwings TEXT, hindwings TEXT, lstlegs TEXT, cerci TEXT, tarsomere TEXT, locomotive TEXT, specificcharacteristics TEXT, development TEXT, metamorphosis TEXT, collecting TEXT, place TEXT, water TEXT, ground TEXT, other TEXT, mediation TEXT, notes TEXT, audiodesc TEXT, datacad TEXT, lat TEXT, lng TEXT, city TEXT, country TEXT, uf TEXT, address TEXT, photo TEXT, photodesc TEXT, win TEXT, temperature TEXT );";
$res=mysqli_query($this->mycon, $sql);
} // da criacao da tabela
 
public function Delete($n) {
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
 
public function __construct($id = 0) {
//$this->mycon = mysqli_connect("localhost", "limafj_snpscts", "Domvirt@SnapSects018","limafj_snapsect");  
$this->mycon = mysqli_connect("localhost", "root", "","limafj_snapsect");  
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
?>
