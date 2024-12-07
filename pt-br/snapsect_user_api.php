<?php
include "scripts/config.php";
include "scripts/snapsect_userclass.php";
 
$erros = array("'", chr(34), "<", ">");
 
if (isset($_GET["act"]))
$act = str_replace($erros, "", $_GET["act"]);
 
if ($act == "add") {
 
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
else
$id = 0;
 
$tp = new snapsect_UserClass($id);
$tp->id = $id;
 
if (isset($_GET["status"]))
$tp->status = str_replace($erros, "", $_GET["status"]);
if (strlen($tp->status) < 1) { $tp->status="0"; }
 
if (isset($_GET["nome"]))
$tp->nome = str_replace($erros, "", $_GET["nome"]);
 
if (isset($_GET["email"]))
$tp->email = str_replace($erros, "", $_GET["email"]);
 
if (isset($_GET["pws"]))
$tp->pws = str_replace($erros, "", $_GET["pws"]);
 
if (isset($_GET["url"]))
$tp->url = str_replace($erros, "", $_GET["url"]);
 
if (isset($_GET["obs"]))
$tp->obs = str_replace($erros, "", $_GET["obs"]);
 
$tp->Save();
 
$l = array("result" => "OK");
$data = JSON_encode($l);
echo $data;
} // salvando...
 
if (($act == "get") && (isset($_GET["id"]))) {
$id = str_replace($erros, "", $_GET["id"]);
 
$tp = new snapsect_UserClass($id);
$tp->id = $id;
 
$l = array("id" => $tp->id,"status" => $tp->status,"nome" => $tp->nome,"email" => $tp->email,"pws" => $tp->pws,"url" => $tp->url,"obs" => $tp->obs);
 
$data = JSON_encode($l);
echo $data;
 
} // recuperando os dados.
if ($act == "loc") {
 
$tp = new snapsect_UserClass();
 
$res = $tp->Find("select * from [banco]");
$l = array();
while($rs=mysqli_fetch_array($res)) {
$tp->GetRes($rs);
$l[count($l)] = array("id" => $tp->id, "status" => $tp->status, "nome" => $tp->nome, "email" => $tp->email, "pws" => $tp->pws, "url" => $tp->url, "obs" => $tp->obs );
} // do while...
$data = JSON_encode($l);
echo $data;
} // enviando os dados para o gerfile...

if ($act == "cuser") {
if (isset($_GET["email"]))
$email = str_replace($erros,'',$_GET["email"]);
if (isset($_GET["id"]))
$id = str_replace($erros,'',$_GET["id"]);
$u = new snapsect_UserClass();
$res = $u->Find('select * from [banco] where id='.$id.' and email="'.$email.'" and status=0;');
while($r=mysqli_fetch_array($res)) {
$u->GetRes($r);
$u->status=1;
$u->Save();
} // do while.
?>
<script>
window.location='<?php echo $site_url.'snapsect_ger.php'; ?>';
</script>
<?php
} // da funcao...
?>
