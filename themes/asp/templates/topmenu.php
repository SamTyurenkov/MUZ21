<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
 <?php 

	$uid = wp_get_current_user()->ID; 
	if (empty($uid)) $uid = '';
	$cid = get_user_meta($uid,'cid',true);
	if (empty($cid)) $cid = '';
	wp_nonce_field('_uuid_nonce', '_uuid_nonce');
 ?>
  <script type="text/javascript">
  function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
	
    function uuid(){
	if(readCookie('cid') != null && readCookie('cid').length > 10) {
			  var uuidd = readCookie('cid');
		  } else {
	  var dt = new Date().getTime();
	  var uuidd = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
              var r = (dt + Math.random()*16)%16 | 0;
        dt = Math.floor(dt/16);
        return (c=='x' ? r :(r&0x3|0x8)).toString(16);
	      });
	  var date = new Date();
      date.setTime(date.getTime()+(365*24*60*60*1000));
      document.cookie = "cid=" + uuidd + "; expires=" + date.toGMTString()+";path=/;"+"SameSite=Lax;"+"Secure";
	 }
	 <?php if (is_user_logged_in() && empty($cid)) { ?>	 

	  var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
	  var id = '<?php echo esc_html($uid); ?>';
	  
	  var nonce = document.getElementById("_uuid_nonce").value;
	  var meta = uuidd;
			
			var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				id: id,
				meta : meta,
				nonce : nonce,
				action: 'setuid',
				},
				success: function(data, textStatus, jqXHR) {					
				},
				error: function(jqXHR, textStatus, errorThrown){ 
				}
			
		}, true);
	<?php }; ?>
	return uuidd;
}
  function fetchPageView() {
<?php if (is_user_logged_in() && !empty($cid)) {  ?>
	var cid = '<?php echo esc_html($cid); ?>';
	<?php } else { ?>
	var cid = uuid();
<?php }; ?>	
	var time = new Date(Date.now());
	var nonce = Math.floor((time.getTime()/1000)).toString(); 
	var ajaxurl = 'https://www.google-analytics.com/collect?v=1&tid=UA-55186923-1&cid='+cid+'&t=pageview&dh=asp.sale&dp='+window.location.pathname+'&dt='+window.location.pathname+'&z='+nonce;  
	var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,		
		}, true);
  }
  fetchPageView();
 </script>
<?php if(is_amp_endpoint() == true) { ?>
		<amp-analytics type="gtag" data-credentials="include">
		<script type="application/json">
		{
		"vars" : {
			"gtag_id": "UA-55186923-1",
			"config" : {
			"UA-55186923-1": { "groups": "default" }
			}
		}
		}
		</script>
		</amp-analytics>
        <amp-analytics type="metrika">
            <script type="application/json">
                {
                    "vars": {
                        "counterId": "62533903"
                    }
                }
            </script>
        </amp-analytics>
<div class="topmenu">
<a href="/"><div class="logo" style="width: calc(100% - 32px);text-align: center"><span style="color: #d03030">ASP</span> Недвижимость</div></a>
</div>
<?php } else { ?>
<div class="topmenu">
<a href="/"><div class="logo"><span style="color: #d03030">ASP</span> Недвижимость</div></a>
<div onClick="loadauth(1)" class="account"><i class="icon-user-o"></i> Аккаунт</div><div onClick="openaddproperty()" class="addprop"><i class="icon-plus"></i> Добавить</div><a href="/blog/"><div class="button toblog"><i class="icon-newspaper"></i> Блог</div></a><a href="/news/" style="margin-left: 4px"><div class="button toblog"><i class="icon-doc-text"></i> Новости</div></a>
<script type="text/javascript">
function getDimensions() {
var logo = document.querySelector(".logo");
var addprop = document.querySelector(".addprop");
var blog = document.querySelectorAll(".toblog");
var account = document.querySelector(".account");
	
  if (window.innerWidth < '681') {
	  logo.innerHTML = '<span style="color: #d03030">ASP</span>';
	  addprop.innerHTML = '<i class="icon-plus"></i>';
	  blog[0].innerHTML = '<i class="icon-newspaper"></i>';
	  blog[1].innerHTML = '<i class="icon-doc-text"></i>';
	  account.innerHTML = '<i class="icon-user-o"></i>';
  } else {
	  logo.innerHTML = '<span style="color: #d03030">ASP</span> Недвижимость';
	  addprop.innerHTML = '<i class="icon-plus"></i> Добавить';
	  blog[0].innerHTML = '<i class="icon-newspaper"></i> Блог';
	  blog[1].innerHTML = '<i class="icon-doc-text"></i> Новости';
	  account.innerHTML = '<i class="icon-user-o"></i> Аккаунт';
  }
};

//lListen for window.resize
window.addEventListener('resize', getDimensions, false);

// call once to initialize page
getDimensions();
</script>
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

}}
 ?> 
