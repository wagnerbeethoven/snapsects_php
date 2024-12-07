var d1= new Date();

    document.addEventListener("deviceready", function () {
convertpage(); // nao verifica alteracoes no dicionario
open_snapsect();
tela(1);
d1 = new Date();
cvoz();
    }, false);

function envia() {
var d2 = new Date();
var d = new Date();
d.setTime(d2.getTime() - d1.getTime());
var resp1 = '';
var nota = 0;
for (var r=1;r<6;r++) {
if (document.getElementById('chk0'+r).checked == true) resp1+=r+'';
} // do for...
if (resp1 == '5') nota = 25;
var resp2 = 0;
var resposta = 'BCA';
for (var r=1;r<4;r++) {
if (document.getElementById('lst'+r).value == resposta[r-1]) resp2++;
} // do for...
if (resp2 > 0) nota+=resp2*(25/3);
resposta = 'CDEAB';
var resp3=0;
for (var r=1;r<6;r++) {
if (document.getElementById('lst'+(r+3)).value == resposta[r-1]) resp3++;
} // do for...
if (resp3 > 0) nota+=resp3*(25/5);
var resp4 = '';
for (var r=1;r<6;r++) {
if (document.getElementById('chk'+r).checked == true) resp4+=r+'';
} // do for...
if (resp4 == '24') nota += 25;
var texto = '';
if (nota < 50) texto = 'Seu resultado foi abaixo do esperado. totalizou '+nota+' pontos.';
else texto = 'Parabéns, você alcançou '+nota+' pontos.'
texto+=' Quer tentar novamente?';
myconfirm('SnapSects School',texto,['SIM','NÃO'], function(res) {
if (res == '1') window.location='school.html';
else window.location='snapsect_school.html';
});
} // da funcao...