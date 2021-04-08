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

<div class="categories2 container">

</div>
<div class="button loadprops"><i class="icon-plus"></i> Загрузить еще</div>