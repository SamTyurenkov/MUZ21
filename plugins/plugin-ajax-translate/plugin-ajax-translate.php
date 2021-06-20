<?php

/*
Plugin Name: 	AJAX Translate Fields
Description:    Add translations directly from English version
Version: 		1.0
Author: 		Sam Tyurenkov
*/


/**
 * Register required scripts and styles
 *
 * @return void
 */
function pat_enqueue()
{
    $post = get_post();

    wp_register_style(
        'pat-admin-css',
        plugins_url('/css/pat.css', __FILE__) . '?v' . filemtime(plugin_dir_path(__FILE__) . '/css/pat.css'),
        false,
        null,
        'all'
    );
    wp_enqueue_style('pat-admin-css');

    wp_register_script("pat-admin-js", plugins_url('/js/pat.js', __FILE__) . '?v' . filemtime(plugin_dir_path(__FILE__) . '/js/pat.js'), array('jquery'), null, true);
    
    if($post != null) {
    wp_localize_script('pat-admin-js','localize_obj',array(
        'post_id' => $post->ID,
        'post_type' => $post->post_type
    ));
    wp_enqueue_script("pat-admin-js");
}
}

add_action('admin_enqueue_scripts', 'pat_enqueue');

/**
 * Create the user interface for the translation process
 *
 * @return void
 */
function pat_popup()
{ ?>

    <!-- Do the modal markup -->
    <div class="pat_popup">
        
        <div class="pat_popup_inner">
        <p>Changes are saved when field looses focus, so to save the field - click outside of it. If field becomes green - it's saved, if red - there was an error or something.</p>
            <button class="pat_popup_close">X</button>

            <div class="pat_popup_inputs">


            </div>
        </div>
    </div>

<?php
}


add_action('acf/input/admin_footer', 'pat_popup');

function pat_getvals()
{
    $response  = array();
    global $wpdb;

    $post_id = $_POST['post_id'];
    $post_type = $_POST['post_type'];
    $field_id = $_POST['field_id'];
    $field_name = $_POST['field_name'];
    $field_name = str_replace('acf','',$field_name);
    $field_name = str_replace('row-','',$field_name);
    $field_name = str_replace('][','-',$field_name);
    $field_name = str_replace('[','',$field_name);
    $field_name = str_replace(']','',$field_name);

    $field_parts = explode('-',$field_name);
    $field_name = '';
    foreach ($field_parts as $field) {
        if (is_numeric($field)) {
            $field_name .= $field.'_';
        } else {
            $field_meta = $wpdb->get_results( $wpdb->prepare("SELECT post_excerpt FROM {$wpdb->prefix}posts WHERE post_name = %s",$field),ARRAY_A )[0];
            //error_log(print_r($field_meta,true));
            $field_name .= $field_meta['post_excerpt'].'_';
        }
    }
    $field_name = substr($field_name, 0, -1);
    //error_log('field_name '.$field_name);
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );

    foreach($languages as $key => $value) {
        $languages[$key] = array();
        $languages[$key]['dest_post_id'] = apply_filters( 'wpml_object_id', $post_id, $post_type, FALSE, $key );
        $languages[$key]['dest_field_id'] = $field_id;
        $languages[$key]['dest_field_name'] = $field_name;
        $languages[$key]['field_val'] = get_post_meta($languages[$key]['dest_post_id'],$field_name,true);
        //$languages[$key]['field_val'] = get_field($field_id,$languages[$key]['dest_post_id']);
    }

    echo json_encode($languages);
    wp_die();
}

add_action('wp_ajax_pat_getvals', 'pat_getvals');

function pat_setvals()
{
    $response  = array();

    $dest_post_id = $_POST['dest_post_id'];
    $dest_field_id = $_POST['dest_field_id'];
    $dest_field_name = $_POST['dest_field_name'];
    $dest_val  = $_POST['dest_val'];

    //$response['result'] = update_field($dest_field_name,$dest_val,$dest_post_id);
    $response['result'] = update_post_meta($dest_post_id,$dest_field_name,$dest_val);
    echo json_encode($response);
    wp_die();
}

add_action('wp_ajax_pat_setvals', 'pat_setvals');
