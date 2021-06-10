<?php

namespace Core;

class Helpers
{
    //HELPERS FOR EXTERNALS METHODS
    function curlCheck()
    {
        return function_exists('curl_version');
    }

    function ucfirst($str)
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc . mb_substr($str, 1);
    }

    //CHECK IF CLIENT IS ON MOBILE DEVICE
    function wp_is_mobile()
    {
        static $is_mobile;

        if (isset($is_mobile))
            return $is_mobile;

        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $is_mobile = false;
        } elseif (
            strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        ) {
            $is_mobile = true;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
            $is_mobile = true;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }

        return $is_mobile;
    }

    //CHECK IF POST HAS ATTACHEMENTS
    function property_attachments($post)
    {

        $attachments = get_posts(array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $post->ID,
            'exclude'     => get_post_thumbnail_id()
        ));
        return $attachments;
    }

    //ACF OPTIONS GET FIELD CHOICES
    function get_field_choices($field_name, $multi = false)
    {
        $results = array();
        foreach (get_posts(array('post_type' => 'acf-field', 'posts_per_page' => -1)) as $acf) {
            if ($acf->post_excerpt === $field_name) {
                $field = unserialize($acf->post_content);
                if (isset($field['choices'])) {
                    if (!$multi) return $field['choices'];
                    else $results[] = $field;
                }
            }
        }
        return $results;
    }
}
?>