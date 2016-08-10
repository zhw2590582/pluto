<?php
$avatar_bg = cs_get_option( 'i_avatar_bg' );
$avatar_image = cs_get_option( 'i_avatar_image' );
$avatar_content = cs_get_option( 'i_avatar_content' );
$me = cs_get_option( 'i_me_switch' );
?>

<?php if (!is_mobile()) { ?>
		<aside id="sidebar" class="m_hide">
			<div class="sidebar-inner">
				<?php if ($me == true) {?>
						<div id="about">
								<p class="me_content">
										<?php echo $avatar_content; ?>
								</p>
								<div class="social_link">
										<?php
												$my_socials = cs_get_option( 'i_social' );
												echo '<ul class="clearfix">';
												if( ! empty( $my_socials ) ) {
													foreach ( $my_socials as $social ) {
														$iconstyle = $social['i_icon_style'];
														echo '<li>';
														if( ! empty( $social['i_social_link'] ) ){echo '<a href="'. $social['i_social_link'] .'" class="tooltip tooltip-bottom" data-tooltip="'. $social['i_social_title'] .'"';}else{echo '<a href="javascript:void(0)"  class="tooltip tooltip-bottom" data-tooltip="'. $social['i_social_title'] .'" ';}
														if ( $social['i_social_newtab'] == true) { echo 'target="_black"';}
														if ($iconstyle == 'i_icon') {echo '><i class="'. $social['i_social_icon'] .'"></i>';} else {echo '><img src="'. $social['i_social_image'] .'">';}
														echo '</a>';
														echo '</li>';
													}
												}
												echo '</ul>';
										?>
								</div>
						</div>
				<?php } ?>
				<div id="widget" class="widgets">
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Aside') ) : else : ?>
						<?php endif; ?>
				</div>
			</div>
		</aside>
<?php }?>
