<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function str_split_unicode($str, $length = 1) {
    $tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
    if ($length > 1) {
        $chunks = array_chunk($tmp, $length);
        foreach ($chunks as $i => $chunk) {
            $chunks[$i] = join('', (array) $chunk);
        }
        $tmp = $chunks;
    }
    return $tmp;
}

function synonimizer() {
if (current_user_can('administrator') == false) exit_ajax('Need admin rights');
if (!wp_verify_nonce( $_GET["nonce"], "_edit_blog")) exit_ajax('Nonce is shit');
if (!is_numeric($_GET['id'])) exit_ajax('Give me ID');

    header('Content-Type: application/json');  
	$response = array();

$syns = array();
$text = str_split_unicode(get_the_content( null, false, $_GET['id'] ),5000);
foreach ($text as $textchunk) {

    $post = [
    'method' => 'getSynText',
    'text' => $textchunk,
 //   'backLight' => 1, // не обязательный параметр, если передан то будет включена подсветка слов

    ];
    $ch = curl_init('https://rustxt.ru/api/index.php');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-Requested-With: XMLHttpRequest",
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $resutl_syn = curl_exec($ch);
    curl_close($ch);
    $syn = json_decode($resutl_syn, true);
	$syns[] = $syn['modified_text'];

}
	$synstring = implode("", $syns);

	$response['synstring'] = $synstring;
    echo json_encode( $response );  
	die();	
}

add_action('wp_ajax_synonimizer', 'synonimizer');