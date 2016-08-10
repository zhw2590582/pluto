<?php 
/* 
Template Name: 归档页面
*/ 
error_reporting(0);
$layout = cs_get_option('i_layout');
$avatar_image = cs_get_option( 'i_avatar_image' );
$avatar_content = cs_get_option( 'i_avatar_content' );
$me = cs_get_option( 'i_me_switch' );
$bulletin = cs_get_option( 'i_bulletin' );
?>

<?php get_header(); ?>

		<section id="content">
            <div class="container">
                <div class="content-inner">

        <?php if (!is_mobile()) { ?>
            <div class="main_header colbox m_hide">
                <div class="avatar_box col">
                    <div class="me_img">
                        <div class="me_avatar">
                            <img src="<?php echo $avatar_image; ?>">
                        </div>
                        <ul class="me_name">
                            <li>
                                <p class="me_num"><?php $count_posts = wp_count_posts(); echo $published_posts =$count_posts->publish;?></p>
                                <p class="me_title">文章</p>
                            </li>
                            <li>
                                <p class="me_num"><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");?></p>
                                <p class="me_title">评论</p>
                            </li>
                            <li>
                                <p class="me_num"><?php $link = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'"); echo $link; ?></p>
                                <p class="me_title">邻居</p>
                            </li>
                        </ul>                     
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
        <?php } ?>

                    <div class="main_body colbox">
                        <?php if (!is_mobile() && $layout == 'i_layout_two') { ?>
                            <aside id="sidebar" class="col m_hide">
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
                                                    if( ! empty( $social['i_social_link'] ) ){echo '<a href="'. $social['i_social_link'] .'" title="'. $social['i_social_title'] .'"';}else{echo '<a href="javascript:void(0)" title="'. $social['i_social_title'] .'" ';}
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
                            </aside>
                        <?php }?>
                        <div id="main" class="col">
                            <div class="main-inner">
        	                    <div id="posts-box">
        	                        <div class="posts clearfix">
        								<article>
        									<div class="post-wrap">
        										<div class="post-inner">
        											<div class="post-body">
        												<header>
															<h2 class="entry-title">
																<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
																	<?php the_title(); ?>
																</a>
															</h2>
        												</header>
        												<div class="post-content">
        													<div calss="content clearfix">
                                                                <div class="archivePost">
                                                                     <ul class="timeline">
                                                                     <li class="tl-header">
                                                                       <div class="btn btn-info">现在</div>
                                                                     </li>
                                                                     <?php $count_posts = wp_count_posts(); $published_posts = $count_posts->publish;
                                                                     query_posts( 'posts_per_page=-1' );
                                                                     while ( have_posts() ) : the_post();
                                                                         echo '<li class="tl-item"><div class="tl-wrap">';
                                                                         echo '<span class="tl-date">';
                                                                         the_time(get_option( 'date_format' ));
                                                                         echo '</span><div class="tl-content">
                                                                         <span class="arrow"></span>
                                                                         <a href="';
                                                                         the_permalink();
                                                                         echo '" title="'.esc_attr( get_the_title() ).'">';
                                                                         the_title();
                                                                         echo '</a></div></div></li>';
                                                                         $published_posts--;
                                                                     endwhile;
                                                                     wp_reset_query(); ?>
                                                                      <li class="tl-header">
                                                                        <div class="btn btn-info">过去</div>
                                                                      </li>
                                                                     </ul>
                                                                 </div>
        													</div>
        												</div>
        											</div>
        										</div>
        									</div>
        								</article>
        	                        </div>
        	                    </div>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php get_footer(); ?>