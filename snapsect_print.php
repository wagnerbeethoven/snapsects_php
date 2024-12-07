<?php
session_start();
if (!isset($_SESSION["ssid"]) == true) {
$_SESSION["ssid"] = 0;
$_SESSION["ssnome"] = '';
$_SESSION["ssemail"] = '';
$_SESSION["ssstatus"] = 0;
$_SESSION["ssurl"] = '';
$_SESSION["language"] = 'pt-BR';
}

include "scripts/config.php";
require("scripts/Template.class.php");
include "scripts/snapsect_class.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
 $tpl = new Template("templates/layout_sample.html",false,"templates/partial/snapsect_print.html","SnapSects");
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
if ($id > 0) {
$tp = new snapsectClass($id);
} // existe...
$hoje = getdate();
if (isset($_GET["lang"]))
$_SESSION["language"] = $_GET["lang"];

$ddic = opendicionario($_SESSION["language"]);
$dic = $ddic["dic"];

$tpl->ID = $id;
// $tpl->CODID = $id;
$le = gettextfunction($id, $dic, $_SESSION["language"],$_SESSION["ssid"],$_SESSION["ssstatus"]);
// $tpl->TEXTO = file_get_contents($site_url.'snapsect_api.php?act=gettext&id='.$id.'&lang='.$_SESSION["language"].'&uid='.$_SESSION["ssid"].'&ust='.$_SESSION["ssstatus"]);

$ee = $le["data"];
$media_url = SITE_URL.'photos/'.$_SESSION["language"][0].$_SESSION["language"][1].'/'.$id.'/';
$t = '<center><h2>'.$ee->commonname.' ('.$ee->scientificname.')</h2></center>';
if (strlen($ee->photo) > 0) {
$t .= '<br><center><img id="grpi" src="'.$media_url.$ee->photo.'" alt="'.$dic[219].' '.$ee->commonname.' ('.$ee->scientificname.') - '.$ee->photodesc.'" width="500px" onload="redimensiona();" onclick="showimg('.$id.", '".$ee->photo."');".'" /></center><br>';
}

$l = $le["photos"];
$phtxt = '';
if (count($l) > 0) {
if (count($l) == 1) {
$phtxt = '<center><img src="'.$media_url.$l[0]["url"].'" width="300px" ';
$phtxt.=(strlen($l[0]["text"]) > 0)?'alt="'.$l[0]["text"].'"':'alt="Image"';
$phtxt.=' onclick="showimg('.$id.", '".$l[0]["url"]."');".'"></center>';
} // apenas uma foto...
else {
$phtxt .='<table border="0" width="100%"><tr>';
$pht = 1;
for ($r=0;$r<count($l);$r++) {
$phtxt .= '<td width="33%"><center><img src="'.$media_url.$l[$r]["url"].'" width="300px" ';
$phtxt .=(strlen($l[$r]["text"]) > 0)?'alt="'.$l[$r]["text"].'"':'alt="Image"';
$phtxt .=' onclick="showimg('.$id.", '".$l[$r]["url"]."');".'"></center>';
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
$t.=$phtxt;

$tpl->TEXTO = $t.$le["text"];
$tpl->LANG = $_SESSION["language"];
// $tpl->LANGUAGE = $_SESSION["language"];
$tpl->show(0,$_SESSION["language"]);
?>
