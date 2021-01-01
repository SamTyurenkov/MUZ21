<?php

/*
Plugin Name: PBG SITEMAP
Plugin URI: https://play-best-games.com
Description: Sitemap for PBG
Author: Sam Tyurenkov
Version: 1
Author URI: https://windowspros.ru
Tags: sitemap
Text Domain: pbg-sitemap
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}; 
add_action('init', 'customRSS');
function customRSS(){
        add_feed('sitemap_index775143.xml', 'sitemap_index');
		add_feed('property_sitemap4326745.xml', 'property_sitemap');
		add_feed('page_sitemap.xml', 'page_sitemap');
		add_feed('news_sitemap.xml', 'news_sitemap');
		add_feed('blog_sitemap.xml', 'blog_sitemap');
		add_feed('tag_sitemap.xml', 'tag_sitemap');
		add_feed('yandexnews_sitemap.xml', 'yandexnews_sitemap');
}

function sitemap_index(){     
http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, must-revalidate, max-age=86400');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?>';
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
//date
$args = array( 
'numberposts' => '1',
'post_status' => 'publish',
'post_type' => 'property' );
//props
$recent_posts = wp_get_recent_posts( $args );
$date = date('c',strtotime($recent_posts[0]["post_date"]));
$props = wp_cache_get( 'pbg_sitemap_index_props' );
if ( false === $props ) {
$props = new WP_Query(array(					'post_type' => 'property',
												'post_status' => 'publish',
												'posts_per_page' => 10000,
												'paged'         => $paged,
									));
wp_cache_set( 'pbg_sitemap_index_props', $props );
}
 { ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<sitemap>
		<loc><?php echo get_feed_link('page_sitemap.xml'); ?></loc>
		<lastmod><?php echo esc_html( $date); ?></lastmod>
	</sitemap>
	<?php 
$i = 1;
while ( $i <= $props->max_num_pages ) {
	 ?>
	<sitemap>
		<loc><?php echo get_feed_link('property_sitemap4326745.xml').'?paged='.esc_html($i++); ?></loc>
		<lastmod><?php echo esc_html( $date); ?></lastmod>
	</sitemap>
	<?php
	}; 
	
$paged2 = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
//date
$args2 = array( 
'numberposts' => '1',
'post_status' => 'publish',
'post_type' => 'post',
'category_name' => 'news', );
//props
$recent_posts2 = wp_get_recent_posts( $args2 );
$date2 = date('c',strtotime($recent_posts2[0]["post_date"]));
$news = wp_cache_get( 'pbg_sitemap_index_news' );
if ( false === $news ) {
$news = new WP_Query(array(					'post_type' => 'post',
												'post_status' => 'publish',
												'posts_per_page' => 10000,
												'paged'         => $paged2,
												'category_name' => 'news',
									));
wp_cache_set( 'pbg_sitemap_index_news', $news );
}
$n = 1;
while ( $n <= $news->max_num_pages ) {
	 ?>
		<sitemap>
		<loc><?php echo get_feed_link('news_sitemap.xml').'?paged='.esc_html($n++); ?></loc>
		<lastmod><?php echo esc_html( $date); ?></lastmod>
		</sitemap>
	<?php
	}; 
	
$paged3 = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
//date
$args3 = array( 
'numberposts' => '1',
'post_status' => 'publish',
'post_type' => 'post',
'category_name' => 'blog', );
//props
$recent_posts3 = wp_get_recent_posts( $args3 );
$date3 = date('c',strtotime($recent_posts2[0]["post_date"]));
$blog = wp_cache_get( 'pbg_sitemap_index_blog' );
if ( false === $blog ) {
$blog = new WP_Query(array(					'post_type' => 'post',
												'post_status' => 'publish',
												'posts_per_page' => 10000,
												'paged'         => $paged2,
												'category_name' => 'blog',
									));
wp_cache_set( 'pbg_sitemap_index_blog', $blog );
}
$m = 1;
while ( $m <= $blog->max_num_pages ) {
	 ?>		
		<sitemap>
		<loc><?php echo get_feed_link('blog_sitemap.xml').'?paged='.esc_html($m++); ?></loc>
		<lastmod><?php echo esc_html( $date); ?></lastmod>
		</sitemap>
		<sitemap>
		<loc><?php echo get_feed_link('tag_sitemap.xml'); ?></loc>
		</sitemap>
	<?php
	}; 	?>	
</sitemapindex>
<?php }
ob_end_flush();
}

function tag_sitemap(){ 
http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, must-revalidate, max-age=86400');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$tags = wp_cache_get( 'pbg_sitemap_tags' );
if ( false === $tags ) {
$args = array(
	'echo' => 0,
	'number' => 5000,
    'format'    => 'array',
    'orderby'   => 'count',
    'order'     => 'DESC',
	'show_count' => '0',
    'topic_count_text_callback'  => 'default_topic_count_text',
    'topic_count_scale_callback' => 'default_topic_count_scale',
    'filter'    => 1 );
$tags = wp_tag_cloud( $args );
wp_cache_set( 'pbg_sitemap_tags', $tags );								
}
$i = 1;
foreach ($tags as $tag) {
	if ($i < 30) {
		$priority = '0.7';
	} else if ($i < 100) {
		$priority = '0.4';
	} else if ($i < 200) {
		$priority = '0.1';
	} else {
		$priority = '0.0';
	}
	preg_match('!https?://\S+/!',$tag,$matches);
	echo '<url><loc>'.esc_url($matches[0]).'</loc><changefreq>daily</changefreq><priority>'.esc_html($priority).'</priority></url>';
	$i++;
}
echo '</urlset>';
ob_end_flush();
}

function property_sitemap(){ 
http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, must-revalidate, max-age=86400');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'; 
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$objects = wp_cache_get( 'pbg_sitemap_props_'.$paged );
if ( false === $objects ) {
$objects = new WP_Query(array(					'post_type' => 'property',
												'post_status' => 'publish',
												'posts_per_page' => 10000,
												'paged'         => $paged,
									));
wp_cache_set( 'pbg_sitemap_props_'.$paged, $objects );								
}
while ($objects->have_posts()) : $objects->the_post();
echo '<url><loc>'; 
the_permalink(); 
echo '</loc><lastmod>'; 
the_modified_time('c'); 
echo '</lastmod><priority>0.6</priority>';
echo '<image:image><image:loc>'.get_the_post_thumbnail_url(null,'medium').'</image:loc><image:caption>'.get_the_title().' Фото</image:caption></image:image>';
echo '</url>';
endwhile;wp_reset_postdata(); 
echo '</urlset>';
ob_end_flush();
}

function news_sitemap(){ 
http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, must-revalidate, max-age=86400');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">'; 
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$objects = wp_cache_get( 'pbg_sitemap_news_'.$paged );
if ( false === $objects ) {
$objects = new WP_Query(array(					'post_type' => 'post',
												'post_status' => 'publish',
												'posts_per_page' => 10000,
												'paged'         => $paged,
												'category_name' => 'news',
									));
wp_cache_set( 'pbg_sitemap_news_'.$paged, $objects );								
}
while ($objects->have_posts()) : $objects->the_post();
echo '<url><loc>'; 
the_permalink(); 
echo '</loc><news:news><news:publication><news:name>ASP Новости</news:name><news:language>ru</news:language></news:publication>';
echo '<news:publication_date>'.get_the_modified_time('c').'</news:publication_date>'; 
echo '<news:title>'.get_the_title().'</news:title>'; 
echo '</news:news></url>';
endwhile;wp_reset_postdata(); 
echo '</urlset>';
ob_end_flush();
}

function yandexnews_sitemap(){ 
http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, must-revalidate, max-age=86400');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?><rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" version="2.0">'; 
echo '<channel>';
echo '<title>ASP Новости</title>';
echo '<link>https://asp.sale/news/</link>';
echo '<description>Новости про Недвижимость и Туризм</description>';
echo '<language>ru</language>';
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$objects = wp_cache_get( 'pbg_sitemap_yandex_news_'.$paged );
if ( false === $objects ) {
$objects = new WP_Query(array(					'post_type' => 'post',
												'post_status' => 'publish',
												'posts_per_page' => 10000,
												'paged'         => $paged,
												'category_name' => 'news',
									));
wp_cache_set( 'pbg_sitemap_yandex_news_'.$paged, $objects );								
}
while ($objects->have_posts()) : $objects->the_post();
echo '<item>';
echo '<title>'.get_the_title().'</title>';
echo '<link>'; 
the_permalink(); 
echo '</link>';
echo '<pdalink>'; 
the_permalink(); 
echo '</pdalink>';
echo '<enclosure url="'.get_the_post_thumbnail_url(null,'medium').'" />';
echo '<pubDate>';
the_modified_time('D, d M y H:i:s O');
echo '</pubDate>'; 
echo '<yandex:full-text><![CDATA['.get_the_content().']]></yandex:full-text>';
echo '</item>';
endwhile;wp_reset_postdata(); 
echo '</channel>';
echo '</rss>';
ob_end_flush();
}

function blog_sitemap(){ 
http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, must-revalidate, max-age=86400');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'; 
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$objects = wp_cache_get( 'pbg_sitemap_blog_'.$paged );
if ( false === $objects ) {
$objects = new WP_Query(array(					'post_type' => 'post',
												'post_status' => 'publish',
												'posts_per_page' => 10000,
												'paged'         => $paged,
												'category_name' => 'blog',
									));
wp_cache_set( 'pbg_sitemap_blog_'.$paged, $objects );								
}
while ($objects->have_posts()) : $objects->the_post();
echo '<url><loc>'; 
the_permalink(); 
echo '</loc><lastmod>'; 
the_modified_time('c'); 
echo '</lastmod><priority>0.6</priority>';
echo '<image:image><image:loc>'.get_the_post_thumbnail_url(null,'medium').'</image:loc><image:caption>'.get_the_title().' Фото</image:caption></image:image>';
echo '</url>';
endwhile;wp_reset_postdata(); 
echo '</urlset>';
ob_end_flush();
}

function page_sitemap(){ 
http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, must-revalidate, max-age=86400');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$home = get_home_url(null,'','https');
//date
$args = array( 'numberposts' => '1',
'post_status' => 'publish',
'post_type' => 'page' );

$recent_posts = wp_get_recent_posts( $args );

$args2 = array( 
'numberposts' => '1',
'post_status' => 'publish',
'post_type' => 'post',
'category_name' => 'news', );
//props
$recent_posts2 = wp_get_recent_posts( $args2 );	
								
$args3 = array( 
'numberposts' => '1',
'post_status' => 'publish',
'post_type' => 'post',
'category_name' => 'blog', );
//props
$recent_posts3 = wp_get_recent_posts( $args3 );								
									
echo '<url><loc>'.$home.'</loc><changefreq>daily</changefreq><lastmod>'.date('c',strtotime(esc_html($recent_posts[0]["post_date"]))).'</lastmod><priority>1.0</priority></url>';
echo '<url><loc>'.$home.'/news/</loc><changefreq>hourly</changefreq><lastmod>'.date('c',strtotime(esc_html($recent_posts2[0]["post_date"]))).'</lastmod><priority>0.9</priority></url>';
echo '<url><loc>'.$home.'/blog/</loc><changefreq>daily</changefreq><lastmod>'.date('c',strtotime(esc_html($recent_posts3[0]["post_date"]))).'</lastmod><priority>0.9</priority></url>';
//echo '<url><loc>https://asp.sale/xml-vygruzka-obyavlenij-nedvizhimosti/</loc><priority>0.8</priority></url>';
//echo '<url><loc>https://asp.sale/terms/</loc><priority>0.3</priority></url>';


$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$objects = wp_cache_get( 'pbg_sitemap_pages_'.$paged );
if ( false === $objects ) {
$objects = new WP_Query(array(					'post_type' => 'page',
												'post_status' => 'publish',
												'posts_per_page' => 10000,
												'paged'         => $paged,
												'post__not_in' => array(5787,5913)
									));
wp_cache_set( 'pbg_sitemap_pages_'.$paged, $objects );								
}
while ($objects->have_posts()) : $objects->the_post();
echo '<url><loc>'; 
the_permalink(); 
echo '</loc><lastmod>'; 
the_modified_time('c'); 
echo '</lastmod><priority>0.6</priority>';
echo '</url>';
endwhile;wp_reset_postdata();

$cities = array("moskva", "sochi", "sankt-peterburg", "tolyatti", "orenburg", "pskov","penza");
$dtypes = array("kupit", "snyat", "posutochno-snyat");
$ptypes = array("kvartira", "dom", "nezhiloe", "komnata", "uchastok","hotel","koikomesto");

foreach ($dtypes as $dtype) {
	echo '<url><loc>'.$home.'/'.esc_html($dtype).'/</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
	foreach ($ptypes as $ptype) {
		if($ptype == 'kvartira' || $ptype == 'dom' || $ptype == 'uchastok' || $ptype == 'nezhiloe' || $ptype == 'komnata') { 
		$priority = '1.0'; 
		} else { 
		$priority = '0.3'; 
		}
		if (($dtype == 'snyat' || $dtype == 'posutochno-snyat')) continue;
		if ($dtype == 'posutochno-snyat' && ($ptype == 'uchastok' || $ptype == 'nezhiloe')) continue;
		if ($dtype == 'kupit' && ($ptype == 'hotel' || $ptype == 'koikomesto')) continue;
		
		echo '<url><loc>'.$home.'/'.esc_html($dtype).'/'.esc_html($ptype).'/</loc><changefreq>daily</changefreq><priority>'.esc_html($priority).'</priority></url>';
		foreach ($cities as $city) {
			
		if ($city == 'sochi') {
		$priority = '0.5';	
		} else {
		$priority = '0.0';		
		}
		
		echo '<url><loc>'.$home.'/'.esc_html($dtype).'/'.esc_html($ptype).'/'.esc_html($city).'/</loc><changefreq>daily</changefreq><priority>'.esc_html($priority).'</priority></url>';	
		}
	}
	
}
echo '</urlset>';  
ob_end_flush();
}

function category_sitemap(){ 
http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, must-revalidate, max-age=86400');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$cats = wp_cache_get( 'pbg_sitemap_cats' );
if ( false === $cats ) {
$cats = get_categories(array(
    'orderby' => 'count',
	'order' => 'DESC'
	));
wp_cache_set( 'pbg_sitemap_cats', $cats );								
}	
foreach ($cats as $cat) {
	if ($cat->parent == 0) {
		$priority = '0.9';
	} else {
		$priority = '0.5';
	}
	echo '<url><loc>'.esc_url( get_category_link( $cat->term_id ) ).'</loc><changefreq>daily</changefreq><priority>'.esc_html($priority).'</priority></url>';
};
echo '</urlset>';
ob_end_flush();
}
?>