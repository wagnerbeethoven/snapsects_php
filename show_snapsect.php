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
// include "scripts/diclib.php";
 
$erros = array("'", chr(34), "<", ">");
$id = 0;
 
 $tpl = new Template("templates/layout_base.html",false,"templates/partial/show_snapsect.html");
// include "scripts/header.php";
if (isset($_GET["id"]))
$id = str_replace($erros, "", $_GET["id"]);
 
if ($id > 0) {
$tp = new snapsectClass($id);

$hoje = getdate();
if (isset($_GET["lang"]))
$_SESSION["language"] = $_GET["lang"];

$ddic = opendicionario($_SESSION["language"]);
$dic = $ddic["dic"];

$tpl->ID = $id;
$tpl->CODID = $id;
$le = gettextfunction($id, $dic, $_SESSION["language"],$_SESSION["ssid"],$_SESSION["ssstatus"]);
$ee = $le["data"];
$media_url = SITE_URL.'photos/'.$_SESSION["language"][0].$_SESSION["language"][1].'/'.$id.'/';
$t = '<center><h2>'.$ee->commonname.' ('.$ee->scientificname.')</h2></center>';
if (strlen($ee->photo) > 0) {
$t .= '<br><center><img id="grpi" src="'.$media_url.$ee->photo.'" alt="'.$dic[219].' '.$ee->commonname.' ('.$ee->scientificname.') - '.$ee->photodesc.'" width="500px" onload="redimensiona();" onclick="showimg('.$id.", '".$ee->photo."');".'" /></center><br>';
}
$tpl->SHOWTITULO = $t;

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
$tpl->SHOWFOTOS = $phtxt;

$l = $le["videos"];
$phtxt = '';
if (count($l) > 0) {
$phtxt.='<ul>';
foreach($l as $r) {
$phtxt .= '<li><button onclick="javascript:showvideo('."'".$media_url.$r["url"]."');".'" >'.$r["text"].'</button>';
if (($_SESSION["ssstatus"] > 49) || ($_SESSION["ssid"].'' == $ee->userid.'')) {
$phtxt .= '   <button onclick="javascript: delvideo('.$id.", '".$media_url.$r["url"]."');".'" >'.$dic[370].' - '.$r["text"].'</button>';
} // mostrando o botao de remover
$phtxt .= '</li>';
} // do for...
$phtxt.='</ul>';
} // existem videos.

$tpl->SHOWVIDEOS = $phtxt;

$l = $le["audios"];
$phtxt = '';
if (count($l) > 0) {
$phtxt.='<ul>';
$ccc = 0;
foreach($l as $r) {
$ccc = $ccc + 1;
$phtxt .= '<li><input type="button" id="cmdaudio'.$ccc.'" onclick="javascript:showaudio('."'".$media_url.$r["url"]."');".'" value="'.$r["text"].'">';
// $phtxt.='<audio controls>';
// $pxurl = explode('.',$r["url"]);
// $audiourl = $pxurl[count($pxurl)-1];
// $phtxt.='<source src="'.SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"].'" type="audio/'.$audiourl.'">';
// $phtxt.='<embed height="60" type="audio/midi" width="144" src="'.SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"].'" loop="false" autostart="false" />';
// $phtxt.='</audio>';
// $phtxt.='<embed height="60" type="audio/midi" width="144" src="'.SITE_URL.$ee->photos->pasta.$id.'/'.$r["url"].'" loop="false" autostart="false" />';
if (($_SESSION["ssstatus"] > 49) || ($_SESSION["ssid"].'' == $ee->userid.'')) {
$phtxt .= '   <button onclick="javascript: delvideo('.$id.", '".$media_url.$r["url"]."');".'" >'.$dic[370].' - '.$r["text"].'</button>';
} // mostrando o botao de remover
$phtxt .= '</li>';
} // do for...
$phtxt.='</ul>';
} // existem videos.
$phtxt.='</div>';

$tpl->SHOWAUDIOS = $phtxt;
$tpl->TEXTO = $le["text"];
if (($_SESSION["ssid"] == $tp->userid) || (strpos(' '.$tp->ground,'|'.$_SESSION["ssid"].'|') > 0) || ($_SESSION["ssstatus"] > 49) || ($tp->userid == 0)) {
$tpl->block("BLOCK_EDIT");
$tpl->block("BLOCK_VIDEOFUNC");
} // logado
else {
$tpl->block("BLOCK_NOEDIT");
} // not user...

$tpl->LANG = $_SESSION["language"];
$tpl->LANGUAGE = $_SESSION["language"];
$tpl->LANG = $_SESSION["language"];
$tpl->show(0,$_SESSION["language"]);
} else {
?>
<script>
window.location='index.php';
</script>
<?php
}
?>
