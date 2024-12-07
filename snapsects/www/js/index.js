    document.addEventListener("deviceready", function () {

verificalog();

if (!sessionStorage.startapp) {
sessionStorage.startapp = '1';
if (!localStorage.primeiravez) {
primeiravez();
} else {
if (localStorage.autodic == '1') {
getlanguage();
} else {
convertpage(); // nao verifica alteracoes no dicionario
}

sndplay('index.wav', function() {
    fala(dic[299],cvoz);
});
} // da primeiravez / instalacao...
} else {
convertpage();
    fala(dic[299],cvoz);
}

    }, false);

function primeiravez() {
document.getElementById('dvprimeiravez').style.display='inline';
document.getElementById('dvpage').style.display='none';
if (!localStorage.nome) { localStorage.nome = ''; }
if (!localStorage.email) { localStorage.email = ''; }

if (!localStorage.autospeak) { localStorage.autospeak = '1'; }
if (!localStorage.autodic) { localStorage.autodic = '1'; } // verificando se existe o autodic...
if (!localStorage.language) { localStorage.language = 'pt-br'; }

var t = 'Obrigado por instalar o snapsects school! seja bem vindo... ';
if (checkConnection() == false) {
t+=' foi detectado que você está sem acesso a internet no momento...';
localStorage.primeiravez = '1';
openfiletext('res/', 'pt-br.txt', function(texto) {
openlangtext(texto);
convertpage(); 
document.getElementById('dvprimeiravez').style.display='none';
t+=' atualizei o dicionário...';
fala(t, function() {
sndplay('index.wav', function() {
    fala(dic[299],cvoz);
});
});
}, function() {
t+=' não encontrei o arquivo do dicionário... tente mais tarde!!!';
fala(t);
});
} else {
t+=' foi detectado sua conecçao na internet, farei agora o download do idioma...';
openlanguage('pt-br', function() {
localStorage.primeiravez = '1';
document.getElementById('dvprimeiravez').style.display='none';
sndplay('index.wav', function() {
    fala(dic[299],cvoz);
});
}, function() {
localStorage.primeiravez = '1';
openfiletext('res/', 'pt-br.txt', function(texto) {
openlangtext(texto);
convertpage(); 
document.getElementById('dvprimeiravez').style.display='none';
t+=' atualizei o dicionário...';
fala(t, function() {
sndplay('index.wav', function() {
    fala(dic[299],cvoz);
});
});
}, function() {
t+=' não encontrei o arquivo do dicionário... tente mais tarde!!!';
fala(t);
// });

}); // erro no download carrega local
});
} // online...

} // da primeira vez que abre o app...

function logout() {
spopen(dic_path+'cel_api.php','act=logout&id='+localStorage.lgi,'POST', function(res) { 
localStorage.removeItem('lgi');
localStorage.removeItem('lge');
localStorage.removeItem('lgp');
localStorage.removeItem('lgn');
sessionStorage.removeItem('lgs');
window.location='index.html';
});
} // da funcao...

function verificalog() {
if ((!localStorage.lge) || (localStorage.lgp)) {
// window.location='login.html';
} // não tem login...
// sessionStorage.lgs = '0';
var ok = 0;
document.getElementById('dvlogin').style.display='inline';
document.getElementById('dvlogout').style.display='none';
if ((!localStorage.lge) || (localStorage.lge.length < 1)) {
ok = 1;
} // nao está logado...
if ((!localStorage.lgp) || (localStorage.lgp.length < 1)) {
ok = 1;
} // nao está logado...
if (ok == 0) {
if ((!sessionStorage.lgs) || (sessionStorage.lgs.length < 1)) {
spjson(dic_path+'cel_api.php','act=login&email='+localStorage.lge+'&pws='+localStorage.lgp,'POST', function(q) {
if (q.status > 0) {
sessionStorage.lgs = q.status;
localStorage.lgi = q.id;
localStorage.lgn = q.nome;
document.getElementById('dvlogin').style.display='none';
document.getElementById('dvlogout').style.display='inline';
if (sessionStorage.lgs == 5) {
document.getElementById('dvschool').style.display = 'inline';
} // escola / professor / adm
if (sessionStorage.lgs == 67) {
document.getElementById('dvschool').style.display = 'inline';
document.getElementById('dvadm').style.display='inline';
} // administrador...
} // faz login...
});
} // pode logar...
else {
document.getElementById('dvlogin').style.display='none';
document.getElementById('dvlogout').style.display='inline';
document.getElementById('dvadm').style.display='none';
if (sessionStorage.lgs == '5') {
document.getElementById('dvschool').style.display = 'inline';
} // prof
if (sessionStorage.lgs == '67') {
document.getElementById('dvschool').style.display = 'inline';
document.getElementById('dvadm').style.display='inline';
} // administrador...
} // ja esta logado, libera o menu...
} // se nao estiver logado, faz login...
} // da funcao...

function sendemail() {
cordova.plugins.email.open({
to: 'hi@snapsects.com',
subject: 'Send Arthropod...',
body: document.getElementById('dvresultado').innerHTML,
isHtml: true
});
} // da funcao...
