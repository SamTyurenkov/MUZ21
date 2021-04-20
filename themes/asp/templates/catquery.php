<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php 
$taxonomy = get_queried_object();
$singletitle = single_term_title('',false);
$cit = get_query_var( 'city' );
$ptype = get_query_var( 'ptype' );	
$brcms = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/"><span itemprop="name">ASP</span></a><meta itemprop="position" content="1" /></span>';
$brcms .= ' > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy->slug.'/"><span itemprop="name">'.$singletitle.'</span></a><meta itemprop="position" content="2" /></span>';
$title = '';
$typetitle = 'Недвижимость';
if (!empty($ptype)) {
	
switch($ptype) {
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
	$brcms .= ' > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy->slug.'/nedvizhimost/"><span itemprop="name">'.$typetitle.'</span></a><meta itemprop="position" content="3" /></span>';
	break;
}	
if($typetitle != 'Недвижимость')
$brcms .= ' > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy->slug.'/'.$ptype.'/"><span itemprop="name">'.$typetitle.'</span></a><meta itemprop="position" content="3" /></span>';
}
if (!empty($cit) && array_key_exists($cit,CityManager::getCities())) {
		$citytitle = CityManager::getCityBySlug($cit);
		$title = $citytitle.' - ';
		$brcms .= ' > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy->slug.'/'.$ptype.'/'.$cit.'/"><span itemprop="name">'.$city.'</span></a><meta itemprop="position" content="4" /></span>';	
} else {
	$citytitle = 'empty';
}
$title .= $singletitle.' '.$typetitle;
?>

<div class="row category">
<h1 class="homeh2"><?php echo esc_html($title); ?> </h1>

<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
<?php echo $brcms; ?>
</div>

<div class="container" style="text-align:center">
<?php 
if($ptype) {
$curterm = get_term_by( 'slug', $ptype, 'property-type' );
} else {
$curterm = $taxonomy;
}
echo term_description( $curterm );
?>
</div>

<div class="selector container" id="filters">

<div class="custom-select" id="querycity">
<select>
  <option value="empty" selected="selected">Город</option>
  <?php
foreach (CityManager::getImportantCities() as $slug => $value) {
	echo '<option value="'.$value.'">'.$value.'</option>';
}
?>
</select>
</div>
<div class="custom-select" id="querytype">
<select>
  <option value="empty" selected="selected">Тип недвижимости</option>
  <option value="kvartira">Квартира</option>
  <option value="dom">Дом</option>
  <option value="komnata">Комната</option>
  <option value="nezhiloe">Нежилое</option>
  <option value="uchastok">Участок</option>
  <option value="hotel">Отель</option>
  <option value="novostrojka">Новостройка</option>
  <option value="koikomesto">Койко-место</option>
</select>
</div>
<div class="custom-select" id="querysort">
<select>
  <option value="empty" selected="selected">Сортировка</option>
  <option value="date">Новые</option>
  <option value="price">По цене</option>
</select>
</div>

</div>
</div>
<script type="text/javascript">
function populate_query_fields() {
	var city = '<?php if (!empty($citytitle)) echo esc_html($citytitle); ?>';
	var ptype = '<?php if (!empty($ptype)) echo esc_html($ptype); ?>';
	
	if (ptype != '' && ptype != 'nedvizhimost') document.getElementById('querytype').getElementsByTagName("select")[0].value = ptype;
	if (city != 'empty') document.getElementById('querycity').getElementsByTagName("select")[0].value = city;
}
populate_query_fields();
</script>

<div class="categories2 container">
      
</div>
<div class="button loadprops"><i class="icon-plus"></i> Загрузить еще</div>
<script type="text/javascript">

</script>