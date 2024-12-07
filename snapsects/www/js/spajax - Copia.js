var local_path = localpath()+'audio/';
function localpath() {
var x = window.location.pathname.split('/');

var t = '';
var len = (x.length) - 1;
for (var r=0;r<len;r++) {
t+=x[r]+'/';
} // do for.
return t;
} // da funcao.

function spparse(x) {
try {
return JSON.parse(x);
}
catch(e) {
var p = -1;
for (var r=0;r<x.length;r++) { if ( p == -1) if ((x[r] == '{') || (x[r] == '[')) { p = r; break; } }
if (p > -1) {
x = x.substring(p);
return JSON.parse(x);
} // p > -1
else { return x; }
}
} // da funcao...

function fala(txt,okfunc) {
MobileAccessibility.speak(txt);
if (!okfunc) { } else {okfunc(); }
} // da funcao

function fala8(txt, okfunc) {
if (!localStorage.mute) { localStorage.mute = '0'; }
if (localStorage.mute == '0') {
if (!localStorage.vel) { localStorage.vel = '1.50'; }
TTS.speak({ text: txt, locale: localStorage.language, rate: parseFloat(localStorage.vel) }, function() {
if (!okfunc) { } else { okfunc(); }
});
} else {
if (!okfunc) { } else { okfunc(); }
}
} // da funcao...

function querystring(index) {
    var URL = document.location.href;
    var qString = URL.split('?');
    if (qString.length < 2) {
        return false;
    }
    else {
        var keyVal = qString[1].split('&');
        if (keyVal.length > index) {
            var valor = keyVal[index].split('=');
            return urldecode(valor[1]); // .replaceAll('%20', ' ');
        } else {
            return false;
        }
    } // existe valor ?
} // da funcao

function setcookie(nome, valor) {
    var d = new Date();
    d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000));
    document.cookie = nome + "=" + valor + "; expires=" + d.toGMTString();
} // da funcao...

function getcookie(key, skips) {
    if (skips == null) skips = 0;

    var cookie_string = "" + document.cookie;
    var cookie_array = cookie_string.split("; ");
    var len = cookie_array.length;

    for (var i = 0; i < len; ++i) {
        var single_cookie = cookie_array[i].split("=");
        if (single_cookie.length != 2)
            continue;
        var name = unescape(single_cookie[0]);
        var value = unescape(single_cookie[1]);

        if (key == name && skips-- == 0) return value;
    }

    return null;
} // da funcao

function ajax() {
    if (typeof XMLHttpRequest != "undefined")
        return new XMLHttpRequest();
    else if (window.ActiveXObject) {
        var versoes = ["MSXML2.XMLHttp.5.0",
            "MSXML2.XMLHttp.4.0", "MSXML2.XMLHttp.3.0",
            "MSXML2.XMLHttp", "Microsoft.XMLHttp"
        ];
    }
    for (var i = 0; i < versoes.length; i++) {
        try {
            return new ActiveXObject(versoes[i]);
        } catch (e) {
        }
    }
    throw new Error("Seu browser n�o suporta AJAX");
}


function spopen(arq, params, tipo, resultfunc, errorfunc) {
    var XML = ajax();
    if (tipo == 'POST') {
        if (params.length > 0) {
            params += '&qwqwqw=' + Math.random();
        } else {
            params = 'qwqwqw=' + Math.random();
        }
        XML.open(tipo, arq, true);
        XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XML.setRequestHeader("Content-length", params.length);
        XML.setRequestHeader("Connection", "Close");

    } else {
        if (params.length > 0) {
            params = '?' + params + '&qwqwqw=' + Math.random();
        } else {
            params = '?qwqwqw=' + Math.random();
        }
        XML.open(tipo, arq + params, true);
    } // modo get

    XML.onreadystatechange = function () {
        if (XML.readyState == 4)
            if (XML.status == 200) {
                if (resultfunc) {
                    resultfunc(XML.responseText);
                }

            } else {
//             div.innerHTML = "Um erro ocorreu" + XML.statusText;
                if (errorfunc) {
                    errorfunc();
                }
            }
    };
    if (tipo == 'POST') {
        XML.send(params);
    } else {
        XML.send(null);
    }
} // da funcao

function spjson(arq, params, tipo, resultfunc, errorfunc) {
    var XML = ajax();
    if (tipo == 'POST') {
        XML.open(tipo, arq, true);
        XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XML.setRequestHeader("Content-length", params.length);
        XML.setRequestHeader("Connection", "Close");

    } else {
        if (params.length > 0) {
            params = '?' + params + '&qwqwqw=' + Math.random();
        } else {
//            params = '?qwqwqw=' + Math.random();
        }
        if (tipo == '') {
            tipo = 'GET';
            params = '';
        } // caso seja get sem parametro...
        XML.open(tipo, arq + params, true);
    } // modo get

    XML.onreadystatechange = function () {
        if (XML.readyState == 4)
            if (XML.status == 200) {
                if (resultfunc) {
// var re = eval("("+XML.responseText+")");
                    var re = spparse(XML.responseText);

                    resultfunc(re);
                }

            } else {
//             div.innerHTML = "Um erro ocorreu" + XML.statusText;
                if (errorfunc) {
                    errorfunc();
                }
            }
    };
    if (tipo == 'POST') {
        XML.send(params);
    } else {
        XML.send(null);
    }
} // da funcao

String.prototype.replaceAll = function(de, para) {
var str = this;
var pos = str.indexOf(de);
while (pos > -1) {
str = str.replace(de, para);
pos = str.indexOf(de);
} // do while...
return str;
} // da funcao.

function urldecode(texto) {
texto = unescape(texto);
while( texto.search("\\+") != -1) {
texto = texto.replace("+"," ");
}
return utf8_decode(texto); 
} // da funcao.

function utf8_decode(str_data) {
  //  discuss at: http://phpjs.org/functions/utf8_decode/
  // original by: Webtoolkit.info (http://www.webtoolkit.info/)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Norman "zEh" Fuchs
  // bugfixed by: hitwork
  // bugfixed by: Onno Marsman
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: kirilloid
  //   example 1: utf8_decode('Kevin van Zonneveld');
  //   returns 1: 'Kevin van Zonneveld'

  var tmp_arr = [],
    i = 0,
    ac = 0,
    c1 = 0,
    c2 = 0,
    c3 = 0,
    c4 = 0;

  str_data += '';

  while (i < str_data.length) {
    c1 = str_data.charCodeAt(i);
    if (c1 <= 191) {
      tmp_arr[ac++] = String.fromCharCode(c1);
      i++;
    } else if (c1 <= 223) {
      c2 = str_data.charCodeAt(i + 1);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
      i += 2;
    } else if (c1 <= 239) {
      // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
      i += 3;
    } else {
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      c4 = str_data.charCodeAt(i + 3);
      c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
      c1 -= 0x10000;
      tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1 >> 10) & 0x3FF));
      tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
      i += 4;
    }
  }

  return tmp_arr.join('');
}

function utf8_encode(argString) {
  //  discuss at: http://phpjs.org/functions/utf8_encode/
  // original by: Webtoolkit.info (http://www.webtoolkit.info/)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: sowberry
  // improved by: Jack
  // improved by: Yves Sucaet
  // improved by: kirilloid
  // bugfixed by: Onno Marsman
  // bugfixed by: Onno Marsman
  // bugfixed by: Ulrich
  // bugfixed by: Rafal Kukawski
  // bugfixed by: kirilloid
  //   example 1: utf8_encode('Kevin van Zonneveld');
  //   returns 1: 'Kevin van Zonneveld'

  if (argString === null || typeof argString === 'undefined') {
    return '';
  }

  var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
  var utftext = '',
    start, end, stringl = 0;

  start = end = 0;
  stringl = string.length;
  for (var n = 0; n < stringl; n++) {
    var c1 = string.charCodeAt(n);
    var enc = null;

    if (c1 < 128) {
      end++;
    } else if (c1 > 127 && c1 < 2048) {
      enc = String.fromCharCode(
        (c1 >> 6) | 192, (c1 & 63) | 128
      );
    } else if ((c1 & 0xF800) != 0xD800) {
      enc = String.fromCharCode(
        (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    } else { // surrogate pairs
      if ((c1 & 0xFC00) != 0xD800) {
        throw new RangeError('Unmatched trail surrogate at ' + n);
      }
      var c2 = string.charCodeAt(++n);
      if ((c2 & 0xFC00) != 0xDC00) {
        throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
      }
      c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
      enc = String.fromCharCode(
        (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    }
    if (enc !== null) {
      if (end > start) {
        utftext += string.slice(start, end);
      }
      utftext += enc;
      start = end = n + 1;
    }
  }

  if (end > start) {
    utftext += string.slice(start, stringl);
  }

  return utftext;
}

function savelocal_add() {
if (!localStorage.localvoltar) {
localStorage.localvoltar = '';
} // nao existe...
var x = window.location.href.split('/');
localStorage.localvoltar+='|'+x[x.length-1];
} // da funcao...

function savelocal_index() {
localStorage.localvoltar = '|index.html';
} // da funcao...

function returnlocal() {
if (!localStorage.localvoltar) {
localStorage.localvoltar = '';
} // nao existe...
else {
var x = localStorage.localvoltar.split('|');
var xx = x[x.length-2];
localStorage.localvoltar = '';
for (var r=0;r<x.length-2;r++) {
localStorage.localvoltar+='|'+x[r];
} // do for...
window.location=xx;
} // existe local...
} // da funcao...

function upload(FFile, ToServ, winfunc) {
var options = new FileUploadOptions();
options.fileKey = "file";
options.fileName = FFile.substr(FFile.lastIndexOf('/') + 1);
options.mimeType = "video/mp4";
options.params = {}; // if we need to send parameters to the server request
var ft = new FileTransfer();
ft.upload(FFile, encodeURI(ToServ), function(r) {
if (!winfunc) { } else { winfunc(r); }
}, function(error) {

}, options);
} // da funcao

function convertacentotohtml(txt) {
var letra = 'áéíóúÁÉÍÓÚ';
var html = ['&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;'];
var t = '';
for (var r=0;r<txt.length;r++) {
if (letra.indexOf(txt[r]) > -1) { t+=html[letra.indexOf(txt[r])]; }
else { t+=txt[r]; }
} // do for...
return t;
} // da funcao...
