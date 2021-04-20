<?php

class CityManager {

private static $cities = array(
    'moskva' => 'Москва',
    'spb' => 'Санкт-Петербург',
    'sochi' => 'Сочи',
    'tolyatti' => 'Тольятти',
    'penza' => 'Пенза',
    'pskov' => 'Псков',
    'orenburg' => 'Оренбург',
    'krasnodar' => 'Краснодар',
    'abinsk' => 'Абинск',
    'anapa' => 'Анапа',
    'apsheronsk' => 'Апшеронск',
    'armavir' => 'Армавир',
    'belorechensk' => 'Белореченск',
    'gelendzhik' => 'Геленджик',
    'goryachii-klyuch' => 'Горячий Ключ',
    'gulkevichi' => 'Гулькевичи',
    'eisk' => 'Ейск',
    'korenovsk' => 'Кореновск',
    'kropotkin' => 'Кропоткин',
    'krymsk' => 'Крымск',
    'kurganinsk' => 'Курганинск',
    'labinsk' => 'Лабинск',
    'novokubansk' => 'Новокубанск',
    'novorossiisk' => 'Новороссийск',
    'primorsko-ahtarsk' => 'Приморско-Ахтарск',
    'slavyansk-na-kubani' => 'Славянск-на-Кубани',
    'temryuk' => 'Темрюк',
    'timashevsk' => 'Тимашёвск',
    'tihoretsk' => 'Тихорецк',
    'ust-labinsk' => 'Усть-Лабинск',
    'hadyzhensk' => 'Хадыженск'
);

public static function getCityBySlug(string $slug = 'empty') {

    if(array_key_exists($slug,CityManager::$cities)) return CityManager::$cities[$slug];

}

public static function getCities() {

    return CityManager::$cities;

}

public static function getImportantCities() {

    global $wpdb;

    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = %s 
        AND p.post_status = %s 
        AND p.post_type = %s
    ", 'locality-name', 'publish', 'property' ) );

    return $r;
}

}
