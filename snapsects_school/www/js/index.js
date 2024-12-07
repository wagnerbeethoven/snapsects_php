    document.addEventListener("deviceready", function () {

open_snapsect();
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
    fala(dic[70], cvoz);
});
} // da primeiravez / instalacao...
} else {
convertpage();
    fala(dic[70], cvoz);
}

    }, false);

// agora testar ao contrario, mas sem conexao...

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
    fala(dic[70], cvoz);
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
    fala(dic[70], cvoz);
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
    fala(dic[70], cvoz);
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

function mostraimagem(arq, obj) {
if (arq.length < 1) { document.getElementById(obj).style.display = 'none'; }
else {
document.getElementById(obj).src = 'img/'+arq.replaceAll(' ','_')+'.jpg';
document.getElementById(obj).width = 150;
document.getElementById(obj).style.display = 'block';
}
} // da funcao

