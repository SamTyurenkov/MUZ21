<?php
$attr = get_query_var('block-attr');
?>
<div class="section">
<h2><?php echo esc_html($attr['title']); ?></h2>
<p><?php echo esc_html($attr['subtitle']); ?></p>
<?php //echo esc_html($attr['image']); ?>
</div>