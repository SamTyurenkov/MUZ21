$ = jQuery;
$( document ).ready(function() {

function synDictionary() {

return arr;
}

const synDyc = synDictionary();

function getRandomInt(max) {
  return Math.floor(Math.random() * Math.floor(max));
}

function processTextBlock(val) {

for(var i = 0; i < synDyc.length; i++) {
var rIndex = getRandomInt(2);
val.replaceAll(synDyc[i]['pattern'], synDyc[i][rIndex]);
}
}

function synonimizer() {
			var ajaxurl = synonimizer_ajax_object.ajax_url;
			var id = synonimizer_ajax_object.id;
			var nonce = synonimizer_ajax_object.nonce;
			var composite = document.getElementsByClassName('compositecontent')[0];
			var el = composite.children;

for (let i = 0; i < el.length; i++) {
if(el[i].classList.contains("compositeimage")) {

} else {
var eltextarea = el[i].getElementsByTagName('textarea')[0];	
var string = processTextBlock(eltextarea.value);
eltextarea.value = string;
console.log(string);
}
}		
	
}


});