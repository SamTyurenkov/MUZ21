<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="vigruzki">
<div class="container">

<div class="editmenu">
<span class="pslidercount" onClick="loadeditor(2)">Закрыть</span>
</div>

<?php get_template_part('templates/integrations/yandex-data') ?>
<?php get_template_part('templates/integrations/avito-data') ?>
<?php get_template_part('templates/integrations/cian-data') ?>

</div>
</div>



<script type="text/javascript">
function update_post_integrations(n,partner) {

var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
var nonce = document.getElementById('_edit_properties').value;
var id = parseInt('<?php echo $post->ID; ?>');

var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				id : id,
				metaname : partner,
				metavalue : n,
				action: 'update_props_ajax',
				},
				success: function(data, textStatus, jqXHR) {
					if(data.response == 'success') {
					let xmlbutton = document.querySelector('#xml'+partner);

					if(data.val == 1) {
						xmlbutton.innerHTML = 'Убрать из выгрузки';
						xmlbutton.setAttribute('onclick',"update_post_integrations(2,'"+partner+"')");
					} else if (data.val == 2) {
						xmlbutton.innerHTML = 'Добавить в выгрузку';
						xmlbutton.setAttribute('onclick',"update_post_integrations(1,'"+partner+"')");
					} 
					console.log("success "+data.val + data.meta)
					} else {
					console.log("error "+data.meta + data.val);
					}
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					console.log('ajax error in update xml status');
				}
			})

};
</script>