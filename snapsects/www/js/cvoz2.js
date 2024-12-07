var cvz = 0;
var recognition;
var cmds = [];
var watchID = null

function speak(txt, okfunc) {
if (!localStorage.vel) { localStorage.vel = '1.5'; }
var vel = parseFloat(localStorage.vel);
var lang = localStorage.language;
lang = localStorage.language.substring(0,2)+'-'+localStorage.language.substring(3).toUpperCase();

TTS.speak({ text: txt, locale: lang, rate: vel }, function() {
if (!okfunc) { } else { okfunc(); }
});
} // da funcao...

function getlinks(v) {
v = v.toUpperCase();
var ok = 0;
var a = document.getElementsByTagName('select');
var b = a.length; 
var ok = 0;
for (var i=0;i<b;i++) {
if (a[i].offsetParent !== null) { // apenas os itens visiveis...
for (var ii=0;ii<a[i].length;ii++) {
if (a[i].options[ii].text.toUpperCase().indexOf(v) > -1) {
ok = 1;
a[i].value = a[i].options[ii].value;
a[i].onchange();
break;
} // encontrou...
} // do for rr
if (ok == 1) { break; }
} // apenas visiveis...
} // do for...
if (ok == 0) {
var a = document.getElementsByTagName('a');
var b = a.length; 
for (var i = 0; i < b; i++) { 
if (a[i].offsetParent !== null) { // apenas os itens visiveis...
if (a[i].innerHTML.toUpperCase().indexOf(v) > -1) {
a[i].click();
ok = 1;
break;
} // encontrou...
} // visivel
} // do for...
if (ok == 0) {

var a = document.getElementsByTagName('button');
var b = a.length; 
for (var i = 0; i < b; i++) { 
if (a[i].offsetParent !== null) { // apenas os itens visiveis...
var s = a[i].innerHTML.toUpperCase();
if (s.indexOf(v) > -1) {
a[i].click();
ok = 1;
break;
} // encontrou...
} // visivel
} // do for...
if (ok == 0) { 
var a = document.getElementsByTagName('input');
var b = a.length; 
for (var i = 0; i < b; i++) { 
if (a[i].offsetParent !== null) { // apenas os itens visiveis...
var s = a[i].value.toUpperCase();
if (s.indexOf(v) > -1) {
a[i].click();
ok = 1;
break;
} // encontrou...
} // visivel
} // do for...
if (ok == 0) {
var a = document.getElementsByTagName('li');
var b = a.length; 
for (var i = 0; i < b; i++) { 
if (a[i].offsetParent !== null) { // apenas os itens visiveis...
var s = a[i].innerHTML.toUpperCase();
if (s.indexOf(v) > -1) {
a[i].click();
ok = 1;
break;
} // encontrou...
} // visivel
} // do for...
if (ok == 0) {
for (var r=0;r<cmds.length;r++) {
var x = v.indexOf(cmds[r].title.toUpperCase());
if (x > -1) {
ok = 1;
var str_cmd = v.substring(x+cmds[r].title.length).trim();
eval(cmds[r].cmd);
break;
}
} // do for...
if (ok == 0) {
fala(dic[423], startcommand);
} //
} // do li
} // nao encontrou...
}
} // nao encontrou links
} // nao e option...
} // da funcao...

function startmove() {
if (watchID == null) {
localStorage.move = '1';
    var options = { frequency: 1000 };
watchID = navigator.accelerometer.watchAcceleration(function(acc) {
if ((acc.y < -1) && (cvz == 0)) {
cvz = 1;
startcommand();
// navigator.notification.beep(1);
} // ativa...
if ((acc.y > -1) && (cvz == 1)) {
cvz = 0;
} // desliga
}, function() {
}, options);
var snd = new Audio('gaveta.wav');
snd.play();
} else {
fala(dic[443], startcommand);
} // ja está ativado...
} // da funcao...

function stopmove() {
if (watchID != null) {
navigator.accelerometer.clearWatch(watchID);
watchID = null;
fala(dic[444], function() {
var snd = new Audio('gaveta2.wav');
snd.play();

});
localStorage.move = '0';
}
} // da funcao...

function cvoz(ut) {
recognition = new SpeechRecognition();
if (!localStorage.move) { localStorage.move = '1'; }
if (localStorage.move == '1') { startmove(); }
startcmds();
if (!localStorage.autoform) { localStorage.autoform = '0'; }
if ((localStorage.autoform == '1') && (ut)) {
editform();
} // le formulário...
} // da funcao...

function startcommand() {
speak(dic[422], function() {
var lang = localStorage.language;
lang = localStorage.language.substring(0,2)+'-'+localStorage.language.substring(3).toUpperCase();

recognition.lang = lang;
recognition.continuous = false;
   recognition.onresult = comandodevoz;
   recognition.onerror = function(e) { startcommand(); }
    recognition.start();
    });
} // da funcao.

function comandodevoz(event) {
if (event.results.length > 0) {
            var comando = event.results[0][0].transcript;
getlinks(comando);
         }
        else { speak(dic[423]); }
    } // da funcao

function getvoice(texto, okfunc) {
var lang = localStorage.language;
lang = localStorage.language.substring(0,2)+'-'+localStorage.language.substring(3).toUpperCase();

recognition.lang = lang;
recognition.continuous = false;
recognition.onerror = function(e) { getvoice(texto, okfunc); }
                recognition.onresult = function(result) {
                if (result.results.length > 0) {
                var comando = result.results[0][0].transcript;
                if (!okfunc) { } else { okfunc(comando); }
               } // maior que 1.
                } // da = function
                fala(texto, function() {
                recognition.start();
                });
} // da funcao.

function readli() {
var t = '';
var a = document.getElementsByTagName('li');
var b = a.length; 
for (var i = 0; i < b; i++) { 
t+= a[i].textContent+', ';
} // do for...
if (t == '') {
fala(dic[446], startcommand);
} else {
fala(t, startcommand);
}
} // da funcao...

function readcomandos() {
var t = dic[447]+' ';
if (!localStorage.nome) { } else { t+=localStorage.nome+' '; }
t+='!!! '+dic[448]+' ';
for (var r=0;r<cmds.length;r++) {
t+=cmds[r].title+'; ';
} // do for...
fala(t, startcommand);
} // da funcao...

function editando(titulo, obj) {
var t = dic[445]+' '+titulo;
t+=(obj.value.length > 0)?' '+dic[465]+': '+obj.value+': , '+dic[466]:' '+dic[467];
getvoice(t, function(res) {
if ((dic[478]).indexOf(res.toUpperCase()) > -1) {
getvoice('então pode começar a ditar: ', function(rr) {
obj.value = rr;
fala(dic[449]+': '+rr+' '+dic[450]+' '+titulo,startcommand);
}); // do objread
} else {
fala(dic[451], startcommand);
} // cancelar...
}); // do sim/nao...
} // da funcao...
function findedit(v) {
v = v.toUpperCase();
var ok = 0;
var a = document.getElementsByTagName('input');
var b = a.length; 
for (var i = 0; i < b; i++) { 
if (a[i].offsetParent !== null) { // apenas os itens visiveis...
var c = document.querySelector('label[for="'+a[i].id+'"]');
if (c) { 
if (c.innerHTML.toUpperCase().indexOf(v) > -1) {
ok = 1;
editando(c.innerHTML, a[i]);
break;
} // encontrou...
} // existe o label associado
} // elemento visivel...
} // do for...
if (ok == 0) {
fala(dic[452], startcommand);
} // nao encontrou...
} // da funcao...

function selectopc(title, obj, r) {
var t = obj.options[r].text+': seleciona esta opção?';
getvoice(t, function(res) {
if ((dic[478]).indexOf(res.toUpperCase()) > -1) {
obj.value = obj.options[r].value;
if (obj.onchange) { obj.onchange(); }
fala(dic[453]+' '+obj.options[r].title, startcommand);
} // selecionou...
else {
selectopc(title,obj,r+1);
} // nao e o sim...
});
} // da funcao...

function editopc(l, r, rr) {
var t = l[r].options[rr].text+': seleciona esta opção?';
getvoice(t, function(res) {
if ((dic[478]).indexOf(res.toUpperCase()) > -1) {
l[r].value = l[r].options[rr].value;
if (l[r].onchange) { 
l[r].onchange(); 
}
var ll = getform();
var v = -1;
for (var i = 0;i< ll.length;i++) {
if (l[r].id == ll[i].id) { 
v = i; 
break;
}
} // do for...
if (v == -1) v = r;
fala(dic[453]+' '+l[r].options[rr].text, function() { leform(ll,v+1); });
} // selecionou...
else {
editopc(l,r,rr+1);
} // nao e o sim...
});
} // da funcao...

function selectedit(v) {
v = v.toUpperCase();
var a = document.getElementsByTagName('select');
var b = a.length; 
var ok = 0;
for (var i=0;i<b;i++) {
if (a[i].offsetParent !== null) { // apenas os itens visiveis...
var c = document.querySelector('label[for="'+a[i].id+'"]');
if (c) { 
if (c.innerHTML.toUpperCase().indexOf(v) > -1) {
ok = 1;
var t=dic[445]+' '+c.innerHTML;
t+=(a[i].selectedIndex > -1)?' '+dic[468]+' '+a[i].options[a[i].selectedIndex].text+' '+dic[469]:' '+dic[470];
getvoice(t, function(res) {
if ((dic[478]).indexOf(res.toUpperCase()) > -1) {
selectopc(c.innerHTML, a[i], 0);
} else {
fala(dic[442], startcommand);
} // nao selecionou...
});
break;
} // encontrou...
} // existe label...
} // objeto visivel...
if (ok == 1) { break; }
} // do for...
if (ok == 0) {
fala(dic[454], startcommand);
}
} // da funcao...

function getscreen(c) {
c = c.toUpperCase();
var l = [];
var p = document.querySelectorAll('a,li,input, button, select, textarea');
if (!p) { 
return l;
} else {
var len = p.length;
for(var i = 0; i < len; i++) {
if (p[i].offsetParent !== null) { // apenas os itens visiveis...
// verificando os itens diretos...
if (('A LI').indexOf(p[i].tagName) > -1) {
if (p[i].textContent.toUpperCase().indexOf(c) > -1) {
l.push({ title: p[i].textContent, obj: p[i]});
} // encontrou e adiciona...
} // tipo direto
else {
if (((p[i].tagName == 'INPUT') && (p[i].type.toUpperCase() == 'BUTTON')) || ((p[i].tagName == 'INPUT') && (p[i].type.toUpperCase() == 'SUBMIT')) || (p[i].tagName == 'BUTTON')) {
if (p[i].value.toUpperCase().indexOf(c) > -1) {
l.push({ title: p[i].value, obj: p[i]});
} // encontrou...
} // pegando do value...
else {
var d = document.querySelector('label[for="'+p[i].id+'"]');
if (d) { 
if (d.innerHTML.toUpperCase().indexOf(c) > -1) {
l.push({ title: d.innerHTML, obj: p[i]});
} // adiciona...
} // label encontrado...
} // buscando o label....
} // tipo indireto...
} // apenas os visiveis...
} // do for...
} // existe formulario
return l;
} // da funcao...

function getform() {
var l = [];
var p = document.querySelectorAll('input, button, select, textarea');
// var p = document.forms[0];
if (!p) { 
return l;
} else {
var len = p.length;
for(var i = 0; i < len; i++) {
if (p[i].offsetParent !== null) { // apenas os itens visiveis...
l.push(p[i]);
} // apenas os visiveis...
} // do for...
} // existe formulario
return l;
} // da funcao...

function leform(l, r) {
if (r < l.length) {
var texto = '';
// alert(l[r].tagName);
if (((l[r].tagName.toUpperCase() == 'INPUT') && (l[r].type.toUpperCase() == 'BUTTON')) || (l[r].type.toUpperCase() == 'SUBMIT') || (l[r].tagName == 'BUTTON')) { 
texto = l[r].value; 
if (texto.length < 1) { texto = l[r].innerHTML; }
getvoice(dic[471]+': '+texto+'?', function(rr) {
if ((dic[478]).toUpperCase().indexOf(rr.toUpperCase()) > -1) {
fala(dic[455], function() {
l[r].click();
leform(l,r+1);
});
} // clicando...
else {
leform(l, r+1);
} // nao clicou...
}); // getvoice botao...
} // botoes...
else {
if ((l[r].tagName == 'INPUT') || (l[r].tagName == 'TEXTAREA')) {
var c = document.querySelector('label[for="'+l[r].id+'"]');
var texto = '';
if (c) { texto = c.innerHTML; }
if (((l[r].tagName == 'INPUT') && (('TEXT ADDRESS EMAIL NUMBER').indexOf(l[r].type.toUpperCase()) > -1)) || (l[r].tagName == 'TEXTAREA')) {
var t = dic[445]+': '+texto;
t+=(l[r].value.length < 1)?' '+dic[472]:' '+dic[473]+': '+l[r].value+': '+dic[474];
getvoice(t, function(rr) {
if ((dic[478]).indexOf(rr.toUpperCase()) > -1) {
getvoice(dic[456]+': ', function(res) {
l[r].value = res;
fala(dic[457]+': '+res, function() { leform(l, r+1); });
});
} // altera
else {
if ((dic[477]).indexOf(rr.toUpperCase()) > -1) {
fala(dic[442], startcommand);
} else {
leform(l, r+1); 
} // nao cancelou...
} // nao altera o edit...
}); // do get edit...
} // tipo edit
else {
if (l[r].type.toUpperCase() == 'CHECKBOX') {
texto = dic[445]+' '+texto;
texto+=(l[r].checked == true)?' '+dic[475]:' '+dic[476];
getvoice(texto, function(rr) {
if ((dic[478]).indexOf(rr.toUpperCase()) > -1) {
if (l[r].checked == true) {
l[r].checked = false;
fala(dic[458], function() { leform(l,r+1); });
} else {
l[r].checked = true;
fala(dic[459], function() { leform(l,r+1); });
} // agora marca...
} else {
if ((dic[477]).indexOf(rr.toUpperCase()) > -1) {
fala(dic[442], startcommand);
} else {
leform(l,r+1);

} // nao saiu...
} // nao sim
}); // do getvoice
} // checkbox
else {
leform(l,r+1);
} // nao e checkbox...
} // nao e do tipo edit...
} // e input
else {
if (l[r].tagName == 'SELECT') {
var c = document.querySelector('label[for="'+l[r].id+'"]');
var texto = '';
if (c) { texto = c.innerHTML; }
if (texto.length < 1) {
leform(l, r+1);
} else {
texto=(l[r].selectedIndex > -1)?dic[445]+': '+texto+' '+dic[462]+': '+l[r].options[l[r].selectedIndex].text+': '+dic[463]:dic[445]+' '+texto+' '+dic[464];
getvoice(texto, function(rr) {
if ((dic[478]).indexOf(rr.toUpperCase()) > -1) {
editopc(l,r,0);
} else {
leform(l, r+1); 
} // nao altera...
});
} // texto nao vazio...
} // tipo select
else {
leform(l, r+1); 
} // nao e do tipo select
} // nao e input
} // nao e botao...
} else {
fala(dic[460], startcommand);
} // acabou...
} // da funcao...

function editform() {
var lst = getform();
if (lst.length < 1) {
fala(dic[461], startcommand);
} else {
leform(lst,0);
} // existem formularios...
} // da funcao...

function startcmds() {
var f = {
title: dic[424],
cmd: 'fala(dic[425]);'
}
cmds.push(f);

var f = {
title: dic[426],
cmd: 'fala(dic[427]);'
}
cmds.push(f);

var f = {
title: dic[428],
cmd: 'fala(dic[427]);'
}
cmds.push(f);

var f = {
title: dic[429],
cmd: 'var vv = parseFloat(localStorage.vel) + 0.20;localStorage.vel = vv.toString(); fala(dic[430], startcommand);'
}
cmds.push(f);

var f = {
title: dic[431],
cmd: 'var vv = parseFloat(localStorage.vel) - 0.20;localStorage.vel = vv.toString(); fala(dic[432], startcommand);'
}
cmds.push(f);

var f = {
title: dic[433],
cmd: 'readli();'
}
cmds.push(f);

var f = {
title: dic[434],
cmd: "fala(document.getElementById('dvpage').textContent, startcommand);"
}
cmds.push(f);

var f = {
title: dic[435],
cmd: "window.location='index.html';"
}
cmds.push(f);

var f = {
title: dic[436],
cmd: "stopmove();"
}
cmds.push(f);

var f = {
title: dic[437],
cmd: "startmove();"
}
cmds.push(f);

var f = {
title: dic[438],
cmd: 'readcomandos();'
}
cmds.push(f);

var f = {
title: dic[439],
cmd: 'findedit(str_cmd);'
}
cmds.push(f);

var f = {
title: dic[440],
cmd: 'selectedit(str_cmd);'
}
cmds.push(f);

var f = {
title: dic[441],
cmd: 'editform();'
// cmd: "alert(document.querySelectorAll('*').length);"
}
cmds.push(f);

} // da funcao...