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
          <h6 class="archive-title"><div class="title-inner"><?php printf( __( '搜索:  %s' ), '<span>' . get_search_query() . '</span>' ); ?></div></h6>
        <?php } else if(is_tag()) { ?>
          <h6 class="archive-title"><div class="title-inner">标签： <?php single_tag_title(); ?></div></h6>
        <?php } else if(is_day()) { ?>
          <h6 class="archive-title"><div class="title-inner">日期： <?php _e('归档'); ?> <?php echo get_the_date(); ?></div></h6>
        <?php } else if(is_month()) { ?>
          <h6 class="archive-title"><div class="title-inner">日期： <?php echo get_the_date('F Y'); ?></div></h6>
        <?php } else if(is_year()) { ?>
          <h6 class="archive-title"><div class="title-inner">日期： <?php echo get_the_date('Y'); ?></div></h6>
        <?php } else if(is_category()) { ?>
          <h6 class="archive-title"><div class="title-inner">分类： <?php single_cat_title(); ?></div></h6>
        <?php } else if(is_author()) { ?>
          <h6 class="archive-title"><div class="title-inner">作者： <?php
          $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo $curauth->display_name; ?></div></h6>
        <?php } ?>
        <!-- archive title 结束  -->

        <div class="posts clearfix">
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
          <?php setPostViews(get_the_ID());?>
          <article <?php post_class('index-post'); ?>>
            <div class="post-tool">
              <!-- 日期  -->
              <div class="post-date">
                <span class="date-month"><?php the_time('m'); ?>月</span>
                <span class="date-day"><?php the_time('d'); ?></span>
                <span class="date-year"><?php the_time('Y'); ?></span>
              </div>
              <!-- 浏览  -->
              <div class="post-view">
                <a href="javascript:void(0)">
                  <i class="fa fa-eye"></i><span class="view-num"><?php echo getPostViews(get_the_ID()); ?></span>
                </a>
              </div>
              <?php if(current_user_can('level_10')){  ?>
                <!-- 编辑  -->
                <div class="post-edit">
                    <?php edit_post_link( __( '<i class="fa fa-edit"></i><span class="view-num">编辑</span>' ), '<div class="edit-link">', '</div>' ); ?>
                </div>
              <?php } ?>
            </div>

            <div class="post-wrap">

              <?php get_template_part('format', 'standard'); ?>

              <ul class="post-meta clearfix">
                <li class="mate-cat fl clearfix"><i class="fa fa-bookmark"></i><?php the_category(' '); ?></li>
                <?php $posttags = get_the_tags(); if ($posttags) { ?><li class="meta-tabs fl clearfix"><i class="fa fa-tags"></i><?php the_tags('', ' ', ''); ?></li><?php } ?>
                <?php if ($like == true) { ?> <li class="meta-like fr mr0"><?php echo getPostLikeLink( get_the_ID() ); ?></li><?php } ?>
                <li class="mate-com fr"><i class="fa fa-comments-o"></i><span class="mate-num ofh"><?php comments_number(__('0','island'),__('1','island'),__( '%','island') );?></span></li>
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
            <div class="posts-nav text-c">
              <div class="nav-inside clearfix">
                <?php echo paginate_links(array(
                    'prev_text'          =>'<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                    'next_text'          =>'<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                    'before_page_number' => '',
                    'mid_size'           => 2,
                ));?>
              </div>
            </div>
        <?php } ?>
        <a href="#top" class="post-top"></a>
    </div>
        <!-- content-inner 结束-->
  </div>
    <!-- container 结束-->
</section>
<!-- content 结束-->
<?php get_footer(); ?>
