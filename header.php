<?php
error_reporting(0);
$keywords = cs_get_option( 'i_seo_keywords' );
$description = cs_get_option( 'i_seo_description' );
$favicon = cs_get_option( 'i_favicon_icon' );
$topbar = cs_get_option( 'i_topbar' );
$search = cs_get_option( 'i_search' );
$login = cs_get_option( 'i_login' );
$qrPay = cs_get_option( 'i_qrPay' );
$qrPay_btn = cs_get_option( 'i_qrPay_btn' );
$qrPay_img = cs_get_option( 'i_qrPay_img' );
$switcher = cs_get_option( 'i_switcher' );
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
<body <?php body_class(); ?> id="top">

	<?php if (is_mobile()) { ?>
		<!-- 微信缩略图 -->
		<div style="display:none;"><?php the_post_thumbnail( 'medium' ); ?></div>
	<?php }?>

	<!-- header 开始-->
	<?php if (!is_mobile()) { ?>
	  <header id="header" class="m_hide">
		<?php if ($topbar == true) { ?>
				<div class="topbar">
					<div class="container clearfix">
						<?php if ($switcher == true) { ?>
							<div class="skin fl clearfix">
								<a href="<?php echo get_template_directory_uri(); ?>/skin/switcher.php?style=skin01.css" class="with-tooltip skin-cloth" data-tooltip="布质"></a>
								<a href="<?php echo get_template_directory_uri(); ?>/skin/switcher.php?style=skin02.css" class="with-tooltip skin-wood" data-tooltip="木质"></a>
								<a href="<?php echo get_template_directory_uri(); ?>/skin/switcher.php?style=skin03.css" class="with-tooltip skin-paper" data-tooltip="纸质"></a>
								<a href="<?php echo get_template_directory_uri(); ?>/skin/switcher.php?style=skin04.css" class="with-tooltip skin-steam" data-tooltip="蒸汽朋克"></a>
							</div>
						<?php }?>
						<div class="fr clearfix m_hide">
							<?php if ($search == true) { ?>
							<div class="search fl">
									<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
									<input type="text" class="search-form-input text" name="s" onfocus="if (this.value == '查找...') {this.value = '';}" onblur="if (this.value == '') {this.value = '查找...';}" value="查找...">                        </form>
							</div>
							<?php }?>
							<?php if ($login == true) { ?>
								<div class="login fl">
										<?php $current_user = wp_get_current_user(); ?>
										<?php if ( is_user_logged_in() ) { ?>
											<div class="admin-box clearfix">
												<a class="avatar-box fl clearfix with-tooltip" data-tooltip="管理" href="<?php if(current_user_can('level_10')){ echo admin_url( 'admin.php?page=cs-framework' ) ;}else {echo admin_url( 'index.php' ) ;}  ?>">
														<?php if (strlen(get_avatar($current_user->ID, 40)) > 0) { ?>
																<?php echo get_avatar($current_user->ID, 40); ?>
														<?php } else { ?>
																<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/default-avatar.png" alt="">
														<?php } ?>
														<span><?php echo $current_user->display_name; ?></span>
												</a>
												<a href="<?php echo wp_logout_url(home_url()); ?>" class="logout-btn fl with-tooltip" data-tooltip="登出">
													<i class="fa fa-sign-out"></i>
												</a>
											</div>
										<?php } else { ?>
										 <a href="#" class="with-tooltip login-btn" data-tooltip="登陆">
											 <i class="fa fa-user" aria-hidden="true"></i>
										 </a>
										<?php } ?>
								</div>
							<?php } ?>
							<?php if ($qrPay == true) { ?>
							<div class="qr-pay fl">
								<span class="qr-btn"><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php echo $qrPay_btn ?></span>
								<div class="qr-img hide">
									<img src="<?php echo $qrPay_img ?>" class="ajax_gif">
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
		<?php } ?>

			<nav class="topmenu">
				<div class="container clearfix">
					<?php wp_nav_menu(array('theme_location' => 'header', 'container' => 'div','depth' => 2, 'container_class' => 'menu-wrapper', 'menu_class' => 'menu-list clearfix')); ?>
				</div>
			</nav>

			<div class="logo">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"></a>
			</div>
		</header>
		<!-- header 结束-->
	<?php } ?>

	<header id="m-header" class="m_show">
		<div class="m-header-inner colbox">
			<a class="col m-back" href="javascript:history.go(-1)">
				<i class="fa fa-chevron-left" aria-hidden="true"></i>
			</a>
			<a class="col m-logo" href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>">
				<?php bloginfo('name'); ?>
			</a>
			<a class="col m-menu" href="javascript:void(0)">
				<i class="fa fa-bars" aria-hidden="true"></i>
			</a>
		</div>
	</header>

	<nav id="m-menu" class="m_show">
		<div class="menu-tab clearfix">
			<a href="javascript:void(0)" class="menu-tab-item fl current">菜单</a>
			<a href="javascript:void(0)" class="menu-tab-item fl">分类</a>
			<a href="javascript:void(0)" class="m-menu-close fl"><i class="fa fa-times" aria-hidden="true"></i></a>
		</div>
		<div class="menu-content">
			<?php wp_nav_menu(array('theme_location' => 'header', 'container' => 'div','depth' => 1, 'container_class' => 'menu-wrapper', 'menu_class' => 'menu-list clearfix')); ?>
			<?php wp_nav_menu(array('theme_location' => 'main', 'container' => 'div','depth' => 1, 'container_class' => 'menu-wrapper hide', 'menu_class' => 'menu-list clearfix')); ?>
		</div>
	</nav>

	<!-- content 开始-->
	<section id="content" name="content">
	  <!-- container 开始-->
	  <div class="container">
	    <!-- content-inner 开始-->
	    <div class="content-inner">

	        <?php if (!is_mobile()) { ?>
	          <!-- 分类菜单 开始-->
	          <nav class="mianmenu m_hide">
	              <?php wp_nav_menu(array('theme_location' => 'main', 'container' => 'div','depth' => 2, 'container_class' => 'menu-wrapper', 'menu_class' => 'menu-list header-item clearfix')); ?>
	          </nav>
	          <!-- 分类菜单 结束-->
	        <?php } ?>
