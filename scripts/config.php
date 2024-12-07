<?php 
if (!isset($_SESSION["language"])) $_SESSION["language"] = 'pt-br';
$site_url = 'http://www.snapsects.com/';
$server_email = 'hi@snapsects.com';
$server_name = "SnapSects"; // para o nome que do remetente do email...

define("DBSERV", "localhost");
define("DBUSER", "limafj_snpscts");
define("DBPASS", "Domvirt@SnapSects018");
define("DBDB", "limafj_snapsect");

define("SITE_URL", "http://www.snapsects.com/");

include "scripts/snapsect_userclass.php";