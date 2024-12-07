<?php
$lang = $_SESSION["language"];
if (isset($_GET["lang"]))
$lang = $_GET["lang"];
if (strlen($lang) > 0) { $_SESSION["language"] = $lang; }

if ($_SESSION["ssstatus"] > "0") {
if ($_SESSION["ssstatus"] == 5) {
$tpl->block("BLOCK_PROF");
} // prof...
if ($_SESSION["ssstatus"] > '60') {
$tpl->block("BLOCK_PROF");
$tpl->block("BLOCK_ADM");
}
$tpl->block("BLOCK_LOGADO");
} else {
$tpl->block("BLOCK_DESLOGADO");
}

$ll = getlistofdic();
for ($r=0;$r<count($ll);$r++) {
$tpl->LANGID = $ll[$r]["id"];
$tpl->LANGNAME = $ll[$r]["name"];
if ($ll[$r]["id"] == $_SESSION["language"]) { $tpl->SELECIONADO = 'selected'; } else { $tpl->SELECIONADO = ''; }
$tpl->block('BLOCK_DIC');
$tpl->block('BLOCK_DIC2');
} // do for...

$tpl->LANG = $lang;

