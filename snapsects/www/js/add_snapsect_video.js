var sendimage = '';

document.addEventListener("deviceready", function () {
convertpage();
document.getElementById('lang').value = localStorage.language;
document.getElementById('id').value = querystring(0);

fala(dic[327],cvoz);
}, false);

function snapshot() {
navigator.device.capture.captureVideo(function(mediaFiles) {
 var i = 0;
var data = document.getElementById('frm');
var input = document.createElement('input');
input.type="file";
input.src=mediaFiles[i].fullPath;
data.appendChild(input);
// myForm.submit();
var request = new XMLHttpRequest();
request.open("POST", dic_path+"snapsect_api.php");
request.send(new FormData(data));

// alert(mediaFiles[i].fullPath + '; ');
// document.getElementById('img').src = mediaFiles[i].fullPath; //  + '; ';
// alert(document.getElementById('img').src);
// upload(mediaFiles[i].fullPath,dic_path+'upl.php', function(r) {
document.getElementById('saveandview').style.display = 'inline';
// });
}, function(error) {

}, { limit: 1 });

} // da funcao

function snapshot2() {
navigator.camera.getPicture(function(imageData) {
sendimage = imageData;
if (sendimage.length > 0) {
document.getElementById('saveandview').style.display = 'inline';
// document.getElementById('text').focus();
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
var d = new Date();
var nome = d.getTime().toString();
var temp = {
act: 'addvideo',
lang: localStorage.language,
id: querystring(0),
arquivo: nome,
// img: document.getElementById('img'),
text: document.getElementById('text').value
}
// spopen(dic_path+'snapsect_api.php',temp,'POST', function(res) {
// window.location='show_snapsect.html?id='+querystring(0);
// });
var ttemp = document.getElementById('frm');

var dados = new FormData(ttemp);
// $.ajax({
//     url: dic_path+'snapsect_api.php',
//     type: "POST",
//     data: dados,
//     dataType: 'json',
//     processData: false,
//     contentType: false,
//     success: function(json) {
// window.location='show_snapsect.html?id='+querystring(0);
//     }
// });
var request = new XMLHttpRequest();
request.open("POST", dic_path+"snapsect_api.php");
request.send(new FormData(ttemp));
} // da funcao...
