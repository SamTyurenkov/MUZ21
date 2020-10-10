<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
get_header();
$title = get_the_title();
$author_id = $post->post_author;
$curuser = get_current_user_id();
$taxonomy = get_the_category();

?>
<?php 
if($post->post_status == 'publish'){
get_template_part( 'templates/adsenseajax' );
}
?>
<div class="container single stickymenu transparentmenu" style="height:60px">
<?php get_template_part('templates/topmenu'); ?>
</div>
<?php 	 if (has_post_thumbnail() && my_wp_is_mobile()) { 
$thumbnail = get_the_post_thumbnail_url( $post, 'medium' );	
} else if (has_post_thumbnail()) {
$thumbnail = get_the_post_thumbnail_url( $post, 'large' );			
} else {
$thumbnail = null;
}
?>
<div class="blogbanner" style="background: #bbb;<?php if(is_amp_endpoint()) echo 'border-radius:0'; ?>">
<?php 	 if (has_post_thumbnail()) { ?>
<img src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" id="postbanner">

<?php } ?>
</div>
<?php if(is_amp_endpoint() == false) { ?>
<div class="container" style="height: 50px;padding:10px 0">

<div class="pslidercontrols"> 

<?php if (is_user_logged_in() && ( $curuser == $author_id || current_user_can('edit_others_posts'))) { ?>
<div class="pslidercount" onclick="loadeditor(1)">
<i class="icon-doc-text"></i> <span>Редактировать</span>
</div>
<?php }; ?>

<a href="<?php echo esc_attr(get_author_posts_url($author_id)); ?>" class="pslidercount" >
<i class="icon-user-o"></i> <span>Автор публикации: <?php echo esc_html(get_the_author_meta( 'display_name', $author_id )); ?></span>
</a>

<div class="pslidercount"><i class="icon-calendar"></i> Опубликовано: <?php if($taxonomy[0]->slug == 'blog') {the_modified_date( 'd.m.Y' );} else { echo esc_html(get_the_date( 'd.m.Y' ));} ?></div>

</div>

</div>
<?php }; ?>
<?php	while ( have_posts() ) : the_post(); ?>
<div class="container blogcontent" <?php if($taxonomy[0]->slug == 'news') echo 'itemscope itemtype="http://schema.org/NewsArticle"'; ?>>
<meta itemprop="author" itemscope itemtype="http://schema.org/Person">
<meta itemprop="name" content="<?php echo esc_html(get_the_author_meta( 'display_name', $author_id )); ?>">
</meta>
</meta>
<meta itemprop="datePublished" datetime="<?php the_time('c'); ?>"></meta>
<?php if(is_amp_endpoint() == false) { ?>
<div class="psidebar">

</div>
<?php }; ?>
<div class="pcontent">

		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div class="row">

					<h1 class="entry-title" <?php if($taxonomy[0]->slug == 'news') echo 'itemprop="headline"'; ?>><?php the_title(); ?></h1>

		</div>
<?php 
if(is_amp_endpoint() == false) {
$brcms = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/"><span itemprop="name">ASP</span></a><meta itemprop="position" content="1" /></span> > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy[0]->slug.'/"><span itemprop="name">'.$taxonomy[0]->name.'</span></a><meta itemprop="position" content="2" /></span> > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.get_permalink().'"><span itemprop="name">'.mb_substr(get_the_title(),0,50,'UTF-8').'...</span></a><meta itemprop="position" content="3" /></span></div>';
echo $brcms; 
}
?>


		<div class="row">
			<div class="main portfolio-single" role="main">


					<div class="postclass">
						<div class="row">
							<div>
								<?php if(is_amp_endpoint() == false) { ?>
								<ul class="headings-post-nav">
								<b style="margin-bottom:10px;display:block">Оглавление</b>	
								</ul>
								<?php } ?>
								<div class="entry-content" <?php if($taxonomy[0]->slug == 'news') echo 'itemprop="articleBody"'; ?>>
									<?php

									echo preg_replace("/(<li>[^<>]+<\/li>)+/","<ul>$0</ul>",get_the_content());
									?>
								</div>
								<?php if(is_amp_endpoint() == false) { ?>
								<div class="naverx">
								К началу статьи
								</div>
<script>
function scrollToSmoothly(pos, time){
  if(typeof pos!== "number"){
  pos = parseFloat(pos);
  }
  if(isNaN(pos)){
   console.warn("Position must be a number or a numeric String.");
   throw "Position must be a number";
  }
  if(pos<0||time<0){
  return;
  }
  var currentPos = window.scrollY; // || window.screenTop;
    var start = null;
  time = time;// || 1000;
  window.requestAnimationFrame(function step(currentTime){
    start = !start? currentTime: start;
    if(currentPos<pos){
    var progress = currentTime - start;
    window.scrollTo(0, ((pos-currentPos)*progress/time)+currentPos);
    if(progress < time){
        window.requestAnimationFrame(step);
    } else {
        window.scrollTo(0, pos);
    }
    } else {
     var progress = currentTime - start;
    window.scrollTo(0, currentPos-((currentPos-pos)*progress/time));
    if(progress < time){
        window.requestAnimationFrame(step);
    } else {
        window.scrollTo(0, pos);
    }
    }
  });
}

var headings = document.querySelectorAll('.entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6 ');
var nav = document.querySelector('.headings-post-nav');
if(headings.length > 0) {
for (var i = 0; i < headings.length; i++) {
nav.innerHTML += '<li data-attr="'+i+'" class="'+headings[i].tagName+'">'+headings[i].innerHTML+'</li>';
}	
} else {
nav.style.display = 'none';
}
var navels = nav.querySelectorAll('.headings-post-nav li');
console.log(navels.length);
for (var j = 0; j < navels.length; j++) {
	navels[j].addEventListener('click',function(e){
	e.stopPropagation();
	e.stopImmediatePropagation();
	e.preventDefault();
	var n = this.getAttribute('data-attr');
	console.log(headings[n].offsetTop);
	console.log(parseInt(headings[n].offsetTop)+150);
	scrollToSmoothly(parseInt(headings[n].offsetTop)+150, 700);
	});
}	
document.querySelector('.naverx').addEventListener('click',function(e) {
	e.stopPropagation();
	e.stopImmediatePropagation();
	e.preventDefault();
	scrollToSmoothly(parseInt(document.querySelector('h1').offsetTop), 700);
});				
</script>
<?php } ?>
							</div><!--textclass -->
						</div><!--row-->
						<div class="clearfix"></div>
					</div><!--postclass-->
		
			</div>
		</div>
		</article>
</div>
<div style="text-align:center;padding-bottom:20px">
<?php if($post->post_status == 'publish'){
 get_template_part('templates/sharer'); 
}
?>
</div>
</div>

<?php

$terms = get_the_terms( get_the_ID(), 'post_tag' );

if($terms) {
echo '<div class="container" style="height:60px"><div class="pslidercontrols">';
$t = array();
foreach ($terms as $term) {
$t[] = $term->term_id;
echo '<a href="'.esc_attr(get_term_link( $term, 'post_tag' )).'" class="pslidercount" ><span>'.esc_html($term->name).'</span></a>';
}
$qargs['tax_query'] = array(
	array(
		'taxonomy' => 'post_tag',
		'field' => 'term_id',
		'terms' => $t
	)
);
echo '</div></div>';
}

$prevpost = get_previous_post(false, '', 'post_tag');
if ($prevpost == '') {

	$last_post = get_posts( array(
		'post_type'        => 'post',
		'posts_per_page'   => 1,
		'order' => 'DESC',
		'orderby' => 'date'
	) );
	$prevpost = $last_post[0];
	wp_reset_postdata();
}
$nextpost = get_next_post(false, '', 'post_tag');
if ($nextpost == '') {

	$first_post = get_posts( array(
		'post_type'        => 'post',
		'posts_per_page'   => 1,
		'order' => 'ASC',
		'orderby' => 'date'
	) );
	$nextpost = $first_post[0];
	wp_reset_postdata();
}
 ?>
<div class="tagrecommendation">
<h2 style="text-align: center;font-size: 26px">Другие новости и статьи</h2>
<div class="categories2 container">

<?php $thumbnail = get_the_post_thumbnail_url( $nextpost, 'thumbnail' ); ?>
	
<a href="<?php echo esc_attr(get_permalink($nextpost)); ?>" class="catblock2">
<img src="<?php echo esc_attr($thumbnail); ?>">
<h4><?php echo esc_html(get_the_title($nextpost)); ?></h4>
</a>

<?php $thumbnail = get_the_post_thumbnail_url( $prevpost, 'thumbnail' ); ?>
	
<a href="<?php echo esc_attr(get_permalink($prevpost)); ?>" class="catblock2">
<img src="<?php echo esc_attr($thumbnail); ?>">
<h4><?php echo esc_html(get_the_title($prevpost)); ?></h4>
</a>

</div>
</div>


<?php

$cargs = array(
	'post_type' => 'property',
	'posts_per_page' => 3,
	'orderby'        => 'rand'
);

if(get_post_meta(get_the_ID(),'locality-name',true)) {

$relatedcity = wp_cache_get( 'relatedcity_random_'.get_post_meta(get_the_ID(),'locality-name',true) );
if ( false === $relatedcity ) {

$cargs['meta_key'] = 'locality-name';
$cargs['meta_query'][0] = array(
            'meta_query' => array(
                               array('key' => 'locality-name',
									  'value' => get_post_meta(get_the_ID(),'locality-name',true)
										)
                            )
						);
$relatedcity = new WP_Query($cargs);
wp_cache_set( 'relatedcity_random', $relatedcity, '', 86400 );
}

if( $relatedcity->have_posts() ) { ?>
<div class="realtyrecommendation">
<h2 style="text-align: center;font-size: 26px">Недвижимость в городе <?php echo esc_html(get_post_meta(get_the_ID(),'locality-name',true)); ?></h2>
<div class="categories2 container">

<?php 
while( $relatedcity->have_posts() ) {
		$relatedcity->the_post(); ?>

<?php $thumbnail = get_the_post_thumbnail_url( null, 'thumbnail' ); ?>
	
<a href="<?php echo esc_attr(get_the_permalink()); ?>" class="catblock2">
<img src="<?php echo esc_attr($thumbnail); ?>">
<h4><?php echo esc_html(get_the_title()); ?></h4>
<?php	if (get_post_meta(get_the_ID(),'value_price',true)) { ?>
<div class="catprop"><i class="icon-rouble"></i><?php echo esc_html(number_format(get_post_meta(get_the_ID(),'value_price',true)));
	if (has_term(16,'property-type')) echo esc_html('/сутки'); if (has_term(19,'property-type')) echo esc_html('/месяц'); ?>
</div>
<?php	}
	if (get_post_meta(get_the_ID(),'value_area',true)) { ?>
<div class="catprop"><i class="icon-resize-full-alt"></i><?php echo esc_html( get_post_meta(get_the_ID(),'value_area',true).' кв.м.'); ?></div>
<?php }; ?>
</a>

<?php }; ?>
</div>
</div>
<?php }
wp_reset_postdata();
}; 
?>

<?php if (is_user_logged_in() && ( $curuser == $author_id || current_user_can('edit_others_posts'))) { 
 get_template_part('templates/editblog'); 
 }; ?>

<div class="empty2"></div>
					<footer>
<?php endwhile; get_footer(); ?>
					</footer>
				
	
</body>
</html>