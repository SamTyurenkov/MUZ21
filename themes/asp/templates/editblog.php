<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
wp_nonce_field('_edit_blog', '_edit_blog');
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
}
if ((current_user_can('editor') || current_user_can('administrator')) || get_post_status() == 'pending') {
	echo '<span class="pslidercount" onClick="changeStatus(3)">Удалить</span>';
}
?>
<span class="pslidercount" onClick="loadeditor(2)">Закрыть</span>
</div>
<script type="text/javascript">
function changeStatus(status) {
var id = <?php echo esc_html($post->ID); ?>;
var userslug = '<?php echo esc_html(wp_get_current_user()->user_nicename); ?>';
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nonce = document.getElementById('_edit_blog').value;
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
echo 'Новость/статья опубликована, вы можете снять ее с публикации.';
 } else if (get_post_status() == 'draft') { 
echo 'Новость/статья в черновиках, вы можете опубликовать ее повторно.';
 } else if (get_post_status() == 'pending') { 
echo 'Добавьте фотографии и текст, чтобы пройти модерацию.';
 }; ?>
</p>
<div class="row">
<h3 class="homeh3">Редактировать баннер</h3>
<div class="photoeditor">
<div class="editimg featured blogimg" style="background:#fff; <?php if (has_post_thumbnail()) { echo 'background:url('.get_the_post_thumbnail_url(null,'large').') no-repeat center center;background-size: cover';}?>">
<label class="addimg" for="addicon">Нажмите, чтобы добавить основное изображение</label>
<input type="file" name="addicon" id="addicon" style="display:none">
</div>
<script type="text/javascript">
var addicon = document.getElementById("addicon");
addicon.addEventListener("change", function (e) {

			var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
			var id= <?php echo esc_html($post->ID);?>;
			var nonce = document.getElementById("_edit_blog").value;
			var posttype = '<?php echo esc_html(get_post_type()); ?>';

				this.parentElement.getElementsByTagName('label')[0].innerHTML = 'Подождите';
				meta = this.files[0].name;
				file = this.files[0];
			
				 if( file.type === "image/jpg" || file.type === "image/png"  || file.type === "image/jpeg") {
		         extension = true;
		        } else {
					this.parentElement.getElementsByTagName('label')[0].style.background = '#fdd2d2';
					this.parentElement.getElementsByTagName('label')[0].innerHTML = 'Только .jpg и .png';
				}
			
			if (extension === true) {
			var data = new FormData();
			data.append('file', file);
			data.append('id', id);
			data.append('nonce', nonce);
			data.append('meta', meta);
			data.append('feature', 2);
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
					var uthumb = document.getElementById("addicon");//.parentElement.getElementsByTagName('label')[0];
					if( data.response == 'SUCCESS' ){
					
					   uthumb.parentElement.getElementsByTagName('label')[0].style.background = "url('" + data.thumb +"') no-repeat center center";
					   uthumb.parentElement.getElementsByTagName('label')[0].style.backgroundSize = "cover"; 
					   uthumb.parentElement.getElementsByTagName('label')[0].innerHTML = '';
					   
					}	if( data.response == 'ERROR' ){
						
					uthumb.parentElement.getElementsByTagName('label')[0].style.background = '#fdd2d2';
					uthumb.parentElement.getElementsByTagName('label')[0].innerHTML = 'Ошибка: '+data.error;
					}
					},
				error: function(jqXHR, textStatus, errorThrown){ 
				var uthumb = document.getElementById("addicon").parentElement.getElementsByTagName('label')[0];				
					uthumb.parentElement.getElementsByTagName('label')[0].style.background = '#fdd2d2';
					uthumb.parentElement.getElementsByTagName('label')[0].innerHTML = 'Ошибка: '+textStatus;
					}
				})
			}
			
		}, true);		
</script>
</div>

<div class="row">
<h3 class="homeh3">Редактировать контент</h3>
<div class="editoptions">
<?php get_template_part('templates/editblog-options'); ?>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function loadeditor(n) {
if (n==1) {
	document.querySelector('.editor').classList.add('expanded');
} else {
	location.reload();
}
}
</script>