<?php 
require_once 'DB_CONFIG.php';
require_once 'TemplateSettings.php';
//$mycon = mysqli_connect("localhost", "limafj_snpscts", "Domvirt@SnapSects018","limafj_snapsect")  
$mycon = mysqli_connect(HOST, USER, PASS,DB_NAME)  
or die("Nao foi possivel conectar"); 

$site_url = TemplateSettings::getSiteUrl();
$server_email = 'hi@snapsects.com';
$server_name = "SnapSects"; // para o nome que do remetente do email...

