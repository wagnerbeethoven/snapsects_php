var sendimage = '';
var myurl;
var mudar = 0;

document.addEventListener("deviceready", function () {
convertpage();
cvoz();
document.getElementById('id').value = querystring(0);
document.getElementById('lang').value = localStorage.language;
}, false);

function gravaraudio() {
navigator.device.capture.captureAudio(function(mediaFiles) {
var i, len;
for (i = 0, len = mediaFiles.length; i < len; i += 1) {
myurl = mediaFiles[i];
document.getElementById('nome').value = myurl.name;
        }        // do for...
mudar = 1;
document.getElementById('saveandview').style.display = 'inline';

}, function(error) {

}, {limit:1});

} // da funcao...

function snapshot() {
navigator.device.capture.captureVideo(function(mediaFiles) {
// document.getElementById('dvvideo').style.display = 'block';
// var v = document.getElementsByTagName("video")[0];
var i, len;
for (i = 0, len = mediaFiles.length; i < len; i += 1) {
myurl = mediaFiles[i];
document.getElementById('nome').value = myurl.name;
// v.src = mediaFiles[i].fullPath;
        }        // do for...
mudar = 1;
document.getElementById('saveandview').style.display = 'inline';
},  function(error) {

}, {limit: 1});
} // da funcao

function abriu() {
document.getElementById('saveandview').style.display='inline';
mudar = 0;
} // da funcao...

function gravaraudio2() {
var p = cordova.file.applicationDirectory + 'www/';
// var p = window.location.pathname.substring(0,window.location.pathname.lastIndexOf('/')+1);
var d = new Date();
var nome = d.getTime().toString()+'.wav';
var t='<audio id="obj" src=""></audio>';
document.getElementById('resultado').innerHTML = t;
var snd = new Media(nome, function() { }, function(e) { alert(JSON.stringify(e)); });
snd.startRecord();
navigator.notification.confirm('Gravando...', function(res) { 
snd.stopRecord();
if (res == 1) {

mudar = 1;
document.getElementById('saveandview').style.display = 'inline';
document.getElementById('obj').src = p+nome;
document.getElementById('obj').play();
}
}, 'SnapSects School', ['Parar gravação','Cancelar']);

} // da funcao...

function envia1() {
document.getElementById('mudar').value = mudar;
var data = document.getElementById('frm');
spform(dic_path+'/snapsect_api.php', data, function(res) {
window.location='show_snapsect.html?id='+querystring(0);
});
} // da funcao...

function envia() {
if (mudar == 0) {
envia1();
} else {
        var ft = new FileTransfer(), path = myurl.fullPath, name = localStorage.language[0]+localStorage.language[1]+'_'+querystring(0)+'_'+myurl.name;

ft.upload(path, dic_path+"upl.php", function(result) {
envia1();
            }, function(error) {
                alert('Error uploading file ' + path + ': ' + error.code);
            }, { fileName: name, chunkedMode: false });   
} // envia o video...
} // da funcao...