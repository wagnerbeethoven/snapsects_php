
    document.addEventListener("deviceready", function () {

convertpage(); // nao verifica alteracoes no dicionario
// dvorder
spjson(dic_path+'cel_api.php','act=getger','POST', function(res) {
// alert(res);
var texto = '<p><label for="lstother">'+dic[10]+': </label><select name="lstother" id="lstother" value="" onchange="javascript:filtro();">';
texto+='<option value="">'+dic[11]+'</option>';
var len = res.other.length;
for (var r=0;r<len;r++) {
texto+='<option value="'+res.other[r]+'">'+res.other[r]+'</option>';
} // do for...
texto+='</select></p>';
document.getElementById('dvother').innerHTML = texto;
// order
var texto = '<p><label for="lstorder">'+dic[18]+': </label><select name="lstorder" id="lstorder" value="" onchange="javascript:filtro();">';
texto+='<option value="">'+dic[11]+'</option>';
var len = res.order.length;
for (var r=0;r<len;r++) {
texto+='<option value="'+res.order[r]+'">'+res.order[r]+'</option>';
} // do for...
texto+='</select></p>';
document.getElementById('dvorder').innerHTML = texto;

// filtro();

}); // pegando os combos...
fala(dic[71],cvoz);
    }, false);

function filtro() {
var ii='';
if (!localStorage.lgi) ii=''; else ii='&userid='+localStorage.lgi;
spjson(dic_path+'snapsect_api.php','act=mobilefind'+ii+'&antennae='+document.getElementById('lstantennae').value+'&mouthparts='+document.getElementById('lstmouthparts').value+'&wings='+document.getElementById('lstwings').value+'&legs='+document.getElementById('lstlegs').value+'&commonname='+document.getElementById('commonname').value+'&oorder='+document.getElementById('lstorder').value+'&lstnumlegs='+document.getElementById('lstnumlegs').value+'&classe='+document.getElementById('classe').value+'&family='+document.getElementById('family').value+'&lstother='+document.getElementById('lstother').value+'&lang='+localStorage.language,'GET', function(ress) {
// alert(ress);
// ress = JSON.parse(ress);
var res = ress.result;
var contador = ress.count;
if (contador > 0) {
var t = '<center>'+contador+' '+dic[75]+'</center>';
fala(contador+' '+dic[75]);
} else {
var t='<center>'+dic[76]+'</center>';
fala(dic[76]);
}
t += '<center><table border="0">';
t += '<tr>';
t +='<th TEXT-ALIGN="CENTER" width="33%">'+dic[8]+' ('+dic[86]+'): </th>';
t +='<th TEXT-ALIGN="CENTER" width="33%">'+dic[221]+': </th>';
t +='<th TEXT-ALIGN="CENTER" width="33%">'+dic[191]+': </th>';
t+='</tr>';

document.getElementById('dvtab').innerHTML = t + res.replaceAll('.php','.html');
});
} // da funcao

