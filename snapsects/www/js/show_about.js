    document.addEventListener("deviceready", function () {
convertpage();
cvoz();
document.getElementById('dvresultado').innerHTML = dic[querystring(0)];
if (localStorage.autospeak == '1') {
fala(document.getElementById('dvresultado').textContent);
}
    }, false);

function sendemail() {
cordova.plugins.email.open({
to: 'hi@snapsects.com',
subject: 'Send Arthropod...',
body: document.getElementById('dvresultado').innerHTML,
isHtml: true
});
} // da funcao...
