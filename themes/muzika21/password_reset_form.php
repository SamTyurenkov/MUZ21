<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div id="auth4" class="account-keeper">
<form id="register" class="ajax-auth"  action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
    <h4>Установите Новый Пароль</h4>
	<?php if ( isset($_REQUEST['login']) && $_REQUEST['login'] == 'invalidkey' ) {  ?>
	<p class="status" style="display:block">Токен безопасности устарел или недействителен, запросите новую ссылку восстановления.</p>
	<?php } else { ?>
    <p class="status"></p>
	<?php }; ?>
	<input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $_REQUEST['login'] ); ?>" autocomplete="off" />
    <input type="hidden" name="rp_key" value="<?php if ( isset($_REQUEST['key'])) echo esc_attr( $_REQUEST['key'] ); ?>" />       
    <input placeholder="Новый пароль" type="password" name="pass1" id="pass1" class="required" >
    <input placeholder="Повторите пароль" type="password" name="pass2" id="pass2" class="required" >
	<p class="description" style="font-size:12px">Рекомендация: пароль должен быть длиной не менее двенадцати символов. Чтобы сделать его сильнее, используйте заглавные и строчные буквы, цифры и символы, такие как! "? $% ^</p>
	<label for="resetpass-button" class="button">Установить пароль</label>
	<input type="submit" name="submit" id="resetpass-button" value="Reset Password" style="display:none;"/>
</form>
</div>