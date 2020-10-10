<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="row">

<h2 class="homeh2">Актуальные объявления</h2>

</div>
<?php wp_nonce_field('_load_properties', '_load_properties'); ?>
<div class="categories2 container">
      
</div>
<div class="button loadprops"><i class="icon-plus"></i> Загрузить еще</div>
<script type="text/javascript">
var page = 1;

function canUseWebP() {
    var elem = document.createElement('canvas');

    if (!!(elem.getContext && elem.getContext('2d'))) {
        // was able or not to get WebP representation
        return elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
    }

    // very old browser like IE 8, canvas not supported
    return false;
}

function loadproperties() {
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nonce = document.getElementById('_load_properties').value;

var value = jQuery.ajax({
				type: 'GET',
				url: ajaxurl,
				data:{
				nonce : nonce,
				page : page,
				action: 'more_post_ajax',
				},
				success: function(data, textStatus, jqXHR) {
					page++;
					var addwebp = data["response"];
					if(canUseWebP() == true) {
					addwebp = addwebp.split(".png").join(".png.webp");
					addwebp = addwebp.split(".jpg").join(".jpg.webp");
					addwebp = addwebp.split(".jpeg").join(".jpeg.webp");
					}
					document.querySelector('.categories2').innerHTML += addwebp;
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
				//
				}
			})
};
document.querySelector('.loadprops').addEventListener('click', function() {
	loadproperties();
}, false);
loadproperties();
</script>