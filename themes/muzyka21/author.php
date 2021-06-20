<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
};
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();
$args = array(
	'post_type'        => array('post', 'property'),
	'author'     => $curauth->ID,
);

$posts = get_posts($args);
wp_reset_postdata();

if (count($posts) == false && (get_user_meta($curauth->ID, 'valimail', true) == false) && (current_user_can('administrator') == false && $curauth->ID != $curuser->ID)) {
	global $wp_query;
	$wp_query->set_404();
	status_header(404);
	die();
}
get_header();
$name = get_the_author_meta('display_name', $curauth->ID);
$phone = get_the_author_meta('user_phone', $curauth->ID);
$authortype = get_the_author_meta('authortype', $curauth->ID);
if (empty($authortype)) $authortype = 'Агент';
?>
<div>
	<div class="container">
		<div class="author">
			<div class="small-container">
				<div class="field user_thumb">
					<label for="userthumb" style="<?php echo 'background:url(' . esc_url(get_avatar_url($curauth->ID, array('size' => 150,))) . ');background-size: cover'; ?>">Аватар</label>
					<?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { ?>
						<?php wp_nonce_field('_asp_editauthmeta', '_asp_editauthmeta'); ?>
						<input type="file" name="userthumb" id="userthumb" multiple="false">
						<div id="logout" class="button" style="padding: 8px 17px;width: fit-content;z-index: 999;position: relative">Выйти</div>
						<div id="authorid" class="button" style="padding: 8px 17px;width: fit-content;z-index: 999;position: relative"><?php echo esc_attr($curauth->ID); ?></div>
					<?php }; ?>
				</div>
				<?php if (have_posts() == false || $curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { ?>
					<div class="editauthor">
						<input class="text display_name" type="text" value="<?php echo esc_html($name); ?>" placeholder="Отображаемое имя">
						<input class="text user_email" type="text" value="<?php echo esc_html(get_the_author_meta('user_email', $curauth->ID)); ?>" placeholder="E-mail адрес" style="margin: 5px 0 0">
						<input class="text user_phone" type="text" value="<?php echo esc_html($phone); ?>" placeholder="Контактный телефон" style="margin: 5px 0 10px">
					</div>
				<?php } else { ?>
					<div style="text-align: center;padding-bottom: 20px">
						<h1><?php echo esc_html($name); ?></h1>
						<a class="button" href="tel:<?php echo esc_html($phone); ?>" onclick="ym(62533903,'reachGoal','callclick')"><i class="icon-whatsapp"></i> <span><?php echo esc_html($phone); ?></span></a>
					</div>
				<?php }; ?>
			</div>
			<div class="small-container">
				<?php
				if (get_user_meta($uid, 'valimail', true) == false) {
					get_template_part('templates/emailvalidation');
				}
				?>
			</div>
		</div>


		<?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { ?>
			<script type="text/javascript">
				//update thumbnail
				var uthumb = document.getElementById("userthumb");
				uthumb.addEventListener("change", function(e) {

					var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
					var id = <?php echo esc_html($curauth->ID); ?>;
					var nonce = document.getElementById("_asp_editauthmeta").value;

					this.parentElement.getElementsByTagName('label')[0].innerHTML = 'Подождите';
					meta = this.files[0].name;
					file = this.files[0];

					if (file.type === "image/jpg" || file.type === "image/png" || file.type === "image/jpeg") {
						extension = true;
					} else {
						this.parentElement.getElementsByTagName('label')[0].style.background = '#fdd2d2';
						this.parentElement.getElementsByTagName('label')[0].innerHTML = 'Jpg/png plz';
					}

					if (extension === true) {
						var data = new FormData();
						data.append('file', file);
						data.append('id', id);
						data.append('nonce', nonce);
						data.append('meta', meta);
						data.append('action', 'updateavatar');
						var value = jQuery.ajax({
							url: ajaxurl,
							data: data,
							type: 'POST',
							cache: false,
							processData: false, // Don't process the files
							contentType: false, // Set content type to false as jQuery will tell the server its a query string request
							dataType: 'json',
							success: function(data, textStatus, jqXHR) {
								var uthumb = document.getElementById("userthumb").parentElement.getElementsByTagName('label')[0];
								console.log('data.response ' + data["response"] + ' ' + textStatus);
								if (data.response == 'SUCCESS') {
									uthumb.innerHTML = 'Загружено';
									uthumb.style.backgroundImage = "url('" + data.thumb + "')";
								}
								if (data.response == 'ERROR') {
									uthumb.style.background = '#fdd2d2';
									uthumb.innerHTML = 'Ошибка: ' + data.error;
									console.log(data.debug);
								}
							},
							error: function(jqXHR, textStatus, errorThrown) {
								var uthumb = document.getElementById("userthumb").parentElement.getElementsByTagName('label')[0];
								uthumb.style.background = '#fdd2d2';
								uthumb.innerHTML = 'Ошибка: ' + errorThrown;
							}
						})
					}

				}, true);
			</script>
			<script type="text/javascript">
				//logout
				var logout = document.getElementById("logout");
				logout.addEventListener("click", function(e) {
					var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
					var nonce = document.getElementById("_asp_editauthmeta").value;

					var value = jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						cache: false,
						data: {
							nonce: nonce,
							action: 'asp_logout',
						},
						success: function(data, textStatus, jqXHR) {
							window.open("<?php echo esc_url(home_url()); ?>", "_self");
						},
						error: function(jqXHR, textStatus, errorThrown) {
							window.open("<?php echo esc_url(home_url()); ?>", "_self");
						}
					});

				});
			</script>
		<?php }; ?>



	</div>
</div>

<?php get_template_part('templates/authquery'); ?>


<script>
	function updatemetas(field) {

		if (field.parentNode.parentNode.classList[0] == 'custom-select') {
			var name = field.parentNode.parentNode.id;
			var meta = field.innerHTML;
		} else {
			var name = field.classList[1];
			var meta = field.value;
		}

		console.log(name + meta);


		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		var id = <?php echo esc_html($curauth->ID); ?>;
		var nonce = document.getElementById("_asp_editauthmeta").value;

		var value = jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			cache: false,
			data: {
				meta: meta,
				id: id,
				name: name,
				nonce: nonce,
				action: 'updateauth',
			},
			success: function(data, textStatus, jqXHR) {
				if (data.response == "SUCCESS") {
					console.log("updatemeta: success " + data.name + data.meta);
				} else if (data.response == "ERROR") {
					console.log("updatemeta: error: " + data.error);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log('updatemeta: error: ' + errorThrown);
			}
		})
	};

	var fields = document.querySelectorAll('.editauthor .text, .integration .text');
	for (var i = 0; i < fields.length; i++) {

		fields[i].addEventListener("change", function() {
			updatemetas(this);
		}, false);
	};

	var selects = document.querySelectorAll('#settings .select-items div');
	for (var i = 0; i < selects.length; i++) {
		selects[i].addEventListener("click", function() {
			updatemetas(this);
		}, false);
	};
</script>
<?php get_footer(); ?>
</body>

</html>