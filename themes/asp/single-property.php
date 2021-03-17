<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $post;
get_header();
$attachments = property_attachments($post);
if ($attachments) $index = count($attachments);
$options = property_options($post);
$title = get_the_title();
$author_id = $post->post_author;
$curuser = get_current_user_id();
$phone = get_the_author_meta('user_phone',$author_id);
$editors = explode(',', get_the_author_meta('editors',$author_id));
array_push($editors, $author_id); 
$editors = array_filter(array_unique($editors));
?>
<div id="video_container">
<div class="youtube_controls">
<div id="hideyoutubevideo" onclick="hideyoutubevideo()">X</div>
</div>
<div id="youtubevideo"></div>
</div>
<div class="container stickymenu transparentmenu" style="height:60px">
<?php get_template_part('templates/topmenu'); ?>
</div>
<div class="splide">
<div class="splide__arrows">
		<button class="button splide__arrow splide__arrow--prev">
			< Назад
		</button>
		<button class="button splide__arrow splide__arrow--next">
			Вперед >
		</button>
	</div>
<div class="splide__track">
<div class="splide__list pslider">
<?php 
				if (my_wp_is_mobile()) {
					$slidersize = 'medium'; $max = 3; 
				}
				else {
					$slidersize = 'large'; $max = 6;
				}		
				if(has_post_thumbnail()) {
					$src = get_the_post_thumbnail_url( null, $slidersize );
					echo '<img class="splide__slide psliderimg" src="'.esc_url($src).'" style="display:inline-block" title="'.esc_attr($title).', главное фото" alt="'.esc_attr($title).', главное фото">';
				};
				
                if ($attachments) {
				$i = 0;
                    while($index) {	
						$src = wp_get_attachment_image_src( $attachments[--$index]->ID, $slidersize)[0];
						if ($i < $max) {
							echo '<img class="splide__slide psliderimg" data-splide-lazy="'.esc_url($src).'" style="display:inline-block" title="'.esc_attr($title).', фото '.esc_attr($i+1).'" alt="'.esc_attr($title).', фото '.esc_attr($i+1).'">';
						}
						else {
							echo '<img class="splide__slide psliderimg" data-splide-lazy="'.esc_url($src).'" style="display:inline-block" title="'.esc_attr($title).', фото '.esc_attr($i+1).'" alt="'.esc_attr($title).', фото '.esc_attr($i+1).'">';						
						}
						$i++;
                    }

                } else {
					echo '<div class="psliderimg" style="background: #bbb;width:100%"></div>';
				}
?>
</div>
</div>
</div>
<div class="container" style="height:50px;padding: 10px 0;">
<div class="pslidercontrols"> 

<!--SHOW COUNT OF IMAGES ON DESKTOP ONLY-->
<?php if (!my_wp_is_mobile() && $attachments) { 
echo '<div class="pslidercount" onclick="slidernext()"><i class="icon-picture"></i> <span class="photocount">'.esc_html($i+1).' Фото</span></div>'; 
}; ?>
<?php if (get_post_meta($post->ID,'youtube-video',true)) : ?>
<div class="pslidercount" onclick="showyoutubevideo()"><i class="icon-youtube-play"></i> <span>Видео</span></div>

<script>
function showyoutubevideo() {
document.getElementById('video_container').style.opacity = 1;
document.getElementById('video_container').style.zIndex = 99999;
if(document.querySelector('.youtube-script') == undefined);
var tag = document.createElement('script');
tag.classList.add('youtube-script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}
function hideyoutubevideo() {
document.getElementById('video_container').style.opacity = 0;
document.getElementById('video_container').style.zIndex = -99999;
}


function onYouTubeIframeAPIReady() {
	var player;
  	var framer = document.getElementById("youtubevideo");
	var fwidth = document.getElementById("youtubevideo").clientWidth;
	var fheight = (fwidth / 16 * 9)+'px';
	framer.parentElement.style.height = fheight;
	framer.style.height = fheight;
  player = new YT.Player('youtubevideo', {
    videoId: '<?php echo esc_html(get_post_meta($post->ID,"youtube-video",true));?>',
    playerVars: {
	  enablejsapi: 1,
      autoplay: 1, 
      controls: 1,
	  width: fwidth,
	  height: fheight,
      showinfo: 1,
      modestbranding: 1,
      loop: 1,     
      fs: 1,   
      cc_load_policy: 0, 
      iv_load_policy: 3,  
      autohide: 0, 
	  origin: 'https://asp.sale',
	  playsinline: 1,
	  rel: 0
    },
    events: {
      onReady: function(e) {
        e.target.mute();
		e.target.playVideo();
      },
	  onStateChange: function(e) {
		 // e.target.playVideo();
	  }
    }
  });  
 }
</script>
<?php endif; ?>


<?php if (is_user_logged_in() && ( in_array($curuser, $editors) || current_user_can('edit_others_posts'))) { ?>
<div class="pslidercount" onclick="loadeditor(1)">
<i class="icon-cog"></i> <span>Редактировать</span>
</div>
<div class="pslidercount" onclick="loadeditor(3)">
<i class="icon-link-ext"></i> <span>Выгрузки</span>
</div>
<?php }; ?>

<a id="callclick" href="tel:<?php echo esc_html($phone); ?>" onclick="ym(62533903,'reachGoal','callclick')" class="pslidercount">
<i class="icon-whatsapp"></i> <span><?php echo esc_html($phone); ?></span>
</a>

<a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="pslidercount" >
<i class="icon-address-card-o"></i><span> <?php echo esc_html(get_the_author_meta( 'display_name', $author_id )); ?></span>
</a>

</div>
<script type="text/javascript">
document.getElementById("callclick").addEventListener('click',function() {
	var cid = uuid();

	var time = new Date(Date.now());
	var nonce = Math.floor((time.getTime()/1000)).toString(); 
	var ajaxurl = 'https://www.google-analytics.com/collect?v=1&tid=UA-55186923-1&cid='+cid+'&t=event&ec=click&ea=phonenumber&z='+nonce;  
	var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,		
		}, true);
  });
</script>
</div>

<?php while ( have_posts() ) : the_post(); ?>
<div class="container singlecontent">

<div class="psidebar">

<?php 
                if ( $options ) {
					
                    foreach ( $options as $option ) {	
					echo '<div class="option">'.$option.'</div>';
                    }

                }
?>
</div>

<?php
$linkparts = explode("/",get_permalink());
$deallink = $linkparts[3];
$proplink = $linkparts[3].'/'.$linkparts[4];
$citylink = $linkparts[3].'/'.$linkparts[4].'/'.$linkparts[5];
switch($linkparts[3]) {
	case 'kupit':
	if(strtotime('-12 months') > get_post_modified_time()) {
		echo '<div class="maybeold">Объявление было обновлено '; the_modified_date( 'd.m.Y' ); echo '. Возможно оно устарело.</div>';
	}
	break;
	case 'snyat':
	if(strtotime('-1 months') > get_post_modified_time()) {
		echo '<div class="maybeold">Объявление было обновлено '; the_modified_date( 'd.m.Y' ); echo '. Возможно оно устарело.</div>';
	}
	break;
}
?>

<div class="pcontent">

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div class="row">

					<h1 class="entry-title"><?php the_title(); ?></h1>

		</div>

<?php 

switch($linkparts[3]) {
case 'kupit':
	$dealtitle = 'Купить';
	break;
case 'snyat':
	$dealtitle = 'Долгосрочно Снять';
	break;
case 'posutochno-snyat':
	$dealtitle = 'Посуточно Снять';
	break;
}

switch($linkparts[4]) {
case 'kvartira':
	$typetitle = 'Квартиру';
	break;
case 'dom':
	$typetitle = 'Дом';
	break;
case 'komnata':
	$typetitle = 'Комнату';
	break;
case 'koikomesto':
	$typetitle = 'Койко-место';
	break;
case 'nezhiloe':
	$typetitle = 'Нежилое Помещение';
	break;
case 'uchastok':
	$typetitle = 'Участок';
	break;
case 'hotel':
	$typetitle = 'Номер в Отеле';
	break;
case 'novostrojka':
	$typetitle = 'Квартиру в Новостройке';
	break;
default:
	$typetitle = 'Недвижимость';
	break;
}	

switch($linkparts[5]) {
case 'sochi':
	$citytitle = 'Сочи';
	break;
case 'moskva':
	$citytitle = 'Москва';
	break;
case 'sankt-peterburg':
	$citytitle = 'Санкт-Петербург';
	break;
case 'tolyatti':
	$citytitle = 'Тольятти';
	break;
case 'pskov':
	$citytitle = 'Псков';
	break;
case 'orenburg':
	$citytitle = 'Оренбург';
	break;
case 'penza':
	$citytitle = 'Пенза';
	break;	
}

$brcms = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/"><span itemprop="name">ASP</span></a><meta itemprop="position" content="1" /></span> > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$deallink.'/"><span itemprop="name">'.$dealtitle.'</span></a><meta itemprop="position" content="2" /></span> > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$proplink.'/"><span itemprop="name">'.$typetitle.'</span></a><meta itemprop="position" content="3" /></span> > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$citylink.'/"><span itemprop="name">'.$citytitle.'</span></a><meta itemprop="position" content="4" /></span> > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.get_permalink().'"><span itemprop="name">'.mb_substr(get_the_title(),0,60,'UTF-8').'...</span></a><meta itemprop="position" content="5" /></span></div>';
echo $brcms; 
?>


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
								//	$texta = str_replace('</div><li>','</div><ul><li>',get_the_content());
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
<?php 
 get_template_part('templates/sharer'); 
?>
</div>

</div>
<?php if (is_user_logged_in() && ( in_array($curuser, $editors) || current_user_can('edit_others_posts'))) {
get_template_part('templates/vigruzki'); 
get_template_part('templates/editpost'); 
 }; ?>
<script type="text/javascript">  
<?php if (!my_wp_is_mobile()) { ?>
var slider = document.querySelector('.pslider');     
function lazyLoad() {
	var lazy = document.querySelectorAll('.lazy');
	if(lazy) {
	for (var j = 0; j < lazy.length; j++) {

	lazy[j].src = lazy[j].dataset.src;
	lazy[j].classList.remove('lazy');
	lazy[j].removeAttribute('data-src');
	lazy[j].style.display = 'block';
	}
	}
}

<?php } else { ?>
var slider = document.querySelector('.pslider');  

function lazyLoad() {
	var lazy = document.querySelectorAll('.lazy');
	if(lazy) {
	for (var j = 0; j < lazy.length; j++) {

	lazy[j].src = lazy[j].dataset.src;
	lazy[j].classList.remove('lazy');
	lazy[j].removeAttribute('data-src');
	
	}
	}
}
<?php }; ?>
</script>
<div class="empty2"></div>
					<footer>
<?php endwhile; get_footer(); ?>
					</footer>
				
	
</body>
</html>