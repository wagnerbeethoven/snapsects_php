
    document.addEventListener("deviceready", function () {
convertpage();
listlanguage(function(res) {
var t = '<p><label for="language">'+dic[228]+': </label><select id="language" name="language" onchange="javascript:changelang(this.value);">';
var p = JSON.parse(res);
for (var r=0;r<p.length;r++) {
t+='<option value="'+p[r].id+'">'+p[r].name+'</option>';
} // do for...
t+='</select></p>';
document.getElementById('dvlanguage').innerHTML = t;
document.getElementById('language').value = localStorage.language;
});
document.getElementById('cmdautodic').checked = (localStorage.autodic == '1')?true:false;

document.getElementById('cmdautospeak').checked = (localStorage.autospeak == '1')?true:false;
document.getElementById('cmdmute').checked = (localStorage.mute == '1')?true:false;
document.getElementById('cmdmove').checked = (localStorage.move == '1')?true:false;
document.getElementById('cmdautoform').checked = (localStorage.autoform == '1')?true:false;

document.getElementById('txtnome').value = localStorage.nome;
document.getElementById('txtemail').value = localStorage.email;
fala(dic[264],cvoz);
    }, false);

function changelang(lang) {
changelanguage(lang, function() {
window.location='settings.html';
});
} // da funcao

function changeautodic() {
localStorage.autodic=(document.getElementById('cmdautodic').checked == true)?'1':'0';
} // da funcao...

function changevel(x) {
localStorage.vel = x;
fala(dic[256]);
} // da funcao...

function changeautospeak() {
localStorage.autospeak=(document.getElementById('cmdautospeak').checked == true)?'1':'0';
} // da funcao...

function changemute() {
localStorage.mute=(document.getElementById('cmdmute').checked == true)?'1':'0';
} // da funcao...

function salvarconfig() {
localStorage.nome = document.getElementById('txtnome').value;
localStorage.email = document.getElementById('txtemail').value;
fala(dic[265]);
} // da funcao...

function changemove() {
if (document.getElementById("cmdmove").checked == true) {
localStorage.move = '1';
fala('Ativando reconhecimento de movimento...', startmove);
} else {
localStorage.move = '0';
fala('desligando reconhecimento de movimento...', stopmove);
}
} // da funcao...

function changeautoform() {
if (document.getElementById("cmdautoform").checked == true) {
localStorage.autoform = '1';
fala('Ativando leitura automática de formulários...');
} else {
localStorage.autoform = '0';
fala('desligando a leitura automática de formulários...');
}
} // da funcao...

