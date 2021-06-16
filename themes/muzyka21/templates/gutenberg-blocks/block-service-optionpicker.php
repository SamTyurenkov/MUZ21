<?php
$service_variations = get_field('service_variations', get_the_ID());
//print_r($service_variations);
?>
<div class="muzservicepicker">
    <div class="container">
        <div class="muzservicepicker_flex">
            <?php foreach ($service_variations as $sv) : ?>
                <div class="muzservicepicker_flex_el">
                    <div class="muzservicepicker_flex_image">
                        <img src="<?php echo esc_attr($sv['image']['url']); ?>" alt="<?php echo esc_attr($sv['image']['aly']); ?>">
                    </div>
                    <div class="muzservicepicker_flex_text">
                        <h2><?php echo esc_html($sv['title']); ?></h2>
                        <p><?php echo esc_html($sv['description']); ?></p>
                    </div>
                    <div class="muzservicepicker_flex_price">
                    </div>
                    <div class="muzservicepicker_flex_providers">
                        <?php foreach ($sv['providers'] as $prov) : ?>
                            <div class="muzservicepicker_flex_providers_prov">
                                <?php echo $prov['user_avatar']; ?>
                                <?php echo $prov['display_name']; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="muzservicepicker_nav">
            <?php foreach ($service_variations as $sv) : ?>
                <div class="muzservicepicker_nav_el">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>