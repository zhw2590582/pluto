<?php
 // 获取选项
 error_reporting(0);
$avatar_bg = cs_get_option( 'i_avatar_bg' );
$avatar_image = cs_get_option( 'i_avatar_image' );
$avatar_name = cs_get_option( 'i_avatar_name' );
$avatar_content = cs_get_option( 'i_avatar_content' );
$me = cs_get_option( 'i_me_switch' );
$bulletin = cs_get_option( 'i_bulletin' );
$like = cs_get_option( 'i_post_like' );
$view = cs_get_option( 'i_post_view' );
$workscom = cs_get_option( 'i_works_comment' ); 
?> 

<?php get_header(); ?>
	
		<section id="content">
            <div class="container">
                <div class="content-inner">
                    <div class="main_header colbox">
                        <div class="avatar_box col">
                            <div class="me_img">
                                <div class="me_avatar">
                                    <img src="<?php echo $avatar_image; ?>">
                                </div>
                                <span class="me_name"><?php echo $avatar_name; ?></span>
                            </div>
							<?php if ($bulletin) { ?>
								<div class="bulletin">
									<?php
										$my_bulletins = cs_get_option( 'i_bulletin_custom' );
										echo '<ul class="bulletin_list">';
										if( ! empty( $my_bulletins ) ) {
										  foreach ( $my_bulletins as $bulletin ) {
											echo '<li style="display:none">';
											if( ! empty( $bulletin['i_bulletin_link'] ) ){ echo '<a href="'. $bulletin['i_bulletin_link'] .'"';}
											if ( ! empty( $bulletin['i_bulletin_link'] ) && $bulletin['i_bulletin_newtab'] == true) { echo 'target="_black">';}else{ if ( ! empty( $bulletin['i_bulletin_link'] )){ echo '>';}}
											echo ''. $bulletin['i_bulletin_text'] .'';
											if( ! empty( $bulletin['i_bulletin_link'] ) ){ echo '</a>';}
											echo '</li>';
										  }
										}
										echo '</ul>';
									?>
								</div>
							<?php } ?>
                        </div>
                        <div class="main-menu col">
                            <?php wp_nav_menu(array('theme_location' => 'main', 'container' => 'div', 'container_class' => 'header-menu-wrapper', 'menu_class' => 'header-menu-list')); ?>
                        </div>
                    </div>
                    <div class="main_body colbox">
                        <div id="main" class="col">
                            <div class="main-inner">
        	                    <div id="posts-box">
        	                        <div class="posts">
										<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
										<?php setPostViews(get_the_ID());?>
										<article <?php post_class('post'); ?>>
										 <div class="post-wrap">
											<?php
												get_template_part('format', 'standard');
											?>
											<ul class="bottom_meta clearfix">
												<li class="mate-time fl"><i class="fa fa-clock-o"></i><?php echo ''.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></li>
												<li class="mate-cat fl"><i class="fa fa-circle-o-notch"></i><?php the_category(' '); ?></li>
												<?php $posttags = get_the_tags(); if ($posttags) { ?>
													<li class="meta_tabs fl"><i class="fa fa-tags"></i><?php the_tags('', ' ', ''); ?></li>
												<?php } ?>

	                                        <?php if ($like == true) { ?>
	                                            <li class="meta_like fr">
	                                                <?php echo getPostLikeLink( get_the_ID() ); ?>
	                                            </li>
	                                        <?php } ?>
											</ul>
										 </div>
										</article>
										<?php endwhile; ?>
										<?php endif; ?>
        	                        </div>
									<div id="comment-jump" class="comments">
										<?php comments_template(); ?>
									</div>
        	                    </div>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>	
	
<?php get_footer(); ?>

