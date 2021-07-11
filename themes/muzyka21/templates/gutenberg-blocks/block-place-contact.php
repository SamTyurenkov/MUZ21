<?php
$post_id = get_query_var('post_id');
$residents = get_field('residents', $post_id);

?>
<div class="place-contact">
    <div class="container">
        <h2><?php echo get_field('title'); ?></h2>
        <p><?php echo get_field('subtitle'); ?></p>
        <img class="shape2" src="<?php echo get_template_directory_uri() . '/images/shapes/shape2.svg'; ?>">
        <div class="place-contact_flex">


            <div class="socials">
                <?php
                $socials = get_field('socials', $post_id);
                foreach ($socials as $key => $link) {
                    if ($link) : ?>
                        <a href="<?php echo esc_attr($link); ?>" target="_blank">
                            <img src="<?php echo esc_attr(get_template_directory_uri()); ?>/images/socials/<?php echo esc_attr($key); ?>.svg">
                        </a>
                <?php endif;
                }
                ?>

            </div>
            <?php $contacts = get_field('contacts', $post_id); ?>
            <p class="address">
                <?php echo esc_html($contacts['address']); ?>
            </p>
            <p class="phone">
              <?php echo esc_html($contacts['phone']); ?>
            </p>
        </div>
        <img class="shape3" src="<?php echo get_template_directory_uri() . '/images/shapes/shape5.svg'; ?>">
        <img class="shape3" style="left:200px;max-width:50px" src="<?php echo get_template_directory_uri() . '/images/shapes/shape2.svg'; ?>">
        <img class="shape3" style="left:250px" src="<?php echo get_template_directory_uri() . '/images/shape_logo.svg'; ?>">
    </div>
</div>