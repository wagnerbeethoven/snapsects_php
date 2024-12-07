var st = [];

    document.addEventListener("deviceready", function () {
convertpage();
st['0'] = dic[286]; // 'Aguardando confirmação';
st['1'] = dic[287]; // 'Usuário';
st['5'] = dic[288]; // 'Professor';
st['50'] = dic[289]; // 'Editor';
st['67'] = dic[290]; // 'Administrador';

mostra();
fala(dic[298],cvoz);
    }, false);

function mostra() {
spjson(dic_path+'snapsect_user_api.php','act=loc&filtro='+document.getElementById('lstfiltro').value,'GET', function(q) {
// alert(q);
var texto = '<table border="0" width="100%"><tr>';
texto+='<th>'+dic[291]+'</th>';
texto+='<th>'+dic[292]+'</th>';
texto+='<th>'+dic[293]+'</th>';
texto+='</tr>';
for (var r=0;r<q.length;r++) {
texto+='<tr>';
texto+='<td><a href="add_snapsect_user.html?id='+q[r].id+'&email='+q[r].email+'">'+q[r].nome+'</a></td>';
texto+='<td><select id="usr'+r+'" onchange="'+"javascript:atualiza('"+q[r].id+"', this.value);"+'">';
st.forEach(function(i, pos) {
texto+='<option value="'+pos+'"';
if (q[r].status == pos) texto+=' selected';
texto+='>'+i+'</option>';
});
texto+='</select></td>';
texto+='<td>'+q[r].email+'</td>';
texto+='</tr>';
} // do for...
texto+='</table>';
document.getElementById('dvresultado').innerHTML = texto;
// alert(JSON.stringify(q));
});
} // da funcao...

function atualiza(id, v) {
spjson(dic_path+'snapsect_user_api.php','act=chus&id='+id+'&status='+v,'GET', function(res) {
fala('Status alterado com sucesso!');
mostra();
});
} // da funcao...