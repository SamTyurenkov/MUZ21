<div class="wavefix">
    <?php 
    $class = get_field('waveclass');

    if($class == 'start') : ?>
    <img class="wavestart" src="<?php echo get_template_directory_uri() . '/images/wave2start.svg'; ?>">
    <?php elseif ($class == 'end') : ?>
    <img class="wavesend" src="<?php echo get_template_directory_uri() . '/images/waveend_pinkier.svg'; ?>">
    <?php elseif ($class == 'end2') : ?>
    <img class="wavesend" src="<?php echo get_template_directory_uri() . '/images/wave2end.svg'; ?>">
    <?php endif; ?>
</div>