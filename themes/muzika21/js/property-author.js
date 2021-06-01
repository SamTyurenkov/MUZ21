function addBlockElement(type) {
    var composite = document.getElementsByClassName('compositecontent')[0];
    
    if (type.id == 'addheader') {
        
            var custominput = document.createElement('div');
            createControls(custominput);
            
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
            createControls(custominput);
            
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
            createControls(custominput);
            
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
            
        }
    }
    
    function saveBlockEditor() {
    var ajaxurl = propertyauthor.ajaxurl;
    var nonce = document.getElementById('_edit_properties').value;
    var id = parseInt(propertyauthor.post_id);
    var composite = document.getElementsByClassName('compositecontent')[0];
    var el = composite.children;
    var content = '';
    
    for (let i = 0; i < el.length; i++) {
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
    var value = jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    cache: false,
                    data:{
                    nonce : nonce,
                    id : id,
                    content : content,
                    action: 'update_props_content_ajax',
                    },
                    success: function(data, textStatus, jqXHR) {
                            if(data.response == 'success') {
                            //console.log("success "+data.meta + data.val);
                            ErrorsManager.createEl('success','Описание объекта успешно обновлено.');
                            } else {
                            //console.log("error "+data.meta + data.val);
                            ErrorsManager.createEl('error','Ошибка при обновлелнии описания объекта: '+data.error);
                            }
                    },
                    error: function(jqXHR, textStatus, errorThrown){ 	
                        //document.querySelector(".error").innerHTML = 'Произошла ошибка';
                        ErrorsManager.createEl('error','Ошибка при обновлелнии описания объекта: '+textStatus);
                    }
                })
    }	
    
    function createBlockEditor() {
    var composite = document.getElementsByClassName('compositecontent')[0];
    var newcomposite = document.createElement('newcomposite');
    newcomposite.innerHTML = document.getElementsByClassName('entry-content')[0].innerHTML;
    var el = newcomposite.children;
    
    for (let i = 0; i < el.length; i++) {
    if (["H2","H3","H4","H5","H6","DIV","P","UL","LI"].indexOf(el[i].tagName.toUpperCase()) == -1) continue;
        
        if (["H2","H3","H4","H5","H6"].indexOf(el[i].tagName.toUpperCase()) != -1) {
            var custominput = document.createElement('div');
            var text = el[i].textContent;
            createControls(custominput);
            
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
            createControls(custominput);
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
            createControls(custominput);
            
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
            createControls(custominput);
            
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
    }
    }
    
    function createControls(custominput) {
        
    var composite = document.getElementsByClassName('compositecontent')[0];	
      custominput.className = "custom-input passive";
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
            parent.parentNode.removeChild(parent);
        }
    }
    
    createBlockEditor();

    function hide_wrong_meta() {
        var notsale = document.getElementsByClassName("notsale");
        var dailyonly = document.getElementsByClassName("dailyonly");
        
        var notland = document.getElementsByClassName("notland");
        var nothouse = document.getElementsByClassName("nothouse");
        var notroom = document.getElementsByClassName("notroom");
        var notlive = document.getElementsByClassName("notlive");
        var houseonly = document.getElementsByClassName("houseonly");
        var landonly = document.getElementsByClassName("landonly");
        var newdev = document.getElementsByClassName("newdev");
        var houseland = document.getElementsByClassName("houseland");
        
            if (document.querySelector("#dealtype select").value == "kupit") {
                for (var n = 0; n < notsale.length; n++) notsale[n].style.display = "none";
            } else {
            for (var n = 0; n < notsale.length; n++) notsale[n].style.display = "block";	
            }
        
            if(document.querySelector("#propertytype select").value == "uchastok") {
                for (var n = 0; n < notland.length; n++) notland[n].style.display = "none";
                } else {
                for (var n = 0; n < notland.length; n++) notland[n].style.display = "block";	
                }
        
            if(document.querySelector("#propertytype select").value == "dom") {
                for (var n = 0; n < nothouse.length; n++) nothouse[n].style.display = "none";
                } else if (document.querySelector("#propertytype select").value != "uchastok") {
                for (var n = 0; n < nothouse.length; n++) nothouse[n].style.display = "block";	
                }
                
            if(document.querySelector("#propertytype select").value == "nezhiloe") {
                for (var n = 0; n < notlive.length; n++) notlive[n].style.display = "block";
                } else if (document.querySelector("#propertytype select").value != "nezhiloe") {
                for (var n = 0; n < notlive.length; n++) notlive[n].style.display = "none";	
                }	
                
            if(document.querySelector("#propertytype select").value == "dom") {
                for (var n = 0; n < houseonly.length; n++) houseonly[n].style.display = "block";
                } else if (document.querySelector("#propertytype select").value != "dom") {
                for (var n = 0; n < houseonly.length; n++) houseonly[n].style.display = "none";	
                }
        
        //not room 
            if(document.querySelector("#propertytype select").value == "komnata") {
                for (var n = 0; n < notroom.length; n++) notroom[n].style.display = "none";
                } else if (document.querySelector("#propertytype select").value != "dom") {
                for (var n = 0; n < notroom.length; n++) notroom[n].style.display = "block";	
                }	
        
        //daily only
            if (document.querySelector("#dealtype select").value == "posutochno-snyat") {
                for (var n = 0; n < dailyonly.length; n++) dailyonly[n].style.display = "block";
            } else {
            for (var n = 0; n < dailyonly.length; n++) dailyonly[n].style.display = "none";	
            }
                
                if(document.querySelector("#propertytype select").value == "uchastok" ) {
                for (var n = 0; n < landonly.length; n++) landonly[n].style.display = "block";
                } else if (document.querySelector("#propertytype select").value != "uchastok") { 
                for (var n = 0; n < landonly.length; n++) landonly[n].style.display = "none";	
                }		
                
            if(document.querySelector("#market_type select").value == 'Новостройка') {
            for (var n = 0; n < newdev.length; n++) newdev[n].style.display = "block";
            } else if(document.querySelector("#market_type select").value != 'Новостройка') {
            for (var n = 0; n < newdev.length; n++) newdev[n].style.display = "none";
            }		


            if((document.querySelector("#propertytype select").value == "uchastok") || (document.querySelector("#propertytype select").value == "dom") || (document.querySelector("#commercial-type select").value == "land")) {
                for (var n = 0; n < houseland.length; n++) houseland[n].style.display = "block";
                } else if (document.querySelector("#propertytype select").value != "uchastok") { 
                for (var n = 0; n < houseland.length; n++) houseland[n].style.display = "none";	
                }	
        }
            
            var el = document.querySelectorAll(".editoptions .select-items div");
            for (i = 0; i < el.length; i++) {
            el[i].addEventListener("click", function() {
            var nodes = Array.prototype.slice.call( this.parentNode.children );
            var index = nodes.indexOf( this );
            this.parentNode.parentNode.getElementsByTagName("select")[0].selectedIndex = index+1;
            update_post_meta(this.parentNode.parentNode.getElementsByTagName("select")[0]);
            hide_wrong_meta();
            }, true);
            };
        
            var elm = document.querySelectorAll(".editoptions .custom-input input, .integration .custom-input input");
            for (j = 0; j < elm.length; j++) {
            elm[j].addEventListener("change", function() {
            update_post_meta(this);
            hide_wrong_meta();
            }, true);
            };
        
        hide_wrong_meta();
        
        function update_post_meta(obj) {
        
        var ajaxurl = propertyauthor.ajaxurl;
        var nonce = document.getElementById('_edit_properties').value;
        var id = parseInt(propertyauthor.post_id);
        var authid = parseInt(propertyauthor.auth_id);
        var metaname = obj.parentNode.id;
        try {
        var metavalue = obj.parentNode.getElementsByTagName("select")[0].value;
        } catch(e) {
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
                        obj_id: authid,
                        metaname : metaname,
                        metavalue : metavalue,
                        action: 'update_props_ajax',
                        },
                        success: function(data, textStatus, jqXHR) {
                            if(data.response == 'success') {
                            //console.log("success "+data.meta + data.val);
                            ErrorsManager.createEl('success','Поле "'+document.getElementById(data.meta).getElementsByTagName("p")[0].innerHTML+'" успешно обновлено.');
                            } else {
                            //console.log("error "+data.meta + data.val);
                            ErrorsManager.createEl('error','Ошибка при обновлелнии поля '+document.getElementById(data.meta).getElementsByTagName("p")[0].innerHTML+ ', попробуйте обновить страницу или свяжитесь с админом.');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown){ 	
                            //console.log('ajax error in update props');
                            ErrorsManager.createEl('error','Ошибка при обновлелнии поля, попробуйте обновить страницу или свяжитесь с админом.');
                        }
                    })
        
        };