var voltar_url = 'index.html';
    document.addEventListener("deviceready", function () {
convertpage();
cvoz();
document.getElementById('dvresultado').innerHTML = dic[querystring(0)];
if (querystring(1).length > 0) { voltar_url = 'snapsect_school.html'; }
if (localStorage.autospeak == '1') {
fala(document.getElementById('dvresultado').textContent);
}
    }, false);
