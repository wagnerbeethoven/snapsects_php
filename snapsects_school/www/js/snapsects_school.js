var str_tela = ['','','','',''];
var num_tela = [0,0,0,0,0,0];
var tit_tela = [335,404,405,336];
var page = 0;
var salas;


    document.addEventListener("deviceready", function () {
convertpage(); 
cvoz();
open_snapsect();

if (!localStorage.email) { localStorage.email = ''; }
if (!localStorage.nome) { localStorage.nome = ''; }
if ((localStorage.email.length < 1) || (localStorage.nome.length < 1)) {
navigator.notification.alert(dic[395], function(e) {
localStorage.email = '';
window.location='login.html?act=login';
},'SnapSects School');
} else {
// var tempo = window.setInterval(function() {
getsalas();



} // existe email e nome...
    }, false);

function getsalas() {
if (!localStorage.defaultsalas) { localStorage.defaultsalas = ''; }
getconv(function(sls) {
salas = sls;
var t = '<p><label for="lstsalas">'+dic[347]+': </label><select id="lstsalas" onchange="javascript:atualizasala(this.value);">';
for (var r=0;r<salas.length;r++) {
t+='<option value="'+r+'"';
t+=(localStorage.defaultsalas == r)?' selected':'';
t+='>'+salas[r].sala+'</option>';
} // do for...
t+='</select></table>';
document.getElementById('dvsalas').innerHTML = t;
atualizasala(document.getElementById('lstsalas').value);
});
} // da funcao...

function atualizasala(salaid) {
localStorage.defaultsalas = salaid;
getquest(salas[salaid].email,salas[salaid].sala, function(dados) {
var len = dados.leituras.length;
var t = '';
if (len > 0) {
t+='<ul>';
for (var r=0;r<len;r++) {
t+='<li onclick="javascript:window.location='+"'show_leituras.html?email="+salas[salaid].email+"&sala="+salas[salaid].sala+"&title="+dados.leituras[r]+"';"+'"> '+(r+1)+' - '+salas[salaid].sala.replaceAll('_',' ')+', '+dados.leituras[r].replaceAll('_',' ').replaceAll('.txt','')+' - '+dic[532]+' '+salas[salaid].name+'. </li>';
} // do for...
t+='</ul>';
} // existem itens...
str_tela[3] = t;
num_tela[3]=dados.leituras.length;

// sugeridos
var t = '<ul>';
for (var r=0;r<dados.sugeridos.length;r++) {
t+='<li onclick="javascript:window.location='+"'resp_exerciceos.html?id="+dados.sugeridos[r].id+"&sala="+salas[salaid].sala+"&email="+salas[salaid].email+"';"+'"> ';
t+=(r+1)+' - '+dados.sugeridos[r].title+' - '+dic[392]+' '+salas[salaid].name+'. </li>';
} // do for...
t+='</ul>';
str_tela[0] = t;
num_tela[0]=dados.sugeridos.length;

// aguardando correcao...
var t = '<ul>';
for (var r=0;r<dados.provas.length;r++) {
t+='<li onclick="javascript:window.location='+"'show_exerciceos.html?id="+dados.provas[r].id+"&sala="+salas[salaid].sala+"&email="+salas[salaid].email+"';"+'"> ';
t+=(r+1)+' - '+dados.provas[r].title+' - '+dic[392]+' '+salas[salaid].name+'. </li>';
} // do for...
t+='</ul>';
str_tela[1] = t;
num_tela[1]=dados.provas.length;

// corrigidos...
var t='<ul>';
for (var r=0;r<dados.corrigidos.length;r++) {
t+='<li onclick="javascript:window.location='+"'show_exerciceos.html?id="+dados.corrigidos[r].id+"&sala="+salas[salaid].sala+"&email="+salas[salaid].email+"';"+'"> ';
t+=(r+1)+' - '+dados.corrigidos[r].nota+' - '+dados.corrigidos[r].title+' - '+dic[392]+' '+salas[salaid].name+'. </li>';
} // do for...
t+='</ul>';
str_tela[2] = t;
num_tela[2] = dados.corrigidos.length;


for (var r=0;r<4;r++) {
if (num_tela[r] > 0) {
document.getElementById('cmddv'+r.toString()).innerHTML = dic[tit_tela[r]]+' ('+num_tela[r]+')';
} else {
document.getElementById('cmddv'+r.toString()).innerHTML = dic[tit_tela[r]];
}
} // do for...
atualiza(page,dic[335]);

// alert(JSON.stringify(dados));
return false;
var t = '';
var z = '';
var zz = '';
if (dados.results.length > 0) {
t+='<ul>';
var d = dados.results;
for (var r=0;r<d.length;r++) {
var dd = new Date(d[r].datai);
if (d[r].show > 0) {
if (d[r].show == 2) {
zz+='<li onclick="javascript:window.location='+"'show_exerciceos.html?id="+d[r].id+"&sala="+d[r].sala+"&email="+d[r].email+"';"+'">';
zz+=d[r].nota+' - '+d[r].title+' - '+dic[392]+' '+d[r].nic+'</li>';
num_tela[2]++;
} else {
z+='<li onclick="javascript:window.location='+"'show_exerciceos.html?id="+d[r].id+"&sala="+d[r].sala+"&email="+d[r].email+"';"+'">';
z+=d[r].title+' - '+dic[392]+' '+d[r].nic+'</li>';
num_tela[1]++;
}
} else {
t+='<li onclick="javascript:window.location='+"'resp_exerciceos.html?id="+d[r].id+"&sala="+d[r].sala+"&email="+d[r].email+"';"+'">';
t+=d[r].title+' - '+dic[392]+' '+d[r].nic+'</li>';
num_tela[0]++;
}
} // do for...
t+='</ul>';
if (z.length > 0) {
z = '<ul>'+z+'</ul>';
} // existem aguardando correcao...
if (zz.length > 0) {
zz = '<ul>'+zz+'</ul>';
} // existem aguardando correcao...

} // existem itens...
str_tela[0] = t;
str_tela[1] = z;
str_tela[2] = zz;
var len = dados.leituras.length;
var t = '';
if (len > 0) {
t+='<ul>';
for (var r=0;r<len;r++) {
t+='<li onclick="javascript:window.location='+"'show_leituras.html?email="+dados.leituras[r].email+"&sala="+dados.leituras[r].sala+"&title="+dados.leituras[r].title+"';"+'">'+dados.leituras[r].sala.replaceAll('_',' ')+', '+dados.leituras[r].title.replaceAll('_',' ').replaceAll('.txt','')+' - Leitura sugerida por '+dados.leituras[r].nic+'</li>';
num_tela[3]++;
} // do for...
t+='</ul>';
} // existem itens...
str_tela[3] = t;
for (var r=0;r<4;r++) {
if (num_tela[r] > 0) {
document.getElementById('cmddv'+r.toString()).innerHTML = dic[tit_tela[r]]+' ('+num_tela[r]+')';
} else {
document.getElementById('cmddv'+r.toString()).innerHTML = dic[tit_tela[r]];
}
} // do for...
atualiza(page,dic[335]);
    fala(dic[334]);
});

} // da funcao...
function atualiza(n, s) {
page = n;
document.getElementById('dvresultado').innerHTML = '<center><h2>'+s+'</h2></center>'+str_tela[n];
// for (var r=0;r<4;r++) {
// document.getElementById('dv'+r.toString()).style.display = (r == n)?'inline':'none';
// } // do for...
sndplay('beep.wav', function() {
fala(document.getElementById('dvresultado').textContent);
});
} // da funcao...
