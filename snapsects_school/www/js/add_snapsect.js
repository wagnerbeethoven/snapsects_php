var mydados; 
var apifile = dic_path+'snapsect_api.php';
var imagem = '';
var tempphotos = [];
var tempvideos = [];
var tempaudios = [];

    document.addEventListener("deviceready", function () {
convertpage();
cvoz(0);
var px = screen.width;
var py = parseInt(screen.height / 3);
document.getElementById('tabprincipal').width = px;
document.getElementById('dvbody').width = px;
open_snapsect();
document.getElementById('id').value=querystring(0);
if (querystring(0) == '-1') document.getElementById('delbtn').style.display='none';
var vtela = querystring(1);
if (querystring(1).length > 0) { 
document.getElementById('lstpg').value = querystring(1);
// changetela(querystring(1)); 
} else { 
document.getElementById('lstpg').value = 'dvprincipal';
// changetela('dvprincipal'); 
vtela = 'dvprincipal';
}
var texto = '';
if (querystring(0) > '-1') { 
texto = mostra(lst_snapsect[parseInt(querystring(0))]);
}
else {
document.getElementById('author').value = localStorage.nome;
document.getElementById('email').value = localStorage.email;
texto = dic[195];
} // nao tem os
arrumaclasse();
fala(texto, function() { changetela(vtela); });
}, false);

function mostraimagem(arq, obj) {
document.getElementById(obj).src = 'img/'+arq.replaceAll(' ','_')+'.jpg';
document.getElementById(obj).width = 100;
} // da funcao

function arrumaclasse() {
var d = document.getElementById('classe').value;
document.getElementById('classe2').value = document.getElementById('classe').value;
// alert(d);
document.getElementById('dvasas').style.display='none';
document.getElementById('dvantenas').style.display='none';
document.getElementById('dvinseto').style.display='none';
document.getElementById('dvaranha').style.display='none';
document.getElementById('dvmiriapode').style.display='none';
document.getElementById('dvantenas').style.display='inline';
if (d == "16") {
document.getElementById('dvasas').style.display='inline';

document.getElementById('dvinseto').style.display='inline';
document.getElementById('lstnumlegs').value = "55";
} // inseto...
else {
if ((d == "13") || (d == '17')) {
document.getElementById('dvaranha').style.display='inline';
document.getElementById('lstnumlegs').value = "56";
if (d == '13') document.getElementById('dvantenas').style.display='none';
} // aranha...
else {
document.getElementById('dvmiriapode').style.display='inline';
document.getElementById('lstnumlegs').value = "57";
} // nao e aranha
} // nao e inseto
} // da funcao...

function changetela(tela) {
// document.getElementById('cmdprincipal').enabled = true;
document.getElementById('dvauthor').style.display='none';
document.getElementById('dvprincipal').style.display='none';
document.getElementById('dvdescriptions').style.display='none';
document.getElementById('dvmore').style.display='none';
document.getElementById('dvmediation').style.display='none';
document.getElementById('dvnotes').style.display='none';
document.getElementById('dvaudiodesc').style.display='none';
document.getElementById('dvbibliography').style.display='none';
document.getElementById('dvpicture').style.display='none';
document.getElementById(tela).style.display='inline';
var t = '';
if (tela == 'dvprincipal') { t = dic[1]; }
if (tela == 'dvauthor') { t = dic[81]; }
if (tela == 'dvdescriptions') { t = dic[2]; }
if (tela == 'dvmore') { t = dic[3]; }
if (tela == 'dvmediation') { t = dic[4]; }
if (tela == 'dvnotes') { t = dic[5]; }
if (tela == 'dvaudiodesc') { t = dic[6]; }
if (tela == 'dvbibliography') { t = dic[82]; }
fala(t, function() {
if (localStorage.autoform == '1') { editform(); }
});
// document.getElementById('cmdprincipal').enabled = false;
} // da funcao.

function convertaddress(vv) {
for (var r=0;r<vv.length;r++) {
if ((!vv[r].thoroughfare) || (!vv[r].subThoroughfare)) { } else {
var v = vv[r];
var obj = { };
obj.country = v.countryName;
obj.cep = v.postalCode;
obj.estado = v.administrativeArea;
obj.cidade = v.subAdministrativeArea;
obj.bairro = v.subLocality;
obj.address = v.thoroughfare;
obj.number = v.subThoroughfare;
obj.est = '';
obj.title = obj.address+', '+obj.number+'. '+obj.bairro+' - '+obj.cidade+'.';
return obj;
break;
} // existe o endereço...
} // do for...
} // da funcao...

function getgps() {
navigator.geolocation.getCurrentPosition(function(l) {
document.getElementById('lat').value = l.coords.latitude;
document.getElementById('lng').value = l.coords.longitude;
nativegeocoder.reverseGeocode(function(rr) {
var e = convertaddress(rr);
document.getElementById('address').value=e.address+', '+e.number;
document.getElementById('city').value=e.cidade;
document.getElementById('uf').value=e.estado;
document.getElementById('country').value =e.country;
}, function() { }, l.coords.latitude, l.coords.longitude, { useLocale: true, maxResults: 5 });
}, function(e) { });
} // da funcao...

function clearaudiodesc() {
document.getElementById('audiodesc').value='';
} // da funcao

function getaudiodesc() {
// taxinomia
var t=dic[8]+': '+document.getElementById('commonname').value+'\n';
t+=dic[86]+': '+document.getElementById('scientificname').value+'\n';
t+=dic[88]+': '+document.getElementById('other').value+'\n';
t+=dic[209]+': '+document.getElementById('kingdom').value+'\n';
t+=dic[210]+': '+document.getElementById('phylum').value+'\n';
t+=dic[211]+': '+dic[document.getElementById('classe').value]+'\n';
t+=dic[212]+': '+document.getElementById('oorder').value+'\n';
t+=dic[19]+': '+document.getElementById('family').value+'\n';
t+=dic[97]+': '+document.getElementById('genus').value+'\n';
t+=dic[99]+': '+document.getElementById('species').value+'\n';
t+=dic[213]+': '+dic[document.getElementById('gender').value]+'\n';
t+=dic[208]+': '+dic[document.getElementById('development').value]+'\n';
t+=dic[112]+': '+document.getElementById('metamorphosis').value+'\n';

// descricao
t+=dic[114]+': '+document.getElementById('colors').value+'\n';
t+=dic[196]+': '+document.getElementById('bbody').value+'\n';
if (document.getElementById('classe').value == '16') {
t+=dic[118]+': '+document.getElementById('hhead').value+'\n';
t+=dic[120]+': '+document.getElementById('thorax').value+'\n';
t+=dic[122]+': '+document.getElementById('abdomen').value+'\n';
t+=dic[198]+': '+dic[document.getElementById('lstantennae').value]+'\n';
t+=dic[126]+': '+document.getElementById('antennae').value+'\n';
} // dos insetos
else {
if (document.getElementById('classe').value == '13') {
t+=dic[320]+': '+document.getElementById('hhead').value+'\n';
t+=dic[122]+': '+document.getElementById('abdomen').value+'\n';
} // aranha
else {
t+=dic[118]+': '+document.getElementById('hhead').value+'\n';
t+=dic[321]+': '+document.getElementById('thorax').value+'\n';
} // nao e aranha.
} // nao e inseto.
t+=dic[128]+': '+document.getElementById('eyesandocelli').value+'\n';
t+=dic[199]+': '+dic[document.getElementById('lstmouthparts').value]+'\n';
t+=dic[131]+': '+document.getElementById('mouthparts').value+'\n';
if (document.getElementById('classe').value == '16') {
t+=dic[200]+': '+dic[document.getElementById('lstwings').value]+'\n';
t+=dic[134]+': '+document.getElementById('wings').value+'\n';
t+=dic[201]+': '+dic[document.getElementById('lsthindwings').value]+'\n';
t+=dic[137]+': '+document.getElementById('hindwings').value+'\n';
} // das asas dos insetos.
t+=dic[202]+': '+dic[document.getElementById('lstnumlegs').value]+'\n';
t+=dic[203]+': '+dic[document.getElementById('lstlegs').value]+'\n';
t+=dic[204]+': '+document.getElementById('locomotive').value+'\n';
t+=dic[205]+': '+dic[document.getElementById('tarsomere').value]+'\n';
t+=dic[206]+': '+dic[document.getElementById('cerci').value]+'\n';
t+=dic[207]+': '+document.getElementById('specificcharacteristics').value+'\n';
// t+=dic[208]+': '+dic[document.getElementById('development').value]+'\n';
// t+=dic[112]+': '+document.getElementById('metamorphosis').value+'\n';
// notas proemias
t+=document.getElementById('notes').value+'\n';
// t+=dic[153]+': '+document.getElementById('collecting').value+'\n';
// t+=dic[155]+': '+document.getElementById('place').value+'\n';
// t+=dic[168]+': '+document.getElementById('mediation').value+'\n';
document.getElementById('audiodesc').value = t;
} // da funcao

function clearnotes() {
document.getElementById('notes').value='';
} // da funcao

function getnotes() {
// taxinomia
var t=dic[8]+': '+document.getElementById('commonname').value+'\n';
t+=dic[86]+': '+document.getElementById('scientificname').value+'\n';
t+=dic[88]+': '+document.getElementById('other').value+'\n';
t+=dic[209]+': '+document.getElementById('kingdom').value+'\n';
t+=dic[210]+': '+document.getElementById('phylum').value+'\n';
t+=dic[211]+': '+dic[document.getElementById('classe').value]+'\n';
t+=dic[212]+': '+document.getElementById('oorder').value+'\n';
t+=dic[19]+': '+document.getElementById('family').value+'\n';
t+=dic[97]+': '+document.getElementById('genus').value+'\n';
t+=dic[99]+': '+document.getElementById('species').value+'\n';
t+=dic[213]+': '+dic[document.getElementById('gender').value]+'\n';
t+=dic[208]+': '+dic[document.getElementById('development').value]+'\n';
t+=dic[112]+': '+document.getElementById('metamorphosis').value+'\n';
// coleta
t+=dic[153]+': '+document.getElementById('collecting').value+'\n';
t+=dic[155]+': '+document.getElementById('place').value+'\n';
t+=dic[157]+': '+document.getElementById('win').value+'\n';
t+=dic[159]+': '+document.getElementById('address').value+'\n';
t+=dic[160]+': '+document.getElementById('lat').value+'\n';
t+=dic[161]+': '+document.getElementById('lng').value+'\n';
t+=dic[162]+': '+document.getElementById('city').value+'\n';
t+=dic[163]+': '+document.getElementById('uf').value+'\n';
t+=dic[164]+': '+document.getElementById('country').value+'\n';
t+=dic[165]+': '+document.getElementById('datacad').value+'\n';
t+=dic[166]+': '+document.getElementById('temperature').value+'\n';
//  descricao
t+=dic[114]+': '+document.getElementById('colors').value+'\n';
t+=dic[196]+': '+document.getElementById('bbody').value+'\n';
if (document.getElementById('classe').value == '16') {
t+=dic[118]+': '+document.getElementById('hhead').value+'\n';
t+=dic[120]+': '+document.getElementById('thorax').value+'\n';
t+=dic[122]+': '+document.getElementById('abdomen').value+'\n';
t+=dic[198]+': '+dic[document.getElementById('lstantennae').value]+'\n';
t+=dic[126]+': '+document.getElementById('antennae').value+'\n';
} // dos insetos
else {
if (document.getElementById('classe').value == '13') {
t+=dic[320]+': '+document.getElementById('hhead').value+'\n';
t+=dic[122]+': '+document.getElementById('abdomen').value+'\n';
} // aranha
else {
t+=dic[118]+': '+document.getElementById('hhead').value+'\n';
t+=dic[321]+': '+document.getElementById('thorax').value+'\n';
} // nao e aranha.
} // nao e inseto.
t+=dic[128]+': '+document.getElementById('eyesandocelli').value+'\n';
t+=dic[199]+': '+dic[document.getElementById('lstmouthparts').value]+'\n';
t+=dic[131]+': '+document.getElementById('mouthparts').value+'\n';
if (document.getElementById('classe').value == '16') {
t+=dic[200]+': '+dic[document.getElementById('lstwings').value]+'\n';
t+=dic[134]+': '+document.getElementById('wings').value+'\n';
t+=dic[201]+': '+dic[document.getElementById('lsthindwings').value]+'\n';
t+=dic[137]+': '+document.getElementById('hindwings').value+'\n';
} // das asas dos insetos.
t+=dic[202]+': '+dic[document.getElementById('lstnumlegs').value]+'\n';
t+=dic[203]+': '+dic[document.getElementById('lstlegs').value]+'\n';
t+=dic[204]+': '+document.getElementById('locomotive').value+'\n';
t+=dic[205]+': '+dic[document.getElementById('tarsomere').value]+'\n';
t+=dic[206]+': '+dic[document.getElementById('cerci').value]+'\n';
t+=dic[207]+': '+document.getElementById('specificcharacteristics').value+'\n';
// t+=dic[208]+': '+dic[document.getElementById('development').value]+'\n';
// t+=dic[112]+': '+document.getElementById('metamorphosis').value+'\n';

document.getElementById('notes').value = t;
} // da funcao

function delimage() {
imagem='';
document.getElementById('photodesc').value='';
myalert(dic[340], function() {
document.getElementById('grfoto').style.display='none';
});
} // da funcao.

function mostra(res) {
var dados = res;
// document.getElementById('id').value=dados.id;
// document.getElementById('userid').value=dados.userid;
if (!dados.photos) { tempphotos = []; }
else { tempphotos = dados.photos; }
if (!dados.videos) { tempvideos = []; }
else { tempvideos = dados.videos; }
if (!dados.audios) { tempaudios = []; }
else { tempaudios = dados.audios; }

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
document.getElementById('hhead1').value=dados.hhead;
document.getElementById('hhead2').value=dados.hhead;
document.getElementById('hhead3').value=dados.hhead;
document.getElementById('thorax').value=dados.thorax;
document.getElementById('thorax1').value=dados.thorax;
document.getElementById('thorax3').value=dados.thorax;
document.getElementById('abdomen').value=dados.abdomen;
document.getElementById('abdomen1').value=dados.abdomen;
document.getElementById('abdomen2').value=dados.abdomen;
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
document.getElementById('grfoto').style.display=(imagem == '')? 'none':'inline';
document.getElementById('grfoto').src = "data:image/jpeg;base64," + dados.photo;
document.getElementById('photodesc').value=dados.photodesc;
document.getElementById('ground').value=dados.ground;
document.getElementById('author').value=dados.author;
document.getElementById('email').value=dados.email;
document.getElementById('url').value=dados.url;
document.getElementById('colaborative').value=dados.colaborative;
return dic[229]+' '+dic[dados.classe]+', '+dados.commonname;
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
image.style.display='inline';
    image.src = "data:image/jpeg;base64," + imageData;
//    image.src = imageData;
image.width = 300;
imagem = imageData;
// alert(imagem.length);
}, function(message) {

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
image.style.display='inline';
   image.src = "data:image/jpeg;base64," + imageData;
//    image.src = imageData;
image.width = 300;
imagem = imageData;
}, function(message) {

}, { quality: 50,
    destinationType: Camera.DestinationType.DATA_URL,
//                               destinationType: navigator.camera.DestinationType.FILE_URI,
                                sourceType: navigator.camera.PictureSourceType.PHOTOLIBRARY

});
} // da funcao

function delbicho(v) {

} // da funcao...

function salvar() {
if ((document.getElementById('author').value.length < 1) || (document.getElementById('email').value.length < 1)) {
myalert(dic[214], function() {
changetela('dvauthor');
document.getElementById('author').focus();
});
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
photos: tempphotos,
videos: tempvideos,
audios: tempaudios,
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
if (confirm(dic[215])) {
localStorage.author = document.getElementById('author').value;
localStorage.email = document.getElementById('email').value;
} // salvando...
} // nao existe salvo o author e email...
window.location='show_snapsect.html?id='+nn;
} // tem nome e email...
} // da funcao...


