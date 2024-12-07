var sendimage = '';

document.addEventListener("deviceready", function () {
convertpage();
cvoz();
open_snapsect();
fala(dic[327]);
snapshot();
}, false);

function snapshot() {
navigator.device.capture.captureVideo(function(mediaFiles) {
var i = 0;
var v = document.getElementsByTagName("video")[0];
sendimage = mediaFiles[i].fullPath;
v.src = sendimage;
document.getElementById('dvvideo').style.display='inline';
document.getElementById('saveandview').style.display = 'inline';
}, function(error) {

}, { limit: 1 });

} // da funcao

function snapshot2() {
navigator.camera.getPicture(function(imageData) {
sendimage = imageData;
// if (sendimage.length > 0) {
document.getElementById('saveandview').style.display = 'inline';
document.getElementById('dvvideo').style.display='inline';
// document.getElementById('photodesc').focus();
// }
//    var image = document.getElementById('grfoto');
//    image.src = "data:image/jpeg;base64," + imageData;
//    image.src = imageData;
// image.width = 300;
}, function(message) {
    alert('Failed because: ' + message);
}, { quality: 50,
//    destinationType: Camera.DestinationType.DATA_URL,
                               destinationType: navigator.camera.DestinationType.FILE_URI,
sourceType: 1 // navigator.camera.PictureSourceType.SAVEDPHOTOALBUM // PHOTOLIBRARY

});
} // da funcao

function envia() {
if (sendimage == '') {
myalert(dic[338], function() { });
} else {
if (!lst_snapsect[querystring(0)].videos) { lst_snapsect[querystring(0)].videos = []; }
var d = {
url: sendimage,
text: document.getElementById('photodesc').value
}
lst_snapsect[querystring(0)].videos.push(d);
localStorage.snapsect = JSON.stringify(lst_snapsect);
window.location='show_snapsect.html?id='+querystring(0);
} // tem imagem...
} // da funcao...
