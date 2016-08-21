<?php
error_reporting(0);
/* 引入后台框架 */
require_once dirname( __FILE__ ) .'/cs-framework/cs-framework.php';

/* 加载脚本和样式 */
function island_scripts_styles() {

  /* 注册样式 */
  wp_enqueue_style('style', get_template_directory_uri() . "/style.css", array() , '0.9', 'screen');
  wp_enqueue_style('font-awesome-css', get_template_directory_uri() . "/cs-framework/assets/css/font-awesome.css", array() , '0.3', 'screen');

  /* 自定义皮肤 */
    wp_register_style('switcher', get_template_directory_uri() . "/skin/switcher.php", array() , '0.3', 'screen');
    wp_register_style('skin01', get_template_directory_uri() . "/skin/skin01.css", array() , '0.3', 'screen');
    wp_register_style('skin02', get_template_directory_uri() . "/skin/skin02.css", array() , '0.3', 'screen');
    wp_register_style('skin03', get_template_directory_uri() . "/skin/skin03.css", array() , '0.3', 'screen');
    $skin = cs_get_option('i_skin');
    $switcher = cs_get_option('i_switcher');

    if ($switcher == true) {
        wp_enqueue_style('switcher');
    }else {
		switch ($skin) {
			case "i_skin01":
				wp_enqueue_style('skin01');
				break;

			case "i_skin02":
				wp_enqueue_style('skin02');
				break;

			case "i_skin03":
				wp_enqueue_style('skin03');
				break;
		}
	}

  /* 注册脚本 */
  wp_enqueue_script('jquery');
  wp_enqueue_script('plugins-js', get_template_directory_uri() . '/js/plugins.js', false, '0.3', true);
  wp_enqueue_script('comments-ajax', get_template_directory_uri() . '/comments-ajax.js', false, '0.4', true);
  wp_enqueue_script('custom-js', get_template_directory_uri() . '/js/custom.js', false, '2.0', true);

  /* 代码高亮 */
  wp_register_script('prism-js', get_template_directory_uri() . '/js/prism.js', false, '0.3', true);
	$prettify = cs_get_option( 'i_code_prettify' );
	if ($prettify == true) {
		wp_enqueue_style('prism-style', get_template_directory_uri() . "/css/prism.css", array() , '0.9', 'screen');
		wp_enqueue_script('prism-js');
	}

	/* 萤火虫背景 */
	wp_register_script('circle', get_template_directory_uri() . '/js/circle.js', false, '0.3', true);
	$circle = cs_get_option( 'i_circle' );
 	if ( $circle == true && !is_mobile() ) {
		wp_enqueue_script('circle');
	}

}
add_action('wp_enqueue_scripts', 'island_scripts_styles');

/*移除多余信息*/
function wpdaxue_remove_cssjs_ver( $src ) {
	if( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
function disable_stuff( $data ) {
	return false;
}
remove_action('wp_head', 'wp_generator');
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','rsd_link');
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'wp_head','rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action('wp_head', 'rel_canonical');
add_filter( 'style_loader_src', 'wpdaxue_remove_cssjs_ver', 999 );
add_filter( 'script_loader_src', 'wpdaxue_remove_cssjs_ver', 999 );
add_filter( 'index_rel_link', 'disable_stuff' );
add_filter( 'parent_post_rel_link', 'disable_stuff' );
add_filter( 'start_post_rel_link', 'disable_stuff' );
add_filter( 'previous_post_rel_link', 'disable_stuff' );
add_filter( 'next_post_rel_link', 'disable_stuff' );


/* 加载类名 */
function load_css($classes) {
    $page = cs_get_option('i_pagination');
	if ( $page == 'i_ajax' ) {
        $classes[] = 'ajax_load';
    }else {
        $classes[] = '';
	}
    return $classes;
}
add_filter('body_class','load_css');

/* 引入密钥验证 */
include ('verify.php');

/* 引入CDN */
$qiniu = cs_get_option('i_qiniu');
$qiniu_link = cs_get_option('i_qiniu_link');
if ($qiniu == true && !empty( $qiniu_link )) {
	include ('qiniu.php');
}

/* 禁用 WordPress 4.4+ 的响应式图片功能 */
add_filter( 'max_srcset_image_width', create_function( '', 'return 1;' ) );

/* 禁用embeds功能 */
function disable_embeds_init() {
	global $wp;
	$wp->public_query_vars = array_diff( $wp->public_query_vars, array( 'embed', ) );
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	add_filter( 'embed_oembed_discover', '__return_false' );
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
	add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}
add_action( 'init', 'disable_embeds_init', 9999 );
function disable_embeds_tiny_mce_plugin( $plugins ) {
    return array_diff( $plugins, array( 'wpembed' ) );
}
function disable_embeds_rewrites( $rules ) {
    foreach ( $rules as $rule => $rewrite ) {
        if ( false !== strpos( $rewrite, 'embed=true' ) ) { unset( $rules[ $rule ] ); }
    }  return $rules;
}
function disable_embeds_remove_rewrite_rules() {
add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
flush_rewrite_rules(); }
register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );
function disable_embeds_flush_rewrite_rules() {
    remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' ); flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );

/* 引入作品模板 */
include("template-portfolio.php");

/* 引入推荐插件 */
$player = cs_get_option('i_player');
if ($player == true) {
	require_once( get_template_directory().'/TGM/plugins.php' );
}

//替换gravatar地址
function get_ssl_avatar($avatar) {
   $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2" class="avatar avatar-$2" height="$2" width="$2">',$avatar);
   return $avatar;
}
add_filter('get_avatar', 'get_ssl_avatar');

//评论框增强
function smilies_reset() {
	global $wpsmiliestrans, $wp_smiliessearch;
	if (!get_option('use_smilies')) {
		return;
	}
	$wpsmiliestrans_fixed = array(
		':mrgreen:' => "\xf0\x9f\x98\xa2",
		':smile:' => "\xf0\x9f\x98\xa3",
		':roll:' => "\xf0\x9f\x98\xa4",
		':sad:' => "\xf0\x9f\x98\xa6",
		':arrow:' => "\xf0\x9f\x98\x83",
		':-(' => "\xf0\x9f\x98\x82",
		':-)' => "\xf0\x9f\x98\x81",
		':(' => "\xf0\x9f\x98\xa7",
		':)' => "\xf0\x9f\x98\xa8",
		':?:' => "\xf0\x9f\x98\x84",
		':!:' => "\xf0\x9f\x98\x85",
	);
	$wpsmiliestrans = array_merge($wpsmiliestrans, $wpsmiliestrans_fixed);
}
function static_emoji_url() {
	return get_bloginfo('template_directory').'/images/emoji/';
}

function reset_emojis() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	add_filter('the_content', 'wp_staticize_emoji');
	add_filter('comment_text', 'wp_staticize_emoji',50);
        smilies_reset();
        add_filter('emoji_url', 'static_emoji_url');
}
add_action('init', 'reset_emojis');

function fa_get_wpsmiliestrans(){
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    foreach($wpsmilies as $alt => $src_path){
        $emoji = str_replace(array('&#x', ';'), '', wp_encode_emoji($src_path));
        $output .= '<a class="add-smily" data-smilies="'.$alt.'"><img class="wp-smiley" src="'.get_bloginfo('template_directory').'/images/emoji/'. $emoji .'.png" /></a>';
    }
    return $output;
}
add_filter( 'comment_form_defaults','fa_add_smilies_to_comment_form');
function fa_add_smilies_to_comment_form($default) {
    $commenter = wp_get_current_commenter();
    $default['comment_field'] .= '
    <div class="commentPlus clearfix">
        <div class="editor commentSmilies" data-editor="smile">
            <i class="fa fa-smile-o" aria-hidden="true"></i>
            <p class="comment-form-smilies clearfix hide">' . fa_get_wpsmiliestrans() . '</p>
        </div>
        <div class="editor commentBold m_hide" data-editor="bold"><i class="fa fa-bold" aria-hidden="true"></i></div>
        <div class="editor commentItalic m_hide" data-editor="italic"><i class="fa fa-italic" aria-hidden="true"></i></div>
        <div class="editor commentUnderline m_hide" data-editor="underline"><i class="fa fa-underline" aria-hidden="true"></i></div>
        <div class="editor commentDel m_hide" data-editor="del"><i class="fa fa-strikethrough" aria-hidden="true"></i></div>
        <div class="editor commentImg m_hide" data-editor="img"><i class="fa fa-picture-o" aria-hidden="true"></i></div>
        <div class="editor commentClean m_hide" data-editor="clean"><i class="fa fa-trash-o" aria-hidden="true"></i></div>
    </div>
    ';
    return $default;
}
function allowedtags_tab() {
	global $allowedtags;
	$allowedtags['u'] = array('class'=>true,);
}
add_action('comment_post', 'allowedtags_tab');

function recover_comment_fields($comment_fields){
    $comment = array_shift($comment_fields);
    $comment_fields =  array_merge($comment_fields ,array('comment' => $comment));
    return $comment_fields;
}
add_filter('comment_form_fields','recover_comment_fields');

 /* SVG支持 */
function my_upload_mimes($mimes = array()) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'my_upload_mimes');

 /* 默认打开页面评论 */
function open_comments_for_pages( $status, $post_type, $comment_type ) {
    if ( 'page' === $post_type ) {
        $status = 'open';
    }
    return $status;
}
add_filter( 'get_default_comment_status', 'open_comments_for_pages', 10, 3 );

/* Lazyload 功能,默认移动设备不开启，默认特色图不开启 */
function add_image_placeholders($content) {
    if (is_feed() || is_preview() || (function_exists('is_mobile') && is_mobile())) return $content;
    if (false !== strpos($content, 'data-original')) return $content;
    $placeholder_image = apply_filters('lazyload_images_placeholder_image', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
    $content = preg_replace('#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf('<img${1}src="%s" data-echo="${2}"${3}>', $placeholder_image) , $content);
    return $content;
}
$post_img = cs_get_option('i_post_image');
$img_setup = cs_get_option('i_post_setup');
$avatar_img = cs_get_option('i_comment_avatar');
if ($post_img == true) {
    add_filter('the_content', 'add_image_placeholders', 99);
}
if (!is_admin() && $avatar_img == true) {
    add_filter('get_avatar', 'add_image_placeholders', 11);
}
// add_filter( 'post_thumbnail_html', 'add_image_placeholders', 11 );

/* 引入喜欢属性 */
$like = cs_get_option( 'i_post_like' );
if ($like == true) {
 	include_once ('post-like.php');
}

/* 激活后跳转到密钥或设置页 */
add_action('after_switch_theme', 'Init_theme');
function Init_theme($oldthemename) {
	global $pagenow;
	if ('themes.php' == $pagenow && isset($_GET['activated'])) {
		global $verify;
		$key = cs_get_customize_option( 'lazycat_key' );
		$verify = get_option('Owl_license_key');
		if (!empty($verify) || $key == 'zhw2590582' ) {
			wp_redirect(admin_url('admin.php?page=cs-framework'));
			exit;
		} else {
			wp_redirect(admin_url('options-general.php?page=' . get_stylesheet_directory() . '/verify.php'));
			exit;
		}
	}
}

/* 统一标签尺寸 */
function custom_tag_cloud_widget($args) {
  $args['largest'] = 12;
  $args['smallest'] = 12;
  $args['unit'] = 'px';
  $args['number'] = '50';
  $args['orderby'] = 'count';
  $args['order'] = 'DESC';
  return $args;
}
add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );

/* 修改时间格式 */
function timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
        30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
        7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

/* 管理员类名 */
function add_admin_body_class( $classes ) {
    return "$classes zhw_admin";
}
$theme_url = wp_get_theme()->display('ThemeURI');
$wp_url = home_url('/');
if ($theme_url == $wp_url) {
  add_filter( 'admin_body_class', 'add_admin_body_class' );
}

/* 启用后台引导 */
add_action('admin_enqueue_scripts', 'my_admin_enqueue_scripts');
function my_admin_enqueue_scripts() {
    wp_enqueue_style('wp-pointer');
    wp_enqueue_script('wp-pointer');
    add_action('admin_print_footer_scripts', 'my_admin_print_footer_scripts');
}
function my_admin_print_footer_scripts() {
    $dismissed = explode(',', (string)get_user_meta(get_current_user_id() , 'dismissed_wp_pointers', true));
    if (!in_array('my_pointer', $dismissed)):
        $pointer_content = '<h3>你好！验证 Owl 主题成功</h3>';
        $pointer_content.= '<p>主题设置从这里进入，使用中若有疑问，可以联系老赵</p>';
?>
        <script type="text/javascript">
        //<![CDATA[
        jQuery(document).ready( function($) {
            $('#toplevel_page_cs-framework').pointer({
                content: '<?php
        echo $pointer_content; ?>',
				position:		{
									edge:	'left',
									align:	'center'
								},
				pointerWidth:	350,
                close  : function() {
                    jQuery.post( '<?php
        bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php', {
                        pointer: 'my_pointer',
                        action: 'dismiss-wp-pointer'
                    });
                }
            }).pointer('open');
        });
        //]]>
        </script>
        <?php
    endif;
}

/* 添加选项按钮到工具栏 */
function tie_admin_bar() {
    global $wp_admin_bar;
    global $verify;
	$key = cs_get_customize_option( 'lazycat_key' );
    $verify = get_option('Owl_license_key');
    if (!empty($verify) || $key == 'zhw2590582') {
        if (current_user_can('switch_themes')) {
            $wp_admin_bar->add_menu(array(
                'parent' => 0,
                'id' => 'mpanel_page',
                'title' => 'Owl 主题选项',
                'href' => admin_url('admin.php?page=cs-framework')
            ));
        }
    } else {
        if (current_user_can('switch_themes')) {
            $wp_admin_bar->add_menu(array(
                'parent' => 0,
                'id' => 'mpanel_verify',
                'title' => '主题未验证',
                'href' => admin_url('options-general.php?page=' . get_stylesheet_directory() . '/verify.php')
            ));
        }
    }
}
add_action('wp_before_admin_bar_render', 'tie_admin_bar');

/* 默认配置 */
if (!isset($content_width)) $content_width = 690;
if (!function_exists('island_setup')):
    function island_setup() {
        /* 启用缩略图的支持 */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(250, 250, true);
        add_image_size('large-image', 9999, 9999, false);
        /* 启用头部菜单 */
        register_nav_menus(array(
            'header' => __('顶部菜单', 'island') ,
        ));
        /* 启用文章菜单 */
        register_nav_menus(array(
            'main' => __('文章菜单', 'island') ,
        ));
        /* 启动主题可利用的语言 */
        load_theme_textdomain('island', get_template_directory() . '/languages');
    }
endif;
add_action('after_setup_theme', 'island_setup');

/* 隐藏系统工具栏 */
$toolbar = cs_get_option('i_toolbar');
function hide_admin_bar($flag) {
    return false;
}
if ($toolbar == true) {
    add_filter('show_admin_bar', 'hide_admin_bar');
}

// 禁用谷歌字体
class Disable_Google_Fonts {
    public function __construct() {
    add_filter( 'gettext_with_context', array( $this, 'disable_open_sans' ), 888, 4 );
	}
	public function disable_open_sans( $translations, $text, $context, $domain ) {
		if ( 'Open Sans font: on or off' == $context && 'on' == $text ) {
		        $translations = 'off';
		}
		return $translations;
	}
}
$disable_google_fonts = new Disable_Google_Fonts;

/* 启用浏览数目 */
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.'';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if (is_singular()) {
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

}

//后台显示浏览数目
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('浏览');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
	if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}

/* 后台更新提醒 */
function my_admin_notice() {
	$name = wp_get_theme()->display('Name');
	$url = 'https://raw.githubusercontent.com/zhw2590582/'.$name.'/master/update.json';
	$nowversion = wp_get_theme()->display('Version');
	$json_string = wp_remote_retrieve_body( wp_remote_get(''.$url.'',array('timeout' => 120)));
	$obj=json_decode($json_string);
	$newversion=$obj->version;
	$notice=$obj->notice;
	$switch=$obj->switch;
	if ($switch == 'on' && strcmp($newversion,$nowversion)>0) {
		echo '<div class="update-nag">您的'.$name.'当前版本为:'.$nowversion.'，可更新到:'.$newversion.'！</br>'.$notice.'</div>';
	}
}
//add_action( 'admin_notices', 'my_admin_notice' );

/* 边栏评论 */
	function h_comments($outer,$limit){
		global $wpdb;
		$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, SUBSTRING(comment_content,1,22) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND user_id='0' AND comment_author != '$outer' ORDER BY comment_date_gmt DESC LIMIT $limit";
		$comments = $wpdb->get_results($sql);
		foreach ($comments as $comment) {
			$output .= '<li class="colbox"><p class="col avatar-box">'.get_avatar( $comment, 32,"",$comment->comment_author).'</p><p class="col comment_box"><a class="with-tooltip" href="'. get_permalink($comment->ID) .'#comment-' . $comment->comment_ID . '" data-tooltip="《'.$comment->post_title . '》上的评论"><span class="s_name">'.strip_tags($comment->comment_author).':</span><span class="s_desc">'. strip_tags($comment->com_excerpt).'</span></a></p></li>';
		}
		$output = convert_smilies($output);
		echo $output;
	}

/* 启用文章摘录 */
function improved_trim_excerpt($text) {
    global $post;
    if ('' == $text) {
        $text = get_the_content('');
        $text = apply_filters('the_content', $text);
        $text = str_replace('\]\]\>', ']]&gt;', $text);
        $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		/* 可自定义不过滤html标签 */
        $text = strip_tags($text, '<span><pre><code><script><style><br><em><i><ul><ol><li><a><p><img><video><audio><strong><em><blockquote>');
        $text = mb_substr($text, 0, cs_get_option('i_post_excerpt') , 'utf-8') . '...<div class="read_more"><a href="' . get_permalink($post->ID) . '">' . cs_get_option('i_post_more') . '</a></div>';
        $excerpt_length = cs_get_option('i_post_excerpt');
        $words = explode(' ', $text, $excerpt_length + 1);
        if (count($words) > $excerpt_length) {
            array_pop($words);
            array_push($words, '...<div class="read_more"><a " href="' . get_permalink($post->ID) . '">' . cs_get_option('i_post_more') . '</a></div>');
            $text = implode(' ', $words);
        }
    }
    return $text;
}
function custom_excerpt_length($length) {
    return cs_get_option('i_post_excerpt');
}
function new_excerpt_more($more) {
    global $post;
    return '...<div class="read_more"><a href="' . get_permalink($post->ID) . '">' . cs_get_option('i_post_more') . '</a></div>';
}
$excerpt = cs_get_option('i_post_readmore');
$html = cs_get_option('i_post_html');
if ($excerpt == true) {
    if ($html == true) {
        remove_filter('get_the_excerpt', 'wp_trim_excerpt');
        add_filter('get_the_excerpt', 'improved_trim_excerpt');
    } else {
        add_filter('excerpt_length', 'custom_excerpt_length', 999);
        add_filter('excerpt_more', 'new_excerpt_more');
    }
}

/* 启用标题 */
function show_wp_title(){
    global $page, $paged;
    wp_title( '-', true, 'right' );
    // 添加网站标题.
    bloginfo( 'name' );
    // 为首页添加网站描述.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
    echo ' - ' . $site_description;
    // 如果有必要，在标题上显示一个页面数.
    if ( $paged >= 2 || $page >= 2 )
    echo ' - ' . sprintf( '第%s页', max( $paged, $page ) );
}

/* 启用相关文章 */
if (function_exists('add_theme_support')) add_theme_support('post-thumbnails');
function post_thumbnail_src() {
    global $post;
    if ($values = get_post_custom_values("thumb")) {
        $values = get_post_custom_values("thumb");
        $post_thumbnail_src = $values[0];
    } elseif (has_post_thumbnail()) {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID) , 'thumbnail');
        $post_thumbnail_src = $thumbnail_src[0];
    } else {
        $post_thumbnail_src = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $post_thumbnail_src = $matches[1][0];
        if (empty($post_thumbnail_src)) {
            $feature_num = cs_get_option( 'i_feature_num' );
            echo ''.get_template_directory_uri().'/images/thumbnail/img'.rand(1,$feature_num).'.png';
        }
    };
    echo $post_thumbnail_src;
}

/* SMPT设置 */
$stmp = cs_get_option('i_comment_smpt');
if ($stmp == true) {
	add_action('phpmailer_init', 'mail_smtp');
}

function mail_smtp( $phpmailer ) {
$phpmailer->FromName = cs_get_option('i_smpt_name');
$phpmailer->Host = cs_get_option('i_smpt_server');
$phpmailer->Port = cs_get_option('i_smpt_port');
$phpmailer->Username = cs_get_option('i_smpt_email');
$phpmailer->Password = cs_get_option('i_smpt_password');
$phpmailer->From = cs_get_option('i_smpt_email');
$phpmailer->SMTPAuth = true;
$phpmailer->SMTPSecure = '';
$phpmailer->IsSMTP();
}

/* 启用邮件提醒 */
$mail = cs_get_option('i_comment_mail');
if ($mail == true) {
	include_once('notify.php');
}

/* 分页条件 */
function island_page_has_nav() {
    global $wp_query;
    return ($wp_query->max_num_pages > 1);
}

/* 图集和画廊支持 */
function island_theme_setup() {
    add_theme_support('island_themes_gallery_support');
}
add_action('after_setup_theme', 'island_theme_setup');
add_filter('island_themes_portfolio_items_support', '__return_true');
add_filter('pre_option_link_manager_enabled', '__return_true');

/* 注册小工具 */
if (function_exists('register_sidebars')) register_sidebar(array(
    'name' => __('Aside', 'dw-minion') ,
    'id' => 'sidebar-1',
    'description' => __('显示在页面右边', 'island') ,
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h5 class="widget-title"><span>',
    'after_title' => '</span></h5>',
));
register_sidebar(array(
    'name' => __('Sidebar', 'island') ,
    'description' => __('显示在左侧边栏', 'island') ,
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h5 class="widget-title"><span>',
    'after_title' => '</span></h5>',
));

/* 引入小工具 */
require get_template_directory() . '/widgets.php';

/* 判断移动设备 */
function is_mobile() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$mobile_browser = Array(
		"mqqbrowser","opera mobi","juc","iuc","fennec","ios","applewebKit/420","applewebkit/525","applewebkit/532","ipad","iphone","ipaq","ipod","iemobile", "windows ce","240x320","480x640","acer","android","anywhereyougo.com","asus","audio","blackberry","blazer","coolpad" ,"dopod", "etouch", "hitachi","htc","huawei", "jbrowser", "lenovo","lg","lg-","lge-","lge", "mobi","moto","nokia","phone","samsung","sony","symbian","tablet","tianyu","wap","xda","xde","zte"
	);
	$is_mobile = false;
	foreach ($mobile_browser as $device) {
		if (stristr($user_agent, $device)) {
			$is_mobile = true;
			break;
		}
	}
	return $is_mobile;
}
if (is_mobile()) {
} else {
}

/* 维护模式 */
function wp_maintenance_mode(){
    if(!current_user_can('edit_themes') || !is_user_logged_in()){
        wp_die(''.cs_get_option('i_maintenance_notice').'', ''.cs_get_option('i_maintenance_title').'', array('response' =>'503'));
    }
}
$maintenance = cs_get_option('i_maintenance');
if ($maintenance == true) {
	add_action('get_header', 'wp_maintenance_mode');
}

//保护后台登录
function login_protection(){
    if($_GET[''.cs_get_option('i_login_prefix').''] != ''.cs_get_option('i_login_suffix').'')header('Location: '.cs_get_option('i_login_link').'');
}

$protection = cs_get_option('i_login_protection');
if ($protection == true) {
	add_action('login_enqueue_scripts','login_protection');
}

// 增加额外登录验证
function wlp_basic_auth() {
  if( !isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW']) )
    wlp_unauthorized(__('No credentials have been provided.', 'memberpress'));
  else {
    $user = wp_authenticate($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']);

    if(is_wp_error($user))
      wlp_unauthorized( $user->get_error_message() );
  }
}
function wlp_unauthorized($message) {
  header('WWW-Authenticate: Basic realm="' . get_option('blogname') . '"');
  header('HTTP/1.0 401 Unauthorized');
  die(sprintf(__('UNAUTHORIZED: %s', 'memberpress'),$message));
}

$auth = cs_get_option('i_login_auth');
if ($auth == true) {
	add_action('login_init','wlp_basic_auth');
}

//过滤HTTP 1.0的登录POST请求
function wlp_filter_http() {
  if(preg_match('/1\.0/',$_SERVER['SERVER_PROTOCOL'])) { wlp_forbidden(); }
}
$http = cs_get_option('i_login_http');
if ($http == true) {
	add_action('login_init','wlp_filter_http');
}

// POST Cookie 保护
//这将设置一个cookie的初始值，如果cookie不存在POST请求，登录会被阻止
function wlp_set_login_protection_cookie() {
  if( strtoupper($_SERVER['REQUEST_METHOD'])=='GET' and
      !isset($_COOKIE['wlp_post_protection']) ) {
    setcookie('wlp_post_protection','1',time()+60*60*24);
    $_COOKIE['wlp_post_protection'] = '1';
  }
}

function wlp_post_protection() {
  if( strtoupper($_SERVER['REQUEST_METHOD'])=='POST' and
      !isset($_COOKIE['wlp_post_protection']) ) {
    wlp_forbidden();
  }
}
$cookie = cs_get_option('i_login_cookie');
if ($cookie == true) {
	add_action('init','wlp_set_login_protection_cookie');
	add_action('login_init','wlp_post_protection');

}

// 登录错误，返回403状态
function wlp_forbidden() {
  header("HTTP/1.0 403 Forbidden");
  exit;
}

// 返回网站中未审核留言数
function get_not_audit_comments(){
    if(is_home() && current_user_can('level_10')){    //只有在首页，并且管理员登录是才执行
        $awaiting_mod = wp_count_comments();
        $awaiting_mod = $awaiting_mod->moderated;
        if($awaiting_mod){
            //当存在未审核留言
            echo "<div id=\"awaiting_comments\"><a href=".admin_url( 'edit-comments.php' ).'><i class=\'fa fa-comments\'></i>你有'.$awaiting_mod.'条新回复</a></div>';
         }
    }
}
add_filter('wp_footer','get_not_audit_comments');

/* 设置Css */
add_action('wp_head', 'plugin_css', 99);
function plugin_css() {
	$ajaxbar = cs_get_option( 'i_ajax_color' );
	$body_s = cs_get_option( 'i_body_style' );
    $body_b = cs_get_option( 'i_body_image' );
    $body_c = ' '. $body_b[color] .' url(\''. $body_b[image] .'\') '. $body_b[repeat] .' '. $body_b[position] .' '. $body_b[attachment] .'';

	if ( $menu_g  == true) {
		$menu_bg = 'none';
		$menu_c = '#222';
	};

    echo '<!-- 设置Css --><style>

	.loading-bar{
	  background:'. $ajaxbar.';
	}
	</style>';
}

//修改title格式
if ( ! function_exists( '_wp_render_title_tag' ) ) :
   function theme_slug_render_title() {
      ?>
      <title><?php wp_title( '-', true, 'right' ); ?></title>
      <?php
   }
   add_action( 'wp_head', 'theme_slug_render_title' );
endif;

/* 自定义css */
add_action('wp_head', 'add_css', 99);
function add_css() {
    echo '<!-- 自定义css --><style>' . cs_get_option('i_css') . '</style>';
}

/* 自定义js */
add_action('wp_footer', 'add_js', 99);
function add_js() {

    echo '<!-- 自定义js --><script>' . cs_get_option('i_js') . '</script>';
}

/* 评论高亮作者 */
function comment_admin_title($email = '')
{
    if(empty($email))return;
    $handsome=array(
    '1'=>' ',);
    $adminEmail = get_option('admin_email');
    if($email==$adminEmail)
    echo "<span class='author'>(管理员)</span>";
    elseif(in_array($email,$handsome))
    echo "<span class='author'>(管理员)</span>";
}

/* 引入Sitemap.xml */
if (cs_get_option('i_seo_sitemap') == true) {
	include ('sitemap.php');
}

/* 引入百度主动推送 */
if (cs_get_option('i_baidu_submit') == true) {
	include ('baidu_submit.php');
}

/* 百度手动推送 */
if (cs_get_option('i_baidu_manual') == true) {
	function island($url){
		$url='http://www.baidu.com/s?wd='.$url;
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$rs=curl_exec($curl);
		curl_close($curl);
		if(!strpos($rs,'没有找到')){
			return 1;
		}else{
			return 0;
		}
	}
	add_filter( 'the_content',  'baidu_submit' );
	function baidu_submit( $content ) {
		if( is_single() && current_user_can( 'manage_options') )
			if(island(get_permalink()) == 1)
				$content="<p class='baidu_submit'><i class='fa fa-paw'></i>百度已收录</p>".$content;
			else
				$content="<p class='baidu_submit'><a target=_blank href=http://zhanzhang.baidu.com/sitesubmit/index?sitename=".get_permalink()."><i class='fa fa-paw'></i>百度未收录</a></p>".$content;
			return $content;
	}
}

//移除自动保存
if (cs_get_option('i_post_autosave') == true) {
	wp_deregister_script('autosave');
}

//移除修订版本
if (cs_get_option('i_post_revision') == true) {
	remove_action('post_updated','wp_save_post_revision' );
}

//文章目录
function article_index($content) {
	$matches = array();
	$ul_li = '';
	$r = '/<h([3]).*?\>(.*?)<\/h[3]>/is';
	if(is_single() && preg_match_all($r, $content, $matches)) {
		foreach($matches[1] as $key => $value) {
			$title = trim(strip_tags($matches[2][$key]));
			$content = str_replace($matches[0][$key], '<h' . $value . ' id="title-' . $key . '">'.$title.'</h2>', $content);
			$ul_li .= '<li><a class="ofh" href="#title-'.$key.'" title="'.$title.'">'.$title."</a></li>\n";
		}
		$content = "\n<div id=\"article-index\">
		<ol id=\"index-ul\">\n" . $ul_li . "</ol>
		</div>\n" . $content;
	}
	return $content;
}
add_filter( 'the_content', 'article_index' );

/* 自定义评论输出 */
function island_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
/* 主评论计数器 by zwwooooo Modified Gimhoy(http://blog.gimhoy.com) */
        global $commentcount,$wpdb, $post;
        if(!$commentcount) { //初始化楼层计数器
            if ( get_option('comment_order') === 'desc' ) { //倒序
                $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
                $cnt = count($comments);//获取主评论总数量
                $page = get_query_var('cpage');//获取当前评论列表页码
                $cpp=get_option('comments_per_page');//获取每页评论显示数量
                if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
                    $commentcount = $cnt + 1;//如果评论只有1页或者是最后一页，初始值为主评论总数
                } else {
                    $commentcount = $cpp * $page + 1;
                }
            }else{ //顺序
                $page = get_query_var('cpage')-1;
                $cpp=get_option('comments_per_page');//获取每页评论数
                $commentcount = $cpp * $page;
            }
        }
/* 主评论计数器 end */
        if ( !$parent_id = $comment->comment_parent ) {
            $commentcountText = '';
            if ( get_option('comment_order') === 'desc' ) { //倒序
                $commentcountText .= --$commentcount . '楼';
            } else {
                switch ($commentcount) {
                    case 0:
                        $commentcountText .= '<span>沙发！</span>'; ++$commentcount;
                        break;
                    case 1:
                        $commentcountText .= '<span>板凳！</span>'; ++$commentcount;
                        break;
                    case 2:
                        $commentcountText .= '<span>地板！</span>'; ++$commentcount;
                        break;
                    default:
                        $commentcountText .= ++$commentcount . '楼';
                        break;
                }
            }
            $commentcountText .= '';
        }
	?>
	<li <?php comment_class('clearfix'); ?> id="li-comment-<?php comment_ID() ?>">
		<div class="comment-block" id="comment-<?php comment_ID(); ?>">
      <!-- comment-header -->
      <div class="comment-header clearfix">
        <!-- 头像 -->
        <span class="author-img fl">
          <?php echo get_avatar($comment->comment_author_email, 50); ?>
        </span>
        <!-- 名字 -->
        <span class="author-name fl">
          <?php printf(__('%s', 'island') , get_comment_author_link()) ?>
          <?php comment_admin_title($comment->comment_author_email); ?>
        </span>
        <?php if ($comment->comment_approved == '0'): ?>
          <!-- 审核 -->
          <span class="comment-awaiting-moderation fl">
            -你的评论等待审核
          </span>
        <?php endif; ?>
        <!-- 楼层 -->
        <span class="comment-count fr"><?php echo $commentcountText; ?></span>
      </div>
      <!-- comment-body -->
			<div class="comment-body wb clearfix">
				<?php comment_text() ?>
			</div>
      <!-- comment-bottom -->
      <div class="comment-bottom clearfix">
        <!-- 日期 -->
        <span class="comment-date">
            <a class="comment-time" href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>">
            <?php printf(__('%1$s - %2$s', 'island') , get_comment_date('m/d/Y') , get_comment_time()) ?></a>
        </span>
        <!-- 回复 -->
        <span class="comment-reply">
          <?php comment_reply_link(array_merge($args, array(
            'depth' => $depth,
            'max_depth' => $args['max_depth']
          ))) ?>
        </span>
        <!-- 编辑 -->
        <span class="comment-edit">
          <?php edit_comment_link(__('(Edit)', 'island') , '  ', '') ?>
        </span>
      </div>
		</div>
<?php
}
function island_cancel_comment_reply_button($html, $link, $text) {
    $style = isset($_GET['replytocom']) ? '' : ' style="display:none;"';
    $button = '<div id="cancel-comment-reply-link"' . $style . '>';
    return $button . '<i class="icon-remove-sign"></i> </div>';
}
add_action('cancel_comment_reply_link', 'island_cancel_comment_reply_button', 10, 3);
