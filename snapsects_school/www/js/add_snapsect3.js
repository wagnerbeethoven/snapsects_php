var mydados; 
var apifile = 'http://www.domvirt.com.br/snapsect/snapsect_api.php';
var imagem = '';

    document.addEventListener("deviceready", function () {
var px = screen.width;
var py = parseInt(screen.height / 3);
document.getElementById('tabprincipal').width = px;
document.getElementById('dvbody').width = px;
// document.getElementById('colors').height = py;
// document.getElementById('mediation').height = py;
// document.getElementById('notes').height = py;
// document.getElementById('audiodesc').height = py;
// document.getElementById('water').height = py;
// document.getElementById('photodesc').height = py;
// document.getElementById('colaborative').height = py;
// document.getElementById('ground').height = py;
open_snapsect();
document.getElementById('id').value=querystring(0);
// alert(querystring(0));
if (querystring(0) == '-1') document.getElementById('remover').style.display='none';
if (querystring(1).length > 0) { changetela(querystring(1)); } else { changetela('dvprincipal'); }
if (querystring(0) > '-1') { 
mostra(lst_snapsect[querystring(0)]);
}
else {
if (!localStorage.author) { } else {
document.getElementById('author').value = localStorage.author;
} // existe os campos email e author.
if (!localStorage.email) { } else {
document.getElementById('email').value = localStorage.email;
} // pegando o email.
// TTS.speak('add new arthropod...');
} // nao tem os
openfile('CopyRight', function(res) {
document.getElementById('dvrodape').innerHTML = res.replaceAll('.php','.html');
});
    }, false);

function mostraimagem(arq, obj) {
document.getElementById(obj).src = 'img/'+arq.replaceAll(' ','_')+'.jpg';
document.getElementById(obj).width = 100;
} // da funcao

function changetela(tela) {
document.getElementById('cmdprincipal').enabled = true;
document.getElementById('dvauthor').style.display='none';
document.getElementById('dvprincipal').style.display='none';
document.getElementById('dvdescriptions').style.display='none';
document.getElementById('dvmore').style.display='none';
document.getElementById('dvmediation').style.display='none';
document.getElementById('dvnotes').style.display='none';
document.getElementById('dvaudiodesc').style.display='none';
document.getElementById('dvbibliography').style.display='none';
document.getElementById('dvaudiodesc').style.display='none';
document.getElementById(tela).style.display='inline';
document.getElementById('cmdprincipal').enabled = false;
} // da funcao.

function getgps() {
navigator.geolocation.getCurrentPosition(function(l) {
document.getElementById('lat').value = l.coords.latitude;
document.getElementById('lng').value = l.coords.longitude;
spjson("http://maps.google.com/maps/api/geocode/json?latlng="+l.coords.latitude+","+l.coords.longitude+"&sensor=false&region=", '', '', function(data) {
var e = data.results[0];
document.getElementById('address').value=e.address_components[1].short_name+', '+e.address_components[0].short_name;
document.getElementById('city').value=e.address_components[3].long_name;
document.getElementById('uf').value=e.address_components[5].long_name;
document.getElementById('country').value=e.address_components[6].long_name;
});
}, function(e) { });
} // da funcao...

function clearaudiodesc() {
document.getElementById('audiodesc').value='';
} // da funcao

function getaudiodesc() {
var t='Visual attributes: '+document.getElementById('colors').value+'\n';
t+='Body (size shape and segments): '+document.getElementById('bbody').value+'\n';
t+='Head (size shape and other attributes of the head of your specimen): '+document.getElementById('hhead').value+'\n';
t+='Thorax: '+document.getElementById('thorax').value+'\n';
t+='Abdomen: '+document.getElementById('abdomen').value+'\n';
t+='Type of antennae: '+document.getElementById('lstantennae').value+'\n';
t+='Antennae: '+document.getElementById('antennae').value+'\n';
t+='Eyes and ocelli: '+document.getElementById('eyesandocelli').value+'\n';
t+='Type of mouth parts: '+document.getElementById('lstmouthparts').value+'\n';
t+='Mouth parts: '+document.getElementById('mouthparts').value+'\n';
t+='Type of forewings: '+document.getElementById('lstwings').value+'\n';
t+='Forewings: '+document.getElementById('wings').value+'\n';
t+='Type of hind wings: '+document.getElementById('lsthindwings').value+'\n';
t+='Hind wings: '+document.getElementById('hindwings').value+'\n';
t+='Number of legs: '+document.getElementById('lstnumlegs').value+'\n';
t+='Type of legs: '+document.getElementById('lstlegs').value+'\n';
t+='Locomotive legs: '+document.getElementById('locomotive').value+'\n';
t+='Tarsomere: '+document.getElementById('tarsomere').value+'\n';
t+='Cerci: '+document.getElementById('cerci').value+'\n';
t+='Specific characteristics: '+document.getElementById('specificcharacteristics').value+'\n';
t+='Development: '+document.getElementById('development').value+'\n';
t+='Metamorphosis: '+document.getElementById('metamorphosis').value+'\n';
t+='Collecting method: '+document.getElementById('collecting').value+'\n';
t+='Habitat (Place of collection): '+document.getElementById('place').value+'\n';
t+='Mediation text: '+document.getElementById('mediation').value+'\n';
 document.getElementById('audiodesc').value = t;
} // da funcao

function clearnotes() {
document.getElementById('notes').value='';
} // da funcao

function getnotes() {
var t='Common name: '+document.getElementById('commonname').value+'\n';
t+='Scientific name: '+document.getElementById('scientificname').value+'\n';
t+='Author and Date: '+document.getElementById('other').value+'\n';
t+='Kingdom: '+document.getElementById('kingdom').value+'\n';
t+='Phylum (Arthropoda): '+document.getElementById('phylum').value+'\n';
t+='Class: (Insecta): '+document.getElementById('classe').value+'\n';
t+='Order of your specimen: '+document.getElementById('oorder').value+'\n';
t+='Family: '+document.getElementById('family').value+'\n';
t+='Genus: '+document.getElementById('genus').value+'\n';
t+='Species: '+document.getElementById('species').value+'\n';
t+='Sex: '+document.getElementById('gender').value+'\n';

t+='Development: '+document.getElementById('development').value+'\n';
t+='Metamorphosis: '+document.getElementById('metamorphosis').value+'\n';
t+='Collecting method: '+document.getElementById('collecting').value+'\n';
t+='Place of collection: '+document.getElementById('place').value+'\n';
t+='Abiotic factors: '+document.getElementById('win').value+'\n';
t+='Localization: '+document.getElementById('address').value+'\n';
t+='Latitude: '+document.getElementById('lat').value+'\n';
t+='Longitude: '+document.getElementById('lng').value+'\n';
t+='City: '+document.getElementById('city').value+'\n';
t+='State or Province: '+document.getElementById('uf').value+'\n';
t+='Country: '+document.getElementById('country').value+'\n';
t+='Date of collection: '+document.getElementById('datacad').value+'\n';
t+='Temperature: '+document.getElementById('temperature').value+'\n';
 document.getElementById('notes').value = t;
} // da funcao

function delimage() {
spopen('http://www.domvirt.com.br/snapsect/snapsect_api.php','act=delimage&id='+document.getElementById('id').value,'POST', function(res) {
document.getElementById('photodesc').value='';
document.getElementById('grfoto').src = '';
});
} // da funcao.

function mostra(res) {
alert('estou aqui');
var dados = res;
// document.getElementById('id').value=dados.id;
// document.getElementById('userid').value=dados.userid;
document.getElementById('commonname').value=dados.commonname;
document.getElementById('scientificname').value=dados.scientificname;
document.getElementById('other').value=dados.other;
document.getElementById('kingdom').value=dados.kingdom;
document.getElementById('phylum').value=dados.phylum;
document.getElementById('classe').value=dados.classe;
document.getElementById('oorder').value=dados.oorder;
document.getElementById('family').value=dados.family;
document.getElementById('genus').value=dados.genus;
document.getElementById('species').value=dados.species;
document.getElementById('gender').value=dados.gender;
document.getElementById('colors').value=dados.colors;
document.getElementById('bbody').value=dados.bbody;
document.getElementById('hhead').value=dados.hhead;
document.getElementById('thorax').value=dados.thorax;
document.getElementById('abdomen').value=dados.abdomen;
document.getElementById('lstantennae').value=dados.lstantennae;
document.getElementById('antennae').value=dados.antennae;
document.getElementById('eyesandocelli').value=dados.eyesandocelli;
document.getElementById('lstmouthparts').value=dados.lstmouthparts;
document.getElementById('mouthparts').value=dados.mouthparts;
document.getElementById('lstwings').value=dados.lstwings;
document.getElementById('wings').value=dados.wings;
document.getElementById('lsthindwings').value=dados.lsthindwings;
document.getElementById('hindwings').value=dados.hindwings;
document.getElementById('lstnumlegs').value=dados.lstnumlegs;
document.getElementById('lstlegs').value=dados.lstlegs;
document.getElementById('locomotive').value=dados.locomotive;
document.getElementById('tarsomere').value=dados.tarsomere;
document.getElementById('cerci').value=dados.cerci;
document.getElementById('specificcharacteristics').value=dados.specificcharacteristics;
document.getElementById('development').value=dados.development;
document.getElementById('metamorphosis').value=dados.metamorphosis;
document.getElementById('collecting').value=dados.collecting;
document.getElementById('place').value=dados.place;
document.getElementById('datacad').value=dados.datacad;
document.getElementById('lat').value=dados.lat;
document.getElementById('lng').value=dados.lng;
document.getElementById('city').value=dados.city;
document.getElementById('country').value=dados.country;
document.getElementById('uf').value=dados.uf;
document.getElementById('address').value=dados.address;
document.getElementById('win').value=dados.win;
document.getElementById('temperature').value=dados.temperature;
document.getElementById('mediation').value=dados.mediation;
document.getElementById('notes').value=dados.notes;
document.getElementById('audiodesc').value=dados.audiodesc;
document.getElementById('water').value=dados.water;
imagem = dados.photo;
document.getElementById('grfoto').src = "data:image/jpeg;base64," + dados.photo;
document.getElementById('photodesc').value=dados.photodesc;
document.getElementById('ground').value=dados.ground;
document.getElementById('author').value=dados.author;
document.getElementById('email').value=dados.email;
document.getElementById('url').value=dados.url;
document.getElementById('colaborative').value=dados.colaborative;
// TTS.speak('edit '+dados.classe+', '+dados.commonname);
} // da funcao...

function envia() {
if (document.getElementById('commonname').value.length > 0) {
if (document.getElementById('scientificname').value.length > 0) {
var temp='act=add';
temp+='&id='+document.getElementById('id').value;
temp+='&userid='+document.getElementById('userid').value;
temp+='&commonname='+document.getElementById('commonname').value;
temp+='&scientificname='+document.getElementById('scientificname').value;
temp+='&other='+document.getElementById('other').value;
temp+='&kingdom='+document.getElementById('kingdom').value;
temp+='&phylum='+document.getElementById('phylum').value;
temp+='&classe='+document.getElementById('classe').value;
temp+='&oorder='+document.getElementById('oorder').value;
temp+='&family='+document.getElementById('family').value;
temp+='&genus='+document.getElementById('genus').value;
temp+='&species='+document.getElementById('species').value;
temp+='&gender='+document.getElementById('gender').value;
temp+='&colors='+document.getElementById('colors').value;
temp+='&bbody='+document.getElementById('bbody').value;
temp+='&hhead='+document.getElementById('hhead').value;
temp+='&thorax='+document.getElementById('thorax').value;
temp+='&abdomen='+document.getElementById('abdomen').value;
temp+='&lstantennae='+document.getElementById('lstantennae').value;
temp+='&antennae='+document.getElementById('antennae').value;
temp+='&eyesandocelli='+document.getElementById('eyesandocelli').value;
temp+='&lstmouthparts='+document.getElementById('lstmouthparts').value;
temp+='&mouthparts='+document.getElementById('mouthparts').value;
temp+='&lstwings='+document.getElementById('lstwings').value;
temp+='&wings='+document.getElementById('wings').value;
temp+='&lsthindwings='+document.getElementById('lsthindwings').value;
temp+='&hindwings='+document.getElementById('hindwings').value;
temp+='&lstnumlegs='+document.getElementById('lstnumlegs').value;
temp+='&lstlegs='+document.getElementById('lstlegs').value;
temp+='&locomotive='+document.getElementById('locomotive').value;
temp+='&tarsomere='+document.getElementById('tarsomere').value;
temp+='&cerci='+document.getElementById('cerci').value;
temp+='&specificcharacteristics='+document.getElementById('specificcharacteristics').value;
temp+='&development='+document.getElementById('development').value;
temp+='&metamorphosis='+document.getElementById('metamorphosis').value;
temp+='&collecting='+document.getElementById('collecting').value;
temp+='&place='+document.getElementById('place').value;
temp+='&datacad='+document.getElementById('datacad').value;
temp+='&lat='+document.getElementById('lat').value;
temp+='&lng='+document.getElementById('lng').value;
temp+='&city='+document.getElementById('city').value;
temp+='&country='+document.getElementById('country').value;
temp+='&uf='+document.getElementById('uf').value;
temp+='&address='+document.getElementById('address').value;
temp+='&win='+document.getElementById('win').value;
temp+='&temperature='+document.getElementById('temperature').value;
temp+='&mediation='+document.getElementById('mediation').value;
temp+='&notes='+document.getElementById('notes').value;
temp+='&audiodesc='+document.getElementById('audiodesc').value;
temp+='&water='+document.getElementById('water').value;
temp+='&photo='+document.getElementById('grfoto').src;
temp+='&photodesc='+document.getElementById('photodesc').value;
temp+='&ground='+document.getElementById('ground').value;
temp+='&author='+document.getElementById('author').value;
temp+='&email='+document.getElementById('email').value;
temp+='&url='+document.getElementById('url').value;
temp+='&colaborative='+document.getElementById('colaborative').value;
if (document.getElementById('salvafoto').checked == true) {
temp+='&salvafoto=1';
} else {
temp+='&salvafoto=0';
} // salvar foto...
spjson(apifile,temp,'POST', function(resposta) {
window.location='show_snapsect.html?id='+resposta.id;
}, function() { });
} // scientificname existe
else { document.getElementById('scientificname').focus(); }
} // commonname existe...
else { document.getElementById('commonname').focus(); }
} // da funcao...

function snapshot() {
navigator.camera.getPicture(function(imageData) {
    var image = document.getElementById('grfoto');
    image.src = "data:image/jpeg;base64," + imageData;
//    image.src = imageData;
image.width = 300;
imagem = imageData;
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
    var image = document.getElementById('grfoto');
   image.src = "data:image/jpeg;base64," + imageData;
//    image.src = imageData;
image.width = 300;
imagem = imageData;
}, function(message) {
    alert('Failed because: ' + message);
}, { quality: 50,
    destinationType: Camera.DestinationType.DATA_URL
//                               destinationType: navigator.camera.DestinationType.FILE_URI,
                                sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY

});
} // da funcao

function delbicho(v) {

} // da funcao...

function salvar() {
if ((document.getElementById('author').value.length < 1) || (document.getElementById('email').value.length < 1)) {
alert('Please write author and email...');
changetela('dvauthor');
document.getElementById('author').focus();
} // campos vazios...
else {
var dados = {
commonname: document.getElementById('commonname').value,
scientificname: document.getElementById('scientificname').value,
other: document.getElementById('other').value,
kingdom: document.getElementById('kingdom').value,
phylum: document.getElementById('phylum').value,
classe: document.getElementById('classe').value,
oorder: document.getElementById('oorder').value,
family: document.getElementById('family').value,
genus: document.getElementById('genus').value,
species: document.getElementById('species').value,
gender: document.getElementById('gender').value,
colors: document.getElementById('colors').value,
bbody: document.getElementById('bbody').value,
hhead: document.getElementById('hhead').value,
thorax: document.getElementById('thorax').value,
abdomen: document.getElementById('abdomen').value,
lstantennae: document.getElementById('lstantennae').value,
antennae: document.getElementById('antennae').value,
eyesandocelli: document.getElementById('eyesandocelli').value,
lstmouthparts: document.getElementById('lstmouthparts').value,
mouthparts: document.getElementById('mouthparts').value,
lstwings: document.getElementById('lstwings').value,
wings: document.getElementById('wings').value,
lsthindwings: document.getElementById('lsthindwings').value,
hindwings: document.getElementById('hindwings').value,
lstnumlegs: document.getElementById('lstnumlegs').value,
lstlegs: document.getElementById('lstlegs').value,
locomotive: document.getElementById('locomotive').value,
tarsomere: document.getElementById('tarsomere').value,
cerci: document.getElementById('cerci').value,
specificcharacteristics: document.getElementById('specificcharacteristics').value,
development: document.getElementById('development').value,
metamorphosis: document.getElementById('metamorphosis').value,
collecting: document.getElementById('collecting').value,
place: document.getElementById('place').value,
datacad: document.getElementById('datacad').value,
lat: document.getElementById('lat').value,
lng: document.getElementById('lng').value,
city: document.getElementById('city').value,
country: document.getElementById('country').value,
uf: document.getElementById('uf').value,
address: document.getElementById('address').value,
win: document.getElementById('win').value,
temperature: document.getElementById('temperature').value,
mediation: document.getElementById('mediation').value,
notes: document.getElementById('notes').value,
audiodesc: document.getElementById('audiodesc').value,
water: document.getElementById('water').value,
photo: imagem,
photodesc: document.getElementById('photodesc').value,
ground: document.getElementById('ground').value,
author: document.getElementById('author').value,
email: document.getElementById('email').value,
url: document.getElementById('url').value,
colaborative: document.getElementById('colaborative').value
}
var nn = 0;
if (querystring(0) > -1) {
lst_snapsect[querystring(0)] = dados;
nn = querystring(0);
} else {
lst_snapsect.push(dados);
nn = lst_snapsect.length - 1;
} // novo...
localStorage.snapsect = JSON.stringify(lst_snapsect);
if (!localStorage.author) {
if (confirm('Save author and email for future submissions? If you choose "Cancel" you will have to fill up author name and email address fields next time you submit an audio description.')) {
localStorage.author = document.getElementById('author').value;
localStorage.email = document.getElementById('email').value;
} // salvando...
} // nao existe salvo o author e email...
window.location='show_snapsect.html?id='+nn;
} // tem nome e email...
} // da funcao...
