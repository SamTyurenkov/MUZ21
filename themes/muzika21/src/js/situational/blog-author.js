function addBlockElement(type) {
    var composite = document.getElementsByClassName('compositecontent')[0];
    
        if (['addheader2','addheader3','addheader4'].indexOf(type.id) > -1) {	
            var custominput = document.createElement('div');
            createControls(custominput,1);
            
            let label = document.createElement("p");
            label.innerHTML = "Второстепенный заголовок "+"H"+type.id.substr(type.id.length - 1);
            custominput.appendChild(label);
            
            // Create a textarea
                let textarea = document.createElement("textarea");
                textarea.innerHTML = 'Заголовок, который нужно отредактировать';
                textarea.className = "h"+type.id.substr(type.id.length - 1);
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
        var ajaxurl = blogauthor.ajaxurl;
        var nonce = document.getElementById('_edit_blog').value;
        var id = parseInt(blogauthor.post_id);
    var composite = document.getElementsByClassName('compositecontent')[0];
    var el = composite.children;
    var content = '';
    
    for (let i = 0; i < el.length; i++) {
    if(el[i].classList.contains("compositeimage")) {
    var img = el[i].getElementsByClassName('blogimg')[0];		
    content += '<img src="'+img.getAttribute("data-src")+'" alt="'+blogauthor.post_title+'" title="'+blogauthor.post_title+'">';
    } else {
    var textarea = el[i].getElementsByTagName('textarea')[0];	
    if(textarea.className == "p") {
    content += '<p>';
    content += textarea.value.replace(/(<|>)+/gm, "");
    content += '</p>';
    } else if (["h2","h3","h4","h5","h6"].indexOf(textarea.className.toLowerCase()) > -1) {
    content += '<'+textarea.className.toLowerCase()+'>';
    content += textarea.value.replace(/(<|>)+/gm, "");
    content += '</'+textarea.className.toLowerCase()+'>';
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
            label.innerHTML = "Второстепенный заголовок "+el[i].tagName;
            custominput.appendChild(label);
            
            // Create a textarea
                let textarea = document.createElement("textarea");
                textarea.innerHTML = text;
                textarea.className = el[i].tagName; //"h";
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
    var ajaxurl = blogauthor.ajaxurl;
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
        
    var el = document.querySelectorAll(".editoptions .select-items div");	
    for (i = 0; i < el.length; i++) {	
    el[i].addEventListener("click", function() {	
    var nodes = Array.prototype.slice.call( this.parentNode.children );	
    var index = nodes.indexOf( this );	
    this.parentNode.parentNode.getElementsByTagName("select")[0].selectedIndex = index+1;	
    update_post_meta(this.parentNode.parentNode.getElementsByTagName("select")[0]);	

    }, true);	
    };	
    
    var elm = document.querySelectorAll(".editoptions .custom-input input, .integration .custom-input input");	
    for (j = 0; j < elm.length; j++) {	
    elm[j].addEventListener("change", function() {	
    update_post_meta(this);	

    }, true);	
    };
    
    function update_post_meta(obj) { 
    
    var ajaxurl = blogauthor.ajaxurl;
    var nonce = document.getElementById('_edit_blog').value;
    var id = blogauthor.post_id;
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
                        console.log("success "+data.response + ' ' +data.details);
                        console.log(jqXHR);
                    },
                    error: function(jqXHR, textStatus, errorThrown){ 	
                        console.log('ajax error in update blog');
                    }
                })
    
    };
    
    function add_composite_image(obj) {
    
                var ajaxurl = blogauthor.ajaxurl;
                var id = blogauthor.post_id;
                var nonce = document.getElementById("_edit_blog").value;
                var oldimg = obj.parentElement.parentElement;
                var posttype = blogauthor.post_type;;
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
                data.append('posttype', posttype);
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
    
    function synonimizer() {
                var ajaxurl = blogauthor.ajaxurl;
                var id = blogauthor.post_id;
                var nonce = document.getElementById("_edit_blog").value;
    
                var value = jQuery.ajax({
                    type: 'GET',
                    url: ajaxurl,
                    cache: false,
                    data:{
                    nonce : nonce,
                    id : id,
                    action: 'synonimizer',
                    },
                    success: function(data, textStatus, jqXHR) {
                        console.log("success "+data.response);
                        console.log(data.synstring);
                    },
                    error: function(jqXHR, textStatus, errorThrown){ 	
                        console.log('ajax error in update blog');
                    }
                })
    }