<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php
	
	define( 'OPTIONS_SLUG', 'asp' );
	define( 'LANGUAGE_SLUG', 'asp' );
		
		add_filter( 'intermediate_image_sizes_advanced', 'asp_default_images' ); // REMOVE DEFAULT IMAGE SIZES 		
		add_filter( 'show_admin_bar', '__return_false'); //DO NOT DISPLAY ADMIN BAR
		add_filter( 'send_email_change_email', '__return_false' ); //DO NOT SEND EMAILS ABOUT EMAIL CHANGE
		add_action( 'admin_init', 'baw_no_admin_access', 1 ); //ADMIN ACCESS FOR ADMIN OR AJAX ONLY
		add_filter('jpeg_quality', function($arg){return 95;}); //SET IMAGE QUALITY
		add_image_size( 'mini', 60, 60, true ); //ADD ICON IMAGE SIZE
		add_action('wp_enqueue_scripts', 'disable_gutenberg', 11); //REMOVE GUTENBERG
		add_action( 'init', 'add_taxonomy_type_property_type',0); //ADD PROPERTY TYPE TAXONOMY 
		add_action( 'init', 'add_post_type_property'); //ADD PROPERTY POST TYPE
		add_action( 'init', 'add_post_type_newsletter'); //ADD NEWSLETTER POST TYPE
		add_action( 'template_redirect', 'wpb_redirect_attachment_to_post' ); //REDIRECT ATTACHEMENTS TO POST




function stop_loading_wp_embed() {
	if (!is_admin()) {
		wp_deregister_script('wp-embed');
	}

}
add_action('init', 'stop_loading_wp_embed');

// Remove the REST API endpoint.
remove_action( 'rest_api_init', 'wp_oembed_register_route' );
 
// Turn off oEmbed auto discovery.
add_filter( 'embed_oembed_discover', '__return_false' );
 
// Don't filter oEmbed results.
remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
 
// Remove oEmbed discovery links.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
 
// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
 
// Remove all embeds rewrite rules.
add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

function disable_embeds_rewrites($rules) {
    foreach($rules as $rule => $rewrite) {
        if(false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }
    return $rules;
}

//REMOVE AUTO P IN CONTENT
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
	
//REMOVE FEEDS
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );

function get_meta($field, $id = null){
	return get_post_meta($id != '' ? $id : get_the_ID(), $field, true);
}

function print_replaces($name, $value, $replaces)
{
	if (!$value)
		return;

	foreach ($replaces as $from => $to)
		if ($from == $value)
		{
			echo '<$name>';
			echo $to;
			echo '</$name>\r\n';
			return;
		}
}

function print_meta($name, $field, $format = 'string', $default = false) {
	if (!$name)
		return;

	if (!($value = get_meta($field) ?: $default))
		return;

	if ($format == 'int')
		$value = intval(str_replace(' ', '', $value));
	elseif ($format == 'float')
		$value = floatval(str_replace(' ', '', $value));

	if (!$value)
		return;

	printf('<%s>%s</%s>', $name, $value, $name);
}

		
function itsme_disable_feed() {	
http_response_code(404);
status_header( 404 );
die();
}

		remove_all_actions( 'category_feed_link' );
		remove_all_actions( 'post_feed_link' );
		remove_all_actions( 'page_feed_link' );
		remove_all_actions( 'archive_feed_link' );
		remove_all_actions( 'do_feed' );
		remove_all_actions( 'do_feed_rdf' );
		remove_all_actions( 'do_feed_rss' );
		remove_all_actions( 'do_feed_rss2' );
		remove_all_actions( 'do_feed_atom' );
		remove_all_actions( 'do_feed_rss2_comments' );
		remove_all_actions( 'do_feed_atom_comments' );
		
	add_action('category_feed_link', 'itsme_disable_feed');
	add_action('post_feed_link', 'itsme_disable_feed');
	add_action('page_feed_link', 'itsme_disable_feed');
	add_action('archive_feed_link', 'itsme_disable_feed');

	add_action('do_feed', 'itsme_disable_feed', 1);
	add_action('do_feed_rdf', 'itsme_disable_feed', 1);
	add_action('do_feed_rss', 'itsme_disable_feed', 1);
	add_action('do_feed_rss2', 'itsme_disable_feed', 1);
	add_action('do_feed_atom', 'itsme_disable_feed', 1);
	add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
	add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);	
	
	
	// Remove default image sizes here. 
	function asp_default_images( $sizes ) {
	unset( $sizes['medium_large']); // 768px
	unset( $sizes['1536x1536']);
	unset( $sizes['2048x2048']);
	return $sizes;
	}
	
	function disable_gutenberg() {
		if (!is_admin()) wp_dequeue_style( 'wp-block-library' );
	}
	
	function baw_no_admin_access() {
		if( !current_user_can( 'administrator' ) && !wp_doing_ajax()  ) {
		wp_redirect( home_url() );
		die();
		} 
	}
	
	//FIX DUPLICATE SUBCATEGORY URLS
	add_action( 'template_redirect', function() {
    if ( is_category() ) {      
        $term = get_queried_object();

        if ( isset( $term->parent ) && $term->parent ) {
            global $wp;

            $request_url = trailingslashit( get_site_url( get_current_blog_id(), $wp->request ) );
            $link = get_term_link( $term );

            if ( ! is_wp_error( $link ) ) {
                if ( strpos( $request_url, trailingslashit( $link ) ) !== 0 ) {
                    wp_safe_redirect( $link, 301 ); 
                }                   
            }
        }
    }
	} );
	
	
	function wpb_redirect_attachment_to_post() { 
	if ( is_attachment() ) { 
	global $post;
	if( empty( $post ) ) $post = get_queried_object();  
	if ($post->post_parent)  {
    $link = get_permalink( $post->post_parent );
    wp_redirect( $link, '301' );
    exit(); 
    }
	else    {
    // What to do if parent post is not available
    wp_redirect( home_url(), '301' );
    exit(); 
    }
	}
	}

	function resources_cpt_generating_rule($wp_rewrite) {
    $wp_rewrite->add_rewrite_tag( "%city%", '(.+?)', "city=" );
	$wp_rewrite->add_rewrite_tag( "%dtype%", '(.+?)', "dtype=" );
	$wp_rewrite->add_rewrite_tag( "%ptype%", '(.+?)', "ptype=" );


	$rules['blog$'] = 'index.php?taxonomy=category&term=blog';
	$rules['news$'] = 'index.php?taxonomy=category&term=news';
	$rules['(posutochno-snyat|kupit|snyat|sdelki)/([^/]*)/([^/]*)/([^/]*)$'] = 'index.php?post_type=property&dtype=$matches[1]&ptype=$matches[2]&city=$matches[3]&p=$matches[4]';
	$rules['(posutochno-snyat|kupit|snyat)/([^/]*)/([^/]*)$'] = 'index.php?taxonomy=property-type&term=$matches[1]&ptype=$matches[2]&city=$matches[3]';
	$rules['(posutochno-snyat|kupit|snyat)/([^/]*)$'] = 'index.php?taxonomy=property-type&term=$matches[1]&ptype=$matches[2]';
	$rules['(posutochno-snyat|kupit|snyat)$'] = 'index.php?taxonomy=property-type&term=$matches[1]';
	$rules['([^/]*)$'] = 'index.php?pagename=$matches[1]';
		
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
	}
	///////////////////////////////////
	add_filter('generate_rewrite_rules', 'resources_cpt_generating_rule');
	
	
	
	function change_link( $permalink, $post ) {	 
	
    if( $post->post_type == 'property') {
		
	$cats = get_the_terms( $post, 'property-type' );
	$cats2array = Array();
	

	foreach ($cats as $cat) {
	if (preg_match('/(kupit|posutochno-snyat|snyat)/i', $cat->slug) == 1) {
		$dtype = $cat->slug;
	} else if (preg_match('/(dom|kvartira|nezhiloe|uchastok|komnata|hotel|koikomesto)/i', $cat->slug) == 1) {
		$ptype = $cat->slug;
	}
	}
	$city = get_post_meta($post->ID, 'locality-name', true); 
	
	if (empty($dtype)) $dtype = 'sdelki';
	if (empty($ptype)) $ptype = 'nedvizhimost';
	if (empty($city)) $city = 'russia';
	
		$cyr = [
            'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я',' '
        ];
        $lat = [
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','','e','yu','ya',
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','','e','yu','ya','-'
        ];
        $city = str_replace($cyr, $lat, $city);
	
	if ($dtype && $ptype && $city) {
	$permalink = get_home_url() . "/" . $dtype . "/" . $ptype . "/" . $city . "/" . $post->ID . "/";
	}
        
    } 
		
    return $permalink;
	}
	////////////////////////
	add_filter('post_type_link',"change_link",10,2);


	function change_term_link( $permalink, $term, $taxonomy ) {

	if($taxonomy == 'property-type') {
	$city = get_query_var( 'city' );
	$ptype = get_query_var( 'ptype' );	

	if(in_array($term->slug,array('kupit','posutochno-snyat','snyat')) && $ptype && $city) {
        $permalink = get_home_url() . "/" .$term->slug ."/". $ptype . "/" . $city ."/";
	} else if (in_array($term->slug,array('kupit','posutochno-snyat','snyat')) && $ptype){
		$permalink = get_home_url() . "/" .$term->slug ."/". $ptype . "/";
	} else if (in_array($term->slug,array('kupit','posutochno-snyat','snyat'))) {
		$permalink = get_home_url() . "/" .$term->slug ."/";
	} else {
	global $wp_query;
    $wp_query->set_404();
    status_header(404);
	}
	}

	if($taxonomy == 'category') { 
		$permalink = get_home_url() . "/" .$term->slug."/";
    }


    return $permalink;
	}
	add_filter( 'term_link', 'change_term_link', 10, 3 );
	
	function asp_register_query_vars( $vars ) {
	$vars[] = 'dtype';
	$vars[] = 'city';
	$vars[] = 'ptype';
	$vars[] = 'xkey';
	return $vars;
	}
	add_filter( 'query_vars', 'asp_register_query_vars' );
	
	
	function add_taxonomy_type_property_type() {	
			
	$worklabels = array(
		'name'              => __( 'Property Type', 'asp' ),
		'singular_name'     => __( 'Type', 'asp' ),
		'search_items'      => __( 'Search Type', 'asp' ),
		'all_items'         => __( 'All Type', 'asp' ),
		'parent_item'       => __( 'Parent Type', 'asp' ),
		'parent_item_colon' => __( 'Parent Type:', 'asp' ),
		'edit_item'         => __( 'Edit Type', 'asp' ),
		'update_item'       => __( 'Update Type', 'asp' ),
		'add_new_item'      => __( 'Add New Type', 'asp' ),
		'new_item_name'     => __( 'New Type Name', 'asp' ),
	);

	register_taxonomy( 'property-type', array( 'property' ), array(
		'hierarchical' => true, 
		'labels'       => $worklabels,
		'show_ui'      => true,
		'query_var'    => true,
		'show_in_rest' => true,
		'rewrite' => array(
		'slug' => '/',
		'with_front' => FALSE,
		)
	) );	
		
	}
	
	function add_post_type_property() {
		
	register_post_type( 'property',
	array(
	'label' => null,
	 'taxonomies' => array('property-type'),
		'labels' => array(
			'name'               => 'Объект', // основное название для типа записи
			'singular_name'      => 'Объект', // название для одной записи этого типа
			'add_new'            => 'Добавить объект', // для добавления новой записи
			'add_new_item'       => 'Добавление объектов', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование объекта', // для редактирования типа записи
			'new_item'           => 'Новый объект', // текст новой записи
			'view_item'          => 'Смотреть объект', // для просмотра записи этого типа.
			'search_items'       => 'Искать объект', // для поиска по этим типам записи
			'not_found'          => 'Не найдено объектов по запросу', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'menu_name'          => 'Объекты', // название меню
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'has_archive'        => false,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'exclude_from_search' => null, // зависит от public
		'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
		'show_in_nav_menus'   => null, // зависит от public
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_icon'           => null, 
		'menu_position' => 6,
		'supports' => array(
		'custom-fields',
		'title',
		'thumbnail',
		'comments',
		'author',
		'editor')
		)
	);
	}
	
		function add_post_type_newsletter() {
		
	register_post_type( 'newsletter',
	array(
	'label' => null,
			'labels' => array(
			'name'               => 'Newsletter', // основное название для типа записи
			'singular_name'      => 'Newsletter', // название для одной записи этого типа
			'add_new'            => 'Add Newsletter', // для добавления новой записи
			'add_new_item'       => 'Добавление Newsletter', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование Newsletter', // для редактирования типа записи
			'new_item'           => 'Новый Newsletter', // текст новой записи
			'view_item'          => 'Смотреть Newsletter', // для просмотра записи этого типа.
			'search_items'       => 'Искать Newsletter', // для поиска по этим типам записи
			'not_found'          => 'Не найдено объектов по запросу', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'menu_name'          => 'Newsletters', // название меню
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'has_archive'        => false,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'exclude_from_search' => null, // зависит от public
		'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
		'show_in_nav_menus'   => null, // зависит от public
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_icon'           => null, 
		'menu_position' => 6,
		'supports' => array(
		'custom-fields',
		'title',
		'thumbnail',
		'comments',
		'author',
		'editor')
		)
	);
	}


// Yandex.Realty RSS
add_action('init', 'AddUserXmls');
function AddUserXmls(){

$authors = get_users([ 'role__in' => [ 'author', 'administrator','editor' ] ]);
foreach ($authors as $author) {
    $id = $author->ID;

        add_feed('yandex-'.$id, function() use($id) {
			set_query_var( 'uid', $id );
            get_template_part('feeds', 'yandex');
        });

		add_feed('avito-'.$id, function() use($id) {
			set_query_var( 'uid', $id );
            get_template_part('feeds', 'avito');
        });
		
		add_feed('cian-'.$id, function() use($id) {
			set_query_var( 'uid', $id );
            get_template_part('feeds', 'cian');
        });

    
}
flush_rewrite_rules();
}