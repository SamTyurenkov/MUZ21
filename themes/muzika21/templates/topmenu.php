<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="topmenu">
<a href="/"><div class="logo"><span style="color: #d03030">ASP</span> Недвижимость</div></a>
<div onClick="loadauth(1)" class="account"><i class="icon-user-o"></i> Аккаунт</div><div onClick="openaddproperty()" class="addprop"><i class="icon-plus"></i> Добавить</div><a href="/blog/"><div class="button toblog"><i class="icon-newspaper"></i> Блог</div></a><a href="/news/" style="margin-left: 4px"><div class="button toblog"><i class="icon-doc-text"></i> Новости</div></a>
</div>
<?php 
if (!is_user_logged_in()) {
echo '<div class="acca">';
get_template_part( 'templates/customauth' );
echo '</div>';
} else if (get_user_meta($uid,'valimail',true) == false) { ?>
<div class="addproperty">
<div class="editmenu">
<span class="pslidercount" onClick="closeaddproperty()">Закрыть</span>
</div>
		<form class="add-form" action="valisend" method="post" style="max-width:100%;width:600px;padding-top:60px;text-align:center;margin:0 auto">
        	<div>
            <p>Подтвердите ваш адрес почты, перейдя по ссылке в письме, отправленном на почту, указанную в вашем профиле, чтобы добавлять объявления и статьи.</p>
			<p>Если вы не получили письмо, после нажатия на кнопку ниже - проверьте разделы "спам", "промоакции", "оповещения" в почтовом ящике, а также проверьте правильность указания Email в настройках аккаунта на сайте.</p>
			<?php wp_nonce_field('_vali_send', '_vali_send'); ?>
            
			<div class="button" id="valisend" type="submit" name="valisend">Получить письмо</div>
			<div id="validation" style="padding: 20px;color: #d03030"></div>
        </div>
        </form>
</div>
		<script type="text/javascript">
var submit = document.getElementById("valisend");
submit.addEventListener("click", function (e) {
	e.preventDefault();

			var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
			var id= <?php echo esc_html($uid);?>;
			var nonce = document.getElementById("_vali_send").value;

			var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				id: id,
				nonce : nonce,
				action: 'valisend',
				},
				success: function(data, textStatus, jqXHR) {
				console.log('val.success');
				document.getElementById("valisend").style.pointerEvents = 'none';
				document.getElementById("valisend").style.background = '#f2f2f2';
				document.getElementById('validation').innerHTML = 'Письмо отправлено';
				},
				error: function(jqXHR, textStatus, errorThrown){ 
				console.log('val.error');
				document.getElementById("valisend").style.pointerEvents = 'none';
				document.getElementById("valisend").style.background = '#f2f2f2';
				document.getElementById('validation').innerHTML = textStatus;
				}
			})
		}, true);
</script>	
		<?php } else {

echo '<div class="addproperty">';
get_template_part( 'templates/addproperty' );
echo '</div>';	

}
 ?> 
