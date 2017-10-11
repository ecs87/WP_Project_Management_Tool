<?php
/*
GENERAL FUNCTIONS!
*/

// returns well formed URL
function correct_url($address)
{
    if (!empty($address) AND $address{0} != '#' AND 
    strpos(strtolower($address), 'mailto:') === FALSE AND 
    strpos(strtolower($address), 'javascript:') === FALSE)
    {
        $address = explode('/', $address);
        $keys = array_keys($address, '..');

        foreach($keys AS $keypos => $key)
            array_splice($address, $key - ($keypos * 2 + 1), 2);
        $address = implode('/', $address);
        $address = str_replace('./', '', $address);
        $scheme = parse_url($address);
        if (empty($scheme['scheme']))
            $address = 'http://' . $address;
        $parts = parse_url($address);
        $address = strtolower($parts['scheme']) . '://';
        if (!empty($parts['user']))
        {
            $address .= $parts['user'];
            if (!empty($parts['pass']))
                $address .= ':' . $parts['pass'];
            $address .= '@';
        }
        if (!empty($parts['host']))
        {
            $host = str_replace(',', '.', strtolower($parts['host']));
            if (strpos(ltrim($host, 'www.'), '.') === FALSE)
                $host .= '.com';
            $address .= $host;
        }
        if (!empty($parts['port']))
            $address .= ':' . $parts['port'];
        $address .= '/';

        if (!empty($parts['path']))
        {
            $path = trim($parts['path'], ' /\\');
            if (!empty($path) AND strpos($path, '.') === FALSE)
                $path .= '/';
            $address .= $path;
        }
        if (!empty($parts['query']))
            $address .= '?' . $parts['query'];
        return $address;
    }
    else
        return FALSE;
}

// returns preformatted var dump
function var_viewer( $variable ) {
	echo '<pre>';
	print_r($variable);
	echo '</pre>';
}

// content loading in ajax? 
function is_ajax() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest");
}

// array_multisort variant
function array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;
}

function is_blog() {
	if (is_home() || is_singular('post') || is_post_type_archive('post'))
		return true;
	else return false;
}

/*
// gallery hack
add_filter('wp_get_attachment_link', 'ecs87_gallery_hack', 10, 4);
function ecs87_gallery_hack($content, $post_id, $size, $permalink) {
	if(!$permalink){
		global $post;
		$image = wp_get_attachment_image_src($post_id, 'large');
		$attachment = get_post( $post_id );
		//$title = $attachment->post_title;
		$caption = $attachment->post_content;		
		//$new_content = preg_replace('/href=\'(.*?)\'/', 'href="' . $image[0] . '" rel="gallery-' . $title . '" title="'. $title .' : '.$caption. '" class="fancybox"', $content);
		$new_content = preg_replace('/href=\'(.*?)\'/', 'href="' . $image[0] . '" rel="fancy-gallery" title="'.$caption. '" class="fancybox"', $content);
		return $new_content;
	}
	return $content;
}
*/