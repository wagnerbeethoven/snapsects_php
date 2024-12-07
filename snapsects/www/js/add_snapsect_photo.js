var sendimage = '';

document.addEventListener("deviceready", function () {
convertpage();
if (querystring(1) == false) { 
fala(dic[319],cvoz);
} else {
spjson(dic_path+'cel_api.php','act=getphotodesc&id='+querystring(0)+'&foto='+querystring(1),'POST', function(res) {
document.getElementById('saveandview').style.display = 'inline';
document.getElementById('dvchangephoto').style.display = 'none';
document.getElementById('grfoto').src = dic_path+'photos/'+localStorage.language.substr(0,2)+'/'+querystring(0)+'/'+querystring(1);
document.getElementById('grfoto').alt = res.alt;
document.getElementById('photodesc').value = res.alt;
fala(dic[325],cvoz);
});
}
}, false);

function snapshot() {
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
// imagem = imageData;
// alert(imagem.length);
}, function(message) {
    alert('Failed because: ' + message);
}, { quality: 50,
   destinationType: Camera.DestinationType.DATA_URL,
//                                destinationType: navigator.camera.DestinationType.FILE_URI,
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
if (document.getElementById('dvchangephoto').style.display == 'inline') {
var d = new Date();
var nome = d.getTime().toString();
var temp = 'act=addimage&lang='+localStorage.language;
temp+='&id='+querystring(0);
temp+='&arquivo='+nome+'.jpg';
temp+='&img='+sendimage;
temp+='&text='+document.getElementById('photodesc').value;
spopen(dic_path+'snapsect_api.php',temp,'POST', function(res) {
window.location='show_snapsect.html?id='+querystring(0);
});
} else {
var temp = 'act=addphotodesc&lang='+localStorage.language;
temp+='&id='+querystring(0);
temp+='&foto='+querystring(1);
temp+='&text='+document.getElementById('photodesc').value;
spopen(dic_path+'cel_api.php',temp,'POST', function(res) {
window.location='show_snapsect.html?id='+querystring(0);
});
} // salva apenas desc
} // da funcao...
