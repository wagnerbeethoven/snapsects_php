function mostraimagem(arq, obj) {
document.getElementById(obj).src = URL_SITE+'img/'+arq.replaceAll(' ','_')+'.jpg';
document.getElementById(obj).width = 200;
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

function loading() {
if ({P->ID} < 1) document.getElementById('remover').style.display='none';
document.getElementById('classe').value='{P->CLASSE}';
document.getElementById('development').value='{P->DEVELOPMENT}';
document.getElementById('gender').value='{P->GENDER}';
document.getElementById('lstantennae').value='{P->LSTANTENNAE}';
document.getElementById('lstmouthparts').value='{P->LSTMOUTHPARTS}';
document.getElementById('lstwings').value='{P->LSTWINGS}';
document.getElementById('lsthindwings').value='{P->LSTHINDWINGS}';
document.getElementById('lstnumlegs').value='{P->LSTNUMLEGS}';
document.getElementById('lstlegs').value='{P->LSTLEGS}';
document.getElementById('cerci').value='{P->CERCI}';
document.getElementById('tarsomere').value='{P->TARSOMERE}';
changetela('{DVINIT}');
} // da funcao...

function getgps() {
navigator.geolocation.getCurrentPosition(function(l) {
document.getElementById('lat').value = l.coords.latitude;
document.getElementById('lng').value = l.coords.longitude;
spjson("http://maps.google.com/maps/api/geocode/json?latlng="+l.coords.latitude+","+l.coords.longitude+"&sensor=false&region=", '', '', function(data) {
// alert(JSON.stringify(data.results[0].address_components[1].short_name));
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
var t='[ Visual attributes: ] '+document.getElementById('colors').value+'\n';
t+='[ Body (size shape and segments): ] '+document.getElementById('bbody').value+'\n';
t+='[ Head (size shape and other attributes of the head of your specimen): ] '+document.getElementById('hhead').value+'\n';
t+='[ Thorax: ] '+document.getElementById('thorax').value+'\n';
t+='[ Abdomen: ] '+document.getElementById('abdomen').value+'\n';
t+='[ Type of antennae: ] '+document.getElementById('lstantennae').value+'\n';
t+='[ Antennae: ] '+document.getElementById('antennae').value+'\n';
t+='[ Eyes and ocelli: ] '+document.getElementById('eyesandocelli').value+'\n';
t+='[ Type of mouth parts: ] '+document.getElementById('lstmouthparts').value+'\n';
t+='[ Mouth parts: ] '+document.getElementById('mouthparts').value+'\n';
t+='[ Type of forewings: ] '+document.getElementById('lstwings').value+'\n';
t+='[ Forewings: ] '+document.getElementById('wings').value+'\n';
t+='[ Type of hind wings: ] '+document.getElementById('lsthindwings').value+'\n';
t+='[ Hind wings: ] '+document.getElementById('hindwings').value+'\n';
t+='[ Number of legs: ] '+document.getElementById('lstnumlegs').value+'\n';
t+='[ Type of legs: ] '+document.getElementById('lstlegs').value+'\n';
t+='[ Locomotive legs: ] '+document.getElementById('locomotive').value+'\n';
t+='[ Tarsomere: ] '+document.getElementById('tarsomere').value+'\n';
t+='[ Cerci: ] '+document.getElementById('cerci').value+'\n';
t+='[ Specific characteristics: ] '+document.getElementById('specificcharacteristics').value+'\n';
t+='[ Collecting method: ] '+document.getElementById('collecting').value+'\n';
t+='[ Habitat (Place of collection): ] '+document.getElementById('place').value+'\n';
t+='[ Mediation text: ] '+document.getElementById('mediation').value+'\n';
 document.getElementById('audiodesc').value = t;
} // da funcao

function clearnotes() {
document.getElementById('notes').value='';
} // da funcao

function getnotes() {
var t='[ Common name: ] '+document.getElementById('commonname').value+'\n';
t+='[ Scientific name: ] '+document.getElementById('scientificname').value+'\n';
t+='[ Author and Date: ] '+document.getElementById('other').value+'\n';
t+='[ Kingdom: ] '+document.getElementById('kingdom').value+'\n';
t+='[ Phylum (Arthropoda): ] '+document.getElementById('phylum').value+'\n';
t+='[ Class: (Insecta): ] '+document.getElementById('classe').value+'\n';
t+='[ Order of your specimen: ] '+document.getElementById('oorder').value+'\n';
t+='[ Family: ] '+document.getElementById('family').value+'\n';
t+='[ Genus: ] '+document.getElementById('genus').value+'\n';
t+='[ Species: ] '+document.getElementById('species').value+'\n';
t+='[ Sex: ] '+document.getElementById('gender').value+'\n';

t+='[ Development: ] '+document.getElementById('development').value+'\n';
t+='[ Metamorphosis: ] '+document.getElementById('metamorphosis').value+'\n';
t+='[ Collecting method: ] '+document.getElementById('collecting').value+'\n';
t+='[ Place of collection: ] '+document.getElementById('place').value+'\n';
t+='[ Abiotic factors: ] '+document.getElementById('win').value+'\n';
t+='[ Localization: ] '+document.getElementById('address').value+'\n';
t+='[ Latitude: ] '+document.getElementById('lat').value+'\n';
t+='[ Longitude: ] '+document.getElementById('lng').value+'\n';
t+='[ City: ] '+document.getElementById('city').value+'\n';
t+='[ State or Province: ] '+document.getElementById('uf').value+'\n';
t+='[ Country: ] '+document.getElementById('country').value+'\n';
t+='[ Date of collection: ] '+document.getElementById('datacad').value+'\n';
t+='[ Temperature: ] '+document.getElementById('temperature').value+'\n';

 document.getElementById('notes').value = t;
} // da funcao

function delimage() {
spopen(URL_SITE+'snapsect_api.php','act=delimage&id={P->ID}','POST', function(res) {
document.getElementById('photodesc').value='';
document.getElementById('grfoto').src = '';
});
} // da funcao.
