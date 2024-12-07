var lst_snapsect = [];

function open_snapsect() {
if (!localStorage.snapsect) { 
lst_snapsect = []; 
localStorage.snapsect = JSON.stringify(lst_snapsect);
}
else {
lst_snapsect = JSON.parse(localStorage.snapsect);
} // encontrou...
} // da funcao.

function getorder() {
var len = lst_snapsect.length;
var text = '';
for (var r=0;r<len;r++) {
if (lst_snapsect[r].oorder.length > 0) {
if (text.indexOf(lst_snapsect[r].oorder+'|') == -1) { text+=lst_snapsect[r].oorder+'|'; }
} // nao vazio...
} // do for...
if (text.length > 0) { return text.split('|'); }
else { return []; }
} // dafuncao...

function getother() {
var len = lst_snapsect.length;
var text = '';
for (var r=0;r<len;r++) {
if (lst_snapsect[r].other.length > 0) {
if (text.indexOf(lst_snapsect[r].other+'|') == -1) { text+=lst_snapsect[r].other+'|'; }
} // maior que 0...
} // do for...
if (text.length > 0) { return text.split('|'); }
else { return []; }
} // dafuncao...

function openfile(f, okfunc) {
if (f.length < 1) { okfunc(''); }
else {
//if (localStorage.getItem(f).length < 1) {
spopen(dic_path+'cel_api.php','act=download&arq='+f,'POST', function(res) {
localStorage.setItem(f,res);
okfunc(res);
});
// } // nao existe...
// else {
// okfunc(localStorage.getItem(f));
// } // retorna o conteudo...
} // nao esta vazio...
} // da funcao...

function del_snapsect(n) {
deletelist(lst_snapsect[n].photos);
deletelist(lst_snapsect[n].videos);
lst_snapsect.splice(n,1);
localStorage.snapsect = JSON.stringify(lst_snapsect);
} // da funcao...

function deletefile(fullnome, okfunc) {
var nome = fullnome.substr(fullnome.lastIndexOf('/') + 1);
var path = fullnome.substr(0,fullnome.lastIndexOf('/') + 1);
try {
    window.resolveLocalFileSystemURL(path, function (dir) {
        dir.getFile(nome, {create: false}, function (fileEntry) {
            fileEntry.remove(function (file) {
okfunc();
            }, function (error) {
okfunc();
            }, function () {
okfunc();
            });
        });
    });
      } catch(e) {
        // Exception!
okfunc();
      }

}// da funcao

function openfiletext(path, nome, okfunc, nofunc) {
path = cordova.file.applicationDirectory+'/www/'+path;
window.resolveLocalFileSystemURL(path, function (dir) {
dir.getFile(nome, {create: false}, function (fileEntry) {
       fileEntry.file(function(file) {
           var reader = new FileReader();

           reader.onloadend = function() {
okfunc(this.result);
           };

           reader.readAsText(file);
}, nofunc);
}, nofunc);
}, nofunc);
} // da funcao...

function deletelist(list) {
if (list.length > 0) {
deletefile(list[0].url, function() {
list = list.splice(0,1);
deletelist(list);
});
} // lista nao vazia...
} // da funcao...

function getconv(okfunc) {
if (!localStorage.salas) {
var oldsalas = [];
} else {
var oldsalas = JSON.parse(localStorage.salas);
}
spjson(dic_path+'api_school.php','act=getconv&email='+localStorage.email+'&token='+localStorage.token,'POST', function(res) {
if (res.status == 'ok') {
var salas = res.results;
localStorage.salas = JSON.stringify(salas);

var re_salas = [];
// verificando o que removeu...
for (var r=0;r<oldsalas.length;r++) {
var ok = 0;
for (var rr=0;rr<salas.length;rr++) {
if ((oldsalas[r].sala == salas[rr].sala) && (oldsalas[r].email == salas[rr].email)) {
ok = 1;
break;
} // encontrou e sai...
} // do for rr...
if (ok == 0) {
re_salas.push(oldsalas[r]);
} // nao encontrou...
} // do for...
// agora as novas salas...
var add_salas = [];
for (var r=0;r<salas.length;r++) {
var ok = 0;
for (var rr=0;rr<oldsalas.length;rr++) {
if ((oldsalas[rr].sala == salas[r].sala) && (oldsalas[rr].email == salas[r].email)) {
ok = 1;
break;
} // encontrou e sai...
} // do for rr...
if (ok == 0) {
add_salas.push(salas[r]);
} // novo...
} // do for...
// agora preparando o texto para a mensagem...
var t='';
if (re_salas.length > 0) {
t+='você foi removido das seguintes salas: ';
for (var r=0;r<re_salas.length;r++) {
t+=re_salas[r].sala+' do(a): '+re_salas[r].name+'. ';
} // do for...
} // os removidos...
if (add_salas.length > 0) {
t+='Você foi adicionado nos seguintes cursos: ';
for (var r=0;r<add_salas.length;r++) {
t+=add_salas[r].sala+' do(a): '+add_salas[r].name+'. ';
} // do for...
} // os novos...
if (t.length > 0) {
navigator.notification.beep(1);
fala(t, function() {
if (!okfunc) { } else { okfunc(salas); }
});
}
else {
if (!okfunc) { } else { okfunc(salas); }
}
} // ok encontrou...
else {
if (res.status == 'newuser') {
window.location='login.html?act=add';
} else {
if (res.status == 'login') {
window.location='login.html?act=login';
} else {
alert('Ainda não foi feito seu cadastro, entre em contato com o professor...');
window.location='index.html';

}
} // sai e volta para a página principal...
} // nao encontrou...
}, function() { 
if (!okfunc) { } else { okfunc([]); }
});
} // da funcao...

function getquest(email, sala, okfunc) {
spjson(dic_path+'api_school.php','act=getsalasschool&email='+email+'&sala='+sala+'&userid='+localStorage.email,'POST', function(res) {
if (!okfunc) { } else { okfunc(res); }
}); // do spjson...
} // dafuncao...

function getquest2(salas, okfunc) {
// alert(JSON.stringify(salas));
var sala = '';
for (var r=0;r<salas.length;r++) {
sala+=salas[r].email+'|'+salas[r].sala+'#';
} // do for...

spjson(dic_path+'api_school.php','act=getschoolshow&salas='+sala+'&nome='+localStorage.email+'-'+localStorage.nome,'POST', function(data) {
okfunc(data);
});
} // da funcao...

function getpdf(title, msg, txt,voltarpara) {
let options = {
                documentSize: 'A4',
fileName: 'snapsects.pdf',
                type: 'base64'
// type: 'share' // impressora
              }

pdf.fromData( txt, options)
    .then((stats)=> exportar(title,msg,stats,voltarpara) )   // ok..., ok if it was able to handle the file to the OS.  
    .catch((err)=>console.err(err))

} // da funcao...

function exportar(assunto,msg,arquivo,voltarpara) {
var options = {
  message: msg, // not supported on some apps (Facebook, Instagram)
  subject: assunto, // fi. for email
  files: ['data:application/pdf;df:snapsects.pdf;base64,'+arquivo]
//  url: 'https://www.website.com/foo/#bar?a=b',
//  chooserTitle: 'Pick an app' // Android only, you can override the default share sheet title,
//  appPackageName: 'com.apple.social.facebook' // Android only, you can provide id of the App you want to share with
};

window.plugins.socialsharing.shareWithOptions(options, function() {
window.location=voltarpara;
// alert('foi');
}, function() {
window.location=voltarpara;
});
} // da funcao.

