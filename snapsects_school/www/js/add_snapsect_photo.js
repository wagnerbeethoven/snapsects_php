var sendimage = '';

document.addEventListener("deviceready", function () {
if (querystring(0) < '0') {
window.location='index.html';
} // volta pro index...
convertpage();
cvoz();
open_snapsect();
fala(dic[319]);
}, false);

function snapshot() {
navigator.camera.getPicture(function(imageData) {
sendimage = imageData;
// if (sendimage.length > 0) {
document.getElementById('saveandview').style.display = 'inline';
// }

    var image = document.getElementById('grfoto');
//    image.src = "data:image/jpeg;base64," + imageData;
image.src = imageData;
image.width = 300;
// imagem = imageData;
// alert(imagem.length);
}, function(message) {
    alert('Failed because: ' + message);
}, { quality: 50,
//   destinationType: Camera.DestinationType.DATA_URL,
                                destinationType: navigator.camera.DestinationType.FILE_URI,
saveToPhotoAlbum : true,
                                sourceType: navigator.camera.PictureSourceType.PHOTO

});
} // da funcao

function snapshot2() {
navigator.camera.getPicture(function(imageData) {
sendimage = imageData;
if (sendimage.length > 0) {
document.getElementById('saveandview').style.display = 'inline';
// document.getElementById('photodesc').focus();
}
    var image = document.getElementById('grfoto');
   image.src = "data:image/jpeg;base64," + imageData;
//    image.src = imageData;
image.width = 300;
}, function(message) {
    alert('Failed because: ' + message);
}, { quality: 50,
    destinationType: Camera.DestinationType.DATA_URL,
//                               destinationType: navigator.camera.DestinationType.FILE_URI,
                                sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY

});
} // da funcao

function envia() {
var d = {
url: sendimage,
text: document.getElementById('photodesc').value
}
if (!lst_snapsect[parseInt(querystring(0))].photos) { lst_snapsect[parseInt(querystring(0))].photos = [d]; }
else { lst_snapsect[parseInt(querystring(0))].photos.push(d); }
localStorage.snapsect = JSON.stringify(lst_snapsect);
window.location='show_snapsect.html?id='+querystring(0);
} // da funcao...
