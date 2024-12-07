<?php 

function deltree($d) {
$pasta = $d;
if ($pasta[strlen($pasta)-1] <> '/') { $pasta.='/'; }
$diretorio= dir($d);
while($arquivo= $diretorio-> read()){
if (is_dir($pasta.$arquivo)) {
if (strlen($arquivo) > 2) { 
deltree($pasta . $arquivo);
 }
} // diretorio...
else {
unlink($pasta . $arquivo);
} // arquivo...
} // do while
$diretorio-> close();
rmdir($pasta);
} // da funcao...

function gettables($host, $user, $pass, $db) {
$l = array();
$mycon = mysqli_connect($host, $user, $pass, $db);  

$showtables= mysqli_query($mycon,"SHOW TABLES FROM ".$db); // database_name");

while($table = mysqli_fetch_array($showtables)) { // go through each row that was returned in $result
   $l[] = $table[0];    // print the table that was returned on that row.
}
return $l;
} // da funcao

function backup_tables($host,$user,$pass,$name,$tables = '*', $dr)
{
if (strlen($dr) > 0) {
if (!file_exists($dr)) { mkdir($dr); }
} // verificando a pasta...
$tt = '';
	
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$tt.= 'DROP TABLE IF EXISTS '.$table.';#|#';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$tt.= "".$row2[1].";#|#";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$tt.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = str_replace("\n","",$row[$j]);
					if (isset($row[$j])) { $tt.= '"'.$row[$j].'"' ; } else { $tt.= '""'; }
					if ($j < ($num_fields-1)) { $tt.= ','; }
				}
				$tt.= ");#|#";
			}
		}
		$tt.="\n\n\n";
	}
	
	//save file
	$handle = fopen($dr.'/'.$table.'.sql','w+');
	fwrite($handle,$tt);
	fclose($handle);
} // da funcao

function Zip($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
} // da funcao.

$diretorio = 'backup';
// $zip = new ZipArchive();
// if($zip->open('backup.zip', ZIPARCHIVE::CREATE) == TRUE)
// {

$lsttables = gettables("localhost", "limafj_snpscts", "Domvirt@SnapSects018","limafj_snapsect");  
for ($r=0;$r<count($lsttables);$r++) {
backup_tables("localhost", "limafj_snpscts", "Domvirt@SnapSects018","limafj_snapsect", $lsttables[$r], $diretorio);
// $zip->addFile($diretorio.'/'.$lsttables[$r].'.sql',$lsttables[$r].'.sql');
echo $lsttables[$r] .' ok...<br>';
} // do while
// } // ok... gerou o zip...
// $zip->close();

// header('Content-Description: File Transfer');
 
// header('Content-Disposition: attachment; filename="backup.zip"');
 
// header('Content-Type: application/save');
 
// header('Content-Transfer-Encoding: binary');
 
// header('Content-Length: '.filesize('backup.zip'));
 
// header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
 
// header('Pragma: public');
 
// header('Expires: 0');
  
 
// Envia o arquivo para o cliente
 
// readfile('backup.zip');

// header("Content-Type: application/save"); 
// header("Content-Length:".filesize('backup.zip')); 
// header('Content-Disposition: attachment; filename="backup.zip"'); 
// header("Content-Transfer-Encoding: binary");
// header('Expires: 0'); 
// header('Pragma: no-cache'); 


// $fp = fopen("backup.zip", "r"); 
// fpassthru($fp); 
// fclose($fp);

// $arquivo='backup.zip';

// define('DIR_DOWNLOAD', __DIR__ . '/');

// $caminho_download=DIR_DOWNLOAD . $arquivo;

// if (!file_exists($caminho_download)) {
// echo "erro no nome do arquivo";
// exit;
// } // nao existe...

// header("Content-Type: application/zip"); 
// header("Content-Length:".filesize($caminho_download)); 
// header('Content-Disposition: attachment; filename="backup.zip"'); 
// header("Content-Transfer-Encoding: binary");
// header('Expires: 0'); 
// header('Pragma: no-cache'); 


// readfile($caminho_download);

Zip('backup','backup.zip');
// Zip('../photos','photos.zip');
echo 'ok, terminei...';
?>