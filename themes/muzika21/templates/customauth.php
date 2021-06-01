<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div id="acckeeper" class="account-keeper">
<div id="auth1">
<form id="login" class="ajax-auth" action="login" method="post" autocomplete="off">
    <h3 class="homeh3">Войти на сайт</h3>
<?php   if ( isset($_REQUEST['password']) && $_REQUEST['password'] == 'changed' ) { ?>  
<p class="status" id="error" style="color: #d03030">Ваш пароль был изменен. Вы можете войти.</p>  	
<?php } else { ?>
<p class="status" id="error" style="color: #d03030"></p>  
<?php }; ?>
    <?php wp_nonce_field('_log_user', '_log_user'); ?>  
    <input placeholder="Почта" id="username" type="text" class="required" name="username">
	<input placeholder="Пароль" id="password" type="password" class="required" name="password" autocomplete="off">
	<span class="pslidercount" id="logsubmit">Войти</span><span class="pslidercount" onClick="loadauth(2)">Закрыть</span>
</form>
<div class="ajax-auth">
	<div style="padding: 15px 0 0">Забыли пароль? <span class="pointer" onclick="sw3()">Восстановить</span></div>
</div>
<div id="auth3">
<form id="recoveryform" class="ajax-auth" action="recovery" method="post">
<h3 class="homeh3">Восстановить Пароль</h3>
<p class="status"></p>  
    <?php wp_nonce_field('_lost_pass', '_lost_pass'); ?>  
    <input placeholder="Логин или Почта" id="recovery" type="text" class="required" name="username">
	<label class="button" id="recoverylink">Получить ссылку</label>
</form>
</div>
<div class="ajax-auth">
<div style="padding: 15px 0 0">Впервые на сайте? <span class="pointer" onclick="sw1()">Зарегистрируйтесь</span></div>
</div>
</div>
<div id="auth2">
<form id="register" class="ajax-auth"  action="register" method="post" autocomplete="off">
    <h3 class="homeh3">Регистрация на сайте</h3>
    <p class="status"></p>
    <?php wp_nonce_field('_reg_user', '_reg_user'); ?>         
    <input placeholder="Почта" id="email" type="text" class="required email" name="email">
	<input placeholder="Телефон" id="phone" type="text" class="required phone" name="phone">
    <input placeholder="Пароль" id="signonpassword" type="password" class="required" name="signonpassword" autocomplete="off">
    <input placeholder="Повторите пароль" type="password" id="password2" class="required" name="password2" autocomplete="off">
	<span class="pslidercount" id="regsubmit">Зарегистрироваться</span><span class="pslidercount" onClick="loadauth(2)">Закрыть</span>
</form>
<div class="ajax-auth">
<div style="padding: 15px 0 0">Уже зарегистрированы? <span class="pointer" onclick="sw2()">Войти</span></div>
</div>
</div>
<script type="text/javascript">
var auth1 = document.querySelector("#auth1");
var auth2 = document.querySelector("#auth2");
var auth3 = document.querySelector("#auth3");
function sw1() {
auth2.style.display = 'block';
auth1.style.display = 'none';
};
function sw2() {
auth1.style.display = 'block';
auth2.style.display = 'none';
};
function sw3() {
auth3.style.display = 'block';
};
</script>
<script type="text/javascript">
var logform = document.getElementById("logsubmit");
var regform = document.getElementById("regsubmit");
var recoveryform = document.getElementById("recoverylink");

var loguser = document.getElementById("username");
var logpass = document.getElementById("password");

var regemail = document.getElementById("email");
var regphone = document.getElementById("phone");
var regpass = document.getElementById("signonpassword");
var regpasscheck = document.getElementById("password2");

var recovery = document.getElementById("recovery");

regphone.addEventListener("input", function(e) {
	if(regphone.value.charAt(0) == '8') regphone.value = regphone.value.replace('8','+7');
	regphone.value = regphone.value.replace(/[^0-9+]/,'');
});

//recovery
recoveryform.addEventListener("click", function(e) {
			var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
			var nonce = document.getElementById("_lost_pass").value;
			var username = recovery.value;
			
			var value = jQuery.ajax({
				url: ajaxurl,
				data:{
				username : username,
				nonce : nonce,
				action: 'ajax_forgotpassword',
				},
				type: 'POST',
				dataType: 'json',
				success: function(data, textStatus, jqXHR) {	
	
					console.log(data.response + data.message);
					recoveryform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
					recoveryform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message;
					
					},
				error: function(jqXHR, textStatus, errorThrown){ 
				console.log(errorThrown);
				recoveryform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
					}
				});
			
		}, true);

//login
logform.addEventListener("click", function(e) {
			var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
			var nonce = document.getElementById("_log_user").value;
			var username = loguser.value;
			var password = logpass.value;
			
			var value = jQuery.ajax({
				url: ajaxurl,
				data:{
				password : password,
				username : username,
				nonce : nonce,
				action: 'ajax_login',
				},
				type: 'POST',
				dataType: 'json',
				success: function(data, textStatus, jqXHR) {	
	
					console.log('data.response ' + data.response + ' ' + textStatus);
					logform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
					logform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message;
					if(data.response == 'SUCCESS'){
					location.href = 'https://<?php echo esc_html($_SERVER["SERVER_NAME"]); ?>/author/'+data.id;	
					}
					},
				error: function(jqXHR, textStatus, errorThrown){ 
				console.log(errorThrown);
				logform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
					}
				});
			
		}, true);
		
//register
regform.addEventListener("click", function(e) {
regform.parentElement.getElementsByClassName("status")[0].style.display = 'none';
	
			var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
			var nonce = document.getElementById("_reg_user").value;

			var email = regemail.value;
			var phone = regphone.value;
			var password = regpass.value;
			var password2 = regpasscheck.value;
			
				
				 if( password != password2) {
		         regpasscheck.style.borderColor = '#cd192e';
				 regpass.style.borderColor = '#cd192e';
				 regform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
				 regform.parentElement.getElementsByClassName("status")[0].innerHTML = 'Пароли не совпадают';
				} else if (/^\+7[0-9]{10}$/.test(phone) == false) {
				 regform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
				 regform.parentElement.getElementsByClassName("status")[0].innerHTML = 'Укажите телефон в формате +79999999999';
				} else if (/.+@.+\.[a-zA-Z]+/.test(email) == false) {
				 regform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
				 regform.parentElement.getElementsByClassName("status")[0].innerHTML = 'Укажите почту в формате xxx@yyy.zzz';
				} else {
					var value = jQuery.ajax({
					url: ajaxurl,
					data:{
					password : password,
					email : email,
					phone : phone,
					nonce : nonce,
					action: 'ajax_register',
					},
					type: 'POST',
					dataType: 'json',
					success: function(data, textStatus, jqXHR) {	
					console.log(data.message);
					regform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
					regform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message;
					if(data.response == 'SUCCESS'){
					location.href = 'https://<?php echo esc_html($_SERVER["SERVER_NAME"]); ?>/author/'+data.id ;	
					}
					},
					error: function(jqXHR, textStatus, errorThrown){ 
					console.log(errorThrown);
					regform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
					}
					});
				}
			}, true);
</script>
</div>