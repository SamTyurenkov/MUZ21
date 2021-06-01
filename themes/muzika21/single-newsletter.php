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
<div class="container single stickymenu" style="height:60px">
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
<div class="blogbanner" style="background: #bbb">
<?php 	 if (has_post_thumbnail()) { ?>
<img src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>" title="<?php echo esc_attr($title); ?>" id="postbanner">

<?php } ?>
</div>
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

<div class="pslidercount"><i class="icon-calendar"></i> Опубликовано: <?php the_modified_date( 'd.m.Y' ); ?></div>

</div>
</div>
<?php	while ( have_posts() ) : the_post(); ?>
<div class="container blogcontent" <?php if(is_amp_endpoint() == true) { echo 'style="top: 78px"'; }; ?> >

<div class="psidebar">

</div>

<div class="pcontent">

		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div class="row">

					<h1 class="entry-title"><?php the_title(); ?></h1>

		</div>


		<div class="row">
			<div class="main portfolio-single" role="main">


					<div class="postclass">
						<div class="row">
							<div >
	
							</div><!--imgclass -->
							<div>
								<div class="entry-content">
									<?php
								//	the_content();
									//$texta = str_replace('</div><li>','</div><ul><li>',get_the_content());
									//echo str_replace('</li><div>','</li></ul><div>',$texta);
									echo preg_replace("/(<li>[^<>]+<\/li>)+/","<ul>$0</ul>",get_the_content());
									?>
								</div>
				
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
<?php if (is_user_logged_in() && ( $curuser == $author_id || current_user_can('edit_others_posts'))) { 
 get_template_part('templates/editnewsletter'); 
 }; ?>
<script type="text/javascript">  

</script>
<div class="empty2"></div>
					<footer>
<?php endwhile; get_footer(); ?>
					</footer>
				
	
</body>
</html>