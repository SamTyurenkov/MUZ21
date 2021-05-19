<?php
$attr = get_query_var('block-attr');
?>
<div class="justbanner" style="background-image:url(<?php echo esc_attr($attr['mediaUrl']); ?>);">
</div>