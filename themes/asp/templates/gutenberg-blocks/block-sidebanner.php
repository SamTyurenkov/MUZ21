<?php
$attr = get_query_var('block-attr');
$bannerclass = $attr['bannerside'] . "side sidebanner";
$bannerimage = $attr['mediaUrl'];
?>

<div class="section">
    <div class="<?php echo esc_attr($bannerclass); ?>" style="background-image:url(<?php echo esc_attr($bannerimage); ?>)"></div>
    <div className="sidecontent">
        <h2><?php echo esc_html($attr['title']); ?></h2>
        <p><?php echo esc_html($attr['subtitle']); ?></p>
    </div>
</div>