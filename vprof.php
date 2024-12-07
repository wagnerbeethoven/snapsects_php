<?php
include "scripts/config.php";
$m = mysqli_connect(DBSERV, DBUSER, DBPASS,DBDB);  
$sql = "select distinct(email) from snapsects_salas";
$res = mysqli_query($m, $sql);
while($n=mysqli_fetch_array($res)) {
if (!file_exists('school/'.$n["email"])) {
echo '* '.$n["email"].' *<br>';
// remove aqui as provas
$ss = "delete from snapsects_provas where email='".$n["email"]."'";
$rr = mysqli_query($m,$ss);

$ss = "delete from snapsects_salas where email='".$n["email"]."'";
$rr = mysqli_query($m,$ss);

}
} // do while...
