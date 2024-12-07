
    document.addEventListener("deviceready", function () {
convertpage();
mostra(querystring(0));
    }, false);

function mostra(v) {
spjson(dic_path+'snapsect_user_api.php','act=get&id='+v,'GET', function(q) {
// alert(q.stringify(q));
// q = JSON.parse(q);
document.getElementById('nome').value = q.nome;
document.getElementById('email').value = q.email;
document.getElementById('url').value = q.url;
document.getElementById('status').value = q.status;
document.getElementById('obs').value = q.obs;
document.getElementById('id').value = q.id;
document.getElementById('pws').value = q.pws;
fala(q.nome, cvoz);
}, function(e) { alert(e); });
} // da funcao...

function salvar() {
var temp = 'act=add';
temp+='&nome='+document.getElementById('nome').value;
temp+='&email='+document.getElementById('email').value;
temp+='&url='+document.getElementById('url').value;
temp+='&status='+document.getElementById('status').value;
temp+='&obs='+document.getElementById('obs').value;
temp+='&pws='+document.getElementById('pws').value;
temp+='&id='+document.getElementById('id').value;
spjson(dic_path+'snapsect_user_api.php',temp,'GET', function(r) {
window.location='snapsect_user_ger.html';
});
} // da funcao...

function removeusr() {
if (confirm(dic[316])) {
spjson(dic_path+'snapsect_user_api.php','act=deluser&id='+querystring(0)+'&email='+querystring(1),'GET', function(res) {
window.location='snapsect_user_ger.html';
}, function() { 
window.location='snapsect_user_ger.html';
});
} // da funcao...
