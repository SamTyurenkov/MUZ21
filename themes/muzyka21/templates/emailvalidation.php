<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
} 
$uid = wp_get_current_user()->ID; 
?>
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