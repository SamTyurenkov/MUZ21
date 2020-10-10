<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$title = get_the_title($post); 
$text = get_the_content($post);
?>

<div class="textor container">
<h3 class="homeh3">Редактор текстовых блоков</h3>
<div class="custom-input" id="title">
<p>Заголовок статьи или новости</p>
<input type="text" class="h" value="<?php echo esc_attr(get_the_title()); ?>">
</div>
<div class="compositecontent">

</div>
<div class="textblockcontrols" id="addblock">

<div class="pslidercount" id="addheader" onclick="addBlockElement(this)">
<i class="icon-header"></i> Заголовок
</div>
<div class="pslidercount" id="addtext" onclick="addBlockElement(this)">
<i class="icon-paragraph"></i> Абзац
</div>
<div class="pslidercount" id="addlist" onclick="addBlockElement(this)">
<i class="icon-list-bullet"></i> Список
</div>
<div class="pslidercount" id="addphoto" onclick="addBlockElement(this)">
<i class="icon-picture"></i> Фото
</div>
</div>
<div class="textblockcontrols">

<div class="pslidercount" onclick="saveBlockEditor()">
<i class="icon-lock-open-alt"></i> <span class="error">Сохранить</span>
</div>
</div>
</div>

<script type="text/javascript">

var x, i, j, selElmnt, a, b, c;
/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /* For each element, create a new DIV that will act as the selected item: */
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /* For each element, create a new DIV that will contain the option list: */
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /* For each option in the original select element,
    create a new DIV that will act as an option item: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /* When an item is clicked, update the original select box,
        and the selected item: */
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    /* When the select box is clicked, close any other select boxes,
    and open/close the current select box: */
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);
</script>

<script type="text/javascript">
function addBlockElement(type) {
var composite = document.getElementsByClassName('compositecontent')[0];

if (type.id == 'addheader') {
	
		var custominput = document.createElement('div');
		createControls(custominput,1);
		
		let label = document.createElement("p");
		label.innerHTML = "Второстепенный заголовок";
		custominput.appendChild(label);
		
        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = 'Заголовок, который нужно отредактировать';
            textarea.className = "h";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');

    } else if (type.id == 'addtext') {
		
		var custominput = document.createElement('div');
		createControls(custominput,1);
		
		let label = document.createElement("p");
		label.innerHTML = "Блок текста";
		custominput.appendChild(label);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = 'Абзац, который нужно отредактировать';
            textarea.className = "p";
			textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');

    } else if (type.id == 'addlist') {
		
		var custominput = document.createElement('div');
		createControls(custominput,1);
		
		let label = document.createElement("p");
		label.innerHTML = "Элемент списка";
		custominput.appendChild(label);
		
		let visualli = document.createElement("div");
		visualli.className = 'visualli';
		visualli.innerHTML = "<li></li>";
		custominput.appendChild(visualli);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = 'Элемент списка, который нужно отредактировать';
            textarea.className = "li";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');
		
	} else if (type.id == 'addphoto') {
		
		var custominput = document.createElement('div');
		createControls(custominput,2);

        // Create container
            let imagecontainer = document.createElement("div");
            imagecontainer.className = "editimg blogimg";
			imagecontainer.style.background = "#fff";
            custominput.appendChild(imagecontainer);
			
		// Create inner label
            let innerlabel = document.createElement("label");
            innerlabel.className = "addimg";
			innerlabel.innerHTML = 'Нажмите, чтобы изменить';
            imagecontainer.appendChild(innerlabel);	
			
		// Create inner input
            let innerinput = document.createElement("input");
            innerinput.type = "file";
			innerinput.style.display = "none";
			innerinput.setAttribute('onchange','add_composite_image(this)');
            innerlabel.appendChild(innerinput);
		
	}
}

function saveBlockEditor() {
var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
var nonce = document.getElementById('_edit_blog').value;
var id = parseInt('<?php echo $post->ID; ?>');
var composite = document.getElementsByClassName('compositecontent')[0];
var el = composite.children;
var content = '';

for (let i = 0; i < el.length; i++) {
if(el[i].classList.contains("compositeimage")) {
var img = el[i].getElementsByClassName('blogimg')[0];		
content += '<img src="'+img.getAttribute("data-src")+'" alt="<?php echo esc_html($title); ?>" title="<?php echo esc_html($title); ?>">';
} else {
var textarea = el[i].getElementsByTagName('textarea')[0];	
if(textarea.className == "p") {
content += '<p>';
content += textarea.value.replace(/(<|>)+/gm, "");
content += '</p>';
} else if (textarea.className == "h") {
content += '<h3>';
content += textarea.value.replace(/(<|>)+/gm, "");
content += '</h3>';
} else if (textarea.className == "li") {
content += '<li>';
content += textarea.value.replace(/(<|>)+/gm, "");
content += '</li>';
}
}
}
var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				id : id,
				content : content,
				action: 'update_blog_content_ajax',
				},
				success: function(data, textStatus, jqXHR) {
					document.querySelector(".error").innerHTML = 'Информация сохранена';
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					document.querySelector(".error").innerHTML = 'Произошла ошибка';
				}
			})
}	

function createBlockEditor() {
var composite = document.getElementsByClassName('compositecontent')[0];
var newcomposite = document.createElement('newcomposite');
newcomposite.innerHTML = document.getElementsByClassName('entry-content')[0].innerHTML;
var el = newcomposite.children;

for (let i = 0; i < el.length; i++) {
if (["H2","H3","H4","H5","H6","DIV","P","UL","LI","IMG"].indexOf(el[i].tagName.toUpperCase()) == -1) continue;
	
	if (["H2","H3","H4","H5","H6"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		var custominput = document.createElement('div');
		var text = el[i].textContent;
		createControls(custominput,1);
		
		let label = document.createElement("p");
		label.innerHTML = "Второстепенный заголовок";
		custominput.appendChild(label);
		
        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = text;
            textarea.className = "h";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');

    } else if (["P","DIV"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		var custominput = document.createElement('div');
		var text = el[i].textContent;
		createControls(custominput,1);
		let label = document.createElement("p");
		label.innerHTML = "Блок текста";
		custominput.appendChild(label);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = text;
            textarea.className = "p";
			textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');

    } else if (["UL"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		
		var li = el[i].children;
		
		for (let x = 0; x < li.length; x++) {
		var custominput = document.createElement('div');
		var text = li[x].textContent;
		createControls(custominput,1);
		
		let label = document.createElement("p");
		label.innerHTML = "Элемент списка";
		custominput.appendChild(label);
		
		let visualli = document.createElement("div");
		visualli.className = 'visualli';
		visualli.innerHTML = "<li></li>";
		custominput.appendChild(visualli);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = text;
            textarea.className = "li";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');
		}
		
	} else if (["LI"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		
		var custominput = document.createElement('div');
		var text = el[i].textContent;
		createControls(custominput,1);
	//	custominput.classList.remove("passive");
		
		let label = document.createElement("p");
		label.innerHTML = "Элемент списка";
		custominput.appendChild(label);
		
		let visualli = document.createElement("div");
		visualli.className = 'visualli';
		visualli.innerHTML = "<li></li>";
		custominput.appendChild(visualli);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = text;
            textarea.className = "li";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');
		
		
	} else if (["IMG"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		
		var custominput = document.createElement('div');
		createControls(custominput,2);

        // Create container
            let imagecontainer = document.createElement("div");
            imagecontainer.className = "editimg blogimg";
			imagecontainer.style.background = 'url('+el[i].getAttribute("src")+') no-repeat center center'; 
			imagecontainer.setAttribute('data-src',el[i].getAttribute("src"));
			imagecontainer.style.backgroundSize = 'cover';
            custominput.appendChild(imagecontainer);
			
		// Create inner label
            let innerlabel = document.createElement("label");
            innerlabel.className = "addimg";
            imagecontainer.appendChild(innerlabel);	
			
		// Create inner input
            let innerinput = document.createElement("input");
            innerinput.type = "file";
			innerinput.style.display = "none";
			innerinput.setAttribute('onchange','add_composite_image(this)');
            innerlabel.appendChild(innerinput);
		
	}
}
}

function createControls(custominput,n) {
	
var composite = document.getElementsByClassName('compositecontent')[0];	
 if (n == 1) {
	 custominput.className = "custom-input passive";
 } else {
	 custominput.className = "custom-input compositeimage";
 }
  composite.appendChild(custominput);
	
		let close = document.createElement("div");
		close.innerHTML = "X";
		close.className = "close blockcontrols";
		close.setAttribute('onclick','move(this)');
		custominput.appendChild(close);
		
		let up = document.createElement("div");
		up.innerHTML = "<";
		up.className = "up blockcontrols";
		up.setAttribute('onclick','move(this)');
		custominput.appendChild(up);
		
		let down = document.createElement("div");
		down.innerHTML = ">";
		down.className = "down blockcontrols";
		down.setAttribute('onclick','move(this)');
		custominput.appendChild(down);
}
function active(obj) {
	var el = document.getElementsByClassName('compositecontent')[0].children;	
	for (let i = 0; i < el.length; i++) {
		if(el[i].classList.contains("compositeimage") != true)
			el[i].classList.add('passive');
	}
	obj.parentNode.classList.remove('passive');
	document.querySelector(".error").innerHTML = 'Сохранить';
}

function move(obj) {
	var parent = obj.parentNode;
	var cname = obj.classList[0];
	
	if (cname == 'up' && parent.previousSibling) {
		parent.parentNode.insertBefore(parent, parent.previousSibling);
	} else if (cname == 'down' && parent.nextSibling) {
		parent.parentNode.insertBefore(parent.nextSibling, parent);
	} else if (cname == 'close') {
		if(parent.classList.contains("compositeimage")){
		deleteimg(obj);	
		parent.parentNode.removeChild(parent);
		} else {
		parent.parentNode.removeChild(parent);
		}
	}
}

function deleteimg(obj) {
var image = obj.parentElement.getElementsByClassName('blogimg')[0].getAttribute('data-src');
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nonce = document.getElementById('_edit_blog').value;
var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				image : image,
				action: 'delete_attachement_ajax',
				},
				success: function(data, textStatus, jqXHR) {
					if (data.response == 'SUCCESS') {
					console.log('success removing attach');
					saveBlockEditor();
					}
				},
				error: function(jqXHR, textStatus, errorThrown){ 
				console.log(textStatus+ ' ' +errorThrown);				
				}
			})
}

createBlockEditor();
</script>

<script type="text/javascript">
	
	var el = document.querySelectorAll(".editoptions .select-items div");
	for (i = 0; i < el.length; i++) {
	el[i].addEventListener("click", function() {
	update_post_meta(this.parentNode.parentNode.getElementsByTagName("select")[0]);
	}, true);
	};

	var elm = document.querySelectorAll(".editoptions .custom-select select, .editoptions .custom-input input");
	for (j = 0; j < elm.length; j++) {
	elm[j].addEventListener("change", function() {
	update_post_meta(this);
	}, true);
	};

function update_post_meta(obj) {

var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
var nonce = document.getElementById('_edit_blog').value;
var id = parseInt('<?php echo $post->ID; ?>');
var metaname = obj.parentNode.id;
try {
var metavalue = obj.parentNode.getElementsByTagName("select")[0].value;
} catch {
var metavalue = obj.parentNode.getElementsByTagName("input")[0].value;
}
if(metaname == '') return;

var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				id : id,
				metaname : metaname,
				metavalue : metavalue,
				action: 'update_blog_ajax',
				},
				success: function(data, textStatus, jqXHR) {
					console.log("success "+data.response);
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					console.log('ajax error in update blog');
				}
			})

};

function add_composite_image(obj) {

			var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
			var id = <?php echo esc_html($post->ID);?>;
			var nonce = document.getElementById("_edit_blog").value;
			var oldimg = obj.parentElement.parentElement;
			deleteimg(oldimg);
			
				meta = obj.files[0].name;
				file = obj.files[0];
			
				 if( file.type === "image/jpg" || file.type === "image/png"  || file.type === "image/jpeg") {
		         extension = true;
		        } else {
					obj.parentElement.parentElement.style.background = '#fdd2d2';
					obj.parentElement.parentElement.innerHTML += 'Только .jpg и .png';
				}
			
			if (extension === true) {
			var data = new FormData();
			data.append('file', file);
			data.append('id', id);
			data.append('nonce', nonce);
			data.append('meta', meta);
			data.append('feature', 1);
			data.append('action', 'add_attachement_ajax');
			var value = jQuery.ajax({
				url: ajaxurl,
				data : data,
				type: 'POST',
				cache: false,
	            processData: false, // Don't process the files
	            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
				dataType: 'json',
				success: function(data, textStatus, jqXHR) {	
					if( data.response == 'SUCCESS' ){					
					   obj.parentElement.parentElement.style.background = "url('" + data.thumb +"') no-repeat center center";
					   obj.parentElement.parentElement.setAttribute("data-src",data.large);
					   obj.parentElement.parentElement.style.backgroundSize = "cover"; 
					   saveBlockEditor();
					   
					}	if( data.response == 'ERROR' ){
						
					obj.parentElement.parentElement.style.background = '#fdd2d2';
					obj.parentElement.parentElement.innerHTML += data.error;
					}
					},
				error: function(jqXHR, textStatus, errorThrown){ 			
					obj.parentElement.parentElement.style.background = '#fdd2d2';
					obj.parentElement.parentElement.innerHTML += data.error;
					}
				})
			}
			
		}
</script>