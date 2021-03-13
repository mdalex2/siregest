// JavaScript Document
//esta funion valida los imput file uso: agregar al imput onBlur='LimitAttach(this,n);'
//donde n es el numero de validacion que deseamos hacer
function LimitAttach(tField,iType) {
file=tField.value;
if (iType==1) {
extArray = new Array(".gif",".jpg",".png");
}
if (iType==2) {
extArray = new Array(".swf");
}
if (iType==3) {
extArray = new Array(".exe",".sit",".zip",".tar",".swf",".mov",".hqx",".ra",".wmf",".mp3",".qt",".med",".et");
}
if (iType==4) {
extArray = new Array(".mov",".ra",".wmf",".mp3",".qt",".med",".et",".wav");
}
if (iType==5) {
extArray = new Array(".html",".htm",".shtml");
}
if (iType==6) {
extArray = new Array(".doc",".xls",".ppt");
}
allowSubmit = false;
if (!file) return;
while (file.indexOf("\\") != -1) file = file.slice(file.indexOf("\\") + 1);
ext = file.slice(file.indexOf(".")).toLowerCase();
for (var i = 0; i < extArray.length; i++) {
if (extArray[i] == ext) {
allowSubmit = true;
break;
}
}
if (allowSubmit) {
} else {
	tField.value=''; //limpio si es firefox
	limpiarInputfile(tField.id); //limpio si es mozilla o chrome
alert("Usted sólo puede subir archivos con extensiones " + (extArray.join(" ")) + "\nPor favor seleccione un nuevo archivo");
}
} 
function limpiarInputfile(id) {
	var input = $('#' + id);
  var clon = input.clone();  // Creamos un clon del elemento original
  input.replaceWith(clon);   // Y sustituimos el original por el clon
}
