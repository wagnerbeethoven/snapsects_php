function mostraimagem(arq, obj) {
if (arq.length < 1) { document.getElementById(obj).style.display = 'none'; }
else {
document.getElementById(obj).src = 'http://www.snapsects.com/teste/img/'+arq.replaceAll(' ','_')+'.jpg';
document.getElementById(obj).width = 150;
document.getElementById(obj).style.display = 'block';
}
} // da funcao

function filtro() {
spopen('http://www.snapsects.com/teste/snapsect_api.php','act=find&lang='+document.getElementById('language').value+'&antennae='+document.getElementById('lstantennae').value+'&mouthparts='+document.getElementById('lstmouthparts').value+'&wings='+document.getElementById('lstwings').value+'&legs='+document.getElementById('lstlegs').value+'&commonname='+document.getElementById('commonname').value+'&oorder='+document.getElementById('lstorder').value+'&lstnumlegs='+document.getElementById('lstnumlegs').value+'&classe='+document.getElementById('classe').value+'&family='+document.getElementById('family').value+'&lstother='+document.getElementById('lstother').value,'GET', function(res) {
document.getElementById('dvtab').innerHTML = res;
});
} // da funcao

