<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
$attachments = property_attachments($post);
$author_id = $post->post_author;
if($attachments) {
$index = count($attachments);
} else {
$index = 0;
}
wp_nonce_field('_edit_properties', '_edit_properties');
?>
<div class="editor">
<div class="container">
<div class="editmenu">
<?php 
if(get_post_status() == 'publish')  {
	echo '<span class="pslidercount" onClick="changeStatus(1)">Снять с публикации</span>';
} else if(get_post_status() == 'draft') {
	echo '<span class="pslidercount" onClick="changeStatus(2)">Опубликовать</span>';
} else if(get_post_status() == 'pending' && (current_user_can('editor') || current_user_can('administrator'))) {
	echo '<span class="pslidercount" onClick="changeStatus(2)">Опубликовать</span>';
} else if(get_post_status() == 'pending') {
	echo '<span class="pslidercount" onClick="changeStatus(4)">Запросить модерацию</span>';
}
if ((current_user_can('editor') || current_user_can('administrator')) || (get_post_status() == 'pending' || get_post_status() == 'draft' )) {
	echo '<span class="pslidercount" onClick="changeStatus(3)">Удалить</span>';
}
if($index > 4) {
?>
<span class="pslidercount" onClick="loadeditor(2)">Закрыть</span>
<?php } else { ?>
<a href="<?php echo esc_attr(get_author_posts_url($author_id)); ?>" class="pslidercount" >
<span>Закрыть</span>
</a>
<?php }; ?>
</div>
<script type="text/javascript">
function changeStatus(status) {
var id = <?php echo esc_html($post->ID); ?>;
var userslug = '<?php echo esc_html(wp_get_current_user()->user_nicename); ?>';
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nonce = document.getElementById('_edit_properties').value;
var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				id : id,
				status: status,
				action: 'change_status_ajax',
				},
				success: function(data, textStatus, jqXHR) {
				location.href = 'https://asp.sale/author/'+userslug;
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
				}
			})
}
</script>
<p style="text-align:center">
<?php if(get_post_status() == 'publish')  {
echo 'Объявление опубликовано, вы можете снять его с публикации.';
 } else if (get_post_status() == 'draft') { 
echo 'Объявление в черновиках, вы можете опубликовать его повторно.';
 } else if (get_post_status() == 'pending') { 
echo 'Как минимум добавьте фотографии и описание, чтобы пройти модерацию.';
 }; ?>
</p>
<div class="row">
<h3 class="homeh3" id="imgerror">Редактировать фотографии</h3>
<p style="text-align:center">Добавьте минимум 5 фотографий размером не менее 740 пикселей по высоте.</p>
<div class="photoeditor">
<div class="editimg featured" style="background:#fff; <?php if (has_post_thumbnail()) { echo 'background:url('.get_the_post_thumbnail_url(null,'thumbnail').');background-size: cover';}?>">
<label class="addimg" for="addicon"></label>
<input type="file" name="addicon" id="addicon" style="display:none">
</div>
<div class="editimg" style="background:#fff;">
<label class="addimg" for="addimg"><i class="icon-plus"></i> Фото</label>
<input type="file" name="addimg" id="addimg" style="display:none">
</div>
<?php 
					if ($attachments){
                    $index = count($attachments);
					
						while($index) {	
							$attid = $attachments[--$index]->ID; 
							$src = wp_get_attachment_image_src( $attid , 'thumbnail')[0];
							if ($attid != get_post_thumbnail_id($post)) {
							echo '<div class="editimg" data-img="'.esc_attr($src).'" style="background:url('.esc_attr($src).') no-repeat center center; background-size:cover"><div class="deleteimg" onclick="deleteimg(this)">X</div></div>';
							}
                    }
					}
?>
</div>
<script type="text/javascript">

var addimg = document.getElementById("addimg");
addimg.addEventListener("change", function (e) {

			var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
			var id= <?php echo esc_html($post->ID);?>;
			var nonce = document.getElementById("_edit_properties").value;

				this.parentElement.getElementsByTagName('label')[0].innerHTML = 'Подождите';
				meta = this.files[0].name;
				file = this.files[0];
			
				 if( file.type === "image/jpg" || file.type === "image/png"  || file.type === "image/jpeg") {
		         extension = true;
		        } else {
					document.getElementById("imgerror").style.background = '#fdd2d2';
					document.getElementById("imgerror").innerHTML = 'Только .jpg и .png';
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
					var uthumb = document.getElementById("addimg").parentElement.getElementsByTagName('label')[0];
					if( data.response == 'SUCCESS' ){
					   var newimage = document.createElement("div");     
					   newimage.classList.add("editimg");
					   newimage.style.backgroundImage = "url('" + data.thumb +"')";
					   newimage.style.backgroundSize = "cover";
					   newimage.setAttribute('data-img', data.thumb );
					   
					   var newdelete = document.createElement("div");
					   newdelete.classList.add('deleteimg');
					   newdelete.innerHTML = 'X';
					   newdelete.setAttribute('onclick','deleteimg(this)');
					   
					   newimage.appendChild(newdelete);
					   document.getElementsByClassName("photoeditor")[0].appendChild(newimage); 				   
					   uthumb.innerHTML = '<i class="icon-plus"></i> Фото';
					   document.getElementById("imgerror").style.background = "#e0e0e0";
					   document.getElementById("imgerror").innerHTML = 'Редактировать фотографии';
					   
					}	if( data.response == 'ERROR' ){
					uthumb.innerHTML = '<i class="icon-plus"></i> Фото';	
					document.getElementById("imgerror").style.background = '#fdd2d2';
					document.getElementById("imgerror").innerHTML = 'Ошибка: '+data.error;
					}
					},
				error: function(jqXHR, textStatus, errorThrown){ 		
					document.getElementById("imgerror").style.background = '#fdd2d2';
					document.getElementById("imgerror").innerHTML = 'Ошибка: '+errorThrown;
					}
				})
			}
			
		}, true);	
		
var addicon = document.getElementById("addicon");
addicon.addEventListener("change", function (e) {

			var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
			var id= <?php echo esc_html($post->ID);?>;
			var nonce = document.getElementById("_edit_properties").value;

				this.parentElement.getElementsByTagName('label')[0].innerHTML = 'Подождите';
				meta = this.files[0].name;
				file = this.files[0];
			
				 if( file.type === "image/jpg" || file.type === "image/png"  || file.type === "image/jpeg") {
		         extension = true;
		        } else {
					document.getElementById("imgerror").style.background = '#fdd2d2';
					document.getElementById("imgerror").innerHTML = 'Только .jpg и .png';
				}
			
			if (extension === true) {
			var data = new FormData();
			data.append('file', file);
			data.append('id', id);
			data.append('nonce', nonce);
			data.append('meta', meta);
			data.append('feature', 2);
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
					
					   addicon.parentElement.style.backgroundImage = "url('" + data.thumb +"')";
					   addicon.parentElement.style.backgroundSize = "cover"; 
					   document.getElementById("imgerror").style.background = "#e0e0e0";
					   document.getElementById("imgerror").innerHTML = 'Редактировать фотографии';
					   addicon.parentElement.getElementsByTagName('label')[0].innerHTML = '';
					}	if( data.response == 'ERROR' ){
						
					document.getElementById("imgerror").style.background = '#fdd2d2';
					document.getElementById("imgerror").innerHTML = 'Ошибка: '+data.error;
					}
					},
				error: function(jqXHR, textStatus, errorThrown){ 			
					document.getElementById("imgerror").style.background = '#fdd2d2';
					document.getElementById("imgerror").innerHTML = 'Ошибка: '+textStatus;
					}
				})
			}
			
		}, true);		

function deleteimg(obj) {
var image = obj.parentElement.getAttribute('data-img');
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nonce = document.getElementById('_edit_properties').value;
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
					obj.parentElement.remove();
					console.log('test '+data.imagefull);
					}
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
				}
			})
}
</script>
</div>

<div class="row">
<h3 class="homeh3">Редактировать объявление</h3>
<div class="editoptions">
<?php get_template_part('templates/editpost-options'); ?>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function loadeditor(n) {
if (n==1) {
	document.querySelector('.editor').classList.add('expanded');
} else if (n==3) {
	document.querySelector('.vigruzki').classList.add('expanded');
} else {
	location.reload();
}
}
<?php 
if($index < 5) : ?>
if (document.referrer == '<?php echo esc_attr(get_author_posts_url($author_id)); ?>' && get_post_status( $post ) == 'pending')
loadeditor(1);
<?php endif; ?>
</script>