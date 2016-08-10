<?php
$layout = cs_get_option('i_layout');
$sliders = cs_get_option( 'i_slider' );
$pagination = cs_get_option('i_pagination');
$like = cs_get_option( 'i_post_like' );
$bulletin = cs_get_option( 'i_bulletin' );
$com = cs_get_option( 'i_index_com' );
?>

<?php get_header(); ?>

<section id="content">
    <div class="container flex">
        <div class="content-inner shadow flex_item">

        <?php if (!is_mobile()) { ?>
            <!-- 主菜单 -->
            <div class="main_header m_hide">
                <div class="main-menu">
                    <?php wp_nav_menu(array('theme_location' => 'main', 'container' => 'div', 'container_class' => 'menu-wrapper', 'menu_class' => 'menu-list header-item clearfix')); ?>
                </div>
            </div>
        <?php } ?>

            <div class="main_body">
                <div id="main">
                	<?php if(is_home() && !is_paged()) { ?>
                		<!-- 调用幻灯片 -->
                		<?php if ($sliders == true) { ?>
                            <div class="app_slider">
                                <div class="slider_inner">
                                    <div id="slider" class="nivoSlider">
                                        <?php
                                            $my_sliders = cs_get_option( 'i_slider_custom' );
                                            if( ! empty( $my_sliders ) ) {
                                              foreach ( $my_sliders as $slider ) {
                                                if( ! empty( $slider['i_slider_link'] ) ){ echo '<a href="'. $slider['i_slider_link'] .'"';}
                                                if ( ! empty( $slider['i_slider_link'] ) && $slider['i_slider_newtab'] == true) { echo 'target="_black">';}else{ if ( ! empty( $slider['i_slider_link'] )){ echo '>';}}
                                                echo '<img class=" " src="'. $slider['i_slider_image'] .'" data-thumb="'. $slider['i_slider_image'] .'" title="'. $slider['i_slider_text'] .'"/>';
                                                if( ! empty( $slider['i_slider_link'] ) ){ echo '</a>';}
                                              }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                		<?php } ?>
                	<?php } ?>

        					<?php if(is_search()) { ?>
        						<h6 class="archive-title"><div class="title-inner"><i class="fa fa-search"></i> <?php printf( __( '搜索结果: %s' ), '<span>' . get_search_query() . '</span>' ); ?></div></h6>
        					<?php } else if(is_tag()) { ?>
        						<h6 class="archive-title"><div class="title-inner"><i class="fa fa-tags"></i> <?php single_tag_title(); ?></div></h6>
        					<?php } else if(is_day()) { ?>
        						<h6 class="archive-title"><div class="title-inner"><i class="icon-time"></i> <?php _e('归档'); ?> <?php echo get_the_date(); ?></div></h6>
        					<?php } else if(is_month()) { ?>
        						<h6 class="archive-title"><div class="title-inner"><i class="fa fa-calendar"></i> <?php echo get_the_date('F Y'); ?></div></h6>
        					<?php } else if(is_year()) { ?>
        						<h6 class="archive-title"><div class="title-inner"><i class="fa fa-calendar"></i> <?php echo get_the_date('Y'); ?></div></h6>
        					<?php } else if(is_category()) { ?>
        						<h6 class="archive-title"><div class="title-inner"><i class="fa fa-bookmark"></i> <?php single_cat_title(); ?></div></h6>
        					<?php } else if(is_author()) { ?>
        						<h6 class="archive-title"><div class="title-inner"><i class="fa fa-user"></i> <?php
        						$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo $curauth->display_name; ?></div></h6>
        					<?php } ?>

                    <div class="main-inner">
	                    <div id="posts-box">
	                        <div class="posts clearfix">
	                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                            <?php setPostViews(get_the_ID());?>
	                            <article <?php post_class('post bddb'); ?>>
	                                <div class="post-wrap rel">

                                      <?php if ( is_sticky() ) : ?>
                                      <!-- 置顶文章 -->
                                      <div class="post-sticky with-tooltip m_hide" data-tooltip="置顶文章"></div>
                                      <?php else : ?>
                                      <?php endif; ?>

	                                    <?php
											                    get_template_part('format', 'standard');
	                                    ?>

	                                    <ul class="bottom_meta clearfix">
	                                    	<li class="mate-time fl"><i class="fa fa-clock-o"></i><?php echo ''.timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ); ?></li>
	                                        <li class="mate-cat fl"><i class="fa fa-bookmark"></i><?php the_category(' '); ?></li>
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

	                                <?php $nums=5;
                                    $get_comments_num=5;
                                    $min_comments = get_comments('status=approve&type=comment&number='.$get_comments_num.'&post_id='.get_the_ID());
                                    if ( $com && !empty($min_comments) && !is_mobile() ) {
                                    	$my_email=get_bloginfo ('admin_email');
                                    	$i = 1; ?>
                                    	<div class="min_comments m_hide">
                                    		<ul><?php
                                    			$commentcount = $min_comments->comment_count;
                                    			$min_output='';
                                    			foreach ($min_comments as $min_comment) {
                                    				if ($min_comment->comment_author_email != $my_email) {
                                    					$min_avatar=get_avatar($min_comment->comment_author_email,60);
                                    					$min_output .= '<li><a class="" href="'
                                    					.get_comment_link( $min_comment->comment_ID, array('type' => 'all')).'" title="'.$min_comment->comment_date.'"><figure class="avatar avatar-box avatar-xs">'
                                    					.$min_avatar
                                    					.'</figure><span class="comment_box">'
                                    					.$min_comment->comment_author.'：'
                                    					.convert_smilies(strip_tags($min_comment->comment_content))
                                    					.'</span></a></li>';
                                    					if ($i == $nums || $i == $commentcount) break;
                                    					++$i;
                                    				}
                                    			}
                                    			echo $min_output;
                                    			if ($min_output) echo '<!-- <li class="min_more">', comments_popup_link('','','...'), '</li> -->';?>
                                    		</ul>
                                    	</div><?php
                                    } ?>

	                            </article>
	                            <?php endwhile; ?>
	                            <?php endif; ?>
	                        </div>
	                    </div>
                	</div>
                </div>
            </div>

            <!-- 分页 -->
            <?php if ( $pagination == 'i_ajax') { ?>
                <?php if( island_page_has_nav() ) : ?>
                    <div class="post-nav">
                        <div class="post-nav-inside text-c clearfix">
                            <div class="post-nav-left"><?php previous_posts_link(__('上一页')) ?></div>
                            <div class="post-nav-right"><?php next_posts_link(__('下一页')) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php } else { ?>
                <div class="posts-nav">
                    <div class="nav-inside text-c clearfix">
                    <?php echo paginate_links(array(
                        'prev_next'          => 0,
                        'before_page_number' => '',
                        'mid_size'           => 2,
                    ));?>
                    </div>
                </div>
                <?php ?>
            <?php } ?>

        </div>

        <?php get_sidebar(); ?>

    </div>
</section>

<?php get_footer(); ?>
