
    document.addEventListener("deviceready", function () {
convertpage(); // nao verifica alteracoes no dicionario

open_snapsect();

// dvother
var l = getother();
var texto = '<p><label for="lstother">'+dic[10]+': </label><select name="lstother" id="lstother" value="" onchange="javascript:filtro();">';
texto+='<option value="">'+dic[11]+'</option>';
var len = l.length - 1;
for (var r=0;r<len;r++) {
texto+='<option value="'+l[r]+'">'+l[r]+'</option>';
} // do for...
texto+='</select></p>';
document.getElementById('dvother').innerHTML = texto;
// order
var texto = '<p><label for="lstorder">'+dic[18]+': </label><select name="lstorder" id="lstorder" value="" onchange="javascript:filtro();">';
texto+='<option value="">'+dic[11]+'</option>';
var l = getorder();
var len = l.length - 1;
for (var r=0;r<len;r++) {
texto+='<option value="'+l[r]+'">'+l[r]+'</option>';
} // do for...
texto+='</select></p>';
document.getElementById('dvorder').innerHTML = texto;

var txt = dic[71];
    fala(txt,cvoz);

    }, false);

function filtro() {
var len = lst_snapsect.length;
var texto = '<table border=0 width="100%"><tr>';
texto+='<th>'+dic[8]+' / '+dic[86]+'</th>';
texto+='</tr>';
var contador = 0;
for (var r=0;r<len;r++) {
if (lst_snapsect[r].lstantennae.indexOf(document.getElementById('lstantennae').value) > -1) {
if (lst_snapsect[r].lstmouthparts.indexOf(document.getElementById('lstmouthparts').value) > -1) {
if (lst_snapsect[r].lstwings.indexOf(document.getElementById('lstwings').value) > -1) {
if (lst_snapsect[r].lstlegs.indexOf(document.getElementById('lstlegs').value) > -1) {
if ((lst_snapsect[r].commonname.toUpperCase().indexOf(document.getElementById('commonname').value.toUpperCase()) > -1) || (lst_snapsect[r].scientificname.toUpperCase().indexOf(document.getElementById('commonname').value.toUpperCase()) > -1)) {
if (lst_snapsect[r].oorder.indexOf(document.getElementById('lstorder').value) > -1) {
if (lst_snapsect[r].lstnumlegs.indexOf(document.getElementById('lstnumlegs').value) > -1) {
if (lst_snapsect[r].classe.indexOf(document.getElementById('classe').value) > -1) {
if (lst_snapsect[r].family.indexOf(document.getElementById('family').value) > -1) {
if (lst_snapsect[r].other.indexOf(document.getElementById('lstother').value) > -1) {
contador++;
texto+='<tr>';
texto+='<td><a id="btn'+r+'" href="#" onclick="javascript:abre('+r+');">';
if (lst_snapsect[r].commonname.length > 0) { texto+=lst_snapsect[r].commonname; } else {texto+=dic[92]; }
texto+=' / ';
if (lst_snapsect[r].scientificname.length > 0) { texto+=lst_snapsect[r].scientificname; } else { texto+=dic[92]; }
if (lst_snapsect[r].photo.length > 0) {
texto+= '<br><center><img id="grpi'+r+'" src="data:image/jpeg;base64,'+lst_snapsect[r].photo+'" alt="'+lst_snapsect[r].photodesc+'" width="300px" onload="redimensiona();" /></center>';
} // inserindo a foto.
texto+='</a></td>';
texto+='</tr>';
} // lstother
} // family
} // classe
} // lstnumlegs
} // lstorder
} // commonname
} // lstlegs
} // lstwings
} // lstmouthparts
} // lstantennae
} // do for...
texto+='</table><br><br>';
if (contador > 0) {
texto = '<center><h2>'+contador+' '+dic[75]+'</h2></center>'+texto;
var falatexto = contador+' '+dic[75];
} else {
texto = '<center><h2>'+dic[76]+'</h2></center>'+texto;
var falatexto = dic[76]; // 'No arthropoda found...';
} // vazio
document.getElementById('dvtab').innerHTML = texto;
 fala(falatexto);
} // da funcao

function mostraimagem(arq, obj) {
if (arq.length < 1) { document.getElementById(obj).style.display = 'none'; }
else {
document.getElementById(obj).src = 'img/'+arq.replaceAll(' ','_')+'.jpg';
document.getElementById(obj).width = 150;
document.getElementById(obj).style.display = 'block';
}
} // da funcao

function abre(n) {
window.location='show_snapsect.html?id='+n;
} // da funcao
