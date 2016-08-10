<?php
add_action('publish_post', 'publish_bd_submit');
function publish_bd_submit($post_ID){
	global $post;
		$bd_submit_site = cs_get_option('i_baidu_link');
		$bd_submit_token = cs_get_option('i_baidu_key');
		if( empty($post_ID) || empty($bd_submit_site) || empty($bd_submit_token) ) return;
		$api = 'http://data.zz.baidu.com/urls?site='.$bd_submit_site.'&token='.$bd_submit_token;
		$status = $post->post_status;
		if($status != '' && $status != 'publish'){
			$url = get_permalink($post_ID);
			$ch = curl_init();
			$options =  array(
				CURLOPT_URL => $api,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => $url,
				CURLOPT_HTTPHEADER => array('Content-Type: text/plain')
			);
			curl_setopt_array($ch, $options);
		}
}

function get_naps_bot(){
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);  
	if (strpos($useragent, 'baiduspider') !== false){  
		return 'Baiduspider';  
	}
	return false;
}