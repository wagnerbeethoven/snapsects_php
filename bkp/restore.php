<?php
function openbackup($file) {
$myc = mysqli_connect("localhost", "limafj_snpscts", "Domvirt@SnapSects018","limafj_snapsect");  
$sql = file_get_contents($file);
$l = explode('#|#',$sql);
$t = str_replace('`','', $l[1]);

$l[1] = $t;

for ($r=0;$r<count($l);$r++) {
if (strlen($l[$r]) > 10) {
echo '<br>'.$r.' - '.$l[$r].'<br>';
$res = mysqli_query($myc, $l[$r]) or die('falha na execucao da linha '.$r);
}
} // do for...
} // da funcao...

$basedir = 'backup/';
$diretorio= dir($basedir);
while($arquivo= $diretorio-> read()){
if (strpos($arquivo,'.sql') > 0) {
echo '<br>** '.$arquivo.' **<br>';
openbackup($basedir.$arquivo);
} // arquivos lang...
}
$diretorio-> close();

echo '<br>Terminou com exito!!! **<br>';
// openbackup('backup.sql');
