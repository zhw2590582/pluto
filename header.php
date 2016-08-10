<?php
// 获取选项
$notice = cs_get_option( 'i_notice' );
$notice_main = cs_get_option( 'i_notice_main' );
$keywords = cs_get_option( 'i_seo_keywords' );
$description = cs_get_option( 'i_seo_description' );
$favicon = cs_get_option( 'i_favicon_icon' );
$banner = cs_get_option( 'i_banner_image' );
$symbol = cs_get_option( 'i_symbol' );
$logo = cs_get_option( 'i_logo_image' );
$search = cs_get_option( 'i_search' );
$login = cs_get_option( 'i_login' );
$switcher = cs_get_option( 'i_switcher' );
$banner_test = cs_get_option( 'i_banner_text' );
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php if(function_exists('show_wp_title')){show_wp_title();} ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0,minimal-ui">
	<meta name="keywords" content="<?php echo $keywords ?>" />
	<meta name="description" content="<?php echo $description ?>" />
	<link rel="shortcut icon" href="<?php echo $favicon; ?>" title="Favicon">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<?php if (is_mobile()) { ?>
		<div style="display:none;"><?php the_post_thumbnail( 'medium' ); ?></div>
	<?php }?>

  <?php if ($notice && !is_mobile()) { ?>
    <div class="notice hide m_hide">
        <div class="notice-inner"><?php echo $notice_main; ?></div>
        <a href="javascript:void(0)" class="clo-notice"><i class="fa fa-times"></i></a>
    </div>
  <?php }?>

  <header id="header">
	    <div class="container">
					<div id="topMenu" class="flex_item shadow clearfix">
						<nav class="header-menu header-item menu fl">
								<?php wp_nav_menu(array('theme_location' => 'header', 'container' => 'div', 'container_class' => 'menu-wrapper', 'menu_class' => 'menu-list clearfix')); ?>
						</nav>
						<ul class="header-tool header-item fr">
								<?php if ($search == true && !is_mobile()) { ?>
										<li class="search m_hide">
												<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
												<input type="text" class="search-form-input text" name="s" onfocus="if (this.value == '查找...') {this.value = '';}" onblur="if (this.value == '') {this.value = '查找...';}" value="查找...">                        </form>
										</li>
								<?php }?>
								<?php if ($login == true && !is_mobile()) { ?>
										<li class="navbar-login menu-item-has-children m_hide">
												<?php $current_user = wp_get_current_user(); ?>
												<?php if ( is_user_logged_in() ) { ?>
														<a class="avatar-box" href="<?php if(current_user_can('level_10')){ echo admin_url( 'admin.php?page=cs-framework' ) ;}else {echo admin_url( 'index.php' ) ;}  ?>" title="后台管理">
																<?php if (strlen(get_avatar($current_user->ID, 40)) > 0) { ?>
																		<?php echo get_avatar($current_user->ID, 40); ?>
																<?php } else { ?>
																		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/default-avatar.png" alt="<?php echo $current_user->display_name; ?>">
																<?php } ?>
														</a>
														<ul class="sub-menu clearfix">
																<li class="name">
																		<a href="<?php if(current_user_can('level_10')){ echo admin_url( 'admin.php?page=cs-framework' ) ;}else {echo admin_url( 'index.php' ) ;}  ?>"><i class="fa fa-tachometer"></i>后台管理</a>
																</li>
																<li class="edit-post">
																		<a href="<?php echo admin_url( 'post-new.php' ) ; ?>"><i class="fa fa-edit"></i>发文章</a>
																</li>
																<li class="log-out">
																		<a href="<?php echo wp_logout_url(home_url()); ?>" class="tooltip"><i class="fa fa-sign-out"></i>登出</a>
																</li>
														</ul>
												<?php } else { ?>
												 <a href="#" onclick="return false;" class="navbar-btn">登陆</a>
												<?php } ?>
										</li>
								<?php } ?>
						</ul>
				</div>
				<div id="topLogo" class="flex flex_vc flex-hc">
						<div class="logo circle flex flex_vc flex-hc">
								<?php if ( $symbol == 'i_text' ) { ?>
										<a class="logo_text" href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"></a>
								<?php }elseif( $symbol == 'i_logo' ){ ?>
										<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
												<img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-echo="<?php echo $logo ;?>" alt="<?php bloginfo('name'); ?>" />
										</a>
								<?php }else{ ?>
									 	<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><i class="icon-logo"></i></a>
								<?php } ?>
						</div>
				</div>
	  </div>
	</header>
