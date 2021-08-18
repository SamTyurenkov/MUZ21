<div class="single-in-list-purchase">
<div class="single-in-list-purchase_id single-in-list-purchase_el"><b>Номер заказа:</b><br><?php the_ID(); ?></div>
<div class="single-in-list-purchase_user single-in-list-purchase_el"><b>Покупатель:</b><br><?php the_field('buyer'); ?></div>
<div class="single-in-list-purchase_type single-in-list-purchase_el"><b>Тип билета:</b><br><?php the_title(); ?></div>
<div class="single-in-list-purchase_price single-in-list-purchase_el"><b>Оплачено:</b><br><?php the_field('price'); ?></div>
</div>