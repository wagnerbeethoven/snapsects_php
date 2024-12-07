    document.addEventListener("deviceready", function () {
open_snapsect();
if (querystring(0) < '0') {
window.location='index.html';
} // nao tem informacao...
openfile('CopyRight', function(res) {
document.getElementById('dvrodape').innerHTML = res.replaceAll('.php','.html');
mostra();
});
    }, false);

function redimensiona() {
document.images['grpi'].width = 300;
} // da funcao

function mostra() {
var ee = lst_snapsect[querystring(0)];
openfile(ee.classe, function(res) {
var t='';
if (ee.photo.length > 0) {
t += '<br><center><img id="grpi" src="'+ee.photo+'" alt="Picture of '+ee.commonname+' ('+ee.scientificname+') - '+ee.photodesc+'" width="300px" onload="redimensiona();" /></center><br>';
}
t+='<br><center><h2>Credits</h2></center><br>';
t+='Described by: '+ee.author+'<br>';
if (ee.email.length > 0) { t+='Email: <a href="mailto:'+ee.email+'">'+ee.email+'</a><br>'; }
if (ee.url.length > 0) { t+='Home Page: <a href="'+ee.url+'">'+ee.url+'</a><br>'; }
if (ee.colaborative.length > 0) { t+='Collaborators: '+ee.colaborative+'<br>'; }
t+='<br><center><h2>Identification</h2></center><br>';
t+='Common name: '+ee.commonname+'<br>';
t+='Scientific name: '+ee.scientificname+'<br>';
t+='Author and Date: '+ee.other+'<br>';
t+='Kingdom: '+ee.kingdom+'<br>';
t+='Phylum: '+ee.phylum+'<br>';
t+='Class: '+ee.classe+'<br>';
t+='Order: '+ee.oorder+'<br>';
t+='Family: '+ee.family+'<br>';
t+='Genus: '+ee.genus+'<br>';
t+='Species: '+ee.species+'<br>';
t+='Sex: '+ee.gender+'<br>';
t+='Development: '+ee.development+'<br>';
t+='Metamorphosis: '+ee.metamorphosis+'<br>';
t+='<br><center><h2>Partial Description</h2></center><br>';
t+='Visual attributes: '+ee.colors+'<br>';
t+='Body: '+ee.bbody+'<br>';
t+='Head: '+ee.hhead+'<br>';
t+='Thorax: '+ee.thorax+'<br>';
t+='Abdomen: '+ee.abdomen+'<br>';
t+='Type of antennae: '+ee.lstantennae+'<br>';
t+='Antennae: '+ee.antennae+'<br>';
t+='Eyes and ocelli: '+ee.eyesandocelli+'<br>';
t+='Type of mouth parts: '+ee.lstmouthparts+'<br>';
t+='Mouth parts: '+ee.mouthparts+'<br>';
t+='Type of forewings: '+ee.lstwings+'<br>';
t+='Forewings: '+ee.wings+'<br>';
t+='Type of hind wings: '+ee.lsthindwings+'<br>';
t+='Hind wings: '+ee.hindwings+'<br>';
t+='Number of legs: '+ee.lstnumlegs+'<br>';
t+='Type of legs: '+ee.lstlegs+'<br>';
t+='Legs: '+ee.locomotive+'<br>';
t+='Tarsomere: '+ee.tarsomere+'<br>';
t+='Cerci: '+ee.cerci+'<br>';
t+='Specific characteristics: '+ee.specificcharacteristics+'<br>';
t+='<br><center><h2>Collection</h2></center><br>';
t+='Collecting method: '+ee.collecting+'<br>';
t+='Habitat (Place of collection): '+ee.place+'<br>';
t+='<br><center><h2>Proemial notes</h2></center><br>';
t+='<p align="justify">'+ee.notes.replaceAll('\\n','<br>')+'</p><br>';
t+='<br><center><h2>Audio description</h2></center><br>';
t+='<p align="justify">'+ee.audiodesc.replaceAll('\\n','<br>')+'</p><br>';
t+='<br><center><h2>Mediation text</h2></center><br>';
t+='<p align="justify">'+ee.mediation.replaceAll('\\n','<br>')+'</p><br>';
t+='<br><center><h2>Bibliography</h2></center><br>';
t+='<p align="justify">'+ee.water.replaceAll('\\n','<br>')+'</p><br>';
t+='<br>'+res+'<br>';

document.getElementById('resultado').innerHTML = t;
});
} // da funcao...