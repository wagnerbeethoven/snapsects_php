var xp = '';
var email = '';
var author = '';

    document.addEventListener("deviceready", function () {

convertpage();
cvoz();
open_snapsect();
if (querystring(0) < '0') {
window.location='find.html';
} // nao tem informacao...
mostra();
    }, false);

function redimensiona() {
document.images['grpi'].width = 300;
} // da funcao

function mostra() {
var ee = lst_snapsect[querystring(0)];
email = ee.email;
author = ee.author;
xp = ee.photo;
// openfile(ee.classe, function(res) {
var t='';
if (ee.photo.length > 0) {
t += '<br><center><img id="grpi" src="data:image/jpeg;base64,'+ee.photo+'" alt="'+dic[219]+' '+ee.commonname+' ('+ee.scientificname+') - '+ee.photodesc+'" width="300px" onload="redimensiona();" /></center><br>';
}
if (!ee.photos) { } else {
if (ee.photos.length > 0) {
for (var r=0;r<ee.photos.length;r++) {
// alert(ee.photos[r].url);
t+='<img src="'+ee.photos[r].url+'" ';
t+=(ee.photos[r].text.length > 0)?'alt="'+ee.photos[r].text:'alt="'+dic[342];
t+='">';
} // do for...
} // da funcao...
} // existe photos
if (!ee.videos) { } else {
if (ee.videos.length > 0) {
for (var r=0;r<ee.videos.length;r++) {
// t+='<input type="button" onclick="javascript:showvideo('+r+');" value="';
// t+=(ee.videos[r].text.length > 0)?ee.videos[r].text:dic[342];
// t+='">';
// t+='  <input type="button" onclick="javascript:myconfirm('+"'SnapSect School',dic[339],['SIM','NÃO'], function(res) { if (res == '1') {delvideo("+r+');} });" value="Remover vídeo">';
} // do for...
} // da funcao...
} // existe photos

if (!ee.audios) { } else {
if (ee.audios.length > 0) {
for (var r=0;r<ee.audios.length;r++) {
// t+='<input type="button" onclick="javascript:showaudio('+r+');" value="';
// t+=(ee.audios[r].text.length > 0)?ee.audios[r].text:dic[342];
// t+='">';
// t+='  <input type="button" onclick="javascript:myconfirm('+"'SnapSect School',dic[345],['SIM','NÃO'], function(res) { if (res == '1') {delaudio("+r+');} });" value="'+dic[344]+'">';
} // do for...
} // da funcao...
} // existe photos

t+='<div id="dvsend">';
t+='<br><center><h2>'+dic[220]+'</h2></center><br>';
t+=dic[221]+': '+ee.author+'<br>';
if (ee.email.length > 0) { t+=dic[187]+': <a href="mailto:'+ee.email+'">'+ee.email+'</a><br>'; }
if (ee.url.length > 0) { t+=dic[189]+': <a href="'+ee.url+'">'+ee.url+'</a><br>'; }
if (ee.colaborative.length > 0) { t+=dic[191]+': '+ee.colaborative+'<br>'; }
t+='<div id="dvidentificacao">';
t+='<br><center><h2>'+dic[222]+'</h2></center><br>';
t+=dic[8]+': '+ee.commonname+'<br>';
t+=dic[86]+': '+ee.scientificname+'<br>';
t+=dic[88]+': '+ee.other+'<br>';
t+=dic[209]+': '+ee.kingdom+'<br>';
t+=dic[210]+': '+ee.phylum+'<br>';
t+=dic[223]+': '+dic[ee.classe]+'<br>';
t+=dic[94]+': '+ee.oorder+'<br>';
t+=dic[19]+': '+ee.family+'<br>';
t+=dic[97]+': '+ee.genus+'<br>';
t+=dic[99]+': '+ee.species+'<br>';
t+=dic[213]+': '+dic[ee.gender]+'<br>';
t+=dic[208]+': '+dic[ee.development]+'<br>';
t+=dic[112]+': '+ee.metamorphosis+'<br>';
t+='</div>';
t+='<div id="dvdescricao">';
t+='<br><center><h2>'+dic[224]+'</h2></center><br>';
t+=dic[114]+': '+ee.colors+'<br>';
t+=dic[116]+': '+ee.bbody+'<br>';
if (ee.classe == '16') {
t+=dic[118]+': '+ee.hhead+'<br>';
t+=dic[120]+': '+ee.thorax+'<br>';
t+=dic[122]+': '+ee.abdomen+'<br>';
} // insetos
else {
if ((ee.classe == '13') || (ee.classe == '17')) {
t+=dic[320]+': '+ee.hhead+'<br>';
t+=dic[122]+': '+ee.abdomen+'<br>';
} // aranha...
else {
t+=dic[118]+': '+ee.hhead+'<br>';
t+=dic[321]+': '+ee.thorax+'<br>';
} // nao e aranha...
} // nao e insetos...
if (ee.classe != '13') {
t+=dic[198]+': '+dic[ee.lstantennae]+'<br>';
t+=dic[126]+': '+ee.antennae+'<br>';
} // nao e aranha...
t+=dic[128]+': '+ee.eyesandocelli+'<br>';
t+=dic[199]+': '+dic[ee.lstmouthparts]+'<br>';
t+=dic[131]+': '+ee.mouthparts+'<br>';
if (ee.classe == '16') {
t+=dic[200]+': '+dic[ee.lstwings]+'<br>';
t+=dic[134]+': '+ee.wings+'<br>';
t+=dic[201]+': '+dic[ee.lsthindwings]+'<br>';
t+=dic[137]+': '+ee.hindwings+'<br>';
} // insetos
t+=dic[202]+': '+dic[ee.lstnumlegs]+'<br>';
t+=dic[203]+': '+dic[ee.lstlegs]+'<br>';
t+=dic[204]+': '+ee.locomotive+'<br>';
t+=dic[205]+': '+dic[ee.tarsomere]+'<br>';
t+=dic[206]+': '+dic[ee.cerci]+'<br>';
t+=dic[207]+': '+ee.specificcharacteristics+'<br>';
t+='</div>';
t+='<div id="dvcolecao">';
t+='<br><center><h2>'+dic[225]+'</h2></center><br>';
t+=dic[153]+': '+ee.collecting+'<br>';
t+=dic[155]+': '+ee.place+'<br>';
t+='</div>';
t+='<div id="dvnotes">';
if (ee.notes.length > 0) {
t+='<br><center><h2>'+dic[170]+'</h2></center><br>';
t+='<p align="justify">'+ee.notes.replaceAll('\\n','<br>')+'</p><br>';
} else {
document.getElementById('linotes').style.display = 'none';
} // nao existe item...
t+='</div>';
t+='<div id="dvaudio">';
if (ee.audiodesc.length > 0) {
t+='<br><center><h2>'+dic[174]+'</h2></center><br>';
t+='<p align="justify">'+ee.audiodesc.replaceAll('\\n','<br>')+'</p><br>';
} else {
document.getElementById('liaudio').style.display='none';
} // nao existe audiodesc...
t+='</div>';
t+='<div id="dvtext">';
if (ee.mediation.length > 0) {
t+='<br><center><h2>'+dic[168]+'</h2></center><br>';
t+='<p align="justify">'+ee.mediation.replaceAll('\\n','<br>')+'</p><br>';
} else {
document.getElementById('litext').style.display = 'none';
}
t+='</div>';
t+='<div id="dvbibliografia">';
if (ee.water.length > 0) {
t+='<br><center><h2 >'+dic[177]+'</h2></center><br>';
t+='<p align="justify">'+ee.water.replaceAll('\\n','<br>')+'</p><br>';
t+='<br>';
} else {
document.getElementById('libibliografia').style.display='none';
} // nao existe bibliografia
t+='</div>';
t+='<div id="dvartropode">';
if ((ee.classe != '') && (ee.classe != '92')) { t+=dic[parseInt(ee.classe)+217]; }
t+='</div>';
t+='<br>';
t+='</div>';
document.getElementById('resultado').innerHTML = t;
fala(dic[226]+' '+dic[ee.classe]+' '+ee.commonname);
// });
} // da funcao...

function sendemail() {
spopen(dic_path+'cel_api.php','act=sendemail&author='+author+'&email='+email+'&texto='+document.getElementById('dvsend').innerHTML+'&photo='+xp,'POST', function(res) {
alert('Congratulations!\nYour audio description has been sent.');
});
} // da funcao...

function sendemail2() {
cordova.plugins.email.open({
to: 'limafj.us@gmail.com',
subject: 'Send Arthropod...',
body: document.getElementById('resultado').innerHTML,
isHtml: true
});
} // da funcao...

function showimg(i) {
myconfirm('SnapSects School',dic[322],[dic[324],dic[325],dic[243]], function(res) {
if (res == 1) { delimg(i); }
if (res == 2) { alert('editar descrição'); }
});
} // da funcao...

function delimg(v) {
myconfirm('SnapSects School',dic[183],[dic[249],dic[248]], function(res) {
if (res == 1) {
deletefile(lst_snapsect[querystring(0)].photos[v].url, function() { });
lst_snapsect[querystring(0)].photos.splice(v,1);
localStorage.snapsect = JSON.stringify(lst_snapsect);
window.location='show_snapsect.html?id='+querystring(0);
} // removendo...
});
} // da funcao...

function showvideo(i) {
document.getElementById('dvvideo').style.display='inline';
var v = document.getElementsByTagName("video")[0];
v.addEventListener('ended', function() {
document.getElementById('dvvideo').style.display='none';
});

v.src = lst_snapsect[querystring(0)].videos[i].url;
v.play();
} // da funcao...

function delvideo(i) {
var fullnome = lst_snapsect[querystring(0)].videos[i].url;
var nome = fullnome.substr(fullnome.lastIndexOf('/') + 1);
var path = fullnome.substr(0,fullnome.lastIndexOf('/') + 1);
lst_snapsect[querystring(0)].videos.splice(i,1);
localStorage.snapsect = JSON.stringify(lst_snapsect);

    window.resolveLocalFileSystemURL(path, function (dir) {
        dir.getFile(nome, {create: false}, function (fileEntry) {
            fileEntry.remove(function (file) {
window.location='show_snapsect.html?id='+querystring(0);
            }, function (error) {
window.location='show_snapsect.html?id='+querystring(0);
            }, function () {
window.location='show_snapsect.html?id='+querystring(0);
            });
        });
    });

} // da funcao

function delaudio(i) {
var fullnome = lst_snapsect[querystring(0)].audios[i].url;
var nome = fullnome.substr(fullnome.lastIndexOf('/') + 1);
var path = fullnome.substr(0,fullnome.lastIndexOf('/') + 1);
lst_snapsect[querystring(0)].audios.splice(i,1);
localStorage.snapsect = JSON.stringify(lst_snapsect);

    window.resolveLocalFileSystemURL(path, function (dir) {
        dir.getFile(nome, {create: false}, function (fileEntry) {
            fileEntry.remove(function (file) {
window.location='show_snapsect.html?id='+querystring(0);
            }, function (error) {
window.location='show_snapsect.html?id='+querystring(0);
            }, function () {
window.location='show_snapsect.html?id='+querystring(0);
            });
        });
    });

} // da funcao

function gravaraudio() {
var p = cordova.file.applicationDirectory + 'www/';
var d = new Date();
var nome = d.getTime().toString()+'.wav';
var snd = new Media(nome, function() { }, function(e) { alert(JSON.stringify(e)); });
snd.startRecord();
navigator.notification.confirm(dic[410], function(res) { 
snd.stopRecord();
if (res == 1) {
navigator.notification.prompt(dic[409], function(r) {
var dados = lst_snapsect[querystring(0)];
if (!dados.audios) { dados.audios = []; }
if (r.buttonIndex == 1) {
dados.audios.push({ url: p+nome, text: r.input1 });
} else {
dados.audios.push({ url: p+nome, text: 'audio'});
} // 
lst_snapsect[querystring(0)] = dados;
localStorage.snapsect = JSON.stringify(lst_snapsect);
window.location='show_snapsect.html?id='+querystring(0);
}, 'SnapSects School', ['Ok','Cancel'], '');
} // gravando...
}, 'SnapSects School', ['Parar gravação','Cancelar']);

} // da funcao...

function showaudio(i) {
var x = lst_snapsect[querystring(0)].audios[i].url;
x = x.substr(x.lastIndexOf('/')+1);
var snd = new Media(x, function() {  }, function(e) { alert(JSON.stringify(e)); });
// var snd = new Media(lst_snapsect[querystring(0)].audios[i].url, function() {  }, function(e) { alert(JSON.stringify(e)); });
snd.play();
} // da funcao...

function preparetela22() {
document.getElementById('dvmenu2').style.display='inline';
document.getElementById('dvmenu').style.display='none';
} // da funcao...

function preprint22() {
// preparetela22();
// alert(dic[380]);
var page = document.getElementById('dvpage').innerHTML;
window.setTimeout(function() { cordova.plugins.printer.print(page, 'Document.html'); }, 1000);
// window.setTimeout( function() { window.location='snapsect_print.html?id='+querystring(0); }, 2000);
} // da funcao...

function tosend() {
preparetela22();
getpdf(dic[407],dic[408],'<html>'+document.getElementById('dvpage').innerHTML+'</html','show_snapsect.html?id='+querystring(0)+'&lang='+localStorage.language);
} // da funcao...
