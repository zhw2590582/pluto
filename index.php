<?php
error_reporting(0);
$sliders = cs_get_option( 'i_slider' );
$pagination = cs_get_option('i_pagination');
$like = cs_get_option( 'i_post_like' );
?>

<?php get_header(); ?>


        <?php if(is_home() && !is_paged()) { ?>
          <!-- slider 开始 -->
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
          <!-- slider 结束 -->
        <?php } ?>

        <!-- archive title 开始  -->
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
        <!-- archive title 结束  -->

        <div class="posts clearfix">
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <?php setPostViews(get_the_ID());?>
          <article <?php post_class('index-post'); ?>>
            <div class="post-date">
              <span class="date-month"><?php the_time('m'); ?>月</span>
              <span class="date-day"><?php the_time('d'); ?></span>
              <span class="date-year"><?php the_time('Y'); ?></span>
            </div>
            <div class="post-wrap">

              <?php get_template_part('format', 'standard'); ?>

              <ul class="post-meta clearfix">
                <li class="mate-cat fl clearfix"><i class="fa fa-bookmark"></i><?php the_category(' '); ?></li>
                <?php $posttags = get_the_tags(); if ($posttags) { ?><li class="meta-tabs fl clearfix"><i class="fa fa-tags"></i><?php the_tags('', ' ', ''); ?></li><?php } ?>
                <?php if ($like == true) { ?> <li class="meta-like fr"><?php echo getPostLikeLink( get_the_ID() ); ?></li><?php } ?>
              </ul>

            </div>
          </article>
          <?php endwhile; ?>
          <?php endif; ?>
        </div>

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
        <!-- content-inner 结束-->
  </div>
    <!-- container 结束-->
</section>
<!-- content 结束-->
<?php get_footer(); ?>
