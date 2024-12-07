<?php
session_start();
echo "antes do config";
include "scripts/config.php";

echo "abri o config...";
$res = $users->Find('select * from [banco]');
while($n=mysqli_fetch_array($res)) {
$users->GetRes($n);
$users->pws = md5($users->pws);
$users->Save();
} // do for...
echo 'ok, terminei...';
?>