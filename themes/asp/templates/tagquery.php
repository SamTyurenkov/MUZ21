<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php 
$taxonomy = get_queried_object();
$singletitle = single_tag_title('',false);
$brcms = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/"><span itemprop="name">ASP</span></a><meta itemprop="position" content="1" /></span> > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a style="text-transform: capitalize;" itemprop="item" href="/tag/'.$taxonomy->slug.'/"><span itemprop="name">'.$singletitle.'</span></a><meta itemprop="position" content="2" /></span>';
?>


<div class="row category">
<h1 class="homeh2" style="text-transform: capitalize;"><?php echo ucfirst(esc_html($singletitle)); ?> </h1>

<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
<?php echo $brcms; ?>
</div>

<div class="container" style="text-align:center">
<?php 
echo term_description( $taxonomy );
?>
</div>
</div>

<?php 
wp_nonce_field('_load_tag', '_load_tag');
?>
<div class="categories2 container">

</div>
<div class="button loadprops"><i class="icon-plus"></i> Загрузить еще</div>
<script type="text/javascript">
var page = 1;
var selectors = document.querySelectorAll("#filters .custom-select select");

function resetquery() {
page = 1;
document.querySelector('.categories2').innerHTML = '';
document.querySelector('.loadprops').innerHTML = '<i class="icon-plus"></i> Загрузить еще';
loadproperties();
}

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

var selected = [];
if (selectors) {
for (var i = 0; i < selectors.length; i++) {
selected[i] = selectors[i].value;
}};

var taxid = parseInt('<?php echo $taxonomy->term_id; ?>');
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nonce = document.getElementById('_load_tag').value;
var webp = canUseWebP();
console.log(webp);

var value = jQuery.ajax({
				type: 'GET',
				url: ajaxurl,
				data:{
				nonce : nonce,
				page : page,
				taxid : taxid,
				options : selected,
				action: 'tag_blog_ajax',
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
					if(data.amount < 9) {
					document.querySelector('.loadprops').innerHTML = 'Больше ничего нет';	
					}
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					console.log('ajax error in category query');
				}
			})
};

document.querySelector('.loadprops').addEventListener('click', function() {
	loadproperties();
}, false);

var dropdowns = document.querySelectorAll('#filters .select-items div');
for (var n = 0; n < dropdowns.length; n++) {
dropdowns[n].addEventListener('click', function() {
	console.log('reset');
	resetquery();
}, false);
}

loadproperties();
</script>