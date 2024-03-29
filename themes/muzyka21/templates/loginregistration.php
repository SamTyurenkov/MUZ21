<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
$uid = wp_get_current_user()->ID;
?>
<div class="account_forms">
	<div class="container">
		<?php wp_nonce_field('_regforms', '_regforms'); ?>
		<div class="small-container">
			<span class="button close closeaccforms" style="right: 0;position: absolute;top: -50px;padding: 3px 7px;z-index:15">X</span>
		</div>

		<div id="auth1">
			<form id="login" class="small-container" action="login" method="post" autocomplete="off">
				<h3 class="homeh3">Войти на сайт</h3>
				<?php if (isset($_REQUEST['password']) && $_REQUEST['password'] == 'changed') { ?>
					<p class="status" id="error" style="color: #d03030">Ваш пароль был изменен. Вы можете войти.</p>
				<?php } else { ?>
					<p class="status" id="error" style="color: #d03030"></p>
				<?php }; ?>
				<span class="input_container">
					<label>Ваш E-mail</label>
					<input placeholder="your@email.domain" id="username" type="text" class="required" name="username">
				</span>
				<span class="input_container">
					<label>Ваш пароль</label>
					<input placeholder="Пароль" id="password" type="password" class="required" name="password" autocomplete="off">
				</span>
				<span class="button" id="logsubmit">Войти</span>
			</form>
			<div class="small-container">
				<div style="padding: 15px 0 0">Забыли пароль? <span class="pointer" id="showreset">Восстановить</span></div>
			</div>
			<div class="small-container">
				<div style="padding: 15px 0 0">Впервые на сайте? <span class="pointer" id="showreg">Зарегистрируйтесь</span></div>
			</div>
			<div id="auth3">
				<form id="recoveryform" class="small-container" action="recovery" method="post">
					<h3 class="homeh3">Восстановить Пароль</h3>
					<p class="status"></p>
					<span class="input_container">
					<label>Ваш E-mail</label>
					<input placeholder="your@email.domain" id="recovery" type="text" class="required" name="username">
					</span>
					<label class="button" id="recoverylink">Получить ссылку</label>
				</form>
			</div>

		</div>
		<div id="auth2">
			<form id="register" class="small-container" action="register" method="post" autocomplete="off">
				<h3 class="homeh3">Регистрация на сайте</h3>
				<p class="status"></p>
				<span class="input_container">
					<label>Ваш E-mail</label>
					<input placeholder="your@email.domain" id="email" type="text" class="required email" name="email">
				</span>
				<span class="input_container">
					<label>Ваш Телефон</label>
					<input placeholder="+7..." id="phone" type="text" class="required phone" name="phone">
				</span>
				<span class="input_container">
					<label>Ваш Пароль</label>
					<input placeholder="*******" id="signonpassword" type="password" class="required" name="signonpassword" autocomplete="off">
				</span>
				<span class="input_container">
					<label>Повторите пароль</label>
					<input placeholder="*******" type="password" id="password2" class="required" name="password2" autocomplete="off">
				</span>
				<span class="button" id="regsubmit">Зарегистрироваться</span>
			</form>
			<div class="small-container">
				<div style="padding: 15px 0 0">Уже зарегистрированы? <span class="pointer" id="showlogin">Войти</span></div>
			</div>
		</div>
	</div>
</div>