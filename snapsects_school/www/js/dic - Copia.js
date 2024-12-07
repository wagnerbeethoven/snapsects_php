// var dic_path = 'http://www.domvirt.com.br/snapsects/';
var dic_path = 'http://www.snapsects.com/teste/';

var ddic;
var dic;

function checkConnection() {
        var networkState = navigator.connection.type;
        var states = {};
        states[Connection.UNKNOWN]  = 'Unknown connection';
        states[Connection.ETHERNET] = 'Ethernet connection';
        states[Connection.WIFI]     = ' WiFi connection';
        states[Connection.CELL_2G]  = 'Cell 2G connection';
        states[Connection.CELL_3G]  = 'Cell 3G connection';
        states[Connection.CELL_4G]  = 'Cell 4G connection';
        states[Connection.CELL]     = 'Cell generic connection';
        states[Connection.NONE]     = 'none';
if (states[networkState].indexOf('none') > -1) return false; else return true;
    }

function getlanguage() {
if (checkConnection() == true) {
if (!localStorage.language) {
navigator.globalization.getPreferredLanguage(function (language) {
localStorage.language = language.value;
openlanguage(localStorage.language);
},function () {
alert('Error getting language\n');
});
} else {
if (!localStorage.lang) {
openlanguage(localStorage.language);
} else {
ddic = JSON.parse(localStorage.lang);
dic = ddic.dic;
spopen(dic_path+'dic.php','act=verify&lang='+localStorage.language+'&controle='+ddic.controler,'GET', function(res) {
// alert(res);
var t = JSON.parse(res);
if (t.status == 'update') {
ddic = t.dados;
localStorage.lang = JSON.stringify(t.dados);
openlanguage(localStorage.language);
TTS.speak({ text: dic[74], locale: localStorage.language }); 
} else {
if (t.status == 'ok') { openlanguage(localStorage.language); }
// else {  }  fazer aqui o erro....
} // nao e update
});

} // verifica se existe alteracao no dicionario
}
} else { convertpage(); }
} // da funcao...

function openlanguage(l) {
document.documentElement.lang = l;
if (!localStorage.lang) {
spopen(dic_path+'dic.php','act=get&lang='+l,'GET', function(res) {
// alert('funcionou... '+res);
localStorage.lang = res;
convertpage();
}, function() {
alert('ocorreu um erro ao abrir a api');
});
} // peimeira vez...
else {
convertpage();
} // utilizando o já carregado...
// alert('abrindo '+l);
} // da funcao...

function convertpage() {
document.documentElement.lang = localStorage.language;
document.getElementById('dvpage').style.display='none';
ddic = JSON.parse(localStorage.lang);
dic = ddic.dic;
var texto = document.getElementById('dvpage').innerHTML;
for (var r=0;r<dic.length;r++) {
texto = texto.replaceAll('{dic'+r+'}',dic[r]);
 } // do for...
// dic.forEach(function(item, indice) {
// texto = texto.replaceAll('{dic'+indice+'}',item);
// alert(item+' '+indice);
// });
document.getElementById('dvpage').innerHTML = texto;
document.getElementById('dvpage').style.display='inline';
} // da funcao...

function listlanguage(okfunc) {
spopen(dic_path+'dic.php','act=list','GET', function(res) {
okfunc(res);
});
} // da funcao...

function changelanguage(l,okfunc) {
spopen(dic_path+'dic.php','act=get&lang='+l,'GET', function(res) {
localStorage.language = l;
localStorage.lang = res;
ddic = JSON.parse(res);
dic = ddic.dic;
if (!okfunc) { } else { okfunc(); }
});
// convertpage();
} // da funcao...

function openlangtext(txt) {
var linhas = [];
var t = '';
for (var r=0;r<txt.length;r++) {
if (txt.charCodeAt(r) < 30) {
if (txt.charCodeAt(r) == 13) { 
if (t.trim().length > 0) {
t = t.trim();
if (t.indexOf('|') < 0) {
linhas.push(t); 
}
} // length...
}
t = '';
} // menor que 30...
else { t+=txt[r]; }
} // do for...
if (t.trim().length > 0) {
t = t.trim();
if (t[0] != '[') { linhas.push(t); }
} // existe texto
var n = linhas[0];
var c = linhas[1];
linhas.splice(0,2);
ddic = {
name: n,
controler: c,
dic: linhas
}
localStorage.lang = JSON.stringify(ddic);
} // da funcao...