<?php
$attr = get_query_var('block-attr');
array_key_exists('bannerside',$attr) ? $bannerclass = $attr['bannerside'] . "side sidebanner" : $bannerclass = "leftside sidebanner";
array_key_exists('mediaUrl',$attr) ? $bannerimage = $attr['mediaUrl'] : $bannerimage = '';
array_key_exists('title',$attr) ? $title = $attr['title'] : $title = '';
array_key_exists('subtitle',$attr) ? $subtitle = $attr['subtitle'] : $subtitle = '';
?>

<div class="section">
    <div class="<?php echo esc_attr($bannerclass); ?>" style="background-image:url(<?php echo esc_attr($bannerimage); ?>)"></div>
    <div class="sidecontent">
        <h2><?php echo esc_html($title); ?></h2>
        <p><?php echo esc_html($subtitle); ?></p>
    </div>
</div>